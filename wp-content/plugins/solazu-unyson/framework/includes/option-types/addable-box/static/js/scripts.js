jQuery(document).ready(function ($) {
	var optionTypeClass = '.slz-option-type-addable-box';

	var methods = {
		/** Make full/prefixed event name from short name */
		makeEventName: function(shortName) {
			return 'slz:option-type:addable-box:'+ shortName;
		},
		/** Create object with useful data about box for event data */
		getBoxDataForEvent: function($box) {
			var data = {};

			data.$box       = $box;
			data.$controls  = $box.find('.slz-option-box-controls:first');
			data.$options   = $box.find('.slz-option-box-options:first');

			data.$box       = $box.find('.slz-postbox:first');
			data.$title     = data.$box.find('> .hndle:first');
			data.$titleText = data.$title.find('> span:first');

			return data;
		},
		/** Make boxes to be sortable */
		reInitSortable: function ($boxes) {
			try {
				$boxes.sortable('destroy');
			} catch (e) {
				// happens when sortable was not initialized before
			}

			if (!$boxes.first().closest(optionTypeClass).hasClass('is-sortable')) {
				return false;
			}

			var isMobile = $(document.body).hasClass('mobile');

			$boxes.sortable({
				items: '> .slz-option-box',
				handle: '.hndle:first',
				cursor: 'move',
				placeholder: 'sortable-placeholder',
				delay: ( isMobile ? 200 : 0 ),
				distance: 2,
				tolerance: 'pointer',
				forcePlaceholderSize: true,
				axis: 'y',
				start: function(e, ui){
					// Update the height of the placeholder to match the moving item.
					{
						var height = ui.item.outerHeight();

						height -= 2; // Subtract 2 for borders

						ui.placeholder.height(height);
					}
				},
				update: function(){
					$(this).closest(optionTypeClass).trigger('change'); // for customizer
				}
			});
		},
		/** Init boxes controls */
		initControls: function ($boxes) {
			$boxes
				.find('.slz-option-box-controls:not(.initialized)')
				.on('click', '.slz-option-box-control', function(e){
					e.preventDefault();
					e.stopPropagation(); // prevent open/close of the box (when the link is in box title bar)

					var $control  = $(this);
					var controlId = $control.attr('data-control-id');

					switch (controlId) {
						case 'delete':
							var $option = $control.closest(optionTypeClass);

							$control.closest('.slz-option-box').remove();

							methods.checkLimit($option);
							methods.updateHasBoxesClass($option);
							break;
						default:
							// custom control. trigger event for others to handle this
							$control.closest(optionTypeClass).trigger(
								methods.makeEventName('control:click'), {
									controlId: controlId,
									$control: $control,
									box: methods.getBoxDataForEvent($control.closest('.slz-option-box'))
								}
							);
					}
				})
				.addClass('initialized')
				.find('.slz-option-box-control').off('click'); // remove e.stopPropagation() added by /wp-admin/js/postbox.min.js
		},
		checkLimit: function($option) {
			var $button = $option.find('> .slz-option-boxes-controls .slz-option-boxes-add-button');
			var limit = slz.intval($button.attr('data-limit'));

			if (limit > 0 && $option.find('> .slz-option-boxes > .slz-option-box').length >= limit) {
				$button.addClass('slz-hidden');
			} else {
				$button.removeClass('slz-hidden');
			}
		},
		updateHasBoxesClass: function($option) {
			$option[
				$option.find('> .slz-option-boxes > .slz-option-box:first').length
				? 'addClass' : 'removeClass'
			]('has-boxes');
		}
	};

	/**
	 * Update box title using the 'template' option parameter and box option values
	 */
	var titleUpdater = {
		pendingClass: 'slz-option-type-addable-box-pending-title-update',
		isBusy: false,
		template: function(template, vars) {
			try {
				return _.template(
					$.trim(template),
					undefined,
					{
						evaluate: /\{\{([\s\S]+?)\}\}/g,
						interpolate: /\{\{=([\s\S]+?)\}\}/g,
						escape: /\{\{-([\s\S]+?)\}\}/g
					}
				)(vars);
			} catch (e) {
				return '[Template Error] '+ e.message;
			}
		},
		/**
		 * Update the given box title, or find a pending box
		 * @public
		 */
		update: function($box) {
			if (this.isBusy) {
				return;
			}

			if (typeof $box == 'undefined') {
				$box = $(optionTypeClass +' .'+ this.pendingClass +':first');
			}

			if (!$box.length) {
				return;
			}

			var data = JSON.parse(
				$box.closest(optionTypeClass).attr('data-for-js')
			);

			data.template = $.trim(data.template);

			if (!data.template.length) {
				delete data;
				return;
			}

			var $dataWrapper = $box.closest('.slz-option-box');

			var values = $dataWrapper.attr('data-values');

			if (values) {
				// box after refresh
				$dataWrapper.removeAttr('data-values');

				$box.removeClass(titleUpdater.pendingClass);

				var jsonParsedValues = JSON.parse(values) || {};

				$box.find('> .hndle span:not([class])').first().html(
					this.template(data.template, $.extend({}, {o: jsonParsedValues}, jsonParsedValues))
				);

				delete data;
				delete jsonParsedValues;
				this.update();
				return;
			}

			this.isBusy = true;

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: [
					'action=slz_backend_options_get_values',
					'options='+ encodeURIComponent(JSON.stringify(data.options)),
					'name_prefix='+ encodeURIComponent($dataWrapper.attr('data-name-prefix')),
					$box.find('> .inside > .slz-option-box-options').find('input, select, textarea').serialize()
				].join('&'),
				dataType: 'json'
			}).done(_.bind(function (response, status, xhr) {
				this.isBusy = false;
				$box.removeClass(titleUpdater.pendingClass);

				var template = '';

				if (response.success) {
					template = this.template(data.template, $.extend({}, {o: response.data.values}, response.data.values));
				} else {
					template = '[Ajax Error] '+ response.data.message
				}

				$box.find('> .hndle span:not([class])').first().html(template);

				delete data;

				this.update();
			}, this)).fail(_.bind(function (xhr, status, error) {
				this.isBusy = false;
				$box.removeClass(titleUpdater.pendingClass);

				$box.find('> .hndle span:not([class])').first().text('[Server Error] '+ status +': '+ error.message);

				delete data;

				this.update();
			}, this));
		}
	};

	slzEvents.on('slz:options:init', function (data) {
		var $elements = data.$elements.find(optionTypeClass +':not(.slz-option-initialized)');

		/** Init Add button */
		$elements.on('click', '> .slz-option-boxes-controls > .slz-option-boxes-add-button', function(){
			var $button   = $(this);
			var $option   = $button.closest(optionTypeClass);
			var $boxes    = $option.find('.slz-option-boxes:first');
			var increment = parseInt($button.attr('data-increment'));

			var $newBox = $(
				$option.find('> .default-box-template').attr('data-template')
					.split( $button.attr('data-increment-placeholder') ).join( String(increment) )
			);

			$button.attr('data-increment', increment + 1);

			// animation
			{
				$newBox.addClass('slz-animation-zoom-in');

				setTimeout(function(){
					$newBox.removeClass('slz-animation-zoom-in');
				}, 300);
			}


			$boxes.append($newBox);

			// Re-render wp-editor
			if (
				window.slzWpEditorRefreshIds
				&&
				$newBox.find('.slz-option-type-wp-editor:first').length
			) {
				slzWpEditorRefreshIds(
					$newBox.find('.slz-option-type-wp-editor textarea:first').attr('id'),
					$newBox
				);
			}

			methods.initControls($newBox);

			if ($option.hasClass('is-sortable')) {
				methods.reInitSortable($boxes);
			}

			// remove focus form "Add" button to prevent pressing space/enter to add easy many boxes
			$newBox.find('input,select,textarea').first().focus();

			slzEvents.trigger('slz:options:init', {$elements: $newBox});

			var box = methods.getBoxDataForEvent($newBox);

			$option.trigger(methods.makeEventName('box:init'), {box: box});

			methods.checkLimit($option);
			methods.updateHasBoxesClass($option);
		});

		// close postboxes and attach event listener
		$elements.find('> .slz-option-boxes > .slz-option-box > .slz-postbox').addClass('closed');

		$elements.on('slz:box:close', '> .slz-option-boxes > .slz-option-box > .slz-postbox', function(){
			// later a script will pick it by this class and will update the title via ajax
			$(this).addClass(titleUpdater.pendingClass);

			/*
			$(this).find('> .hndle span:not([class])').first().html(
				$('<img>').attr('src', slz.img.loadingSpinner)
			);
			*/

			titleUpdater.update($(this));
		});

		methods.initControls($elements);

		$elements.each(function(){
			methods.checkLimit($(this));
		});

		$elements.addClass('slz-option-initialized');

		setTimeout(function(){
			// executed later, after .sortable('destroy') from backend-options.js
			methods.reInitSortable($elements.find('.slz-option-boxes'));

			// execute box:init event for existing boxes
			$elements.each(function(){
				var $option = $(this);

				$option.find('> .slz-option-boxes > .slz-option-box').each(function(){
					$option.trigger(methods.makeEventName('box:init'), {
						box: methods.getBoxDataForEvent($(this))
					});
				})
			});
		}, 100);

		titleUpdater.update();
	});
});

/**
 * Included on pages where backend options are rendered
 */

var slzBackendOptions = {
	/**
	 * @deprecated Tabs are lazy loaded https://github.com/ThemeFuse/Unyson/issues/1174
	 */
	openTab: function(tabId) { console.warn('deprecated'); }
};

jQuery(document).ready(function($){
	var localized = _slz_backend_options_localized;

	/**
	 * Functions
	 */
	{
		/**
		 * Make slz-postbox to close/open on click
		 *
		 * (fork from /wp-admin/js/postbox.js)
		 */
		function addPostboxToggles($boxes) {
			/** Remove events added by /wp-admin/js/postbox.js */
			$boxes.find('h2, h3, .handlediv').off('click.postboxes');

			var eventNamespace = '.slz-backend-postboxes';

			// make postboxes to close/open on click
			$boxes
				.off('click'+ eventNamespace) // remove already attached, just to be sure, prevent multiple execution
				.on('click'+ eventNamespace, '> .hndle, > .handlediv', function(e){
					var $box = $(this).closest('.slz-postbox');

					if ($box.parent().is('.slz-backend-postboxes') && !$box.siblings().length) {
						// Do not close if only one box https://github.com/ThemeFuse/Unyson/issues/1094
						$box.removeClass('closed');
					} else {
						$box.toggleClass('closed');
					}

					var isClosed = $box.hasClass('closed');

					$box.trigger('slz:box:'+ (isClosed ? 'close' : 'open'));
					$box.trigger('slz:box:toggle-closed', {isClosed: isClosed});
				});
		}

		/** Remove box header if title is empty */
		function hideBoxEmptyTitles($boxes) {
			$boxes.find('> .hndle > span').each(function(){
				var $this = $(this);

				if (!$.trim($this.html()).length) {
					$this.closest('.postbox').addClass('slz-postbox-without-name');
				}
			});
		}
	}

	/** Init tabs */
	(function(){
		var htmlAttrName = 'data-slz-tab-html',
			initTab = function($tab) {
				var html;

				if (html = $tab.attr(htmlAttrName)) {
					slzEvents.trigger('slz:options:init', {
						$elements: $tab.removeAttr(htmlAttrName).html(html),
						/**
						 * Sometimes we want to perform some action just when
						 * lazy tabs are rendered. It's important in those cases
						 * to distinguish regular slz:options:init events from
						 * the ones that will render tabs. Passing by this little
						 * detail may break some widgets because slz:options:init
						 * event may be fired even when tabs are not yet rendered.
						 *
						 * That's how you can be sure that you'll run a piece
						 * of code just when tabs will be arround 100%.
						 *
						 * slzEvents.on('slz:options:init', function (data) {
						 *   if (! data.lazyTabsUpdated) {
						 *     return;
						 *   }
						 *
						 *   // Do your business
						 * });
						 *
						 */
						lazyTabsUpdated: true
					});
				}
			},
			initAllTabs = function ($el) {
				var selector = '.slz-options-tab[' + htmlAttrName + ']', $tabs;

				// fixes https://github.com/ThemeFuse/Unyson/issues/1634
				$el.each(function(){
					if ($(this).is(selector)) {
						initTab($(this));
					}
				});

				// initialized tabs can contain tabs, so init recursive until nothing is found
				while (($tabs = $el.find(selector)).length) {
					$tabs.each(function(){ initTab($(this)); });
				}
			};

		slzEvents.on('slz:options:init:tabs', function (data) {
			initAllTabs(data.$elements);
		});

		slzEvents.on('slz:options:init', function (data) {
			var $tabs = data.$elements.find('.slz-options-tabs-wrapper:not(.initialized)');

			if (localized.lazy_tabs) {
				$tabs.tabs({
					create: function (event, ui) {
						initTab(ui.panel);
					},
					activate: function (event, ui) {
						initTab(ui.newPanel);
					}
				});

				$tabs
					.closest('form')
					.off('submit.slz-tabs')
					.on('submit.slz-tabs', function () {
						if (!$(this).hasClass('prevent-all-tabs-init')) {
							// All options needs to be present in html to be sent in POST on submit
							initAllTabs($(this));
						}
					});
			} else {
				$tabs.tabs();
			}

			$tabs.each(function () {
				var $this = $(this);

				if (!$this.parent().closest('.slz-options-tabs-wrapper').length) {
					// add special class to first level tabs
					$this.addClass('slz-options-tabs-first-level');
				}
			});

			$tabs.addClass('initialized');
		});
	})();

	/** Init boxes */
	slzEvents.on('slz:options:init', function (data) {
		var $boxes = data.$elements.find('.slz-postbox:not(.initialized)');

		hideBoxEmptyTitles(
			$boxes.filter('.slz-backend-postboxes > .slz-postbox')
		);

		addPostboxToggles($boxes);

		/**
		 * leave open only first boxes
		 */
		$boxes
			.filter('.slz-backend-postboxes > .slz-postbox:not(.slz-postbox-without-name):not(:first-child):not(.prevent-auto-close)')
			.addClass('closed');

		$boxes.addClass('initialized');

		// trigger on box custom event for others to do something after box initialized
		$boxes.trigger('slz-options-box:initialized');
	});

	/** Init options */
	slzEvents.on('slz:options:init', function (data) {
		data.$elements.find('.slz-backend-option:not(.initialized)')
			// do nothing, just a the initialized class to make the fadeIn css animation effect
			.addClass('initialized');
	});

	/** Fixes */
	slzEvents.on('slz:options:init', function (data) {
		{
			var eventNamespace = '.slz-backend-postboxes';

			data.$elements.find('.postbox:not(.slz-postbox) .slz-option')
				.closest('.postbox:not(.slz-postbox)')

				/**
				 * Add special class to first level postboxes that contains framework options (on post edit page)
				 */
				.addClass('postbox-with-slz-options')

				/**
				 * Prevent event to be propagated to first level WordPress sortable (on edit post page)
				 * If not prevented, boxes within options can be dragged out of parent box to first level boxes
				 */
				.off('mousedown'+ eventNamespace) // remove already attached (happens when this script is executed multiple times on the same elements)
				.on('mousedown'+ eventNamespace, '.slz-postbox > .hndle, .slz-postbox > .handlediv', function(e){
					e.stopPropagation();
				});
		}

		/**
		 * disable sortable (drag/drop) for postboxes created by framework options
		 * (have no sense, the order is not saved like for first level boxes on edit post page)
		 */
		{
			var $sortables = data.$elements
				.find('.postbox:not(.slz-postbox) .slz-postbox, .slz-options-tabs-wrapper .slz-postbox')
				.closest('.slz-backend-postboxes')
				.not('.slz-sortable-disabled');

			$sortables.each(function(){
				try {
					$(this).sortable('destroy');
				} catch (e) {
					// happens when not initialized
				}
			});

			$sortables.addClass('slz-sortable-disabled');
		}

		/** hide bottom border from last option inside box */
		{
			data.$elements.find('.postbox-with-slz-options > .inside, .slz-postbox > .inside')
				.append('<div class="slz-backend-options-last-border-hider"></div>');
		}

		hideBoxEmptyTitles(
			data.$elements.find('.postbox-with-slz-options')
		);
	});

	/**
	 * Help tips (i)
	 */
	(function(){
		slzEvents.on('slz:options:init', function (data) {
			var $helps = data.$elements.find('.slz-option-help:not(.initialized)');

			slz.qtip($helps);

			$helps.addClass('initialized');
		});
	})();

	$('#side-sortables').addClass('slz-force-xs');
});

(function ($) {
	var $rootClass = '.slz-option-type-icon-v2';

	/**
	 * We'll have this HTML structure
	 *
	 * <div class="slz-icon-v2-preview-wrapper>
	 *   <div class="slz-icon-v2-preview">
	 *     <i></i>
	 *     <button class="slz-icon-v2-remove-icon"></button>
	 *   </div>
	 *
	 *   <button class="slz-icon-v2-trigger-modal">Add Icon</div>
	 * </div>
	 */

	slzEvents.on('slz:options:init', function (data) {
		data.$elements.find($rootClass).toArray().map(renderSinglePreview);
	});

	$(document).on('click', '.slz-icon-v2-remove-icon', removeIcon);
	$(document).on('click', '.slz-icon-v2-trigger-modal', getNewIcon);
	$(document).on('click', '.slz-icon-v2-preview', getNewIcon);

	/**
	 * For debugging purposes
	 */
	function refreshEachIcon () { $($rootClass).toArray().map(refreshSinglePreview); }

	function getNewIcon (event) {
		event.preventDefault();

		var $root = $(this).closest($rootClass);
		var modalSize = $root.attr('data-slz-modal-size');

		/**
		 * slz.OptionsModal should execute it's change:values callbacks
		 * only if the picker was changed. That's why we introduce unique-id
		 * for each picker.
		 */
		if (! $root.data('unique-id')) {
			$root.data('unique-id', slz.randomMD5());
		}

		slzOptionTypeIconV2Instance.set('size', modalSize);

		slzOptionTypeIconV2Instance.open(getDataForRoot($root))
			.then(function (data) {
				setDataForRoot($root, data);
			})
			.fail(function () {
				// modal closed without save
			});

        /*
		slzOptionTypeIconV2Picker.pick(
			getDataForRoot($root),
			$root.data('unique-id'),
			function (data) {
				setDataForRoot(
					$root,
					data
				);
			},
			modalSize
		);
        */
	}

	function removeIcon (event) {
		event.preventDefault();
		event.stopPropagation();

		var $root = $(this).closest($rootClass);

		if (getDataForRoot($root)['type'] === 'icon-font') {
			setDataForRoot($root, {
				'icon-class': ''
			});
		}

		if (getDataForRoot($root)['type'] === 'custom-upload') {
			setDataForRoot($root, {
				'attachment-id': '',
				'url': ''
			});
		}
	}

	function renderSinglePreview ($root) {
		$root = $($root);

		/**
		* Skip element if it's already activated
		*/
		if ( $root.hasClass('slz-activated') ) {
			return;
		}

		$root.addClass('slz-activated');

		var $wrapper = $('<div>', {
			class: 'slz-icon-v2-preview-wrapper',
			'data-icon-type': getDataForRoot($root)['type']
		});

		var $preview = $('<div>', {
			class: 'slz-icon-v2-preview',
		}).append(
			$('<i>')
		).append(
			$('<a>', {
				class: 'slz-icon-v2-remove-icon dashicons slz-x',
				html: ''
			})
		);

		$wrapper.append(
			$preview
		).append(
			$('<button>', {
				class: 'slz-icon-v2-trigger-modal button-secondary button-large',
				type: 'button',
				html: slz_icon_v2_data.add_icon_label
			})
		);

		$wrapper.appendTo( $root );

		refreshSinglePreview( $root );
	}

	function refreshSinglePreview ($root) {
		$root = $($root);

		var data = getDataForRoot( $root );

		$root.find('.slz-icon-v2-trigger-modal').text(
			slz_icon_v2_data[
				hasIcon(data) ? 'edit_icon_label' : 'add_icon_label'
			]
		);

		$root.find('.slz-icon-v2-preview-wrapper')
			.removeClass('slz-has-icon')
			.addClass(
				hasIcon(data) ? 'slz-has-icon' : ''
			);

		$root.find('.slz-icon-v2-preview-wrapper').attr(
			'data-icon-type',
			data['type']
		);

		if (data.type === 'icon-font') {
			$root.find('i').attr('class', data['icon-class']);
			$root.find('i').attr('style', '');
		}

		if (data.type === 'custom-upload') {
			if (hasIcon(data)) {
				$root.find('i').attr(
					'style',
					'background-image: url("' + data['url'] + '");'
				);

				$root.find('i').attr('class', '');
			} else {
				$root.find('i').attr(
					'style',
					''
				);

				$root.find('i').attr('class', '');
			}
		}

		function hasIcon (data) {
			if (data.type === 'icon-font') {
				if (data['icon-class'] && data['icon-class'].trim() !== '') {
					return true;
				}
			}

			if (data.type === 'custom-upload') {
				if (data['url'].trim() !== '') {
					return true;
				}
			}

			return false;
		}
	}

	function getDataForRoot ($root) {
		return JSON.parse($root.find('input').val());
	}

	function setDataForRoot ($root, data) {
		var currentData = getDataForRoot($root);

		$root.find('input').val(
			JSON.stringify(
				_.omit(
					_.extend(
						{},
						currentData,
						data
					),

					'attachment'
				)
			)
		).trigger('change');

		refreshSinglePreview($root);
	}

}(jQuery));


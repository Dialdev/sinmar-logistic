slzEvents.on('slz-builder:'+ 'form-builder' +':register-items', function(builder){
	var currentItemType = 'radio';
	var localized = window['slz_form_builder_item_type_'+ currentItemType];

	var ItemView = builder.classes.ItemView.extend({
		template: _.template(
			'<div class="slz-form-builder-item-style-default slz-form-builder-item-type-'+ currentItemType +'">'+
				'<div class="slz-form-item-controls slz-row">'+
					'<div class="slz-form-item-controls-left slz-col-xs-7">'+
						'<div class="slz-form-item-width"></div>'+
					'</div>'+
					'<div class="slz-form-item-controls-right slz-col-xs-5 slz-text-right">'+
						'<div class="slz-form-item-control-buttons">'+
							'<a class="slz-form-item-control-required dashicons<% if (required) { %> required<% } %>" data-hover-tip="<%- toggle_required %>" href="#" onclick="return false;" >*</a>'+
							'<a class="slz-form-item-control-edit dashicons dashicons-admin-generic" data-hover-tip="<%- edit %>" href="#" onclick="return false;" ></a>'+
							'<a class="slz-form-item-control-remove dashicons dashicons-no" data-hover-tip="<%- remove %>" href="#" onclick="return false;" ></a>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="slz-form-item-preview">'+
					'<div class="slz-form-item-preview-label">'+
						'<div class="slz-form-item-preview-label-wrapper"><label data-hover-tip="<%- edit_label %>"><%- label %></label> <span <% if (required) { %>class="required"<% } %>>*</span></div>'+
						'<div class="slz-form-item-preview-label-edit"><!-- --></div>'+
					'</div>'+
					'<div class="slz-form-item-preview-choices">'+
						'<% if (choices.length) { %>'+
							'<div class="slz-form-item-preview-choices-list">'+
								'<% _.each(choices, function(choice, i){ %>'+
									'<p class="slz-form-item-preview-choice">'+
										'<input type="radio" onclick="return false;"> '+
										'<strong><%- choice %></strong> '+
										'<% if (i === 0 && choices.length > 1) { %>'+
											'<a href="#" onclick="jQuery(this).closest(\'.slz-form-item-preview-choices-list\').toggleClass(\'open\'); return false;"><strong>('+
												'<span class="if-list-closed"><%- x_more.replace("{x}", choices.length - 1) %></span>'+
												'<span class="if-list-open"><%- close %></span>'+
											')</strong></a>'+
										'<% } %>'+
									'</p>'+
								'<% }); %>'+
							'</div>'+
						'<% } else { %>'+
							'<p class="no-choices slz-form-item-preview-choice">'+
								'<input type="radio" onclick="return false;"> '+
								'<strong><%- item_title %></strong> '+
							'</p>'+
						'<% } %>'+
					'</div>'+
				'</div>'+
			'</div>'
		),
		events: {
			'click': 'onWrapperClick',
			'click .slz-form-item-control-edit': 'openEdit',
			'click .slz-form-item-control-remove': 'removeItem',
			'click .slz-form-item-control-required': 'toggleRequired',
			'click .slz-form-item-preview .slz-form-item-preview-label label': 'openLabelEditor'
		},
		initialize: function() {
			this.defaultInitialize();

			// prepare edit options modal
			{
				this.modal = new slz.OptionsModal({
					title: localized.l10n.item_title,
					options: this.model.modalOptions,
					values: this.model.get('options'),
					size: 'medium'
				});

				this.listenTo(this.modal, 'change:values', function(modal, values) {
					this.model.set('options', values);
				});

				this.model.on('change:options', function() {
					this.modal.set(
						'values',
						this.model.get('options')
					);
				}, this);
			}

			this.widthChangerView = new SlzBuilderComponents.ItemView.WidthChanger({
				model: this.model,
				view: this
			});

			this.labelInlineEditor = new SlzBuilderComponents.ItemView.InlineTextEditor({
				model: this.model,
				editAttribute: 'options/label'
			});
		},
		render: function () {
			this.defaultRender({
				label: slz.opg('label', this.model.get('options')) || localized.l10n.item_title,
				required: slz.opg('required', this.model.get('options')),
				toggle_required: localized.l10n.toggle_required,
				edit: localized.l10n.edit,
				remove: localized.l10n.delete,
				edit_label: localized.l10n.edit_label,
				choices: slz.opg('choices', this.model.get('options')),
				x_more: localized.l10n.x_more,
				close: localized.l10n.close,
				item_title: localized.l10n.item_title
			});

			if (this.widthChangerView) {
				this.$('.slz-form-item-width').append(
					this.widthChangerView.$el
				);
				this.widthChangerView.delegateEvents();
			}

			if (this.labelInlineEditor) {
				this.$('.slz-form-item-preview-label-edit').append(
					this.labelInlineEditor.$el
				);
				this.labelInlineEditor.delegateEvents();
			}
		},
		openEdit: function() {
			this.modal.open();
		},
		removeItem: function() {
			this.remove();

			this.model.collection.remove(this.model);
		},
		toggleRequired: function() {
			var values = _.clone(
				// clone to not modify by reference, else model.set() will not trigger the 'change' event
				this.model.get('options')
			);

			values.required = !values.required;

			this.model.set('options', values);
		},
		openLabelEditor: function() {
			this.$('.slz-form-item-preview-label-wrapper').hide();

			this.labelInlineEditor.show();

			this.listenToOnce(this.labelInlineEditor, 'hide', function() {
				this.$('.slz-form-item-preview-label-wrapper').show();
			});
		},
		onWrapperClick: function(e) {
			if (!this.$el.parent().length) {
				// The element doesn't exist in DOM. This listener was executed after the item was deleted
				return;
			}

			if (!slz.elementEventHasListenerInContainer(jQuery(e.srcElement), 'click', this.$el)) {
				this.openEdit();
			}
		}
	});

	var Item = builder.classes.Item.extend({
		defaults: function() {
			var defaults = _.clone(localized.defaults);

			defaults.shortcode = slzFormBuilder.uniqueShortcode(defaults.type +'_');

			return defaults;
		},
		initialize: function() {
			this.defaultInitialize();

			/**
			 * get options from wp_localize_script() variable
			 */
			this.modalOptions = localized.options;

			this.view = new ItemView({
				id: 'slz-builder-item-'+ this.cid,
				model: this
			});
		}
	});

	builder.registerItemClass(Item);
});
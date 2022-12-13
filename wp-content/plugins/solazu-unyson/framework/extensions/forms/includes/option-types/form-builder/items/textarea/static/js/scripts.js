slzEvents.on('slz-builder:'+ 'form-builder' +':register-items', function(builder){
	var currentItemType = 'textarea';
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
					'<div class="slz-form-item-preview-input"><input type="text" placeholder="<%- placeholder %>" value="<%- default_value %>"></div>'+
				'</div>'+
			'</div>'
		),
		events: {
			'click': 'onWrapperClick',
			'click .slz-form-item-control-edit': 'openEdit',
			'click .slz-form-item-control-remove': 'removeItem',
			'click .slz-form-item-preview .slz-form-item-preview-label label': 'openLabelEditor',
			'click .slz-form-item-control-required': 'toggleRequired'
		},
		initialize: function(){
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

				this.listenTo(this.model, 'change', function() {
					this.modal.set(
						'values',
						this.model.get('options')
					);
				});
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
				placeholder: slz.opg('placeholder', this.model.get('options')),
				required: slz.opg('required', this.model.get('options')),
				default_value: slz.opg('default_value', this.model.get('options')),
				edit: localized.l10n.edit,
				remove: localized.l10n.delete,
				edit_label: localized.l10n.edit_label,
				toggle_required: localized.l10n.toggle_required
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
		openLabelEditor: function() {
			this.$('.slz-form-item-preview-label-wrapper').hide();

			this.labelInlineEditor.show();

			this.listenToOnce(this.labelInlineEditor, 'hide', function() {
				this.$('.slz-form-item-preview-label-wrapper').show();
			});
		},
		toggleRequired: function() {
			var values = _.clone(
				// clone to not modify by reference, else model.set() will not trigger the 'change' event
				this.model.get('options')
			);

			values.required = !values.required;

			this.model.set('options', values);
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
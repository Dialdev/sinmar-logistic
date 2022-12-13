jQuery(function($){
	var inst = {
		localized: _slz_ext_backups_localized,
		$el: $('#slz-ext-backups-log'),
		onUpdating: function(){},
		onUpdate: function(data) {
			this.$el.html(data.log.html);
		},
		onUpdateFail: function() {},
		onUpdated: function() {},
		init: function(){
			slzEvents.on({
				'slz:ext:backups:status:updating': _.bind(this.onUpdating, this),
				'slz:ext:backups:status:update': _.bind(this.onUpdate, this),
				'slz:ext:backups:status:update-fail': _.bind(this.onUpdateFail, this),
				'slz:ext:backups:status:updated': _.bind(this.onUpdated, this)
			});

			this.$el.on('click', '#slz-ext-backups-log-show-button a', function() {
				inst.$el.toggleClass('show-list');
			});
		}
	};

	inst.init();
});
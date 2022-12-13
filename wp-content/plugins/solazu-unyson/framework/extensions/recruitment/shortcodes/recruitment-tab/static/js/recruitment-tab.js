jQuery(function($) {
	"use strict";

	var SLZ = window.SLZ || {};

	SLZ.load_recruitment_tab_content = function() {
		$('.slz-shortcode.sc-recruitment-style-tab').each(function(){
			var atts = jQuery.parseJSON( $(this).attr('data-json') );
			var cats =  jQuery.parseJSON( $('.tab-content',$(this)).attr('data-cats') );
			var container = $(this);
			var data = {"atts":atts,"cats" : cats};
	        $.fn.Form.ajax(['recruitment', 'ajax_load_recruitment_tab_content'], data, function(res) {
	            $('.slz-cv-wrapper .tab-content',container).append(res);
	        });
		})
    }
	
	$(document).ready(function() {
		SLZ.load_recruitment_tab_content();
	});
});

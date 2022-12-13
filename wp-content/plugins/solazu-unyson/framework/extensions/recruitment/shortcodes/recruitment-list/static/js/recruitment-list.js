jQuery(function($) {
	"use strict";

	var SLZ = window.SLZ || {};

	SLZ.load_recruitment_content = function() {
		var atts = jQuery.parseJSON( $('.slz-shortcode.sc-recruitment-tab').attr('data-json') );
        $.fn.Form.ajax(['recruitment', 'ajax_load_recruitment_list_content'], atts, function(res) {
            $('.sc-recruitment-tab .slz-cv-wrapper .tab-content.cv-content').append(res);
        });
    }
	
	$(document).ready(function() {
		SLZ.load_recruitment_content();
	});
});

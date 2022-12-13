jQuery(function($) {
	"use strict";

	$.slz_portfolio_get_history = function(){
		$('.portfolio-history .slz-select-version').change(function(){
			var target_link = $(this).find(":selected").attr('data-target');
			if( target_link == undefined) target_link = '';
			$(this).next('.slz-btn-download').attr("href", $(this).val());
			if( target_link != ''){
				$(this).next('.slz-btn-download').attr("target", target_link);
			}
		});
	};

	$.slz_portfolio_attachment_view = function () {
		$('ul.tool-list a.link.mp3').click(function () {
			var url = $(this).data('url');
			var modal_id = $(this).data('target');
			var modal = $( modal_id ).find( '.modal-body' );
			var content = '<audio controls><source src="' + url + '">Your browser does not support the audio element.</audio>';
			modal.html(content);
        });
        $('ul.tool-list a.link.video').click(function () {
            var url = $(this).data('url');
            var modal_id = $(this).data('target');
            var modal = $( modal_id ).find( '.modal-body' );
            var content = '<video height="300" controls><source src="' + url + '">Your browser does not support the video tag.</video>';
            modal.html(content);
        });
    };
	
	$(document).ready(function() {
		jQuery.slz_portfolio_get_history();
		jQuery.slz_portfolio_attachment_view();
	});
});

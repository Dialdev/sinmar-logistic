jQuery(function($){
	"use strict";

	var SLZ = window.SLZ || {};

	SLZ.timelineFunction = function() {
		// Cut off time-"line" a bit equal with height of the last milestone.
		if( $(".slz-timeline.layout-2").length ) {
			var last_milestone_height = $(".slz-timeline.layout-2 .milestone:last-child").height();
			$("head").append("<style>.slz-timeline.layout-2:before{height: calc(100% - " + last_milestone_height + "px)}</style>");
		}
	}

	/*======================================
	=			INIT FUNCTIONS			=
	======================================*/

	$(document).ready(function(){
	});

	$(window).on('load', function() {
		SLZ.timelineFunction();
	});

	$(window).on('resize', function() {
		SLZ.timelineFunction();
	});
	/*======================================
	=		  END INIT FUNCTIONS		  =
	======================================*/

});
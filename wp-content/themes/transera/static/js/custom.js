jQuery(function($) {
	"use strict";
	var transera = window.transera || {};
	/**
	 * Comment
	 */
	transera.comment = function() {
		//start rating
		$('.stars-rating span a').on('click', function(e){
			e.preventDefault();
			$('.stars-rating span').find('a').removeClass('active');
			$(this).addClass('active');
			$(this).closest('.comment-form-rating').find('input[name="rating"]').val( $(this).html() );
		});
		
		$('.comment-form').find('.comment-col1').wrapAll( "<div class='col-50' />");
		$("#submit",$("#commentform")).click(function () {
			var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
			var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
			var isError = false;
			var focusEle   = null; 
			$("#commentform .input-error-msg").addClass('hide');
			$("#commentform input, #commentform textarea").removeClass('input-error');
			if ( $("#author").length ){
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
				else if($("#author").val().trim() == '' ) {
						$('#author-err-required').removeClass('hide');
						$("#author").addClass('input-error');
						isError  = true;
						focusEle = "#author";
					}
				else if($("#email").val().trim() == '' ){
					$('#email-err-required').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
				else if(!$("#email").val().match(emailRegex)){
					$('#email-err-valid').removeClass('hide');
					$("#email").addClass('input-error');
					isError  = true;
					focusEle = "#email";
				}
			}else{
				if($("#comment").val().trim() == '' ){
					$('#comment-err-required').removeClass('hide');
					$("#comment").addClass('input-error');
					isError  = true;
					focusEle = "#comment";
				}
			}
			if(isError){
				$(focusEle).focus();
				return false;
			}
			return true;
		});
		$('.entry-comment .comment-field').each(function(){
			if ($(this).val()){
				$(this).addClass('edited');
			}
		})
	}; // end comment func

	$(document).ready(function() {
		transera.comment();
	});



});

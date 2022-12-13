jQuery(function($){
    "use strict";

    // Ajax Event Search Function
    $.slz_search_event = function() {
        $('.sc_event_block .search-item.search-time').each(function (idx, dom) {
            var datepicker = $(dom);
            var wrap_div   = datepicker.closest('.sc_event_block');

            // Init Datepicker
            datepicker.datepicker({
                format: "mm/dd/yyyy",
                weekStart: 1,
                todayBtn: "linked",
                clearBtn: true,
                daysOfWeekHighlighted: "0,6",
                autoclose: true,
                todayHighlight: true
            });

            // Event On Click Search Button
            wrap_div.find('.btn-search')
                    .off()
                    .click(function () {
                        var btnSearch_element = $(this);
                        var block_element = btnSearch_element.parents('.slz-list-event-01').eq(0);
                        var searchResult_element = block_element.find('.search-result').eq(0);
                        var searchLoading_element = block_element.find('.search-loading').eq(0);
                        var result_element = block_element.find('.list-event').eq(0);

                        block_element.find('.btn-readmore').eq(0).remove();
                        searchLoading_element.addClass('active');

                        var concert_name = block_element.find('.concert_name').eq(0).val();
                        var from = block_element.find('.from').eq(0).val();
                        var to = block_element.find('.to').eq(0).val();
                        var artists_bands = block_element.find('.artists_bands').eq(0).val();
                        var atts = block_element.find('.search-event').eq(0).attr('data-json');


                        var data = {
                            "concert_name": concert_name,
                            "from": from,
                            "to": to,
                            "artists_bands": artists_bands,
                            "atts": atts
                        };

                        $.fn.Form.ajax(['events', 'ajax_search_event'], [data], function(res) {
                            res = jQuery.parseJSON(res);
                            if( res != undefined ) {
                                searchResult_element.text( 'Found ' + res.count + ' Results' );
                                result_element.html( res.content );
                                searchLoading_element.removeClass('active');
                            }
                        });
            });

            // Event On Click Load More Button
            wrap_div.find('.btn-readmore')
                    .off()
                    .click(function () {
                        var _this = $(this);
                        var atts = _this.attr('data-json');
                        var html_render = _this.attr('data-html-render');
                        var offset_post = parseInt(_this.attr('data-offset-post'));
                        var max_post = parseInt(_this.attr('data-max-post'));
                        var limit_post = parseInt(_this.attr('data-limit-post'));
                        var data = {
                            "atts": atts,
                            'html_render':html_render,
                            'offset_post':offset_post
                        };

                        $.fn.Form.ajax(['events', 'ajax_btn_more_event'], [data], function(res) {
                            if (res != '') {
                                if (max_post > offset_post+limit_post) {
                                    _this.attr('data-offset-post', offset_post+limit_post);
                                } else {
                                    _this.remove();
                                }
                                $('.list-event.search-bar').append(res);
                            }
                        });
                    });
        });
    };

    $(document).ready(function(){
        jQuery.slz_search_event();
    });
});
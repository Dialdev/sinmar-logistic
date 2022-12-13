jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    /*=======================================
    =             MAIN FUNCTION             =
    =======================================*/

    SLZ.fancyboxFunction = function() {
        if($('.fancybox').length) {
            $('.fancybox').fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers: {
                    overlay: {
                        locked: false,
                    },
                    thumbs: {
                        width   : 60,
                        height  : 60,
                    }
                }
            });
        }

        if($('.fancybox-thumb').length) {
            $('.fancybox-thumb').fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers : {
                    overlay: {
                      locked: false,
                    },
                    thumbs: {
                        width   : 60,
                        height  : 60,
                    }
                }
            });
        }
        if($('.fancybox-thumb').length) {
            if( $(window).width() > 600 ) {
                $.fancybox.helpers.thumbs.onUpdate = function( opts, obj ){
                    if (this.list) {
                        var center = Math.floor($(window).width() * 0.5 - (obj.group.length / 2 * this.width + this.width * 0.5));
                        this.list.css('left', center);
                    }
                };
            }
        }
    };

     /* fancy box */
    SLZ.fancyboxisotopeFunction = function() {
        $(".sc_isotope_post .fancybox").each(function() {
            $(this).fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });
        });

        if($('.sc_isotope_post .fancybox-thumb').length) {
            $('.sc_isotope_post .fancybox-thumb').fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers : {
                    overlay: {
                      locked: false,
                    },
                    thumbs: {
                        width   : 60,
                        height  : 60,
                    }
                }
            });
        }

        $(".sc_isotope .fancybox").each(function() {
            $(this).fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });
        });

        if($('.sc_isotope .fancybox-thumb').length) {
            $('.sc_isotope .fancybox-thumb').fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers : {
                    overlay: {
                      locked: false,
                    },
                    thumbs: {
                        width   : 60,
                        height  : 60,
                    }
                }
            });
        }

        if( $(window).width() > 600 ) {
            $.fancybox.helpers.thumbs.onUpdate = function( opts, obj ){
                if (this.list) {
                    var center = Math.floor($(window).width() * 0.5 - (obj.group.length / 2 * this.width + this.width * 0.5));
                    this.list.css('left', center);
                }
            };
        }

    }

    SLZ.ajaxfunction = function() {
        $('.sc_isotope_post').each(function(index, el) {
            var id_class = $(this).attr('data-block-class');
            $(this).find('.grid-main .block-image a').attr('data-fancybox-group','group-'+id_class);
        });

        /* ajax isotope post */
        $('.sc_isotope_post a.slz-btn.btn-loadmore').on('click', function() {
            var uniq_id = $(this). parents('.sc_isotope_post').attr('data-block-class');
            var data_pages = $(this).parents('.sc_isotope_post').find('.grid-clone .gallery_atts_more').attr('data-pages');

            var atts = jQuery.parseJSON( $(this).parents('.sc_isotope_post').find('.grid-clone .gallery_atts_more').attr('data-json') );

            $.fn.Form.ajax(['gallery', 'ajax_load_more_func'], [atts], function(res) {
                $( uniq_id + ' .gallery_atts_more').remove();
                $(uniq_id + ' .grid-clone').append(res);
                $(uniq_id).find('.grid-main').html( $(uniq_id).find('.grid-clone').html() );

                setTimeout(function() {
                    $(uniq_id).find('.grid-main').isotope('destroy').isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });

                    $(uniq_id + ' .grid-main .block-image a').attr('data-fancybox-group','group-'+uniq_id);

                }, 100);

                if( data_pages == '') {
                    $(uniq_id).find('a.btn-loadmore').remove();
                }

            });
        });
    }

    /* appear btn on tab all */
    SLZ.tab_all_btn = function() {
        $('.slz-isotope-nav ul.tab-filter li.tab-data-less div').on('click', function() {
            var id = $(this).parents('.sc_isotope_post').attr('data-block-class');
            $(id + ' .btn.btn-loadmore').addClass('hide');
            // console.log(id);
        });
        $('.slz-isotope-nav ul.tab-filter li.tab-all-active div').on('click', function() {
            var id = $(this).parents('.sc_isotope_post').attr('data-block-class');
            $(id + ' .btn.btn-loadmore').removeClass('hide');
        });
    }

    SLZ.isotopeFunction = function() {

        setTimeout(function(){
            // mansory 1
            if($('.slz-isotope-grid').length) {
                $('.slz-isotope-grid').each(function(){
                    var $grid = $(this).isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });

                    // filter functions
                    var filterFns = {
                        // show if number is greater than 50
                        numberGreaterThan50: function () {
                            var number = $(this).find('.number').text();
                            return parseInt(number, 10) > 50;
                        },
                        // show if name ends with -ium
                        ium: function () {
                            var name = $(this).find('.name').text();
                            return name.match(/ium$/);
                        }
                    };
                    // bind filter button click
                    $(this).parent().find('.tab-filter').on('click', '.tab', function () {
                        var filterValue = $(this).attr('data-filter');
                        // use filterFn if matches value
                        filterValue = filterFns[filterValue] || filterValue;
                        $grid.isotope({filter: filterValue});
                    });
                    // change is-checked class on buttons
                    $(this).parent().find('.tab-filter').each(function (i, buttonGroup) {
                        var $buttonGroup = $(buttonGroup);
                        $buttonGroup.on('click', '.tab', function () {
                            $buttonGroup.find('.active').removeClass('active');
                            $(this).addClass('active');
                        });
                    });

                });
            }

            //masonry 2
            if($('.sc_isotope_post .slz-isotope-grid-2.grid-main').length) {
                $('.sc_isotope_post .slz-isotope-grid-2.grid-main').each(function(){
                    var $grid = $(this).isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });

                    // filter functions
                    var filterFns = {
                        // show if number is greater than 50
                        numberGreaterThan50: function () {
                            var number = $(this).find('.number').text();
                            return parseInt(number, 10) > 50;
                        },
                        // show if name ends with -ium
                        ium: function () {
                            var name = $(this).find('.name').text();
                            return name.match(/ium$/);
                        }
                    };
                    // bind filter button click
                    $(this).parent().find('.tab-filter').on('click', '.tab', function () {
                        var filterValue = $(this).attr('data-filter');
                        // use filterFn if matches value
                        filterValue = filterFns[filterValue] || filterValue;
                        $grid.isotope({filter: filterValue});
                    });
                    // change is-checked class on buttons
                    $(this).parent().find('.tab-filter').each(function (i, buttonGroup) {
                        var $buttonGroup = $(buttonGroup);
                        $buttonGroup.on('click', '.tab', function () {
                            $buttonGroup.find('.active').removeClass('active');
                            $(this).addClass('active');
                        });
                    });

                });
            }

            if($('.sc_isotope .slz-isotope-grid-2.grid-main').length) {
                $('.sc_isotope .slz-isotope-grid-2.grid-main').each(function(){
                    var $grid = $(this).isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });

                    // filter functions
                    var filterFns = {
                        // show if number is greater than 50
                        numberGreaterThan50: function () {
                            var number = $(this).find('.number').text();
                            return parseInt(number, 10) > 50;
                        },
                        // show if name ends with -ium
                        ium: function () {
                            var name = $(this).find('.name').text();
                            return name.match(/ium$/);
                        }
                    };
                    // bind filter button click
                    $(this).parent().find('.tab-filter').on('click', '.tab', function () {
                        var filterValue = $(this).attr('data-filter');
                        // use filterFn if matches value
                        filterValue = filterFns[filterValue] || filterValue;
                        $grid.isotope({filter: filterValue});
                    });
                    // change is-checked class on buttons
                    $(this).parent().find('.tab-filter').each(function (i, buttonGroup) {
                        var $buttonGroup = $(buttonGroup);
                        $buttonGroup.on('click', '.tab', function () {
                            $buttonGroup.find('.active').removeClass('active');
                            $(this).addClass('active');
                        });
                    });

                });
            }


        }, 500);

    };

    SLZ.gallery_tab = function() {
        // get fancybox image related
        $('.sc_gallery_tab  .tab-pane').each(function(index, el) {
            $(this).find('.block-image a').attr('data-fancybox-group','group-#'+$(this).attr('id'));
        });

        // gallery style 01
        $(".slz-gallery-tab-01").each(function(){
            var json_data =  $(this).data('json');
            if ( typeof json_data !== 'undefined' ) {
                var extend = {
                    autoplaySpeed: 2000,
                    infinite: true,
                    slidesToScroll: 1,
                    centerMode: true,
                    centerPadding: '0px',
                    responsive: [
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                }
                jQuery.extend( json_data, extend );
                $(this).find('.gallery-list').slick( json_data );
            }
         });

        // gallery style 02
        if($('.sc_gallery_tab .slz-isotope-grid-2.grid-main').length) {
            $('.sc_gallery_tab .slz-isotope-grid-2.grid-main').each(function(){
                var $grid = $(this).isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.grid-item'
                    }
                });
                // filter functions
                var filterFns = {
                    // show if number is greater than 50
                    numberGreaterThan50: function () {
                        var number = $(this).find('.number').text();
                        return parseInt(number, 10) > 50;
                    },
                    // show if name ends with -ium
                    ium: function () {
                        var name = $(this).find('.name').text();
                        return name.match(/ium$/);
                    }
                };

                // bind filter button click
                $(this).parents('.sc_gallery_tab').find('.tab-filter .tab_item').on('shown.bs.tab', function (e) {
                     var $grid = $(this).parents('.sc_gallery_tab').find('.slz-isotope-grid-2.grid-main').isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });
                })
            });
        }
    };

    SLZ.gallery_carousel = function() {

        $('.sc_gallery_carousel').each(function(index, el) {
        var id_class = $(this).attr('data-item');
        $(this).find('.block-image a').attr('data-fancybox-group','group-.'+id_class);
        });

        if ($('.sc_gallery_carousel').length) {
            $('.sc_gallery_carousel').each(function() {
                var item = $(this).attr('data-item');
                var block = '.' + item + ' ';
                var slick_block = $(block + ".slz-gallery-slide-slick");
                if ( slick_block.length ) {
                    var slick_json = $(slick_block).data('slick-json');
                    if (typeof slick_json !== 'undefined') {
                        var centerMode = {centerMode:false}
                        jQuery.extend( slick_json, centerMode );
                        slick_block.slick( slick_json );
                    }
                }
            });
        }

        // layout 2
        $(".slz-slick-slider-mockup").each(function() {
            var json_data =  $(this).data('json');
            if (typeof json_data !== 'undefined') {
                var extend = {
                    slidesToShow: 3,
                    centerMode: true,
                    focusOnSelect: true,
                    centerPadding: '160px',
                    slidesToScroll: 1,
                    autoplaySpeed: 2000,
                    appendArrows: $('.slz-slick-slider-mockup').parents('.slz-carousel-wrapper'),
                    prevArrow: '<button class="btn btn-prev slick-arrow-center"><i class="fa fa-long-arrow-left"></i></button>',
                    nextArrow: '<button class="btn btn-next slick-arrow-center"><i class="fa fa-long-arrow-right"></i></button>',
                    responsive: [
                                {
                                    breakpoint: 992,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        centerPadding: '60px',
                                        arrows: false,
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        centerPadding: '20px',
                                        arrows: false,
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        centerPadding: '10px',
                                        arrows: false,
                                    }
                                }
                            ]
                }
                jQuery.extend( json_data, extend );
                var sliderMock = $(this).not('.slick-initialized');
                sliderMock.on('init', function(){
                    $(window).load(function(){
                        $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                    });
                    $(window).resize(function(){
                        $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                    });
                });
                sliderMock.slick( json_data );

            }

        });

        // style 03,04
        $('.sc_gallery_carousel').each(function(index, el) {
            var id_class = $(this).attr('data-item');
            $(this).find('.image-gallery-wrapper  a').attr('data-fancybox-group','group-.'+id_class);
        });
        $(".slz-carousel-syncing").each(function() {
            var carousel_item = $(this).find('.slider-nav').attr('data-slidesToShow');
            var slick_for =  $(this).find('.slider-for').data('json');
            if (typeof slick_for !== 'undefined') {
                var extend = {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    adaptiveHeight: true,
                    asNavFor:$(this).find('.slider-nav'),
                }
                jQuery.extend( slick_for, extend );
                $(this).find('.slider-for').slick('unslick');
                $(this).find('.slider-for').slick( slick_for );
            }
            var slick_nav = $(this).find('.slider-nav').data('json');
            if (typeof slick_nav !== 'undefined') {
                var extend = {
                slidesToShow: carousel_item,
                slidesToScroll: 1,
                asNavFor:$(this).find('.slider-for'),
                focusOnSelect: true,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 5
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 601,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 381,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
                }
                jQuery.extend( slick_nav, extend );
                $(this).find('.slider-nav').slick('unslick');
                $(this).find('.slider-nav').slick( slick_nav );
            }
           $(this).addClass('slz-initial');
        });

        //style 5
        $('.slz-carousel-center').each(function(){
            var json_data =  $(this).data('json');
            if (typeof json_data !== 'undefined') {
                var extend = {
                    autoplaySpeed: 4000,
                    centerMode: true,
                    slidesToShow: 1,
                    centerPadding: '22%',
                    responsive: [
                        {
                            breakpoint: 1025,
                            settings: {
                                centerPadding: '15%',
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                centerPadding: '70px',
                            }
                        },
                        {
                            breakpoint: 481,
                            settings: {
                                arrows: false,
                                centerPadding: '15px',
                            }
                        }
                    ]
                }
                jQuery.extend( json_data, extend );
                $(this).slick('unslick');
                $(this).slick( json_data );
            }
        });

    };

    SLZ.gallerycatrgories = function() {
        $(".slz-gallery-feature").each(function() {
            var object = $(this);
            var slider = $(this).find('.service-slider-wrapper');
            if (slider.length) {
                var slideItem = $(this).find('.slide-carousel');
                slideItem.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed:3000,
                    speed:1000,
                    fade: true,
                });
                $(this).find('.slz-sv-item').each(function(index, el) {
                    slideItem.on('afterChange', function(event, slick, currentSlide, nextSlide) {
                    	var data_count = parseInt( $(el).attr('data-count') );
                        if (data_count === parseInt(currentSlide)) {
                            $('.slz-sv-item',object).removeClass('active');
                            $(el).addClass('active');
                        }
                        $(el).click(function() {
                            slideItem.slick('slickGoTo', index, false);
                        });
                    });
                    $(el).click(function() {
                    	var clickplace = parseInt( $(this).attr('data-count') );
                        $('.slz-sv-item',object).removeClass('active');
                        $(this).addClass('active');
                        slideItem.slick('slickGoTo', clickplace, false);
                    });
                });
            }
        });
    };

    $(document).ready(function() {
        SLZ.fancyboxFunction();
        SLZ.isotopeFunction();
        SLZ.fancyboxisotopeFunction();
        SLZ.ajaxfunction();
        SLZ.tab_all_btn();
        SLZ.gallery_carousel();
        SLZ.gallerycatrgories();
        SLZ.gallery_tab();
    });
});

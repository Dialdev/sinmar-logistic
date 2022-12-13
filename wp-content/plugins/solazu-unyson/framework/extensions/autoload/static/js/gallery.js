jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    /*=======================================
    =             MAIN FUNCTION             =
    =======================================*/

    SLZ.fancyboxFunction = function() {
    	// It is no small thumbs
        if($('.fancybox').length) {
            $('.fancybox').fancybox({
                openEffect  : 'elastic',
                closeEffect : 'elastic',
                helpers: {
                    overlay: {
                        locked: false,
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
    }

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
                afterShow: function(){
	               $('body').addClass("fancy-open");
            	},
	            afterClose: function(){
            	   $('body').removeClass("fancy-open");
	            },
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

                var data_pages = $(uniq_id + ' .grid-clone .gallery_atts_more').attr('data-pages');
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
            $(id + ' .slz-btn.btn-loadmore').addClass('hide');
        });
        $('.slz-isotope-nav ul.tab-filter li.tab-all-active div').on('click', function() {
            var id = $(this).parents('.sc_isotope_post').attr('data-block-class');
            $(id + ' .slz-btn.btn-loadmore').removeClass('hide');
        });
    }

    SLZ.isotopeFunction = function() {
        // effect hover
        $('.slz-isotope-grid-2 .slz-block-gallery-01 .block-image').directionalHover();
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
        $('.gallery-list .grid-item').directionalHover();
        // get fancybox image related
        $('.sc_gallery_tab  .tab-pane').each(function(index, el) {
            $(this).find('.block-image a').attr('data-fancybox-group','group-#'+$(this).attr('id'));
        });

        // gallery style 01
        $(".slz-gallery-tab-01").each(function(){
            var carousel_item = parseInt($(this).attr('data-slidestoshow'));
            var dots = $(this).attr('data-dots');
            var arrow = $(this).attr('data-arrows');
            var autoplay = $(this).attr('data-autoplay');
            var loop = $(this).attr('data-infinite');
            var speed = $(this).attr('data-speed');
            var animation = $(this).attr('data-animation');
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }
            if( speed == 0 || speed == '' || speed == undefined){
                speed = 500;
            }
            if ( animation == '1' ) {
                animation = true;
            }else{
                animation = false;
            }
            if (carousel_item == 1) {
                $(this).find('.gallery-list').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: arrow,
                    dots: dots,
                    autoplay: autoplay,
                    infinite: loop,
                    speed: speed,
                    fade: animation,
                    prevArrow:'<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
                    nextArrow:'<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
                });
            }
            if (carousel_item == 2) {
                $(this).find('.gallery-list').slick({
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: arrow,
                    dots: dots,
                    autoplay: autoplay,
                    infinite: loop,
                    speed: speed,
                    fade: animation,
                    prevArrow:'<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
                    nextArrow:'<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
                    responsive: [{
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item == 3) {
                $(this).find('.gallery-list').slick({
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: arrow,
                    dots: dots,
                    autoplay: autoplay,
                    infinite: loop,
                    speed: speed,
                    fade: animation,
                    prevArrow:'<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
                    nextArrow:'<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
                    responsive: [{
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item >= 4) {
                $(this).find('.gallery-list').slick({
                    slidesToShow: carousel_item,
                    slidesToScroll: carousel_item,
                    arrows: arrow,
                    dots: dots,
                    autoplay: autoplay,
                    infinite: loop,
                    speed: speed,
                    fade: animation,
                    prevArrow:'<button class="btn btn-prev"><i class="icons fa fa-angle-left"><i></button>',
                    nextArrow:'<button class="btn btn-next"><i class="icons fa fa-angle-right"><i></button>',
                    responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    }, {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            }
         });

        // gallery style 02
        if($('.sc_gallery_tab .slz-isotope-grid-2.grid-main').length) {
            $('.sc_gallery_tab .slz-isotope-grid-2.grid-main').each(function(){
                var number = $(this).closest('.sc_gallery_tab').attr('data-number');
                var $grid = $(this).isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true,
                    filter: ':nth-child(-n+'+ number +')',
                    masonry: {
                        columnWidth: '.grid-item'
                    }
                });

                // bind filter button click
                $(this).parents('.sc_gallery_tab').find('.tab-filter .tab_item').on('shown.bs.tab', function (e) {
                    $(this).closest('.sc_gallery_tab').find('.tab-pane.active .btn-loadmore').attr('data-number', number).show();
                    var $grid = $(this).parents('.sc_gallery_tab').find('.slz-isotope-grid-2.grid-main').isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        filter: ':nth-child(-n+'+ number +')',
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });
                });

                // check hsow or hide load more button
                var all_items  =  $(this).find('.grid-item').length;
                if( number >= all_items ){
                    $(this).parent().find('.btn-loadmore-wrapper').remove();
                }
            });
             $('.sc_gallery_tab .tab-content .tab-pane .btn-loadmore').on('click', function(event) {
                var number  = $(this).closest('.sc_gallery_tab').attr('data-number');
                var current = $(this).attr('data-number');
                var all_items  =  $(this).closest('.tab-pane').find('.slz-isotope-grid-2.grid-main .grid-item').length;
                var new_number = parseInt( number ) + parseInt( current );
                $(this).closest('.sc_gallery_tab').find('.slz-isotope-grid-2.grid-main').isotope({
                    itemSelector: '.grid-item',
                    filter: ':nth-child(-n+'+ new_number +')',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.grid-item'
                    }
                });
                $(this).attr('data-number', new_number);
                if( new_number >= all_items ){
                    $(this).hide();
                }
             });
        } 
    };

    SLZ.gallery_carousel = function() {
        // effect hover
        $('.sc_gallery_carousel .slz-carousel .item').directionalHover();

        $('.sc_gallery_carousel').each(function(index, el) {
            var id_class = $(this).attr('data-item');
            $(this).find('.block-image a').attr('data-fancybox-group','group-.'+id_class);
            $(this).find('.image-gallery-wrapper a').attr('data-fancybox-group','group-.'+id_class);
        });

        // layout 1
        $(".sc_gallery_carousel .slz-carousel").each( function(e, val) {
            var carousel_item = parseInt($(this).attr('data-slidestoshow'));
            var dots = $(this).attr('data-dotshow');
            var arrow = $(this).attr('data-arrowshow');
            var autoplay = $(this).attr('data-autoplay');
            var loop = $(this).attr('data-infinite');
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }

            if (carousel_item == 1) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>'
                });
            }
            if (carousel_item == 2) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item == 3) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }]
                });
            }
            if (carousel_item >= 4) {
                $(this).slick({
                    infinite: loop,
                    autoplay: autoplay,
                    slidesToShow: carousel_item,
                    slidesToScroll: carousel_item,
                    dots: dots,
                    arrows: arrow,
                    appendArrows: $(this).parents('.slz-image-carousel'),
                    prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                    nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                    responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    }, {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }, {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            }
        });

        // layout 2
        $(".sc_gallery_carousel .slz-carousel-mockup").each(function() {
            var dots = $(this).find('.slz-slick-slider-mockup').attr('data-dotshow');
            var arrow = $(this).find('.slz-slick-slider-mockup').attr('data-arrowshow');
            var autoplay = $(this).find('.slz-slick-slider-mockup').attr('data-autoplay');
            var loop = $(this).find('.slz-slick-slider-mockup').attr('data-infinite');
            var sliderMock = $(this).find('.slz-slick-slider-mockup');
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }
            sliderMock.on('init', function(){
                $(window).load(function(){
                    $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                });
                $(window).resize(function(){
                    $(this).find(".slider-mockup").css("width", $(this).find('img.img-slider-item').width() + 30);
                });
            });
            sliderMock.slick({
                infinite: loop,
                autoplay: autoplay,
                dots: dots,
                arrows: arrow,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                centerPadding: '160px',
                focusOnSelect: true,
                autoplaySpeed: 2000,
                appendArrows: $(this).find('.slz-slick-slider-mockup').parents('.slz-image-carousel'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
                responsive: [
                    {
                        breakpoint: 1025,
                        settings: {
                            centerPadding: '100px',
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            centerPadding: '0',
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '200px',
                        }
                    },
                    {
                        breakpoint: 601,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '120px',
                        }
                    },
                    {
                        breakpoint: 481,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '80px',
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 415,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            centerPadding: '30px',
                            arrows: false,
                        }
                    }
                ]
            })
           
        });

        // layout 3,4
        $(".sc_gallery_carousel.slz-carousel-syncing").each(function() {
            var carousel_item = parseInt($(this).find('.slider-nav').attr('data-slidestoshow'));
            var dots = $(this).find('.slider-nav').attr('data-dotshow');
            var loop = $(this).find('.slider-nav').attr('data-infinite');
            var arrow = $(this).find('.slider-for').attr('data-arrowshow');
            var autoplay = $(this).find('.slider-for').attr('data-autoplay');
            var dots2 = $(this).find('.slider-for').attr('data-dotshow');
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( dots2 == '1' ) {
                dots2 = true;
            }else{
                dots2 = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }

            //$(this).find('.slider-for').slick( 'unslick' );
            $(this).find('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: arrow,
                dots: dots2,
                fade: true,
                adaptiveHeight: true,
                asNavFor: $(this).find('.slider-nav'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span> <i class="icons fa"></i></button>',
            });

            //$(this).find('.slider-nav').slick( 'unslick' );
            $(this).find('.slider-nav').slick({
                slidesToShow: carousel_item,
                slidesToScroll: 1,
                asNavFor: $(this).find('.slider-for'),
                focusOnSelect: true,
                arrows: false,
                infinite: loop,
                centerMode: true,
                centerPadding: '0px',
                dots: dots,
                responsive: [{
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 601,
                    settings: {
                        slidesToShow: 4
                        }
                    }, {
                    breakpoint: 415,
                    settings: {
                        slidesToShow: 3
                        }
                    }, {
                    breakpoint: 381,
                    settings: {
                        slidesToShow: 2
                    }
                }]
            });
        });

        // layout 5
        $('.sc_gallery_carousel.slz-carousel-centermode .carousel-overflow').each(function(){
            var dots = $(this).attr('data-dotshow');
            var loop = $(this).attr('data-infinite');
            var arrow = $(this).attr('data-arrowshow');
            var autoplay = $(this).attr('data-autoplay');
            if ( dots == '1' ) {
                dots = true;
            }else{
                dots = false;
            }
            if ( arrow == '1' ) {
                arrow = true;
            }else{
                arrow = false;
            }
            if ( autoplay == '1' ) {
                autoplay = true;
            }else{
                autoplay = false;
            }
            if ( loop == '1' ) {
                loop = true;
            }else{
                loop = false;
            }

            $(this).slick({
                infinite: loop,
                autoplay: autoplay,
                dots: dots,
                arrows: arrow,
                centerMode: true,
                slidesToShow: 1,
                centerPadding: '22%',
                appendArrows: $(this).parents('.slz-image-carousel'),
                prevArrow: '<button class="btn btn-prev"><i class="icons fa"></i><span class="text">Previous</span></button>',
                nextArrow: '<button class="btn btn-next"><span class="text">Next</span><i class="icons fa"></i></button>',
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
            });
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
    SLZ.instagram_slider = function(){
        if($(".slz-carousel-photos .slz-carousel").length){
            $(".slz-carousel-photos .slz-carousel").each(function() {
                var carousel_item = $(this).attr('data-slidesToShow');
                if( carousel_item == '' ){
                    carousel_item = 4;
                }
                if (carousel_item == 1) {
                    $(this).slick({
                        slidesToShow: carousel_item,
                        dots: true,
                        arrows: false,
                    });
                }
                if (carousel_item == 2) {
                    $(this).slick({
                        slidesToShow: carousel_item,
                        dots: true,
                        arrows: false,
                        responsive: [{
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });
                }
                if (carousel_item == 3) {
                    $(this).slick({
                        slidesToShow: carousel_item,
                        dots: true,
                        arrows: false,
                        responsive: [{
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        }, {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });
                }
                if (carousel_item >= 4) {
                    $(this).slick({
                        slidesToShow: carousel_item,
                        dots: true,
                        arrows: false,
                        responsive: [{
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                            }
                        }, {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                            }
                        }, {
                            breakpoint: 481,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            }
                        }]
                    });
                }
            });

            $('.slz-carousel-photos .slz-carousel .thumb').directionalHover({
                speed: 200
            });

            $('.slz-instagram .item').directionalHover({
                speed: 200
            });

            if($(".slz-instagram").hasClass("slz-image-carousel")){
                $('.slz-carousel-photos .slz-carousel .item').directionalHover();
            }

        }
    }

    $(document).ready(function() {
        SLZ.fancyboxFunction();
        SLZ.isotopeFunction();
        SLZ.fancyboxisotopeFunction();
        SLZ.ajaxfunction();
        SLZ.tab_all_btn();
        SLZ.gallery_carousel();
        SLZ.gallerycatrgories();
        SLZ.gallery_tab();
        SLZ.instagram_slider();
    });

});

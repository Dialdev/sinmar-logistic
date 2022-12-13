jQuery(function($) {
    "use strict";

    var transera = window.transera || {};

    transera.mainFunction = function() {
        if ($('.back-to-top').length) {
            var scrollTrigger = 100; // px
            var backToTop = function() {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.back-to-top').addClass('show');
                } else {
                    $('.back-to-top').removeClass('show');
                }
            };

            backToTop();

            $(window).on('scroll', function() {
                backToTop();
            });

            $('.back-to-top').on('click', function(e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        }

        // append span tag to title widget
        $(".slz-sidebar-column .title-widget").each(function(e){
            var str = $(this).text();
            $(this).html("<span>"+str+"</span>");
        })

    }

    transera.headerFunction = function() {

        //sub header
        $('.slz-header-main .slz-menu-icon').on('click', function(e) {
            e.preventDefault();
            $(this).parents('.slz-header-wrapper').find('.slz-menu-wrapper').addClass('open');
            $('.subheader-mask').addClass('active');
        });
        $('.slz-sub-header .slz-menu-icon').on('click', function(e) {
            e.preventDefault();
            $(this).parents('.slz-header-wrapper').find('.slz-menu-wrapper').removeClass('open');
            $('.subheader-mask').removeClass('active');
        });
        // slz-header-main

        // Show - hide box search on menu
        $('.slz-button-search').on('click', function () {
            $(this).toggleClass('active');
            $(this).next().toggleClass('hide');
            $(this).next().toggleClass('active');
            //$('.nav-search-full .nav-wrapper').toggleClass('addHeight');
            $('.nav-search input').focus();
        });

        //hide box seach when click outside
        $('body').on('click', function (event) {
            if ($('.slz-button-search').has(event.target).length == 0 && !$('.slz-button-search').is(event.target) && $('.nav-search').has(event.target).length == 0 && !$('.nav-search').is(event.target)) {
                if ($('.nav-wrapper').hasClass('hide') == false) {
                    $('.nav-wrapper').toggleClass('hide');
                    $('.slz-button-search').toggleClass('active');
                    $('.nav-search-full').toggleClass('active');
                }
            }
        });

        // Menu fixded
        if ($('header .slz-header-main').length && $('header .slz-header-main').hasClass('slz-header-sticky')) {
            var header_position = $('header .slz-header-main').offset(),
                lastScroll = 50;
            var window_height = $(window).height();
            $(window).on('scroll load', function (event) {
                var st = $(this).scrollTop();
               if (st > header_position.top) {
                    if($(".slz-header-table").length)
                        $('header .slz-header-table').addClass("slz-header-fixed");
                    else
                        $('header .slz-header-main').addClass("slz-header-fixed");
                }
                else {
                    if($(".slz-header-table").length)
                        $('header .slz-header-table').removeClass("slz-header-fixed");
                    else
                        $('header .slz-header-main').removeClass("slz-header-fixed");
                }

                if (st > lastScroll && st > header_position.top) {
                    if($(".slz-header-table").length)
                        $('header .slz-header-table').addClass("slz-hidden-menu");
                    else
                        $('header .slz-header-main').addClass("slz-hidden-menu");
                }
                else if (st <= lastScroll){
                    if($(".slz-header-table").length)
                        $('header .slz-header-table').removeClass("slz-hidden-menu");
                    else
                        $('header .slz-header-main').removeClass("slz-hidden-menu");
                }

                lastScroll = st;

                if(st == 0) {
                    if($(".slz-header-table").length)
                        $('header .slz-header-table').removeClass("slz-header-fixed");
                    else
                        $('header .slz-header-main').removeClass("slz-header-fixed");
                }
            });
        }

        if ($("#wpadminbar").length) {
            $(".slz-header-main").addClass("slz-wpadminbar");
        }


        // Menu mobile
        $('.slz-hamburger-menu').on('click', function() {
            $('.slz-hamburger-menu .bar').toggleClass('animate');
            $(".slz-main-menu-mobile").toggleClass('slz-open-menu-mobile');
            $(".slz-header-main").toggleClass('slz-unhidden-menu');

            // delete dropdown open
            $('.menu-item-has-children').removeClass('mb-dropdown-open');
            $('.menu-item-has-mega-menu').removeClass('mb-dropdown-open');
        })

        
        $('.slz-main-menu-mobile .slz-menu-wrapper .menu-item-has-children > .icon-dropdown-mobile').on('click', function(){
            if ($(this).closest('.menu-item-has-children').hasClass('mb-dropdown-open') === true) {
                $(this).closest('.menu-item-has-children').removeClass('mb-dropdown-open');
            }
            else {
                $(this).closest('.menu-item-has-children').addClass('mb-dropdown-open');
            }
        });


        // CTA for sub header
        if($('.slz-sub-header').length>0){
            if($('.btn-contact-toggle').length>0){
                $('.btn-contact-toggle').on('click', function(e) {
                    e.preventDefault();
                    // alert("a");
                    $(this).parents('.slz-sub-header').find('.contact').addClass('open');
                    $(this).parents('.slz-sub-header').find('.menu-body').addClass('inactive');
                    $(this).parents('.slz-sub-header').find('.action-top').addClass('inactive');
                    $(this).parents('.slz-sub-header').find('.app-post').addClass('inactive');
                });
                $('.slz-close-contact').on('click', function(e) {
                    e.preventDefault();
                    // alert("a");
                    $(this).parents('.slz-sub-header').find('.contact').removeClass('open');
                    $(this).parents('.slz-sub-header').find('.menu-body').removeClass('inactive');
                    $(this).parents('.slz-sub-header').find('.action-top').removeClass('inactive');
                    $(this).parents('.slz-sub-header').find('.app-post').removeClass('inactive');
                });
            }
            $('.subheader-mask').click(function(event) {
                /* Act on the event */
                $(this).removeClass('active');
                $('.contact').removeClass('open');
                $('.menu-body').removeClass('inactive');
                $('.action-top').removeClass('inactive');
                $('.app-post').removeClass('inactive');
                $('.slz-menu-wrapper').removeClass('open');
            });
        }

        //hide menu mobile when click outside
        $('body').on('click', function (event) {
            if ($('.slz-hamburger-menu').has(event.target).length === 0 && !$('.slz-hamburger-menu').is(event.target) && $('.slz-main-menu-mobile').has(event.target).length === 0 && !$('.slz-main-menu-mobile').is(event.target)) {
                if ($('.slz-main-menu-mobile').hasClass('slz-open-menu-mobile')) {
                    $('.slz-hamburger-menu .bar').toggleClass('animate');
                    $('.slz-main-menu-mobile').toggleClass('slz-open-menu-mobile');
                    $('.slz-header-main').toggleClass('slz-unhidden-menu');

                    // delete dropdown open
                    $('.menu-item-has-children').removeClass('mb-dropdown-open');
                    //$('.menu-item-has-mega-menu').removeClass('mb-dropdown-open');
                }
            }
        });
        $(function() {
            $('.slz-header-wrapper a[href*="#"]:not([href="#"])').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }
            });
        });
        $('.js-questionForm').parent().submit(function(){
            yaCounter49288759.reachGoal('Vopros');
            console.log('Vopros ok');
        });
        $('.js-formModal').parent().submit(function(){
            yaCounter49288759.reachGoal('Zayavka');
            console.log('Zayavka ok');
        });
    }
    /*======================================
    =            INIT FUNCTIONS            =
    ======================================*/

    $(document).ready(function() {
        transera.mainFunction();
        transera.headerFunction();
    });



    /*=====  End of INIT FUNCTIONS  ======*/


});

jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.slz_progressbar_1 = function() {
        if ($('.slz-progress-bar-01').length) {
            $(".progress-bar").each(function() {
                var unit = $(this).attr('data-unit');
                var each_bar_width = $(this).attr('aria-valuenow');
                $(this).animate({
                    width: each_bar_width + unit
                });
                $(this).parent().parent().find('.percent').attr('data-to', each_bar_width);
                $(this).parent().parent().find('.percent').countTo({
                    onUpdate: function(value) {
                        $(this).append(unit);
                    }
                });
                
            });
        }

        // $(document).bind('scroll', function(ev) {
        //     $('.progress-bar').each(function() {
        //         var target = $(this).offset().top - window.innerHeight;
        //         if( $(document).scrollTop() > target ){
        //             var unit = $(this).attr('data-unit');
        //             var each_bar_width = $(this).attr('aria-valuenow');
        //             $(this).animate({
        //                 width: each_bar_width + unit
        //             });
        //             $(this).parent().parent().find('.percent').attr('data-to', each_bar_width);
        //             $(this).parent().parent().find('.percent').countTo({
        //                 onUpdate: function(value) {
        //                     $(this).append(unit);
        //                 }
        //             });
        //             if ($(this).hasClass("animated")){
        //                 $(document).unbind('scroll');
        //             }
        //         }
        //     });
        // })
    };



    SLZ.slz_progressbar_2 = function() {
        $('.slz-progress-bar-02'). each(function(index, el) {
            var block_class = $(this).find('.progress-circle').attr('data-block-class');
            var circle_options = $(this).find('.progress-circle').data('plugin-options');
            var circle = document.getElementById('circle-'+block_class);
            var unit = $(this).attr('data-unit');
            if (circle) {
                var c = circle.getContext('2d');
                var posX = circle.width / 2,
                    posY = circle.height / 2,
                    fps = 5,
                    procent = 0,
                    oneProcent = 360 / 100,
                    circle_percent = $(this).find('.progress-circle').attr('data-percent'),
                    result = oneProcent * circle_percent;


                var deegres = 0;
                var acrInterval = setInterval(function() {
                    deegres += 1;
                    c.clearRect(0, 0, circle.width, circle.height);


                    c.beginPath();
                    c.arc(posX, posY, 70, (Math.PI / 180) * 270, (Math.PI / 180) * (270 + 360));
                    c.strokeStyle = circle_options.trackColor;
                    c.lineWidth = circle_options.lineWidthCircle;
                    c.stroke();

                    c.beginPath();
                    c.strokeStyle = circle_options.barColor;
                    c.lineWidth = circle_options.lineWidth;
                    c.arc(posX, posY, 70, (Math.PI / 180) * 270, (Math.PI / 180) * (270 + deegres));
                    c.stroke();
                    $(this).find('.percent').html((deegres / oneProcent).toFixed(0) + '%');
                    if (deegres >= result) {
                        clearInterval(acrInterval);
                        $('.'+block_class + ' span.percent').html( circle_percent + unit );
                    }
                }, fps);

            }
            
        });
    };

    $(document).ready(function() {
        SLZ.slz_progressbar_1();
        SLZ.slz_progressbar_2();
    });

});

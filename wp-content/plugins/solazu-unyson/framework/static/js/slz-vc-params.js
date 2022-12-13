jQuery(function ($) {
    "use strict";

    var SLZ = window.SLZ || {};

    SLZ.file_picker_option = function () {

       wp.media.view.Attachment.prototype.toggleSelectionHandler = function(a) {
           var b;
           if ("INPUT" !== a.target.nodeName && "BUTTON" !== a.target.nodeName) {
               if (37 === a.keyCode || 38 === a.keyCode || 39 === a.keyCode || 40 === a.keyCode)
                   return void this.controller.trigger("attachment:keydown:arrow", a);
               if ("keydown" !== a.type || 13 === a.keyCode || 32 === a.keyCode) {
                   if (a.preventDefault(),
                           this.controller.isModeActive("grid")) {
                       if (this.controller.isModeActive("edit"))
                           return void this.controller.trigger("edit:attachment", this.model, a.currentTarget);
                       this.controller.isModeActive("select") && (b = "toggle")
                   }
                   a.shiftKey ? b = "between" : (a.ctrlKey || a.metaKey) && (b = "toggle"),
                       this.toggleSelection({
                           // method: b
                           method: 'toggle'
                       }),
                       this.controller.trigger("selection:toggle")
               }
           }
       };

        $('.button_add_media').click(function (e) {

            var input = $(this).parent().find('.attach_files_field').eq(0);
            var display = $(this).parent().find('.attach_files_display ul');

            var frame;
            if( ! frame ) {
                frame = new wp.media.view.MediaFrame.Post({
                    title    : 'Media Select',
                    editing  : true,
                    multiple : true,
                    button   : { text : 'Insert' },
                });

                frame.on( 'open' , function() {
                    var state = frame.state();
                    var selection = state.get('selection');

                    if ( ! selection ) return;

                    selection.each(function(file) {
                        var attachment = wp.media.attachment( file.id );
                        attachment.fetch();
                        selection.remove( attachment ? [ attachment ] : [] );
                    });

                    var files = [];

                    if( input.val() ) {
                        files = JSON.parse( input.val() );
                    }

                    if( Array.isArray( files ) ) {
                        $.each( files, function ( files_index, id ) {
                            var attachment = wp.media.attachment( id );
                            attachment.fetch();
                            selection.add( attachment ? [ attachment ] : [] );
                        });
                    }

                });

                frame.on( 'insert' , function () {
                    var state = frame.state();
                    var selection = state.get('selection');
                    if ( ! selection ) return;

                    var files = [];
                    display.html('');
                    selection.each(function(attachment) {
                        var atts = attachment.attributes;
                        files.push( atts.id );
                        display.append('<li class="media-box" data-id="'+ atts.id +'"><a href="javascript:void(0);" class="btn-remove"><i class="icon-remove"></i><div class="title">'+ atts.filename +'</div><div class="thumb"></div></a></li>');
                        if( atts.type == 'image' )
                        {
                            display.find('li[data-id="'+ atts.id +'"] .thumb').eq(0).css('background-image', 'url(' + atts.url + ')');
                        } else {
                            display.find('li[data-id="'+ atts.id +'"] .thumb').eq(0).css('background-image', 'url(' + atts.icon + ')');
                        }
                        $('.btn-remove').off().click(function (e) {
                            var input = $(this).parents('.slz-attach-files-block').find('.attach_files_field');
                            var files = JSON.parse( input.val() );

                            if( ! files ) {
                                return;
                            }

                            var currId = parseInt( $(this).parents('li').attr('data-id') );
                            var pos = files.indexOf( currId );
                            if( pos >= 0 ) {
                                files.splice( pos, 1);
                                input.val( JSON.stringify( files ) );
                                $(this).parents('li').eq(0).remove();
                            }
                        });
                    });

                    var json_value = JSON.stringify( files );
                    input.val( json_value );
                });
            }

            frame.open();

        });

        $('.btn-remove').click(function (e) {
            var input = $(this).parents('.slz-attach-files-block').find('.attach_files_field');
            var files = JSON.parse( input.val() );

            if( ! files ) {
                return;
            }

            var currId = parseInt( $(this).parents('li').attr('data-id') );
            var pos = files.indexOf( currId );
            if( pos >= 0 ) {
                files.splice( pos, 1);
                input.val( JSON.stringify( files ) );
                $(this).parents('li').eq(0).remove();
            }
        });

    };
    SLZ.datetimepicker = function () {
       $('.datepicker').datetimepicker({
            timepicker:false,
            format:'Y-m-d'
        });
        $('.timepicker').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:15
        });
        $('#datetimepicker').datetimepicker({
            timepicker:true,
            format:'Y-m-d H:i'
        });
    }
    $(document).ready(function () {
        SLZ.datetimepicker();
        SLZ.file_picker_option();
        $('li.vc_param_group-add_content').bind('click', function () {
            setTimeout(function () {
                SLZ.file_picker_option();
            }, 1000);
        });
        $('a.vc_control.column_clone').bind('click', function () {
            setTimeout(function () {
                SLZ.file_picker_option();
            }, 2100);
        });
    });
});

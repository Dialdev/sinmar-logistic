jQuery(document).ready(function($) {
    "use strict";

    //page option addable
    setTimeout(function(){
        check_footer_top_style_change();
        if($('#slz-option-page-footer-style-footer_04-footer-top-status--checkbox').val() == '"enable"'){
            check_footer_top_addable_option();
        }
    }, 1000);

    $(".slz-options-tabs-list ul li:nth-child(3)").on('click', function(){
        setTimeout(function(){
            check_footer_top_style_change();
            if($('#slz-option-slz-footer-style-group-footer_01-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_02-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_03-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_04-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_04-footer-main-footer-main-enable--checkbox').val() == '"enable"'){
                alert('1');
                check_footer_top_addable_option();
            }
        }, 1000);
    });

    function check_footer_top_style_change(){

        // page options
        $('#slz-option-page-footer-style-footer-style ul li').on('click', function(){
            $('#slz-option-page-footer-style-footer_04-footer-top-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            $('#slz-option-page-footer-style-footer_04-footer-main-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            
            if($('#slz-option-page-footer-style-footer_04-footer-top-status--checkbox').val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            if($('#slz-option-page-footer-style-footer_04-footer-main-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }

        });

        //theme option
        $('#slz-option-slz-footer-style-group-slz-footer-style ul li').on('click', function(){
            $('#slz-option-slz-footer-style-group-footer_01-footer-top-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            $('#slz-option-slz-footer-style-group-footer_02-footer-top-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            $('#slz-option-slz-footer-style-group-footer_03-footer-top-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            $('#slz-option-slz-footer-style-group-footer_04-footer-top-status--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });
            $('#slz-option-slz-footer-style-group-footer_04-footer-main-footer-main-enable--checkbox').on('change', function(){
                if($(this).val() == '"enable"'){
                    check_footer_top_addable_option();
                }
            });


            if($('#slz-option-slz-footer-style-group-footer_01-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_02-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_03-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_04-footer-top-status--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
            if($('#slz-option-slz-footer-style-group-footer_04-footer-main-footer-main-enable--checkbox').val() == '"enable"'){
                check_footer_top_addable_option();
            }
        });
    }

    function check_footer_top_addable_option(){

        if($('.slz-footer-top-addable-option-01').length > 0 ){
            addable_option_btn_add_click();
            addable_option_btn_remove_click();
            if(($('.slz-footer-top-addable-option-01 table tbody tr').length ) == 3){
                $('.slz-footer-top-addable-option-01 button.slz-option-type-addable-option-add').attr('disabled', true);
            }
        }
        if($('.slz-footer-top-addable-option-02').length > 0 ){
            addable_option_btn_add_click();
            addable_option_btn_remove_click();
            if(($('.slz-footer-top-addable-option-02 table tbody tr').length ) == 3){
                $('.slz-footer-top-addable-option-02 button.slz-option-type-addable-option-add').attr('disabled', true);
            }
        }
        if($('.slz-footer-top-addable-option-03').length > 0 ){
            addable_option_btn_add_click();
            addable_option_btn_remove_click();
            if(($('.slz-footer-top-addable-option-03 table tbody tr').length ) == 3){
                $('.slz-footer-top-addable-option-03 button.slz-option-type-addable-option-add').attr('disabled', true);
            }
        }
        if($('.slz-footer-top-addable-option-04').length > 0 ){
            addable_option_btn_add_click();
            addable_option_btn_remove_click();
            if(($('.slz-footer-top-addable-option-04 table tbody tr').length ) == 3){
                $('.slz-footer-top-addable-option-04 button.slz-option-type-addable-option-add').attr('disabled', true);
            }
        }
        if($('.slz-footer-addable-option-04').length > 0 ){
            addable_option_btn_add_click();
            addable_option_btn_remove_click();
            if(($('.slz-footer-addable-option-04 table tbody tr').length ) == 6){
                $('.slz-footer-addable-option-04 button.slz-option-type-addable-option-add').attr('disabled', true);
            }
        }
    }
    function addable_option_btn_add_click(){

        //page option
        $('#slz-option-page-footer-style-footer_04-footer-top-enable .slz-footer-top-addable-option-04 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-top-addable-option-04').find('table tbody tr').length ) == 3){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
        $('#slz-option-page-footer-style-footer_04-footer-main-enable .slz-footer-addable-option-04 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-addable-option-04').find('table tbody tr').length ) == 6){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });

        //theme options
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-01 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-top-addable-option-01').find('table tbody tr').length ) == 3){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-02 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-top-addable-option-02').find('table tbody tr').length ) == 3){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-03 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-top-addable-option-03').find('table tbody tr').length ) == 3){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-04 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-top-addable-option-04').find('table tbody tr').length ) == 3){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
        $('#slz-options-tab-footer_tab .slz-footer-addable-option-04 button.slz-option-type-addable-option-add').on('click', function(){
            if(($(this).closest('.slz-footer-addable-option-04').find('table tbody tr').length ) == 6){
                $(this).attr('disabled', true);
            }
            addable_option_btn_remove_click();
        });
    }
    function addable_option_btn_remove_click(){
    
        //page option
        $('#slz-option-page-footer-style-footer_04-footer-top-enable .slz-footer-top-addable-option-04 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-top-addable-option-04').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
         $('#slz-option-page-footer-style-footer_04-footer-main-enable .slz-footer-addable-option-04 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-addable-option-04').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });

        //theme option
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-01 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-top-addable-option-01').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-02 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-top-addable-option-02').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-03 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-top-addable-option-03').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
        $('#slz-options-tab-footer_tab .slz-footer-top-addable-option-04 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-top-addable-option-04').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
        $('#slz-options-tab-footer_tab .slz-footer-addable-option-04 table a.slz-option-type-addable-option-remove').on('click', function(){
            $(this).closest('.slz-footer-addable-option-04').find('button.slz-option-type-addable-option-add').attr('disabled', false);
        });
    }
   
});

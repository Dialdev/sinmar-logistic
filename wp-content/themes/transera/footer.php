<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Transera
 * @since 1.0
 */
?>

<?php

if ( transera_check_extension('footers') ) {

	if ( is_page( ) ) {

		$transera_selected_footer = slz_get_db_post_option( get_the_ID(), 'page-footer-style' );

		if ( $transera_selected_footer == 'default' )
			unset ( $transera_selected_footer );

	}

	if ( empty ( $transera_selected_footer ) && slz_get_db_settings_option('slz-footer-style-group/slz-footer-style', false) ){

		$transera_selected_footer = slz_get_db_settings_option('slz-footer-style-group/slz-footer-style', '');

	}

	if ( !empty ( $transera_selected_footer ) ) {

		$transera_footer = slz_ext('footers')->get_footer( $transera_selected_footer );

		if ( !empty ( $transera_footer ) )
			$transera_footer->render();

	}

}
else
	get_template_part('default-templates/footer');

?>

	</div>
</div>
<?php

	if ( defined('SLZ') ) {

		if ( slz_get_db_settings_option('enable-scroll-to', '') == 'yes' ) {
			$transera_scroll_settings = slz_get_db_settings_option('scroll-to-top-styling', '');

			$transera_icon = '<i class="fa fa-angle-up"></i>';

			if ( !empty ( $transera_scroll_settings ) ) {

				if ( $transera_scroll_settings['icon-type']['icon-box-img'] == 'icon-class' && ! empty( $transera_scroll_settings['icon-type']['icon-class']['icon_class'] ) ) {

					$transera_icon = '<i class="' . esc_attr( $transera_scroll_settings['icon-type']['icon-class']['icon_class'] ) . '"></i>';

				} elseif ( $transera_scroll_settings['icon-type']['icon-box-img'] == 'upload-icon' && ! empty( $transera_scroll_settings['icon-type']['upload-icon']['upload-custom-img'] ) ) {

					$transera_icon = '<img src="' . esc_url ( $transera_scroll_settings['icon-type']['upload-icon']['upload-custom-img']['url'] ) . '"/>';
				}

			}

			echo '<div class="btn-wrapper back-to-top"><a href="#top" class="btn btn-transparent">' . wp_kses_post( $transera_icon ) . '</a></div>';

		}

	}
?>
<?php
if( defined('SLZ') && function_exists('slz_get_live_setting') ) {
	slz_get_live_setting();
}
?>
<?php wp_footer(); ?>


<div class="foterlang">
    <?php  dynamic_sidebar( 'sidebarlangbottom' ); ?>
</div>

<div class="slz-footer-bottom" style="display:block ! important;">
            <div class="container">
                <!-- left area -->
                                        <div class="item-wrapper item-left">

                             <!--Text-->
                                                            <div class="item">

                                    <div class="slz-name">
<?php _e('<!--:en-->2000 – 2020 LLC «SinMar»<br>
Freight Forwarding Company.<!--:--><!--:ru-->2000 – 2020 ООО «СинМар»<br>
Транспортная компания. <!--:-->'); ?>
                                        <br>
                                        <a href="/policy.pdf" target="_blank" style="color: white">Политика конфедициальности</a>


</div>
                                </div>

                             <!--Social-->

                             <!--navigation-->

                             <!--Image-->

                           <!--Button-->
                                                         <!--End Option-->

                        </div>                        <div class="item-wrapper item-right">

                             <!--Text-->
                                                            <div class="item">
                                    <div class="slz-name">
<?php _e('<!--:en-->When citing the content from this website, you must refer to the source and include the link in your reference.<!--:--><!--:ru-->При использовании материалов обязательно указывать ссылку на сайт. <!--:-->'); ?>


                                   </div>
                                </div>

                             <!--Social-->
                                                            <div class="item">
                                                                    </div>

                             <!--navigation-->

                             <!--Image-->

                           <!--Button-->
                                                         <!--End Option-->

                        </div>                <!-- <div class="clearfix"></div> -->
            </div>
        </div>

<?php echo do_shortcode('<div class="fancybox-hidden"><div id="contact_form_pop" class="popupform" style="width: 100%;"> [contact-form-7 id="3176" style="wi"title="Всплывающая форма"]</div></div>');
?>

<?php echo do_shortcode('<div class="fancybox-hidden">
<div id="contact_form_pop_en" class="popupform">
[contact-form-7 id="3313" title="Всплывающая форма EN"]
</div>
</div>')?>
<div style="dispay:none" class="fancybox-hidden">
    <div id="search-form" class="search-form__container">
        <div class="search-form__title">Поиск по сайту</div>
        <?php get_search_form(); ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script src="/wp-content/themes/transera/static/libs/jquery.inputmask/jquery.inputmask.min.js"></script>
<script>
    jQuery(function () {
        jQuery('input[type="tel"]').inputmask("+7-999-999-99-99");
        jQuery('.slz-button-search').fancybox({ 
            type: 'inline',
            href: '#search-form'
        });
    });
</script> 
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49288759 = new Ya.Metrika2({
                    id:49288759,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49288759" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110503576-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-110503576-1');
</script>

<script>
	jQuery(function(){
		jQuery( "body" ).on( "submit", "form", function() {
			yaCounter49288759.reachGoal('lid');
			console.log("lid ok");
		});
	});
</script>

</body>
</html>

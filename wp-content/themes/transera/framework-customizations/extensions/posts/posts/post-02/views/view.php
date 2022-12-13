<?php
$post_class = 'slz-sidebar-left';
$post_col_class = 'col-md-8';

if ( slz_get_db_post_option( get_the_ID(), 'post-sidebar-layout', '' ) != '' && slz_get_db_post_option( get_the_ID(), 'post-sidebar-layout', '' ) != 'default' ){

    if ( slz_get_db_post_option( get_the_ID(), 'post-sidebar-layout', 'left' ) == 'none' )

            $post_col_class = 'col-md-12';

        else 

            $post_class = 'slz-sidebar-' . slz_get_db_post_option( get_the_ID(), 'post-sidebar-layout', 'left' );

}
else {

    if ( slz_get_db_settings_option('blog-sidebar-layout', '' ) == 'right' ){

        $post_class = 'slz-sidebar-right';

    }

    if ( slz_get_db_settings_option('blog-sidebar-layout', '' ) == 'none' ){

        $post_col_class = 'col-md-12';

    }

}
$post_info = array();
$post_info = slz_get_db_settings_option('post-info', array());
$module = new SLZ_Block_Module( get_post(), $post_instance->get_data());
?>

<div class="slz-blog-detail <?php echo esc_attr( $post_class ); ?>">
    <div class="row">
        <div class="<?php echo esc_attr( $post_col_class ); ?> col-sm-12 slz-posts slz-content-column single-posts-02">
            <?php
            while ( have_posts() ) : the_post();
            ?>

                <div class="blog-detail-wrapper">

                    <div class="blog-detail-info">
                        <div class="sub-content">
                            <div class="date-time">
                                <span class="day">
                                    <?php echo get_the_date('j'); ?>
                                </span>
                                <span class="month">
                                    <?php echo get_the_date('M'); ?>
                                </span>
                                <span class="year">
                                    <?php echo get_the_date('Y'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="main-content">
                            <a href="<?php echo get_the_permalink(); ?>" class="title"><?php echo get_the_title(); ?></a>
								<?php echo slz_render_view( $post_instance->locate_path('/views/info.php') ); ?>
							<?php if( in_array( 'view', $post_info) || in_array( 'comment', $post_info ) || slz_is_theme_share_on() ) : ?>
                            <ul class="block-info">
                            	<?php if( in_array( 'view', $post_info) ) : ?>
                                <li>
                                   <a href="javascript:void(0)" class="link user"> <?php echo slz_get_post_view( get_the_ID() ); ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if( in_array( 'comment', $post_info ) ) : ?>
                                <li>
                                    <a href="javascript:void(0)" class="link comment"> <?php echo get_comments_number(); ?> </a>
                                </li>
                                <?php endif; ?>
                                <?php if( slz_is_theme_share_on() ) : ?>
                                <li>
                                    <a href="javascript:void(0)" class="link share"><?php slz_extra_get_count_social_share(); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="entry-content">
                        <?php
                            the_content( sprintf(
								esc_html__( 'Read more %s', 'transera' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'transera' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php edit_post_link( __( 'Edit', 'transera' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>
                </div>

                <div class="slz-post-footer">
                    <div class="meta-content">
						<?php 
							$tags = get_the_tags( get_the_ID() );
							if( $tags ) {
						?>
								<div class="tags-links">
									<?php the_tags('');?>
								</div>
						<?php 
							}
						?>
							<?php slz_extra_get_social_share();?>
                    </div>

                    <?php
                        if ( is_single()  && slz_get_db_settings_option('blog-post-author-box', '' ) == 'yes' ) :
                            get_template_part( 'default-templates/author-bio' );
                        endif;
                    ?>
                    <?php if( !empty( $related_post ) && $related_post->have_posts() ) : ?>

                    <div class="slz-carousel-wrapper slz-related-post slz_single_relate_post">
                        <div class="related-title"><?php echo esc_html__('Related Articles', 'transera'); ?></div>
                        <div class="carousel-overflow">
                            <div data-slidestoshow="3" class="slz-carousel">
                                <?php
                                
                                $posts = $related_post->posts;

                                foreach($posts as $post) {

                                    $module = new SLZ_Block_Module( $post, $related_post->related_args );

                                    echo slz_render_view( $post_instance->locate_path('/views/related_item.php'), compact( 'module' ) );
                                    
                                } ?>
                            </div>
                        </div>
                    </div>
                    <?php  endif; ?>
                </div>

                <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>

            <?php endwhile; ?>

        </div>
        <?php if ( $post_col_class != 'col-md-12' ): ?>

            <div class="col-md-4 col-sm-12 slz-sidebar-column slz-widgets">
            
                <?php 

                    $sidebar = slz()->theme->manifest->get('sidebar_name');


                    if ( slz_get_db_post_option( get_the_ID(), 'post-sidebar', '' ) != '' && slz_get_db_post_option( get_the_ID(), 'post-sidebar', '' ) != 'default' ) {

                        $sidebar = slz_get_db_post_option( get_the_ID(), 'post-sidebar', '' );

                    }
                    else {

                        $sidebar = slz_get_db_settings_option( 'blog-sidebar', $sidebar );

                    }

                    if ( empty ( $sidebar ) )
                        
                        $sidebar = slz()->theme->manifest->get('sidebar_name');

                    if ( is_active_sidebar( $sidebar ) )

                        dynamic_sidebar( $sidebar );

                ?>

            </div>
        <?php endif; ?>

        <div class="clearfix"></div>

    </div>
    
</div>
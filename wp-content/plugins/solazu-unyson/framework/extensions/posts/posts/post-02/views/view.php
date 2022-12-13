<?php
$post_class = 'slz-sidebar-left';
$post_col_class = 'col-md-9';

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
?>

<div class="slz-blog-detail layout-2 <?php echo esc_attr( $post_class ); ?>">
    <div class="row">
        <div class="<?php echo esc_attr( $post_col_class ); ?> col-sm-12 slz-posts slz-content-column single-posts-02">
            <?php
            while ( have_posts() ) : the_post();
            ?>

                <div class="blog-detail-wrapper">

                    <?php the_title( '<h1 class="title">', '</h1>' ); ?>

					<?php 
						
						$module = new SLZ_Block_Module( get_post(), $post_instance->get_data());
						echo slz_render_view( $post_instance->locate_path('/views/info.php'), compact('module')); 
					?>
					
                    <div class="entry-content">
                        <?php
                            the_content( sprintf(
								esc_html__( 'Read more %s', 'slz' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );

							wp_link_pages( array(
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'slz' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span>',
								'link_after' => '</span>',
							) );
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php edit_post_link( __( 'Edit', 'slz' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>
                </div>

                <div class="slz-post-footer">
                	<div class="entry-meta">
						<?php slz_post_categories_meta();?>
						<div class="meta-content">
							<?php slz_post_tags_meta() ?>
							<?php slz_extra_get_social_share();?>
						</div>
	                    <?php slz_post_nav();?>
                    </div>

                    <?php
                        if ( is_single() && get_the_author_meta( 'description' ) && slz_get_db_settings_option('blog-post-author-box', '' ) == 'yes' ) :
                            get_template_part( 'default-templates/author-bio' );
                        endif;
                    ?>
                    <?php if( !empty( $related_post ) && $related_post->have_posts() ) : ?>

                    <div class="slz-carousel-wrapper slz-related-post slz_single_relate_post">
                        <div class="related-title"><?php echo esc_html__('Related Articles', 'slz'); ?></div>
                        <div class="carousel-overflow">
                            <div data-slidestoshow="<?php echo esc_attr($related_post->related_args['related_columns']);?>" class="slz-carousel">
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

            <div class="col-md-3 col-sm-12 slz-sidebar-column slz-widgets">
            
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
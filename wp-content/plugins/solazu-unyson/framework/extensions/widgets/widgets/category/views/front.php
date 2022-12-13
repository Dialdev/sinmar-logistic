<?php

$categories_slug = array();
if ( !empty( $category_slug ) )
	$categories_slug = $category_slug;

echo wp_kses_post($before_widget);

?>
<div class="<?php echo ( $style == 3 ) ? 'slz-categories2' : 'slz-categories'; ?> widget slz-widget-category-<?php echo esc_attr( $unique_id ); ?>">
	<?php echo wp_kses_post( $block_title );?>
	<div class="widget-content clearfix <?php echo ( $style == 2 ) ? 'two-column' : ''; ?>">
		<?php
		if( !empty( $categories_slug ) && count( $categories_slug) == 1 && $categories_slug[0] == '' ) {

			$categories_arr = get_categories();

			foreach ($categories_arr as $item) {

				$links = get_category_link( $item->term_id );

				if ( $style == 3 ) {

					echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $item->name ) . '</span>
						<div class="label-right">' . esc_html( $item->category_count ) . '</div>
					</a>';

				}
				else {
					echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $item->name ) . '</span>';

					if ( $style != 2 )
					echo '<span class="badge">' . esc_html( $item->category_count ) . '</span>';

					echo '</a>';
				}
					
			}

		}elseif( !empty( $categories_slug ) ){

			foreach ($categories_slug as $cat) {

				if ( !empty( $cat ) ) {

					$cat_arr = get_category_by_slug( $cat );

					if( $cat_arr ) {
						$links = get_category_link($cat_arr->term_id);
	
						if ( is_object( $cat_arr ) ) {
	
							if ( $style == 3 ) {
	
								echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $cat_arr->name ) . '</span>
									<div class="label-right">' . esc_html( $cat_arr->category_count ) . '</div>
								</a>';
	
							}
							else {
								echo '<a href="' . esc_url( $links ) . '" class="link"> <i class="icons fa fa-angle-right"></i><span class="text">' . esc_html( $cat_arr->name ) . '</span>';
	
								if ( $style != 2 )
								echo '<span class="badge">' . esc_html( $cat_arr->category_count ) . '</span>';
	
								echo '</a>';
							}
	
						}
					}
				}
			}
		}
		?>
	</div>
</div>

<?php 
echo wp_kses_post( $after_widget );

?>
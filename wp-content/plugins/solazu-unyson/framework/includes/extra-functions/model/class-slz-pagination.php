<?php
class SLZ_Pagination {

	public static function paging_nav( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;
		if( $current_query == '' ) {
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2);
		
		if( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if( ! $pages ) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		$output = $output_page = $showpages = $disable = '';
		$page_format = '<a href="%2$s" class="page-numbers" >%1$s</a>';
		if( 1 != $pages ) {
			$output_page .= '<div class="nav-links">';
			// prev
			if( $paged == 1 ) {
				$disable = 'hide';
			}
			$output_page .= '<a href="'.$method($prev).'" class="prev page-numbers '.$disable.'">'.esc_html__('Previous', 'slz').'</a>';
			// first pages
			if( $paged > $showitems ) {
				$output_page .= sprintf( $page_format, 1, $method(1) );
			}
			// show ...
			if( $paged - $range > $showitems && $paged - $range > 2 ) {
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($paged - $range - 1) );
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					if( $paged == $i ) {
						$output_page .= '<span class="page-numbers current">'.$i.'</span>';
					} else {
						$output_page .= sprintf( $page_format, $i, $method($i) );
					}
					$showpages = $i;
				}
			}
			// show ...
			if( $paged < $pages-1 && $showpages < $pages -1 ){
				$showpages = $showpages + 1;
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($showpages) );
			}
			// end pages
			if( $paged < $pages && $showpages < $pages ) {
				$output_page .= sprintf( $page_format, $pages, $method($pages) );
			}
			//next
			$disable = '';
			if( $paged == $pages ) {
				$disable = 'hide';
			}
			$output_page .= '<a href="'.$method($next).'" class="next page-numbers '.$disable.'">'.esc_html__('Next', 'slz').'</a>';
			$output_page .= '</div>';
			$output = '<div class="slz-pagination pagination-custom"><nav class="navigation pagination">'. $output_page  .'</nav></div>';
		}
		return $output;
	}
	public static function paging_ajax( $pages = '', $range = 2, $current_query = '', $base = '' ) {
		global $paged;
		if( $current_query == '' ) {
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2);
		
		if( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if( ! $pages ) {
				$pages = 1;
			}
		}
		if( empty( $base ) ){
			global $wp;
			$base = $wp->request;
		}
		$method = "slz_extra_get_pagenum_link";
		$output = $output_page = $showpages = $disable = '';
		$page_format = '<a href="%2$s" class="page-numbers" data-page="%3$s">%1$s</a>';
		if( 1 != $pages ) {
			$output_page .= '<div class="nav-links">';
			// prev
			if( $paged == 1 ) {
				$disable = 'hide';
			}
			$output_page .= '<a href="'.$method($prev, $base).'" class="prev page-numbers '.$disable.'" data-page="'.$prev.'">'.esc_html__('Previous', 'slz').'</a></li>';
			// first pages
			if( $paged > $showitems ) {
				$output_page .= sprintf( $page_format, 1, $method(1, $base), 1 );
			}
			// show ...
			if( $paged - $range > $showitems && $paged - $range > 2 ) {
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($paged - $range - 1, $base), $paged - $range - 1 );
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					if( $paged == $i ) {
						$output_page .= '<span class="page-numbers current">'.$i.'</span>';
					} else {
						$output_page .= sprintf( $page_format, $i, $method($i, $base), $i );
					}
					$showpages = $i;
				}
			}
			// show ...
			if( $paged < $pages-1 && $showpages < $pages -1 ){
				$showpages = $showpages + 1;
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($showpages, $base), $showpages );
			}
			// end pages
			if( $paged < $pages && $showpages < $pages ) {
				$output_page .= sprintf( $page_format, $pages, $method($pages, $base), $pages );
			}
			//next
			$disable = '';
			if( $paged == $pages ) {
				$disable = 'hide';
			}
			$output_page .= '<a href="'.$method($next, $base).'" class="next page-numbers '.$disable.'" data-page="'.$next.'">'.esc_html__('Next', 'slz').'</a></li>';
			$output_page .= '</div>'."\n";
			$output = '<div class="slz-pagination"><nav class="navigation pagination">'. $output_page .'</nav></div>';
		}
		$output .= '<div class="hide slz-pagination-base" data-base="'. esc_attr($base) .'"></div>';
		return $output;
	}
}
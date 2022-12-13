<?php
$out = '';
$link = '';

$args = '';
if( !empty( $data['order_sort'] ) ) {
	$args .= 'order='.$data['order_sort'];
}else{
	$args .= 'order=ASC';
}
if ( !empty ( $data['sort_by'] ) ){ 
	$args .= '&orderby='. $data['sort_by'];
} else {
	$args .= '&orderby=name';
}
if ( !empty ( $data['limit_author'] ) ){ 
	$args .= '&number='. $data['limit_author'];
} else {
	$args .= '&number=1';
	$data['limit_author'] = 1;
}
if( !empty( $data['role_author'] ) ) {
	$args .= '&role='.$data['role_author']; 
}
else {
	$args .= '&role='.''; 
}
$paged      = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset     = ($paged - 1) * $data['limit_author'];
$args .= '&offset=' . $offset;
$users      = get_users();
$query      = get_users($args);
$total_users = count($users);
$total_query = count($query);

if($total_users % $data['limit_author']==0) {
	$total_pages = intval($total_users / $data['limit_author']);
}else { 
	$total_pages = intval($total_users / $data['limit_author'])+1;
}

if( !empty( $query ) ) {
	foreach ( $query as $user_obj ) {
		if( is_null( $user_obj ) || !is_object( $user_obj ) ) {
			continue;
		}

		// Get info basic of user
		$url = get_author_posts_url($user_obj->ID);
		$avatar = get_avatar( $user_obj->ID, 140);
		$name = !empty( $user_obj->display_name) ? esc_html ( $user_obj->display_name) : esc_html ($user_obj->user_login);
		$user_post_count = count_user_posts($user_obj->ID);

		// Get total comments of author
		global $wpdb;
		$where = 'WHERE comment_approved = 1 AND user_id = ' . $user_obj->ID;
		$comment_count = $wpdb->get_var("SELECT COUNT( * ) AS total FROM {$wpdb->comments} {$where}");

		// Get website value
		$website = get_the_author_meta('user_url', $user_obj->ID);

		$out .= '<div class="slz-author-detail">';
			$out .= '<div class="block-wrapper">';
				$out .= '<div class="image-wrapper">';
					$out .= $avatar;
				$out .= '</div>';
				$out .= '<div class="content-wrapper">';
					$out .= '
						<div class="heading-wrapper">
							<div class="heading-left">
								<a href="'. esc_url( $url ) .'" class="name">'. esc_html( $name ) .'</a>
								<div class="info-wrapper">
									<ul class="slz-list-inline list-info">
										<li><a href="javascript:void(0)" class="link"><span>'. esc_html( $user_post_count ) .' '. esc_html__( 'posts', 'slz' ) .'</span></a></li>
										<li><a href="javascript:void(0)" class="link"><span>'. esc_html( $comment_count ) .' '. esc_html__( 'commments', 'slz' ) .'</span></a></li>
									</ul>
								</div>
							</div>
							<div class="heading-right">
								<a href="'. esc_url( $website ) .'" class="personal-link">'. esc_url( $website ) .'</a>
								<div class="social-wrapper">
									<ul class="slz-list-inline list-social-wrapper">
					';
										if( !empty( $socials ) ) {
											foreach ( $socials as $keysocial => $valuesocial ) {
												$link = '';
												$link = get_user_meta( $user_obj->ID, $keysocial, true );
												if( empty( $link ) ) {
													continue;
												}
												$out .= '<li><a href="'. esc_url( $link ) .'" class="link"><i class="fa fa-'. esc_attr( $keysocial ) .'"></i></a></li>';
											}// end foreach
										}
											
					$out .= '
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					';
					$out .= '<div class="content-text">'. wp_kses_post( nl2br( $user_obj->description ) ) .'</div>';
				$out .= '</div>';
			$out .= '</div>';
		$out .= '</div>';
		
	}// end foreach
	echo ( $out );
	
	if( $data['show_pagination'] == 'yes' ) {
		$pagination_html = '';
		if ($total_users > $total_query) {
			$current_page = max(1, get_query_var('paged'));
			$pages = paginate_links(array (
				'current' => $current_page,
				'total' => $total_pages,
				'prev_next' => true,
				'prev_text' => esc_html__('Prev','slz'),
				'next_text' => esc_html__('Next', 'slz'),
				'type' => 'array'
			));

			if (is_array($pages)) {
				$pagination_html .= '<nav class="pagination-wrapper"> <ul class="pagination">';
				foreach ($pages as $page) {
					$pagination_html .= "<li>$page</li>";
				}

				$pagination_html .= '
				</ul>
				<div class="position-page">Page <span class="active">' . esc_html($current_page) . ' </span>' . esc_html__('of', 'slz') . ' ' . esc_html($total_pages) . '</div>
				<div class="clearfix"></div>
				</nav>';
			}
		}
		echo ( $pagination_html );
	}
}// end if
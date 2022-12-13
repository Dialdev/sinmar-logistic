<?php
if( !empty( $data['user_id'] ) ) {
	$user_data = get_userdata( $data['user_id'] );
	$out = '';

	if( !empty( $user_data ) ) {
		
		//basic info
		$url = get_author_posts_url( $data['user_id'] );
		$avatar = get_avatar( $data['user_id'], 140);
		$name = !empty( $user_data->display_name) ? esc_html ( $user_data->display_name) : esc_html ($user_data->user_login);
		$user_post_count = count_user_posts( $data['user_id'] );
		
		//commentcount
		global $wpdb;
		$where = 'WHERE comment_approved = 1 AND user_id = ' . $data['user_id'];
		$comment_count = $wpdb->get_var("SELECT COUNT( * ) AS total FROM {$wpdb->comments} {$where}");

		// Get website value
		$website = get_the_author_meta('user_url', $data['user_id']);

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
												$link = get_user_meta( $data['user_id'], $keysocial, true );
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
					$out .= '<div class="content-text">'. wp_kses_post( nl2br( get_the_author_meta( 'description', $data['user_id'] ) ) ) .'</div>';
				$out .= '</div>';
			$out .= '</div>';
		$out .= '</div>';
		echo ( $out );
	}// end if
}
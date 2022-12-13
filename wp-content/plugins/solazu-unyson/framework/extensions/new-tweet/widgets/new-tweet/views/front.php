<?php

echo wp_kses_post($before_widget);

$block_cls = $block['extra_class'] . ' new-tweet-' . $unique_id;

?>

<div class="slz-new-tweet widget <?php echo esc_attr($block_cls) ?>">
	<?php echo wp_kses_post( $block['block_title'] );?>

	<div class="widget-content">

		<?php if( !empty( $tweet_data ) && !isset( $tweet_data['errors'] ) ): ?>

			<div class="list-news-tweet">

			<?php
				
				foreach ($tweet_data as $data) {
					$elements = slz_ext_new_tweet_get_display_elements($data, isset($block['show_media'])?$block['show_media']:false );

					?>

					<div class="recent-post">
						<div class="thumb">
							<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
								<img src="<?php echo esc_url( $data['user']['profile_image_url_https'] ); ?>" alt="" class="img-wrapper">
							</a>
						</div>
						<div class="post-info">
							<div class="title">
								<div class="left-text">
                                    <?php if (isset($block['show_author']) && $block['show_author'] == 'true'): ?>
									<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
										<span class="strongtext">
											<?php echo esc_html( $data['user']['name'] ); ?>
										</span>
									</a>
                                    <?php endif; ?>
                                    <?php if (isset($block['show_author_name']) && $block['show_author_name'] == 'true'): ?>
                                    <a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
										<span class="text">
											<?php echo esc_html__('@', 'slz'); ?><?php echo esc_html( $data['user']['screen_name'] ); ?>
										</span>
									</a>
                                    <?php endif; ?>
                                </div>
                               <div class="right-text">
                                   <?php if (isset($block['show_time']) && $block['show_time'] == 'true'): ?>
                                   <span class="text"><?php echo wp_kses_post( $elements['time_ago'] ). ' ' . esc_html__('ago','slz'); ?></span>
                                   <?php endif; ?>
                               </div>
                                <div class="clearfix"></div>
							</div>
							<div class="description">
								<span class="text">
									<?php echo wp_kses_post( $elements['text'] ); ?>
								</span>
								<?php echo wp_kses_post ( $elements['media'] ); ?>
							</div>
						</div>
						<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>" title="" target="_blank" class="link"></a>
					</div>
					<?php
					if(isset($block['re_tweet'])):
						if($block['re_tweet'] == "true" && isset($data['retweeted_status'])):
							$data = $data['retweeted_status'];
							$elements = slz_ext_new_tweet_get_display_elements($data, ($block['show_media'] == "true")?true:false );
					?>
							<div class="re-tweeet">
								<div class="recent-post">
									<div class="thumb">
										<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
											<img src="<?php echo esc_url( $data['user']['profile_image_url_https'] ); ?>" alt="" class="img-wrapper">
										</a>
									</div>
									<div class="post-info">
										<div class="title">
											<div class="left-text">

												<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
										<span class="strongtext">
											<?php echo esc_html( $data['user']['name'] ); ?>
										</span>
												</a>

												<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>">
										<span class="text">
											<?php echo esc_html__('@', 'slz'); ?><?php echo esc_html( $data['user']['screen_name'] ); ?>
										</span>
												</a>

											</div>
											<div class="right-text">
												<span class="text"><?php echo wp_kses_post( $elements['time_ago'] ). ' ' . esc_html__('ago','slz'); ?></span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="description">
								<span class="text">
									<?php echo wp_kses_post( $elements['text'] ); ?>
								</span>
											<?php echo wp_kses_post ( $elements['media'] ); ?>
										</div>
									</div>
									<a href="<?php echo esc_url('https://twitter.com/'); ?><?php echo esc_attr( $data['user']['screen_name'] ); ?>" title="" target="_blank" class="link"></a>
								</div>
							</div>
					<?php
						endif;
					endif;
				}
			?>
			</div>

		<?php endif; ?>
	
	</div>

</div>

<?php echo wp_kses_post($after_widget); ?>
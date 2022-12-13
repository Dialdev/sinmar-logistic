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
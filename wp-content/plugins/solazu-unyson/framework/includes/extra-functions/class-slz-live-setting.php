<?php
class SLZ_Live_Setting {
	public $colors;
	public $layout_patterns;
	public $boxed_layout_images;
	public $purchase_link;
	public $live_seting_use_img;
	public $header_style;
	public $header_transparent;
	public $header_top_bar;
	public $header_animation;
	public $live_demos;
	
	function __construct( $args = array() ) {
		$default = array(
			'color_list' => '',
			'skin_color_use_img' => '',
			'layout_patterns' => '',
			'boxed_layout_images' => '',
			'purchase_link' => '',
			'header_style' => '',
			'header_transparent' => '',
			'header_top_bar'     => '',
			'header_animation'   => '',
			'live_demos'         => '',
		);
		$args = array_merge( $default, $args );
		$this->colors = $args['color_list'];
		$this->layout_patterns = $args['layout_patterns'];
		$this->live_seting_use_img = $args['skin_color_use_img'];
		$this->boxed_layout_images = $args['boxed_layout_images'];
		$this->purchase_link = $args['purchase_link'];
		$this->header_style = $args['header_style'];
		$this->header_transparent = $args['header_transparent'];
		$this->header_top_bar = $args['header_top_bar'];
		$this->header_animation = $args['header_animation'];
		$this->live_demos = $args['live_demos'];
		
		wp_enqueue_style(
			'slz-live-setting',
			slz_get_framework_directory_uri('/static/css/slz-live-setting.css' ),
			array(),
			slz_ext('shortcodes')->manifest->get('version')
		);
		wp_enqueue_script(
			'slz-live-setting',
			slz_get_framework_directory_uri('/static/js/slz-live-setting.js' ),
			array( 'jquery' ),
			slz()->manifest->get_version(),
			true
		);
	}
	
	/*
	 * Get live setting view
	 */
	public function get_view() {
		$reviews = '';
		
		?>
			<div id="theme-setting">
				<a aria-expanded="true" href="#" data-toggle="dropdown" class="btn-theme-setting"><i class="fa fa-cogs"></i></a>
				<div class="theme-setting-content">
					<div class="purchase-wrap">
						<a href="<?php echo esc_url( $this->purchase_link ); ?>" class="purchase-btn">
							<?php echo esc_html__( 'Purchase now', 'slz' ); ?>	
						</a>
					</div>
					<div class="layout-options skin-site" data-url='<?php echo get_template_directory_uri()."/assets/public/css/skin/"; ?>'>
						<h6 class="switchers-title"><?php echo esc_html__( 'Skin Color', 'slz' ); ?></h6>
						<ul class="switchers-content list-unstyled list-inline">
							<?php
								$css = '';
								if( !empty( $this->colors ) ) {
									$use_image = $this->live_seting_use_img;
									$i = 1;
									foreach ( $this->colors as $key => $color ) {
										if( $use_image ) {
											echo '<li><a href="#" data-color="'. esc_attr( $key ) .'" ><img src="'. esc_url( slz_get_upload_directory_uri( $color['image'] ) ) .'" alt="" class="img-responsive"></a></li>';
										}else{
											if( isset( $color['color']['main-color'] ) && !empty( $color['color']['main-color'] ) ) {
												echo '<li><a href="#" data-color="'. esc_attr( $key ) .'" class="color-'. esc_attr( $i ) .'" ></a></li>';
												$css .= '
													#theme-setting .skin-site ul li a.color-'. esc_attr( $i ) .' {
														background-color: #'. esc_attr( $color['color']['main-color'] ) .';
													}
												';
											}
										}
										$i++;
									}
								}
								if( !empty( $css ) ) {
									do_action( 'slz_add_inline_style', $css );
								}
							?>
						</ul>
					</div>
					<div class="layout-options has-child">
						<h6 class="switchers-title"><?php echo esc_html__( 'Layout Options', 'slz' ) ?></h6>
						<div class="switchers-content">
							<a id="layout-wide" class="layout-wide btn active" href="#">Wide</a>
							<a id="layout-boxed" class="layout-boxed btn" href="#">Boxed</a>
						</div>
						<div class="layout-options-child">
							<?php if( !empty( $this->layout_patterns ) && is_array( $this->layout_patterns ) ): ?>
							<div class="layout-options-2 boxed-option boxed-background-patterns">
								<h6 class="switchers-title">Layout patterns</h6>
								<ul class="switchers-content list-unstyled list-inline">
									<?php
									foreach ( $this->layout_patterns as $layout_pattern ) {
										echo '<li><a href="#"><img src="'. esc_url( slz_get_upload_directory_uri( $layout_pattern ) ) .'" alt="" class="img-responsive"></a></li>';
									}
									?>
								</ul>
							</div>
							<?php endif; ?>
							<?php if( !empty( $this->boxed_layout_images ) && is_array( $this->boxed_layout_images ) ): ?>
							<div class="layout-options-2 boxed-option boxed-background-images">
								<h6 class="switchers-title"><?php echo esc_html__( 'Boxed layout images', 'slz' ); ?></h6>
								<ul class="switchers-content list-unstyled list-inline">
									<?php
									foreach( $this->boxed_layout_images as $boxed_layout_image ) {
										echo '<li><a href="#"><img src="'. esc_url( slz_get_upload_directory_uri( $boxed_layout_image ) ) .'" alt="" class="img-responsive"></a></li>';
									}
									?>
								</ul>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php if( !empty( $this->header_top_bar ) ): ?>
					<div class="header-topbar layout-options">
						<h6 class="switchers-title">header topbar</h6>
						<div class="switchers-content">
							<a class="btn" href="#" data-item="1"><?php esc_html_e( 'Yes', 'slz' ); ?></a>
							<a class="btn" href="#" data-item="2"><?php esc_html_e( 'No', 'slz' ); ?></a>
						</div>
					</div>
					<?php endif; ?>
					<?php if( !empty( $this->header_transparent ) ): ?>
					<div class="header-color layout-options">
						<h6 class="switchers-title">header color</h6>
						<div class="switchers-content">
							<a class="btn" href="#" data-item="2"><?php esc_html_e( 'default', 'slz' ); ?></a>
							<a class="btn" href="#" data-item="1"><?php esc_html_e( 'Transparent', 'slz' ); ?></a>
						</div>
					</div>
					<?php endif; ?>
					<?php if( !empty( $this->header_animation ) ): ?>
					<div class="header-animation layout-options">
						<h6 class="switchers-title">header position</h6>
						<div class="switchers-content">
							<a href="#" class="header-normal btn" data-item="1"><?php esc_html_e( 'Normal', 'slz' ); ?></a>
							<a href="#" class="header-fixed btn" data-item="2"><?php esc_html_e( 'Fixed', 'slz' ); ?></a>
						</div>
					</div>
					<?php endif;?>
					<?php if( !empty( $this->header_style ) && is_array( $this->header_style ) ): ?>
					<div class="header-style layout-options">
						<h6 class="switchers-title">header style</h6>
						<div class="switchers-content">
							<?php
							foreach ( $this->header_style as $key=>$layout ) {
								echo '<a class="btn" href="#" data-item="'. esc_attr( $key ) .'">'. esc_html( $layout ) .'</a>';
							}
							?>
						</div>
					</div>
					<?php endif; ?>
					<?php if( !empty( $this->live_demos ) && is_array( $this->live_demos ) ): ?>
					<div class="layout-options">
						<h6 class="switchers-title">live demos</h6>
						<div class="switchers-content">
							<?php 
							foreach( $this->live_demos as $key=>$demo ){
								if( !empty($demo['review_img']) && !empty($demo['thumb'])) {
									?>
									<div class="demo-item">
										<a class="demo-thumbnail" data-item="<?php echo esc_attr($key)?>" href="<?php echo esc_url(network_home_url('/') . $demo['url'])?>">
											<img class="img-responsive" src="<?php echo esc_url( slz_get_upload_directory_uri( $demo['thumb'] ) )?>" alt="">
										</a>
									</div>
								<?php 
									$reviews .= '<img class="img-responsive" data-item="'.esc_attr($key).'" src="'.esc_url( slz_get_upload_directory_uri( $demo['review_img'] ) ).'" alt="">';
								}
							}
							?>
						</div>
					</div>
					<?php endif;?>
				</div>
				<?php if( $reviews ):?>
				<div class="demo-review-wrapper">
					<?php echo ( $reviews );?>
				</div>
				<?php endif;?>
			</div>
		<?php
	}
	public static function get_config(){
		return get_option( 'slz_cfg_live_setting', '' );
	}
	public static function get_session_timeout( $cfg ) {
		if( isset( $cfg['session_save_time'] ) && !empty( $cfg['session_save_time'] ) ) {
			return $cfg['session_save_time'];
		}
		return 50;
	}
	public static function slz_get_livesetting_theme_color( &$search_key, &$replace_key ) {
		$query_string = isset($_GET['skin-color']) ? $_GET['skin-color'] : '';
		$cfg = self::get_config();
		if( empty($cfg) ) return false;
		
		$timeout = self::get_session_timeout($cfg);
		if( isset( $_SESSION['slz-live-setting']['time'] ) && ( $session_time = $_SESSION['slz-live-setting']['time'] ) ) {
			if( time() - $session_time > absint( $timeout ) ) {
				$_SESSION['slz-live-setting']['skin'] = '';
			}
		}

		if( isset( $_SESSION['slz-live-setting']['skin'] ) && ( $session_skin = $_SESSION['slz-live-setting']['skin'] ) && empty( $query_string ) ) {
			
			if( !empty( $cfg ) && isset( $cfg['color_list'] ) ) {
				$cfg_color = $cfg['color_list'];
				if( isset( $cfg_color[ $session_skin ] ) && !empty( $cfg_color[ $session_skin ] ) ) {
					$color_choose = $cfg_color[ $session_skin ];
				}
			}
			
		}elseif( !empty($query_string)) {
			if( isset( $_SESSION['slz-live-setting']['skin'] ) && !empty( $_SESSION['slz-live-setting']['skin'] ) ) {
				if(  $_SESSION['slz-live-setting']['skin']!= $query_string ) {
					$_SESSION['slz-live-setting']['skin'] = $query_string;
					$_SESSION['slz-live-setting']['time'] = time();
				}
			}else{
				$_SESSION['slz-live-setting']['skin'] = $query_string;
				$_SESSION['slz-live-setting']['time'] = time();
			}
			
			if( !empty( $cfg ) && isset( $cfg['color_list'] ) ) {
				$cfg_color = $cfg['color_list'];
				if( isset( $cfg_color[$query_string] ) && !empty( $cfg_color[$query_string] ) ) {
					$color_choose = $cfg_color[$query_string];
				}
			}

		}else{
			return false;
		}
		if( isset( $color_choose['color'] ) && !empty( $color_choose['color'] ) && is_array( $color_choose['color'] ) ) {
			foreach ( $color_choose['color'] as $key => $color ) {
				$key_color = str_replace('-', '_', $key);
				
				$search_key[] = '$' . $key_color;
				$replace_key[] = '#'.$color;
			}
		}
		return true;

	}
	
	public static function get_header_style( &$header_style ) {
		$query_string = isset($_GET['header-style']) ? $_GET['header-style'] : '';
		$cfg = self::get_config();
		if( $cfg ) {
			$timeout = self::get_session_timeout($cfg);
			$header = '';
			$header_map = array('1' => 'header_01', '2' => 'header_02', '3' => 'header_03', '4' => 'header_04', '5' => 'header_05');
			if( !empty( $query_string ) ) {
				$_SESSION['slz-live-setting']['header'] = $query_string;
				$_SESSION['slz-live-setting']['time'] = time();
			}
			if( isset($_SESSION['slz-live-setting']['header']) && $header = $_SESSION['slz-live-setting']['header'] ) {
				// check timeout
				if( isset( $_SESSION['slz-live-setting']['time'] ) && ( $session_time = $_SESSION['slz-live-setting']['time'] ) ) {
					if( time() - $session_time > absint( $timeout ) ) {
						$_SESSION['slz-live-setting']['header'] = '';
						$header = '';
					}
				}
				if( $header && isset($header_map[$header])) {
					$header_style = $header_map[$header];
				}
			}
		}
	}
	
	public static function get_header_transparent( &$header_class, &$transparent ) {
		$query_string = isset( $_GET['header-transparent'] ) ? $_GET['header-transparent'] : '';
		
		$cfg = self::get_config();
		if( $cfg ) {
			$timeout = self::get_session_timeout($cfg);
			if( !empty( $query_string ) ) {
				//Save session.
				$_SESSION['slz-live-setting']['transparent'] = $query_string;
				$_SESSION['slz-live-setting']['time'] = time();
			}
			if( isset($_SESSION['slz-live-setting']['transparent']) && $ss_transparent = $_SESSION['slz-live-setting']['transparent'] ) {
				// check timeout
				if( isset( $_SESSION['slz-live-setting']['time'] ) && ( $session_time = $_SESSION['slz-live-setting']['time'] ) ) {
					if( time() - $session_time > absint( $timeout ) ) {
						$_SESSION['slz-live-setting']['transparent'] = '';
						$ss_transparent = '';
					}
				}
				if( $ss_transparent == '1' ){
					$transparent = true;
					$header_class = 'header-transparent';
				} else {
					$transparent = false;
					$header_class = '';
				}
			}
		}
	}
	public static function get_header_animation( &$sticky_class ) {
		$query_string = isset( $_GET['header-animation'] ) ? $_GET['header-animation'] : '';
	
		$cfg = self::get_config();
		if( $cfg ) {
			$timeout = self::get_session_timeout($cfg);
			$ss_animation = '';
				
			if( !empty( $query_string ) ) {
				//Save session.
				$_SESSION['slz-live-setting']['animation'] = $query_string;
				$_SESSION['slz-live-setting']['time'] = time();
			}
			if( isset($_SESSION['slz-live-setting']['animation']) && $ss_animation = $_SESSION['slz-live-setting']['animation'] ) {
				// check timeout
				if( isset( $_SESSION['slz-live-setting']['time'] ) && ( $session_time = $_SESSION['slz-live-setting']['time'] ) ) {
					if( time() - $session_time > absint( $timeout ) ) {
						$_SESSION['slz-live-setting']['animation'] = '';
						$ss_animation = '';
					}
				}
				if( $ss_animation == '2' ) {
					$sticky_class = 'slz-header-sticky';
				}else{
					$sticky_class = '';
				}
			}
		}
	}
	
	public static function get_top_bar( &$enable_top_bar ) {
		$query_string = isset( $_GET['header-top-bar'] ) ? $_GET['header-top-bar'] : '';
		$cfg = self::get_config();
		if( $cfg ) {
			$timeout = self::get_session_timeout($cfg);
			if( !empty( $query_string ) ) {
				//Save session.
				$_SESSION['slz-live-setting']['header-top-bar'] = $query_string;
				$_SESSION['slz-live-setting']['time'] = time();
			}
			if( isset($_SESSION['slz-live-setting']['header-top-bar']) && $ss_top_bar = $_SESSION['slz-live-setting']['header-top-bar']){
				//check timeout
				if( isset( $_SESSION['slz-live-setting']['time'] ) && ( $session_time = $_SESSION['slz-live-setting']['time'] ) ) {
					if( time() - $session_time > absint( $timeout ) ) {
						$_SESSION['slz-live-setting']['header-top-bar'] = '';
						$ss_top_bar = '';
					}
				}
				if( $ss_top_bar == '1') {
					$enable_top_bar = 'yes';
				} else{
					$enable_top_bar = 'no';
				}
			}
		}
	}
}
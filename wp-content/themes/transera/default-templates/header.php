<div class="body-wrapper-content">
	<div class="sidenav-overlay"></div>
	<header>
		<div class="slz-header-wrapper">
			<div class="slz-header-main">
				<div class="container">
					<div class="slz-logo-wrapper float-l">
						<div class="logo"><a href="<?php echo esc_url(home_url('/') );?>" ><?php echo wp_get_theme(); ?></a></div>
					</div>
					<div class="slz-main-menu float-r">
						<?php if ( has_nav_menu( 'main-nav' ) ) : ?>
							<?php wp_nav_menu( array(
								'container'       => 'ul',
								'menu_class'      => 'nav navbar-nav slz-menu-wrapper',
								'theme_location'  => 'main-nav',
								'link_before'     => '<span>',
								'link_after'      => '</span>',
								'after'           => '<span class="icon-dropdown-mobile fa fa-angle-down"></span>',
							) ); ?>
						<?php endif;?>
					</div>
                    <div class="slz-header-search">
                        <?php get_search_form( $echo ); ?>
                    </div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</header>

	<!-- WRAPPER-->
		<div id="wrapper-content" class="wrapper-content">
			<!-- PAGE WRAPPER-->
			<div id="page-wrapper">
				<!-- MAIN CONTENT-->
				<div class="main-content">

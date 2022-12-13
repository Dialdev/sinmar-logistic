<?php
class Transera_Welcome {

	public static function get_theme_header(){
		echo slz_render_view(slz_fix_path(get_template_directory())
				. slz_get_framework_customizations_dir_rel_path( '/theme/views/welcome-header.php' ));
	}
	
	public function plugin_link( $item ) {
		$return_url = slz()->theme->manifest->get('id');
		$installed_plugins = get_plugins();
	
		$item['sanitized_plugin'] = $item['name'];
	
		/** We need to display the 'Install' hover link */
		if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
			$actions = array(
				'install' => sprintf(
						'<a href="%1$s" class="button button-primary" title="'.esc_html__( 'Install %2$s', 'transera' ).'">'.esc_html__( 'Install', 'transera' ).'</a>',
						wp_nonce_url(
								add_query_arg(
										array(
											'page'          => TGM_Plugin_Activation::$instance->menu,
											'plugin'        => $item['slug'],
											'plugin_name'   => $item['sanitized_plugin'],
											'plugin_source' => $item['source'],
											'tgmpa-install' => 'install-plugin',
											'tgmpa-nonce'   => wp_create_nonce( 'tgmpa-install' ),
											'return_url'    => $return_url
										),
										esc_url( admin_url( TGM_Plugin_Activation::$instance->parent_slug ) )
								),
								'tgmpa-install'
						),
						$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Activate' hover link */
		elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			$actions = array(
				'activate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="'.esc_html__( 'Activate %2$s', 'transera' ).'">'.esc_html__( 'Activate', 'transera' ).'</a>',
						add_query_arg(
								array(
									'plugin'         => $item['slug'],
									'plugin_name'    => $item['sanitized_plugin'],
									'plugin_source'  => $item['source'],
									'slz-activate'   => 'activate-plugin',
									'slz-nonce'      => wp_create_nonce( 'slz-activate' ),
								),
								esc_url( admin_url( 'admin.php?page=' . $return_url) )
						),
						$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Update' hover link */
		elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
			$actions = array(
				'update' => sprintf(
						'<a href="%1$s" class="button button-primary" title="'.esc_html__( 'Update %2$s', 'transera' ).'">'.esc_html__( 'Update', 'transera' ).'</a>',
						wp_nonce_url(
								add_query_arg(
										array(
											'page'          => TGM_Plugin_Activation::$instance->menu,
											'plugin'        => $item['slug'],
											'plugin_name'   => $item['sanitized_plugin'],
											'plugin_source' => $item['source'],
											'tgmpa-update'  => 'update-plugin',
											'version'       => $item['version'],
											'tgmpa-nonce'   => wp_create_nonce( 'tgmpa-update' ),
											'return_url'    => $return_url
										),
										esc_url( admin_url( TGM_Plugin_Activation::$instance->parent_slug ) )
								),
								'tgmpa-install'
						),
						$item['sanitized_plugin']
				),
			);
		} elseif ( is_plugin_active( $item['file_path'] ) ) {
			$actions = array(
				'deactivate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="'.esc_html__( 'Deactivate %2$s', 'transera' ).'">'.esc_html__( 'Deactivate', 'transera' ).'</a>',
						add_query_arg(
								array(
									'plugin'         => $item['slug'],
									'plugin_name'    => $item['sanitized_plugin'],
									'plugin_source'  => $item['source'],
									'slz-deactivate' => 'deactivate-plugin',
									'slz-nonce'      => wp_create_nonce( 'slz-deactivate' ),
								),
								esc_url( admin_url( 'admin.php?page=' . $return_url ) )
						),
						$item['sanitized_plugin']
				),
			);
		}
	
		return $actions;
	}

}
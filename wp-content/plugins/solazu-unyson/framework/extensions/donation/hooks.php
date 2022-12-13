<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

add_action( 'admin_menu', '_action_slz_admin_menu_donation_add' );
function _action_slz_admin_menu_donation_add() {
	add_submenu_page( 'edit.php?post_type=slz-donation', esc_html__( 'Causes', 'slz' ), esc_html__( 'Causes', 'slz' ), 'edit_posts', 'edit.php?post_type=slz-causes' );
}

add_action( 'save_post', '_action_slz_save_donation_post');
function _action_slz_save_donation_post() {

	if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'slz-donation' ) {
		if( isset( $_POST['slz_options'] ) ) {
			$causes_id = $_POST['slz_options']['cause'];
			$posts = slz()->extensions->get( 'donation' )->get_query_approved_donation( $causes_id );

			$donate = 0;
			$raised = 0;
			$count_dornors = 0;
			if( !empty( $posts->posts ) ) {
				foreach ( $posts->posts as $post ) {
					$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
					$raised += intval( $donate );
				}
				$count_dornors = count( $posts->posts );
			}
			
			update_post_meta($causes_id, 'slz-donation-raised-money', $raised);
			update_post_meta($causes_id, 'slz-donation-dornors-number', $count_dornors);
		}
	}
}

add_action( 'wp_trash_post', '_action_slz_delete_donation_post' );
function _action_slz_delete_donation_post( $post_id ) {
	if( get_post_type( $post_id ) == 'slz-donation' ) {
		$causes_id = slz_get_db_post_option( $post_id, 'cause', '' );
		$posts = slz()->extensions->get( 'donation' )->get_query_approved_donation( $causes_id );
		$donate = 0;
		$raised = 0;
		$count_dornors = 0;
        $posts = $posts->posts;
        if( !empty( $posts ) ) {
			foreach ( $posts as $key => $post ) {
				if( $post->ID == $post_id ) {
					unset( $posts[$key] );
					continue;
				}
				$donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
				$raised += intval( $donate );
				
			}
			$count_dornors = count( $posts );
		}
		update_post_meta($causes_id, 'slz-donation-raised-money', $raised);
		update_post_meta($causes_id, 'slz-donation-dornors-number', $count_dornors);
	}
}

add_action( 'wp_trash_post', '_action_slz_delete_cause_post' );
function _action_slz_delete_cause_post( $post_id ) {
    if ( get_post_type($post_id) == 'slz-causes' ) {
        $posts = slz()->extensions->get( 'donation' )->get_query_all_donation($post_id);
        if ( !metadata_exists('post', $post_id, 'slz_option:history_trash') ) {
            add_metadata('post', $post_id, 'slz_option:history_trash', '');
        }
        $history_trash = '';
        $posts = $posts->posts;
        if ( !empty($posts) ) {
            foreach ( $posts as $key => $post ) {
                if ( wp_trash_post($post->ID) ) {
                    if ( !empty($history_trash) ) {
                        $history_trash .=',';
                    }
                    $history_trash .= $post->ID;
                }
            }
        }
        update_metadata('post', $post_id, 'slz_option:history_trash', $history_trash);
    }
}

add_action( 'untrashed_post', '_action_slz_untrash_cause_post');
function _action_slz_untrash_cause_post( $post_id ) {
    $history_trash = '';
    if ( get_post_type($post_id) == 'slz-causes' ) {
        if ( metadata_exists('post', $post_id, 'slz_option:history_trash') ) {
        	$meta_data = get_metadata('post', $post_id, 'slz_option:history_trash');
            $history_trash  = $meta_data[0];
            $history_trash = explode(',', $history_trash);
            for ($i=0; $i < count($history_trash); $i++) {
                $donation_id = $history_trash[$i];
                wp_untrash_post($donation_id);
            }
        }
    }
}

add_action('before_delete_post', '_action_slz_cause_delete_post');
function _action_slz_cause_delete_post($post_id) {
    if ( get_post_type($post_id) == 'slz-causes' ) {
        $posts = slz()->extensions->get( 'donation' )->get_query_all_donation_strash($post_id);
        $posts = $posts->posts;
        if ( !empty($posts) ) {
            foreach ($posts as $post) {
                wp_delete_post($post->ID);
            }
        }
    }
}

add_action( 'untrash_post', '_action_slz_untrash_donation_post');
function _action_slz_untrash_donation_post( $post_id ) {
    if( get_post_type( $post_id ) == 'slz-donation' ) {
        $causes_id = slz_get_db_post_option( $post_id, 'cause', '' );
        $posts = slz()->extensions->get( 'donation' )->get_query_approved_donation( $causes_id );
        $donate = 0;
        $raised = 0;
        $count_dornors = 0;
        $posts = $posts->posts;
        if( !empty( $posts ) ) {
            foreach ( $posts as $key => $post ) {
                $donate = slz_get_db_post_option( $post->ID, 'amount', 0 );
                $raised += intval( $donate );
            }
            $count_dornors = count( $posts );
        }
        update_post_meta($causes_id, 'slz-donation-raised-money', $raised);
        update_post_meta($causes_id, 'slz-donation-dornors-number', $count_dornors);
    }
}

/**
 * Select custom page template on frontend
 *
 * @internal
 *
 * @param string $template
 *
 * @return string
 */
function _filter_slz_ext_donation_template_include( $template ) {

	/**
	 * @var SLZ_Extension_Events $portfolio
	 */
	$donation = slz()->extensions->get( 'donation' );

	if ( is_singular( $donation->get_post_type_name_causes() ) ) {
		if ( $donation->locate_view_path( 'single' ) ) {
			return $donation->locate_view_path( 'single' );
		}
	} else if ( ( is_post_type_archive( $donation->get_post_type_name_causes() ) || is_tax( $donation->get_taxonomy_name_causes() ) ) && $donation->locate_view_path( 'archive' ) ) {
		return $donation->locate_view_path( 'archive' );
	}

	return $template;
}

add_filter( 'template_include', '_filter_slz_ext_donation_template_include' );


/*
 * Filter Tab Admin method
 */
add_action( 'restrict_manage_posts', '_action_slz_admin_posts_filter_restrict_manage_posts' );
function _action_slz_admin_posts_filter_restrict_manage_posts(){
	$type = 'post';
	if (isset($_GET['post_type'])) {
		$type = $_GET['post_type'];
	}

	if ('slz-donation' == $type){
		$status_arr = array(
			esc_html__('Pending', 'slz') => 'pending', 
			esc_html__('Approve', 'slz') => 'approve',
		);
		?>
		<select name="admin_filter_status_value">
		<option value=""><?php echo esc_html__('All Status', 'slz'); ?></option>
		<?php
			$current_status = isset($_GET['admin_filter_status_value'])? $_GET['admin_filter_status_value']:'';
			foreach ($status_arr as $key => $value) {
				printf
					(
						'<option value="%s"%s>%s</option>',
						$value,
						$value == $current_status? ' selected="selected"':'',
						$key
					);
			}
		?>
		</select>
		<?php
		$cause_arr = array();
		global $wpdb;
		$posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE 1=1  AND {$wpdb->posts}.post_type = 'slz-causes' AND ({$wpdb->posts}.post_status = 'publish' )");
		if( !empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$cause_arr[ $post->post_title ] = $post->ID;
			}
		}
		?>
		
		<select name="admin_filter_cause_value">
			<option value=""><?php echo esc_html__('All Causes', 'slz'); ?></option>
			<?php
				$current_cause = isset($_GET['admin_filter_cause_value'])? $_GET['admin_filter_cause_value']:'';
				foreach ($cause_arr as $key => $value) {
				printf
					(
						'<option value="%s"%s>%s</option>',
						$value,
						$value == $current_cause? ' selected="selected"':'',
						$key
					);
				}
			?>
		</select>
		|
		<?php
		$money_from_val = isset($_GET['admin_filter_money_from_value'])? $_GET['admin_filter_money_from_value']:'';
		$money_to_val = isset($_GET['admin_filter_money_to_value'])? $_GET['admin_filter_money_to_value']:'';
		?>
		<?php echo esc_html__( 'Money From', 'slz' ); ?>
		<input name="admin_filter_money_from_value" type="text" value="<?php echo esc_html( $money_from_val ); ?>" />
		<?php echo esc_html__( 'To', 'slz' ); ?>
		<input name="admin_filter_money_to_value" type="text" value="<?php echo esc_html( $money_to_val ); ?>" />
		<?php
    }
}


add_filter( 'parse_query', '_filter_slz_post_donation_custom' );
function _filter_slz_post_donation_custom( $query ){
	if( !is_admin() ) {
		return;
	}
	global $pagenow;
	$type = 'post';
	if (isset($_GET['post_type'])) {
		$type = $_GET['post_type'];
	}
	$i = 0;
	if ( 'slz-donation' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['admin_filter_status_value']) && $_GET['admin_filter_status_value'] != '') {
		$query->query_vars['meta_query'][$i]['key'] = 'slz_option:status';
		$query->query_vars['meta_query'][$i]['value'] = $_GET['admin_filter_status_value'];
		$i++;
	}
	if ( 'slz-donation' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['admin_filter_cause_value']) && $_GET['admin_filter_cause_value'] != '') {
		$query->query_vars['meta_query'][$i]['key'] = 'slz_option:cause';
		$query->query_vars['meta_query'][$i]['value'] = $_GET['admin_filter_cause_value'];
		$i++;
	}
	if ( 'slz-donation' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['admin_filter_money_from_value']) && $_GET['admin_filter_money_from_value'] != '' && isset($_GET['admin_filter_money_to_value']) && $_GET['admin_filter_money_to_value'] != '' ) {
		$query->query_vars['meta_query'][$i]['key'] = 'slz_option:amount';
		$query->query_vars['meta_query'][$i]['value'] = array( intval( $_GET['admin_filter_money_from_value'] ), intval( $_GET['admin_filter_money_to_value'] ) );
		$query->query_vars['meta_query'][$i]['type'] = 'numeric';
		$query->query_vars['meta_query'][$i]['compare'] = 'BETWEEN';
		$i++;
	}
}
add_filter( 'woocommerce_cart_item_subtotal', '_filter_slz_donation_display_item_subtotal', 10, 3 );
function _filter_slz_donation_display_item_subtotal( $output, $cart_item, $cart_item_key ) {
		global $woocommerce;
		if (isset($cart_item['data'])) {
			$item_data = $cart_item['data'];
			$object_class = get_class($item_data);
			if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
				return $output;
			}
			$cart_item_meta = $woocommerce->session->get('slz_donation_session_key_' . $cart_item_key);
			if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['donate_money'] ) ) {
				$output = wc_price( $cart_item_meta['donate_money'] );
			}
		}
		return $output;
}

add_filter( 'woocommerce_cart_item_price', '_filter_slz_donation_display_item_price', 10, 3 );
function _filter_slz_donation_display_item_price( $output, $cart_item, $cart_item_key ) {
	global $woocommerce;
	if (isset($cart_item['data'])) {
		$item_data = $cart_item['data'];
		$object_class = get_class($item_data);
		if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
			return $output;
		}
		$cart_item_meta = $woocommerce->session->get('slz_donation_session_key_' . $cart_item_key);
		if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['donate_money'] ) ) {
			$output = wc_price( $cart_item_meta['donate_money'] );
		}
	}
	return $output;
}

add_action( 'woocommerce_before_calculate_totals' , '_action_slz_donation_add_custom_total_price', 20 , 1 );
function _action_slz_donation_add_custom_total_price($cart_object) {
	global $woocommerce;
	foreach ( $cart_object->cart_contents as $key => $value ) {
		$cart_item_meta = $woocommerce->session->get('slz_donation_session_key_' . $key);
		if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['donate_money'] ) ) {
			$value['data']->price = $cart_item_meta['donate_money'];
		}
	}
}

add_filter( 'woocommerce_variation_is_purchasable', '_filter_slz_donation_variation_is_purchasable', 20, 2 );
function _filter_slz_donation_variation_is_purchasable( $purchasable, $product_variation ) {
	$object_class = get_class($product_variation);
	if( $object_class == 'WC_Product_Variation' ) {
		$purchasable = true;
	}
	return $purchasable;
}

add_action( 'woocommerce_checkout_order_processed', '_action_slz_donation_checkout_order_processed', 10, 2);
function _action_slz_donation_checkout_order_processed( $order_id, $posted ) {
	global $woocommerce;
	
	if( $woocommerce->cart != null ) {
		foreach ( $woocommerce->cart->cart_contents as $key => $value ) {
			$cart_item_meta = $woocommerce->session->get('slz_donation_session_key_' . $key);
			
			if( isset( $cart_item_meta['post_id_cause'] ) ) {
			
				$postarr = array(
					'post_status' => 'publish',
					'post_type'   => 'slz-donation',
				);
	
				$id = wp_insert_post($postarr, true);
				if( !is_wp_error( $id ) ) {
	
					slz_set_db_post_option( $id, 'status', 'pending' );
					
					$first_name = get_post_meta( $order_id, '_billing_first_name', true );
					if( !empty( $first_name ) ) {
						slz_set_db_post_option( $id, 'first_name', $first_name );
					}
					
					$last_name = get_post_meta( $order_id, '_billing_last_name', true );
					if( !empty( $last_name ) ) {
						slz_set_db_post_option( $id, 'last_name', $last_name );
					}
					
					$email = get_post_meta( $order_id, '_billing_email', true );
					if( !empty( $email ) ) {
						slz_set_db_post_option( $id, 'email', $email );
					}
					
					
					$phone = get_post_meta( $order_id, '_billing_phone', true );
					if( !empty( $phone ) ) {
						slz_set_db_post_option( $id, 'phone', $phone );
					}
					
					$payment_method = get_post_meta( $order_id, '_payment_method_title', true );
					if( !empty( $payment_method ) ) {
						slz_set_db_post_option( $id, 'payment', $payment_method );
					}
					
					$address = get_post_meta( $order_id, '_billing_address_1', true );
					if( !empty( $address ) ) {
						slz_set_db_post_option( $id, 'address', $address );
					}
	
					if( isset( $cart_item_meta['donate_money'] ) && $cart_item_meta['donate_money'] != '' ) {
						slz_set_db_post_option( $id, 'amount', $cart_item_meta['donate_money'] );
					}
	
					if( isset( $cart_item_meta['post_id_cause'] ) && $cart_item_meta['post_id_cause'] != '' ) {
						slz_set_db_post_option( $id, 'cause', $cart_item_meta['post_id_cause'] );
					}
				}
			}
		}
	}
}


function _filter_slz_donation_woocommerce_cart_item_thumbnail( $product_get_image, $cart_item, $cart_item_key ) { 
	global $woocommerce;
	if (isset($cart_item['data'])) {
		$item_data = $cart_item['data'];
		$object_class = get_class($item_data);
		if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
			return $product_get_image;
		}
		$cart_item_meta = $woocommerce->session->get('slz_donation_session_key_' . $cart_item_key);
		if ( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'causes' && isset( $cart_item_meta['post_id_cause'] ) ) {
			$attach_id = get_post_thumbnail_id( $cart_item_meta['post_id_cause'] );
			if( $attach_id ) {
				$product_get_image = wp_get_attachment_image( $attach_id, 'medium', array( 'class' => 'woocommerce-placeholder wp-post-image' ) );
			}else{
				return $product_get_image;
			}
		}
	}
	return $product_get_image; 
}; 
add_filter( 'woocommerce_cart_item_thumbnail', '_filter_slz_donation_woocommerce_cart_item_thumbnail', 10, 3 ); 
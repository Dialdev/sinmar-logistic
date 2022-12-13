<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
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
function _filter_slz_ext_portfolio_template_include( $template ) {

	/**
	 * @var SLZ_Extension_Events $portfolio
	 */
	$portfolio = slz()->extensions->get( 'portfolio' );

	if ( is_singular( $portfolio->get_post_type_name() ) ) {
		if ( $portfolio->locate_view_path( 'single' ) ) {
			return $portfolio->locate_view_path( 'single' );
		}
	} else if ( ( is_post_type_archive( $portfolio->get_post_type_name() ) || is_tax( $portfolio->get_taxonomy_name() ) ) && $portfolio->locate_view_path( 'archive' ) ) {
		return $portfolio->locate_view_path( 'archive' );
	}

	return $template;
}

add_filter( 'template_include', '_filter_slz_ext_portfolio_template_include' );

add_filter( 'woocommerce_cart_item_thumbnail', '_filter_slz_portfolio_woocommerce_cart_item_thumbnail', 10, 3 );
function _filter_slz_portfolio_woocommerce_cart_item_thumbnail( $product_get_image, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $product_get_image;
        }
        $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'portfolio' && isset( $cart_item_meta['post_id_portfolio'] ) ) {
            $attach_id = get_post_thumbnail_id( $cart_item_meta['post_id_portfolio'] );
            if( $attach_id ) {
                $product_get_image = wp_get_attachment_image( $attach_id, 'medium', array( 'class' => 'woocommerce-placeholder wp-post-image' ) );
            }else{
                return $product_get_image;
            }
        }
    }
    return $product_get_image;
};

add_filter( 'woocommerce_cart_item_price', '_filter_slz_portfolio_display_item_price', 10, 3 );
function _filter_slz_portfolio_display_item_price( $output, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $output;
        }
        $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['portfolio_price_ticket'] ) ) {
            $output = wc_price( $cart_item_meta['portfolio_price_ticket'] );
        }
    }
    return $output;
}

add_filter( 'woocommerce_cart_item_subtotal', '_filter_slz_portfolio_display_item_subtotal', 10, 3 );
function _filter_slz_portfolio_display_item_subtotal( $output, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $output;
        }
        $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['portfolio_price_ticket'] ) ) {
            $output = wc_price( $cart_item_meta['portfolio_price_ticket'] * $cart_item['quantity'] );
        }
    }
    return $output;
}

add_action( 'woocommerce_before_calculate_totals' , '_action_slz_portfolio_add_custom_total_price', 20 , 1 );
function _action_slz_portfolio_add_custom_total_price($cart_object) {
    global $woocommerce;
    foreach ( $cart_object->cart_contents as $key => $value ) {
        $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['portfolio_price_ticket'] ) ) {
            $value['data']->price = $cart_item_meta['portfolio_price_ticket'];
        }
    }
}

if( ! slz_ext( 'events' ) ) {
    add_filter( 'woocommerce_is_sold_individually', '_filter_slz_portfolio_set_sold', 10, 2 );
}

function _filter_slz_portfolio_set_sold( $return, $instance ) {
    if( isset( $instance->parent->post ) ) {
        $post_id = $instance->parent->post->ID;
        $term_list = wp_get_post_terms($post_id,'product_cat',array('fields'=>'slugs'));

        if( empty( $term_list ) || ! isset( $term_list[0] ) ) {
            return $return;
        }

        $term_list = $term_list[0];

        if( $term_list == 'portfolio' ) {

            return false;
        }else{
            return true;
        }
    }
}

add_filter( 'woocommerce_variation_is_purchasable', '_filter_slz_portfolio_variation_is_purchasable', 20, 2 );
function _filter_slz_portfolio_variation_is_purchasable( $purchasable, $product_variation ) {
    $object_class = get_class($product_variation);
    if( $object_class == 'WC_Product_Variation' ) {
        $purchasable = true;
    }
    return $purchasable;
}

add_action( 'woocommerce_checkout_order_processed', '_action_slz_portfolio_checkout_order_processed', 10, 2);
function _action_slz_portfolio_checkout_order_processed( $order_id, $posted ) {
    global $woocommerce;
    $array_meta = array();
    $array_final = array();
    if( $woocommerce->cart != null ) {
        foreach ( $woocommerce->cart->cart_contents as $key => $value ) {
            $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $key);

            if( isset( $cart_item_meta['post_id_portfolio'] ) ) {
                $i = 0;
                $first_name = '';
                $last_name = '';
                $email = '';
                $phone = '';
                $payment_method = '';
                $address = '';
                $quantity = '';
                $price_ticket = '';

                $id = $cart_item_meta['post_id_portfolio'];
                $array_meta = array();
                $array_final = array();
                $arr_data_db = get_post_meta( $id, 'slz_portfolio_buy_album_data', true );

                $first_name = get_post_meta( $order_id, '_billing_first_name', true );
                $last_name = get_post_meta( $order_id, '_billing_last_name', true );
                $email = get_post_meta( $order_id, '_billing_email', true );
                $phone = get_post_meta( $order_id, '_billing_phone', true );
                $payment_method = get_post_meta( $order_id, '_payment_method_title', true );
                $order_total = get_post_meta( $order_id, '_order_total', true );

                $address = get_post_meta( $order_id, '_billing_address_1', true );
                $quantity = $value['quantity'];
                $price_ticket = slz_get_db_post_option( $id, 'portfolio_album_price', '0' );


                if( !empty( $first_name ) ) {
                    $array_meta['first_name'] = $first_name;
                }

                if( !empty( $last_name ) ) {
                    $array_meta['last_name'] = $last_name;
                }

                if( !empty( $email ) ) {
                    $array_meta['email'] = $email;
                }

                if( !empty( $phone ) ) {
                    $array_meta['phone'] = $phone;
                }

                if( !empty( $payment_method ) ) {
                    $array_meta['payment_method'] = $payment_method;
                }

                if( !empty( $address ) ) {
                    $array_meta['address'] = $address;
                }

                if( !empty( $quantity ) ) {
                    $array_meta['quantity'] = $quantity;
                }

                if( !empty( $price_ticket ) ) {
                    $array_meta['price_ticket'] = $price_ticket;
                }

                if( !empty( $order_total ) ) {
                    $array_meta['order_total'] = $order_total;
                }

                if( !empty( $array_meta ) ) {
                    $arr_data_db = json_decode( $arr_data_db );

                    if( !empty( $arr_data_db ) ) {
                        array_push( $arr_data_db, $array_meta );
                        $array_final = $arr_data_db;
                    }else{
                        $array_final[0] = $array_meta;
                    }

                    $array_final = json_encode($array_final);
                    update_post_meta( $id, 'slz_portfolio_buy_album_data', $array_final );
                }

                if ( !empty($quantity) ) {
                    $carted = get_post_meta( $id, 'portfolio_album_carted', '0' );
                    $album_quantity = slz_get_db_post_option( $id, 'album_quantity', '' );

                    if ( is_array($carted) && count($carted) > 0 ) {
                        $carted = $carted[0];
                    }
                    $carted = intval($carted) + intval($quantity);
                    if ($album_quantity != '' && intval($album_quantity) < $carted) {
                        $result = array(
                            'result' => 'failed',
                            'messages' => '<div class="woocommerce-error">'.__('Exceeds the ticket class allows', 'hearty').'</div>'
                        );
                        echo json_encode($result);
                        exit();
                    }
                    update_post_meta($id, 'portfolio_album_carted', $carted);
                }
                $i++;
            }
        }
    }
}

if( ! slz_ext( 'events' ) ) {
    add_action( 'woocommerce_after_cart_item_quantity_update', '_action_slz_portfolio_after_cart_item_quantity_update', 10, 3);
}

function _action_slz_portfolio_after_cart_item_quantity_update( $cart_item_key, $quantity, $old_quantity ) {
    global $woocommerce;

    $cart_item_meta = $woocommerce->session->get('slz_portfolio_session_key_' . $cart_item_key);
    $id = $cart_item_meta['post_id_portfolio'];

    $carted = get_post_meta( $id, 'portfolio_album_carted', '0' );
    $album_quantity = slz_get_db_post_option( $id, 'album_quantity', '' );
    if ( is_array($carted) && count($carted) > 0 ) {
        $carted = $carted[0];
    }

    if( $album_quantity != '' && intval($carted) + intval($quantity) > intval( $album_quantity ) ) {
        $woocommerce->cart->cart_contents[ $cart_item_key ]['quantity'] = intval( $album_quantity ) - intval($carted);
    }
}



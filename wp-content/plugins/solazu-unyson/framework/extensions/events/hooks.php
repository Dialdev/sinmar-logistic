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
function _filter_slz_ext_events_template_include( $template ) {

    /**
     * @var SLZ_Extension_Events $teams
     */
    $teams = slz()->extensions->get( 'events' );
    $post_type = $teams->get_post_type_name();
    $taxonomy  = $teams->get_taxonomy_name();

    if ( is_singular( $post_type ) && $teams->locate_view_path( 'single' ) ) {
        return $teams->locate_view_path( 'single' );
    }
    else if ( ( is_post_type_archive( $post_type ) || is_tax( $taxonomy ) ) && $teams->locate_view_path( 'archive' ) ) {
        return $teams->locate_view_path( 'archive' );
    }

    return $template;
}

add_filter( 'template_include', '_filter_slz_ext_events_template_include' );

/* Add events to woocommerce cart */
add_filter( 'woocommerce_cart_item_subtotal', '_filter_slz_events_display_item_subtotal', 10, 3 );
function _filter_slz_events_display_item_subtotal( $output, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $output;
        }
        $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['event_price_ticket'] ) ) {
            $output = wc_price( $cart_item_meta['event_price_ticket'] * $cart_item['quantity'] );
        }
        if ( isset($cart_item_meta['type']) && ( $cart_item_meta['type'] == 'event_donate' ) && isset( $cart_item_meta['donate_money'] ) ) {
            $output = wc_price( $cart_item_meta['donate_money'] * $cart_item['quantity'] );
        }
    }
    return $output;
}

add_filter( 'woocommerce_cart_item_price', '_filter_slz_events_display_item_price', 10, 3 );
function _filter_slz_events_display_item_price( $output, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $output;
        }
        $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['event_price_ticket'] ) ) {
            $output = wc_price( $cart_item_meta['event_price_ticket'] );
        }
        if ( isset($cart_item_meta['type']) && ( $cart_item_meta['type'] == 'event_donate' ) && isset( $cart_item_meta['donate_money'] ) ) {
            $output = wc_price( $cart_item_meta['donate_money'] );
        }
    }
    return $output;
}

add_action( 'woocommerce_before_calculate_totals' , '_action_slz_events_add_custom_total_price', 20 , 1 );
function _action_slz_events_add_custom_total_price($cart_object) {
    global $woocommerce;
    foreach ( $cart_object->cart_contents as $key => $value ) {
        $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $key);
        if ( isset($cart_item_meta['type']) && isset( $cart_item_meta['event_price_ticket'] ) ) {
            $value['data']->price = $cart_item_meta['event_price_ticket'];
        }
        if ( isset($cart_item_meta['type']) && ( $cart_item_meta['type'] == 'event_donate' ) && isset( $cart_item_meta['donate_money'] ) ) {
            $value['data']->price = $cart_item_meta['donate_money'];
        }
    }
}

add_filter( 'woocommerce_variation_is_purchasable', '_filter_slz_events_variation_is_purchasable', 20, 2 );
function _filter_slz_events_variation_is_purchasable( $purchasable, $product_variation ) {
    $object_class = get_class($product_variation);
    if( $object_class == 'WC_Product_Variation' ) {
        $purchasable = true;
    }
    return $purchasable;
}

add_filter( 'woocommerce_is_sold_individually', '_filter_slz_events_set_sold', 10, 2 );
function _filter_slz_events_set_sold( $return, $instance ) {
    if( isset( $instance->parent->post ) ) {
        $post_id = $instance->parent->post->ID;
        $term_list = wp_get_post_terms($post_id,'product_cat',array('fields'=>'slugs'));

        if( empty( $term_list ) || ! isset( $term_list[0] ) ) {
            return $return;
        }

        $term_list = $term_list[0];
        $is_event_donation = get_post_meta( $post_id, 'slz-is-donation-product', true );

        if( ( $term_list == 'events' && empty( $is_event_donation ) ) || ( slz_ext( 'portfolio' ) && $term_list == 'portfolio' ) ) {
            return false; // allow change quantity
        }else{
            return true;
        }
    }
}

add_action( 'woocommerce_checkout_order_processed', '_action_slz_events_checkout_order_processed', 10, 2);
function _action_slz_events_checkout_order_processed( $order_id, $posted ) {
    global $woocommerce;
    $array_meta = array();
    $array_final = array();
    if( $woocommerce->cart != null ) {
        foreach ( $woocommerce->cart->cart_contents as $key => $value ) {
            $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $key);

            if( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'events' && isset( $cart_item_meta['post_id_event'] ) ) {
                $i = 0;
                $first_name = '';
                $last_name = '';
                $email = '';
                $phone = '';
                $payment_method = '';
                $address = '';
                $quantity = '';
                $price_ticket = '';

                $id = $cart_item_meta['post_id_event'];
                $array_meta = array();
                $array_final = array();
                $arr_data_db = get_post_meta( $id, 'slz_event_buy_ticket_data', true );

                $first_name = get_post_meta( $order_id, '_billing_first_name', true );
                $last_name = get_post_meta( $order_id, '_billing_last_name', true );
                $email = get_post_meta( $order_id, '_billing_email', true );
                $phone = get_post_meta( $order_id, '_billing_phone', true );
                $payment_method = get_post_meta( $order_id, '_payment_method_title', true );
                $order_total = get_post_meta( $order_id, '_order_total', true );

                $address = get_post_meta( $order_id, '_billing_address_1', true );
                $quantity = $value['quantity'];
                $price_ticket = slz_get_db_post_option( $id, 'event_ticket_price', '0' );


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
                    update_post_meta( $id, 'slz_event_buy_ticket_data', $array_final );
                }

                if ( !empty($quantity) ) {

                    if( ! slz_ext( 'events' )->get_config( 'is_multiple_price' ) ) {
                        $carted = get_post_meta( $id, 'event_ticket_carted', '0' );
                        $number_ticket = slz_get_db_post_option( $id, 'event_ticket_number', '' );

                        if ( is_array($carted) && count($carted) > 0 ) {
                            $carted = $carted[0];
                        }
                        $carted = intval($carted) + intval($quantity);
                        if ($number_ticket != '' && intval($number_ticket) < $carted) {
                            $result = array(
                                'result' => 'failed',
                                'messages' => '<div class="woocommerce-error">'.esc_html__('Exceeds the ticket class allows', 'slz').'</div>'
                            );
                            echo json_encode($result);
                            exit();
                        }
                        update_post_meta($id, 'event_ticket_carted', $carted);
                    } else {

                        $pricing_column = $cart_item_meta['pricing_column'];
                        $price_box = slz_get_db_post_option( $id, 'price_box', array() );

                        foreach ( $price_box as $idx => $box ) {
                            $price_box[ md5( $box['ticket_name'].$box['ticket_price'] ) ] = $box;
                        }

                        $number_ticket = $price_box[$pricing_column]['ticket_number'];

                        $carted = get_post_meta( $id, 'event_ticket_carted', '' );

                        if( ! empty( $carted[0] ) ) {
                            $carted  = (array) json_decode( $carted[0] );
                        }

                        if( ! isset( $carted[$pricing_column] ) ) {
                            $carted[$pricing_column] = 0;
                        }

                        $carted[$pricing_column] = intval($carted[$pricing_column]) + intval($quantity);

                        if ($number_ticket != '' && intval($number_ticket) < $carted[$pricing_column]) {
                            $result = array(
                                'result' => 'failed',
                                'messages' => '<div class="woocommerce-error">'.esc_html__('Exceeds the ticket class allows', 'slz').'</div>'
                            );
                            echo json_encode($result);
                            exit();
                        }

                        update_post_meta($id, 'event_ticket_carted', json_encode( $carted ) );
                    }
                }
                $i++;
            }

            // checkout event donation
            if( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'event_donate' && isset( $cart_item_meta['post_id'] ) ){
                $post_args = array(
                    'post_status' => 'publish',
                    'post_type'   => 'slz-event-donation'
                );
                $post_id   = wp_insert_post( $post_args, true );
                if( !is_wp_error( $post_id ) ) {
                    $post_data['status']     = 'pending';
                    $post_data['event']      = $cart_item_meta['post_id'];
                    $post_data['amount']     = $cart_item_meta['donate_money'];
                    $post_data['payment']    = get_post_meta( $order_id, '_payment_method_title', true );
                    $post_data['first_name'] = get_post_meta( $order_id, '_billing_first_name', true );
                    $post_data['last_name']  = get_post_meta( $order_id, '_billing_last_name', true );
                    $post_data['email']      = get_post_meta( $order_id, '_billing_email', true );
                    $post_data['phone']      = get_post_meta( $order_id, '_billing_phone', true );
                    $post_data['address']    = get_post_meta( $order_id, '_billing_address_1', true );
                    foreach( $post_data as $key=>$val ){
                        if( !empty( $val ) ) {
                            slz_set_db_post_option( $post_id, $key, $val );
                        }
                    }
                }
            }
        }
    }
}

add_action('pre_post_update','_action_slz_event_donation_pre_update');
function _action_slz_event_donation_pre_update($post_id){
    global $slz_old_donation_event_id;
    $slz_old_donation_event_id = slz_get_db_post_option( $post_id, 'event', 0 );
}

add_action( 'parse_query', '_action_slz_events_save_status_taxonomy' );
function _action_slz_events_save_status_taxonomy($post_id) {
    if ( isset($_POST['save']) ) {
        $opts = $_POST['slz_options'];
        if ( isset($opts['status']) ) {
            $term_id = slz_akg('status', $opts, '');
            $term = get_term($term_id, 'slz-event-status');
            if ($term_id) {
                $_POST['tax_input']['slz-event-status'] = array($term->name);
                if ( !isset($_POST['newtag']) ) {
                    $_POST['newtag'] = array();
                }
                $_POST['newtag']['slz-event-status'] = '';
            }
        }
    }
}

add_action( 'save_post', '_action_slz_events_save_post_meta_data' );
function _action_slz_events_save_post_meta_data( $post_id ) {

    $post_type = get_post_type($post_id);

    if( !isset( $_POST['slz_options'] ) || empty( $_POST['slz_options'] ) ) return;

    if ( "slz-event" == $post_type ){

        $opts = $_POST['slz_options'];

        if( ! empty( $opts['event_date_range']['from'] ) )
        {
            $from_date = date( 'Y/m/d', strtotime( $opts['event_date_range']['from'] ) );
            update_post_meta( $post_id, 'slz_option:from_date', sanitize_text_field( $from_date ) );
        }

        if( ! empty( $opts['event_date_range']['to'] ) )
        {
            $to_date = date( 'Y/m/d', strtotime( $opts['event_date_range']['to'] ) );
            update_post_meta( $post_id, 'slz_option:to_date', sanitize_text_field( $to_date ) );
        }
    }
    if ( "slz-event-donation" == $post_type ){
        global $slz_old_donation_event_id;
        $event_id = $_POST['slz_options']['event'];

        slz()->extensions->get( 'events' )->update_event_donation_meta( $event_id );
        if( !empty( $slz_old_donation_event_id ) && $event_id != $slz_old_donation_event_id ){
            slz()->extensions->get( 'events' )->update_event_donation_meta( $slz_old_donation_event_id );
        }
    }

}

function _filter_slz_events_woocommerce_cart_item_thumbnail( $product_get_image, $cart_item, $cart_item_key ) {
    global $woocommerce;
    if (isset($cart_item['data'])) {
        $item_data = $cart_item['data'];
        $object_class = get_class($item_data);
        if ( !$item_data || !$item_data->post || $object_class != 'WC_Product_Variation') {
            return $product_get_image;
        }
        $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $cart_item_key);
        if ( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'events' && isset( $cart_item_meta['post_id_event'] ) ) {
            $attach_id = get_post_thumbnail_id( $cart_item_meta['post_id_event'] );
            if( $attach_id ) {
                $product_get_image = wp_get_attachment_image( $attach_id, 'medium', array( 'class' => 'woocommerce-placeholder wp-post-image' ) );
            }else{
                return $product_get_image;
            }
        }
        if ( isset($cart_item_meta['type']) && $cart_item_meta['type'] == 'event_donate' && isset( $cart_item_meta['post_id'] ) ) {
            $attach_id = get_post_thumbnail_id( $cart_item_meta['post_id'] );
            if( $attach_id ) {
                $product_get_image = wp_get_attachment_image( $attach_id, 'medium', array( 'class' => 'woocommerce-placeholder wp-post-image' ) );
            }else{
                return $product_get_image;
            }
        }
    }
    return $product_get_image;
};
add_filter( 'woocommerce_cart_item_thumbnail', '_filter_slz_events_woocommerce_cart_item_thumbnail', 10, 3 );
// Add Events Donation menu to Events menu
add_action( 'admin_menu', '_action_slz_admin_menu_events_donation_add' );
function _action_slz_admin_menu_events_donation_add() {
    add_submenu_page( 'edit.php?post_type=slz-event', esc_html__( 'Donation', 'slz' ), esc_html__( 'Donation', 'slz' ), 'edit_posts', 'edit.php?post_type=slz-event-donation' );
}

// delete event donation
add_action( 'wp_trash_post', '_action_slz_event_donation_trash_post' );
function _action_slz_event_donation_trash_post( $post_id ) {
    if( get_post_type( $post_id ) == 'slz-event-donation' ) {
        $event_id = slz_get_db_post_option( $post_id, 'event', '' );
        $posts = slz()->extensions->get( 'events' )->get_approved_event_donation( $event_id );

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
        update_post_meta($event_id, 'slz-donation-raised-money', $raised);
        update_post_meta($event_id, 'slz-donation-dornors-number', $count_dornors);
    }
}

add_action( 'untrashed_post', '_action_slz_event_donation_untrash_post');
function _action_slz_event_donation_untrash_post( $post_id ) {
    if( get_post_type( $post_id ) == 'slz-event-donation' ) {
        $event_id = slz_get_db_post_option( $post_id, 'event', '' );
        slz()->extensions->get( 'events' )->update_event_donation_meta( $event_id );
    }
}

add_action( 'wp_trash_post', '_action_slz_event_trash_post' );
function _action_slz_event_trash_post( $post_id ) {
    if ( get_post_type($post_id) == 'slz-event' ) {
        $posts = slz()->extensions->get( 'events' )->get_event_donation($post_id);
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

add_action( 'untrashed_post', '_action_slz_event_untrash_post');
function _action_slz_event_untrash_post( $post_id ) {
    $history_trash = '';
    if ( get_post_type($post_id) == 'slz-event' ) {
        if ( metadata_exists('post', $post_id, 'slz_option:history_trash') ) {
            $meta_data = get_metadata('post', $post_id, 'slz_option:history_trash', true);
            $history_trash = explode(',', $meta_data);
            foreach ( $history_trash as $donation_id ) {
                if( !empty( $donation_id ) ){
                    wp_untrash_post($donation_id);
                }
            }
        }
    }
}

add_action('before_delete_post', '_action_slz_event_delete_post');
function _action_slz_event_delete_post($post_id) {
    if ( get_post_type($post_id) == 'slz-event' ) {
        $posts = slz()->extensions->get( 'events' )->get_event_donation_trashed($post_id);
        $posts = $posts->posts;
        if ( !empty($posts) ) {
            foreach ($posts as $post) {
                wp_delete_post($post->ID);
            }
        }
    }
}

/*
 * Filter Event Donation in Admin
 */
add_action( 'restrict_manage_posts', '_action_slz_event_donation_admin_filter' );
function _action_slz_event_donation_admin_filter(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    if ('slz-event-donation' == $type){
        $status_arr = array(
            esc_html__('Pending', 'slz') => 'pending',
            esc_html__('Approve', 'slz') => 'approve'
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
        global $wpdb;
        $posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE 1=1  AND {$wpdb->posts}.post_type = 'slz-event' AND ({$wpdb->posts}.post_status = 'publish' )");
        if( !empty( $posts ) ) {
            $current_event = isset($_GET['admin_filter_event_value'])? $_GET['admin_filter_event_value']:'';
            echo '<select name="admin_filter_event_value">';
            echo '<option value="">'. esc_html__('All Events', 'slz') .'</option>';
            foreach ( $posts as $post ) {
                printf( '<option value="%1$s"%2$s>%3$s</option>',
                    $post->ID,
                    $post->ID == $current_event ? ' selected="selected"':'',
                    $post->post_title
                );
            }
            echo '</select>';
        }
        $event_cats = get_terms( array( 'taxonomy' => 'slz-event-cat' ) );
        if( !empty( $event_cats ) ) {
            $current_event_cat = '';
            if( isset($_GET['admin_filter_event_cat_value']) ){
                $current_event_cat = $_GET['admin_filter_event_cat_value'];
            }
            echo '<select name="admin_filter_event_cat_value">';
            echo '<option value="">'. esc_html__('All Event Categories', 'slz') .'</option>';

            foreach ( $event_cats as $cat ) {
                printf( '<option value="%s"%s>%s</option>',
                    $cat->slug,
                    $cat->slug == $current_event_cat ? ' selected="selected"':'',
                    $cat->name
                );
            }
            echo '</select>';
        }
        ?>
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


add_filter( 'parse_query', '_filter_slz_event_donation_parse_query' );
function _filter_slz_event_donation_parse_query( $query ){
    if( !is_admin() ) {
        return;
    }
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'slz-event-donation' != $type || $pagenow != 'edit.php' ){
        return;
    }

    $i = 0;
    if ( isset($_GET['admin_filter_status_value']) && $_GET['admin_filter_status_value'] != '') {
        $query->query_vars['meta_query'][$i]['key'] = 'slz_option:status';
        $query->query_vars['meta_query'][$i]['value'] = $_GET['admin_filter_status_value'];
        $i++;
    }
    if ( isset($_GET['admin_filter_event_value']) && $_GET['admin_filter_event_value'] != '') {
        $query->query_vars['meta_query'][$i]['key'] = 'slz_option:event';
        $query->query_vars['meta_query'][$i]['value'] = $_GET['admin_filter_event_value'];
        $i++;
    }
    if ( isset($_GET['admin_filter_event_cat_value']) && $_GET['admin_filter_event_cat_value'] != '') {
        global $wpdb;
        $posts = $wpdb->get_results("
					    SELECT $wpdb->posts.ID
					    FROM $wpdb->posts
						LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
						LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
						LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
						WHERE 1=1
						AND $wpdb->posts.post_type = 'slz-event'
						AND $wpdb->posts.post_status = 'publish'
						AND $wpdb->term_taxonomy.taxonomy  = 'slz-event-cat'
						AND $wpdb->terms.slug = '{$_GET['admin_filter_event_cat_value']}'
					");

        $event_ids = array();
        foreach( $posts as $post ){
            $event_ids[] = $post->ID;
        }
        $query->query_vars['meta_query'][$i]['key'] = 'slz_option:event';
        $query->query_vars['meta_query'][$i]['value'] = $event_ids;
        $query->query_vars['meta_query'][$i]['compare'] = 'IN';
        $i++;
    }
    if ( isset($_GET['admin_filter_money_from_value']) && $_GET['admin_filter_money_from_value'] != '' && isset($_GET['admin_filter_money_to_value']) && $_GET['admin_filter_money_to_value'] != '' ) {
        $query->query_vars['meta_query'][$i]['key'] = 'slz_option:amount';
        $query->query_vars['meta_query'][$i]['value'] = array( intval( $_GET['admin_filter_money_from_value'] ), intval( $_GET['admin_filter_money_to_value'] ) );
        $query->query_vars['meta_query'][$i]['type'] = 'numeric';
        $query->query_vars['meta_query'][$i]['compare'] = 'BETWEEN';
        $i++;
    }
}

add_action( 'woocommerce_after_cart_item_quantity_update', '_action_slz_events_after_cart_item_quantity_update', 10, 3);
function _action_slz_events_after_cart_item_quantity_update( $cart_item_key, $quantity, $old_quantity ) {
    global $woocommerce;

    $cart_item_meta = $woocommerce->session->get('slz_events_session_key_' . $cart_item_key);
    $id = $cart_item_meta['post_id_event'];

    if( ! slz_ext( 'events' )->get_config( 'is_multiple_price' ) ) {
        $carted = get_post_meta( $id, 'event_ticket_carted', '0' );
        $number_ticket = slz_get_db_post_option( $id, 'event_ticket_number', '' );
        if ( is_array($carted) && count($carted) > 0 ) {
            $carted = $carted[0];
        }

        if( $number_ticket != '' && intval($carted) + intval($quantity) > intval( $number_ticket ) ) {
            $woocommerce->cart->cart_contents[ $cart_item_key ]['quantity'] = intval( $number_ticket ) - intval($carted);
        }
    } else {
        $pricing_column = $cart_item_meta['pricing_column'];
        $price_box = slz_get_db_post_option( $id, 'price_box', array() );

        foreach ( $price_box as $idx => $box ) {
            $price_box[ md5( $box['ticket_name'].$box['ticket_price'] ) ] = $box;
        }

        $number_ticket = $price_box[$pricing_column]['ticket_number'];

        $carted = get_post_meta( $id, 'event_ticket_carted', '' );

        if( ! empty( $carted[0] ) ) {
            $carted  = (array) json_decode( $carted[0] );
        }

        if( ! isset( $carted[$pricing_column] ) ) {
            $carted[$pricing_column] = 0;
        }

        if( $number_ticket != '' && intval( $carted[$pricing_column] ) + intval($quantity) > intval( $number_ticket ) ) {
            $woocommerce->cart->cart_contents[ $cart_item_key ]['quantity'] = intval( $number_ticket ) - intval( $carted[$pricing_column] );
        }
    }

    if( slz_ext( 'portfolio' ) ) {
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
}

<?php
?>
<p>
    <label for="<?php echo esc_attr( $object->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title', 'slz'); ?></label>
    <input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id( 'title' ) ); ?>"
           name="<?php echo esc_attr( $object->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>"/>
</p>
<p>
    <label for="<?php echo esc_attr( $object->get_field_id( 'limit_post' ) ); ?>"><?php esc_html_e('Limit Posts', 'slz'); ?></label>
    <input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id( 'limit_post' ) ); ?>"
           name="<?php echo esc_attr( $object->get_field_name( 'limit_post' ) ); ?>" value="<?php echo esc_attr( $instance[ 'limit_post' ] ); ?>"/>
</p>
<p>
    <label for="<?php echo esc_attr( $object->get_field_id( 'offset_post' ) ); ?>"><?php esc_html_e('Offset Posts', 'slz'); ?></label>
    <input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id( 'offset_post' ) ); ?>"
           name="<?php echo esc_attr( $object->get_field_name( 'offset_post' ) ); ?>" value="<?php echo esc_attr( $instance[ 'offset_post' ] ); ?>"/>
</p>
<p>
    <label for="<?php echo esc_attr( $object->get_field_id( 'cat_id' ) ); ?>"><?php esc_html_e('Category ID', 'slz'); ?></label>
    <input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id( 'cat_id' ) ); ?>"
           name="<?php echo esc_attr( $object->get_field_name( 'cat_id' ) ); ?>" value="<?php echo esc_attr( $instance[ 'cat_id' ] ); ?>"/>
    <span><?php esc_html_e( 'Enter categories ID of gallery (Ex 1,2,3)', 'slz'); ?></span>
</p>
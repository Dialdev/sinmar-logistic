<?php
$widget_title = isset($instance['name'])?$instance['name']:'';
$attachment = new SLZ_Image();
if(!isset($instance['attachment_id']) || empty($instance['attachment_id']))
    $attachments = array();
else
    $attachments = $instance['attachment_id'];
?>
<p>
    <label for="<?php echo esc_attr( $object->get_field_id('name') ); ?>"><?php esc_html__('Title Widget','slz'); ?></label>
    <input class="widefat" type="text" id="<?php echo esc_attr( $object->get_field_id('name') ); ?>" name="<?php echo esc_attr( $object->get_field_name('name') ); ?>" value="<?php echo $widget_title ?>" placeholder="Input title of this widget">
</p>

<div id="<?php echo esc_attr( $object->get_field_id('attachment-wrapper') ); ?>">
    <p><?php esc_html__('Add Attachment','slz'); ?></p>
    <?php  $attachment->upload_single_attachment($object->get_field_name('attachment_id'), $attachments ,array(
        'class'=>'wiget-material-download',
        'data-rel' => $object->get_field_id('image'),
        'data-name'=> $object->get_field_name('attachment_id'),
        )); ?>
</div>
<ul class="block-info">
<?php
$edit_link = get_edit_post_link();
if( $edit_link ) {
	edit_post_link( __( 'Edit', 'slz' ), '<li class="edit-link"><i class="fa fa-pencil"></i>', '</li>' );
}
$exclude = slz()->theme->get_config('post_info_exclude', array());
echo $module->get_meta_data('', $exclude);

?>
</ul>
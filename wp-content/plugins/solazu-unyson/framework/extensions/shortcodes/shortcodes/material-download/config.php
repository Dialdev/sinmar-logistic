<?php
if ( ! defined( 'ABSPATH' ) ) {
die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
    'title' => esc_html__ ( 'SLZ Material Download', 'slz' ),
    'description' => esc_html__ ( 'List of files to download.', 'slz' ),
    'tab' => slz()->theme->manifest->get('name'),
    'icon' => 'icon-slzcore-material-download slz-vc-slzcore',
    'tag' => 'slz_material_download'
);

$cfg ['default_value'] = array (
    'title'         => '',
    'title_color'   => '',
    'files'         => '',
    'extra_class'   => ''
);
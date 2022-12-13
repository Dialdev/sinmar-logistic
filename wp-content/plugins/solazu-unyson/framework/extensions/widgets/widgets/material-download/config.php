<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$cfg = array();

$cfg['general'] = array(
    'id'       		 => __( 'material-download', 'slz' ),
    'name' 			 => __( 'SLZ: Material Download', 'slz' ),
    'description'    => __( 'Material Download Widget.', 'slz' ),
    'classname'		 => 'slz-widget-material-download'
);
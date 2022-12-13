<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$dir = dirname(__FILE__);

require $dir . '/simple.php';

require $dir .'/tab/class-slz-container-type-tab.php';
require $dir .'/box/class-slz-container-type-box.php';
require $dir .'/popup/class-slz-container-type-popup.php';
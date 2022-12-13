<?php if ( ! defined( 'SLZ' ) ) {
	die( 'Forbidden' );
}
$extension = new SLZ_Available_Extension();
$extension->set_name('seo');
$register->register($extension);
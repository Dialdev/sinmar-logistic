<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

$dir = dirname( __FILE__ );

slz_include_file_isolated(  $dir . '/option-type-recaptcha/class-slz-option-type-recaptcha.php' );

foreach ( array(
	'ReCaptcha'                  => 'ReCaptcha',
	'ReCaptchaRequestMethod'     => 'RequestMethod',
	'ReCaptchaRequestParameters' => 'RequestParameters',
	'ReCaptchaResponse'          => 'Response',
	'ReCaptchaPost'              => 'RequestMethod/Post',
	'ReCaptchaSocket'            => 'RequestMethod/Socket',
	'ReCaptchaSocketPost'        => 'RequestMethod/SocketPost',
) as $classname => $location ) {
	if ( ! class_exists( $classname ) ) {
		slz_include_file_isolated( $dir . '/ReCaptcha/' . $location . '.php' );
	}
}
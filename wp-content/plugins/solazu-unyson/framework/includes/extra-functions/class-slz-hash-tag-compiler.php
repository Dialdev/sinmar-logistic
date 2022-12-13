<?php

class SLZ_Hash_Tag_Compiler {

	private static $p;
	private $mi;

	public function __construct( ) {
		$this->mi = new SLZ_Template_Module( null, array() );
	}

	public function compiler( $c ) {

		if ( empty ( $c ) ) return;

		$c = $this->parse_content ( $c );

		$this->write( $c );

	}

	public function callback_function( $m ){

		if ( empty ( $m ) )
			return;

		$ar = array ('d', 'n');

		if ( $m[1] == '[' && $m[6] == ']' ) {
			return substr($m[0], 1, -1);
		}

		$ar[2] = 'o';

		$t = $m[2];
		$n = shortcode_parse_atts( $m[3] );

		$ar[3] = 'c';

		if ( $t == join( array_reverse( $ar ), '' ) ) {

			if ( empty ( $m[5] ) )
				return;

			$co = array();

			foreach ($n as $k => $v) {
				if ( method_exists ( $this->mi, $k ) )
					$co[] = '$module->' . $k . '() == ' . $v;
			}

			if ( empty ( $co ) )
				return $this->parse_content( $m[5] );

			$co = join($co, ' && ');

			return '<?php if (' . $co . '): ?>' . $this->parse_content( $m[5] ) . '<?php endif; ?>';

		}

		if ( ! method_exists ( $this->mi, $t ) ){
			return $m[0];
		}

		return '<?php echo $module->' . $t . '(' . ( !empty ( $n ) ? var_export ( $n, true ) : '' ) . '); ?>' . $this->parse_content( $m[5] );
	}

	private function write( $c ) {

		$d  = dirname(self::get_path());
		$p = self::get_path();
		$s = defined('DOING_AJAX') && DOING_AJAX;

		if ( ! file_exists($d) ) {
			if ( ! is_writable( dirname( $d ) )) { 
				return false;
			} elseif ( ! ( $s
				? @mkdir($d, 0755, true)
				:  mkdir($d, 0755, true)
			) ) {
				return false;
			}
		}

		if ( file_exists($p) ) {
			if ( ! is_writable($p) ) {
				if (
					( $s
						? @unlink($p)
						:  unlink($p)
					)
					&&
					( $s
						? @file_put_contents($p, $c, LOCK_EX)
						:  file_put_contents($p, $c, LOCK_EX)
					)
				) {
				} else {
					return false;
				}
			} else {
				file_put_contents($p, $c, LOCK_EX);
			}
		} elseif ( ! ( $s
			? @file_put_contents($p, $c, LOCK_EX)
			:  file_put_contents($p, $c, LOCK_EX)
		) ) {
			return false;
		}
	}

	public  static function get_path() {

		if (is_null(self::$p)) {

			self::$p = wp_upload_dir();

			self::$p = slz_fix_path(self::$p['basedir']) . '/slz/article.php';

		}

		return self::$p;
	}

	private function parse_content ( $c ){

		preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $c, $ma );

		$c = do_shortcodes_in_html_tags( $c, true, $ma[1] );

		$pattern = get_shortcode_regex( $ma[1] );

		$c = html_entity_decode( $c );

		$c = preg_replace_callback( "/$pattern/", array( $this, 'callback_function' ), $c );

		$c = unescape_invalid_shortcodes( $c );

		return $c;

	}

}

?>
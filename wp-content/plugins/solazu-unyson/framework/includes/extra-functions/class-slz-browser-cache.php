<?php
class SLZ_Browser_Cache {
	function __construct() {
		if( self::_is_loadable() ) {
			$this->init_browser_cache();
		}
	}

	public function init_browser_cache(){
		
		$path = ABSPATH;
		if( $this->is_subdirectory_install() ) {
			$path = $this->get_abspath();
		}

		if( file_exists( $path . '.htaccess' ) ) {
			$db_option_gzip = slz_get_db_settings_option( 'data_gzip_status', 'disable' );
			$db_option_leverage = slz_get_db_settings_option( 'data_leverage_browser_caching_status', 'disable' );

			if( empty( $db_option_gzip ) && empty( $db_option_leverage ) ) {
				return;
			}
			$htaccess_temp = '';

			if( isset( $db_option_gzip ) || isset( $db_option_leverage['leverage_browser_caching'] ) ) {
				$htaccess = @file_get_contents( $path . '.htaccess' );
				if( is_writeable( $path . '.htaccess' ) ) {
					if( isset( $db_option_leverage['leverage_browser_caching'] ) ) {
						$htaccess_temp = $this->leverage_browser_caching($htaccess, $db_option_leverage);
					}
					$htaccess_temp = $this->insert_gzip_rule($htaccess_temp, $db_option_gzip);

					if( !empty( $htaccess_temp ) && $htaccess_temp != $htaccess ) {
						file_put_contents($path.".htaccess", $htaccess_temp);
					}
				}
			}else{
				$htaccess = @file_get_contents( $path . '.htaccess' );
				$htaccess_temp = preg_replace("/#\s?BEGIN\s?SolazuUnysonGzip.*?#\s?END\s?SolazuUnysonGzip/s", "", $htaccess);
				$htaccess_temp = preg_replace("/#\s?BEGIN\s?SolazuUnysonLeverage.*?#\s?END\s?SolazuUnysonLeverage/s", "", $htaccess_temp);
				if( $htaccess_temp != $htaccess ) {
					file_put_contents($path.".htaccess", $htaccess_temp);
				}
			}
		}else{
			return;
		} // END IF
	}
	
	private function insert_gzip_rule( $htaccess, $db_option ) {
		if( $db_option == 'enable' ) {
			if( preg_match( "/BEGIN\s*SolazuUnysonGzip/", $htaccess ) ) {
				return $htaccess;
			}
			
			$mime_types = $this->get_mime_types();
			$cssjs_types = $mime_types['cssjs'];
			$cssjs_types = array_unique( $cssjs_types );
			$html_types = $mime_types['html'];
			$other_types = $mime_types['other_compression'];
			
			$compression_types = array();
			$compression_types = array_merge( $compression_types, $cssjs_types );
			$compression_types = array_merge( $compression_types, $html_types );
			$compression_types = array_merge( $compression_types, $other_types );
			
			$rules = '';
			$rules .= "# BEGIN SolazuUnysonGzip"."\n";
			$rules .= "<IfModule mod_deflate.c>\n";
				$rules .= "	AddOutputFilterByType DEFLATE " . implode( ' ', $compression_types ) . "\n";
			$rules .= '</IfModule>'."\n";
			$rules .= "# END SolazuUnysonGzip"."\n";
			
			return $rules. $htaccess;
		}
		$htaccess = preg_replace("/#\s?BEGIN\s?SolazuUnysonGzip.*?#\s?END\s?SolazuUnysonGzip/s", "", $htaccess);
		return $htaccess;
	}
	
	private function leverage_browser_caching( $htaccess, $db_option ) {
		if( $db_option['leverage_browser_caching'] != 'enable' ) {
			$htaccess = preg_replace("/#\s?BEGIN\s?SolazuUnysonLeverage.*?#\s?END\s?SolazuUnysonLeverage/s", "", $htaccess);
			return $htaccess;
		}
		if( preg_match( "/BEGIN\s*SolazuUnysonLeverage/", $htaccess ) ) {
			return $htaccess;
		}

		$mime_type2 = $this->get_mime_types();
		$cssjs_types = $mime_type2['cssjs'];
		$cssjs_types = array_unique( $cssjs_types );
		$html_types = $mime_type2['html'];
		$other_types = $mime_type2['other_compression'];
		
		$mine_types = array();
		
		$html_expire_time = '';
		$cssjs_expire_time = '';
		$other_expire_time = '';
		if( !empty( $db_option['enable']['html_expire_time'] ) ) {
			$html_expire_time = $db_option['enable']['html_expire_time'];
		}
		if( !empty( $db_option['enable']['cssjs_expire_time'] ) ) {
			$cssjs_expire_time = $db_option['enable']['cssjs_expire_time'];
		}
		if( !empty( $db_option['enable']['other_expire_time'] ) ) {
			$other_expire_time = $db_option['enable']['other_expire_time'];
		}

		
		if( $db_option['leverage_browser_caching'] == 'enable' ) {
			if( !empty( $cssjs_expire_time ) ) {
				$mine_types = array_merge( $mine_types, $cssjs_types );
			}
			if( !empty( $html_expire_time ) ) {
				$mine_types = array_merge( $mine_types, $html_types );
			}
			if( !empty( $other_expire_time ) ) {
				$mine_types = array_merge( $mine_types, $other_types );
			}
		}
		
		$rules = '';
		if( count( $mine_types ) ) {
			$rules .= "# BEGIN SolazuUnysonLeverage"."\n";
			$rules .= "<IfModule mod_mime.c>\n";
			foreach ( $mine_types as $ext => $mime_type ) {
				$extensions = explode( '|' , $ext);
				
				if( !is_array( $mime_type ) ) {
					$mime_type = (array)$mime_type;
				}
				foreach ( $mime_type as $mime_type2 ) {
					$rules .= "	AddType ". $mime_type2;
					foreach ( $extensions as $extension ) {
						$rules .= ' .'. $extension;
					}
					$rules .= "\n";
				}
			}
			$rules .= "</IfModule>\n";
			
			$rules .= "<IfModule mod_expires.c>\n";
			$rules .= "	ExpiresActive On\n";

				if( $db_option['leverage_browser_caching'] == 'enable' ) {
					if( !empty( $cssjs_expire_time ) ) {
						foreach ( $cssjs_types as $mime_type ) {
							$rules .= "	ExpiresByType " . $mime_type . " A" . $cssjs_expire_time . "\n";
						}
					}
					if( !empty( $html_expire_time ) ) {
						foreach ( $html_types as $mime_type ) {
							$rules .= "	ExpiresByType " . $mime_type . " A". $html_expire_time ."\n";
						}
					}
					if( !empty( $other_expire_time ) ) {
						foreach ( $other_types as $mime_type ) {
							if( is_array( $mime_type ) ) :
								foreach ( $mime_type as $mime_type2 ) {
									$rules .= "	ExpiresByType " . $mime_type2 . " A". $other_expire_time ."\n";
								}
							else:
								$rules .= "	ExpiresByType " . $mime_type . " A". $other_expire_time ."\n";
							endif;
						}
					}
				}
			
			$rules .= "</IfModule>\n";
			$rules .= "# END SolazuUnysonLeverage"."\n";
		}
		
		return $rules.$htaccess;
	}
	
	private function get_abspath() {
		$path = ABSPATH;
		$siteUrl = site_url();
		$homeUrl = home_url();
		$diff = str_replace($homeUrl, "", $siteUrl);
		$diff = trim($diff,"/");

		$pos = strrpos($path, $diff);

		if($pos !== false){
			$path = substr_replace($path, "", $pos, strlen($diff));
			$path = trim($path,"/");
			$path = "/".$path."/";
		}
		return $path;
	}
	
	private function is_subdirectory_install() {
		if(strlen(site_url()) > strlen(home_url())){
			return true;
		}
		return false;
	}
	
	private function get_mime_types() {
		$array = array(
			'cssjs' => $this->params_cssjs(),
			'html' => $this->params_html(),
			'other' => $this->params_other()
		);

		$other_compression = $array['other'];

		$array['other_compression'] = $other_compression;

		return $array;
	}
	
	private function params_cssjs() {
		return array(
			'css' => 'text/css',
			'htc' => 'text/x-component',
			'less' => 'text/css',
			'js' => 'application/x-javascript',
			'js2' => 'application/javascript',
			'js3' => 'text/javascript',
			'js4' => 'text/x-js',
		);
	}
	
	private function params_html() {
		return array(
			'html|htm' => 'text/html',
			'rtf|rtx' => 'text/richtext',
			'svg|svgz' => 'image/svg+xml',
			'txt' => 'text/plain',
			'xsd' => 'text/xsd',
			'xsl' => 'text/xsl',
			'xml' => 'text/xml'
		);
	}
	
	private function params_other() {
		return array(
			'asf|asx|wax|wmv|wmx' => 'video/asf',
			'avi' => 'video/avi',
			'bmp' => 'image/bmp',
			'class' => 'application/java',
			'divx' => 'video/divx',
			'doc|docx' => 'application/msword',
			'eot' => 'application/vnd.ms-fontobject',
			'exe' => 'application/x-msdownload',
			'gif' => 'image/gif',
			'gz|gzip' => 'application/x-gzip',
			'ico' => 'image/x-icon',
			'jpg|jpeg|jpe' => 'image/jpeg',
			'json' => 'application/json',
			'mdb' => 'application/vnd.ms-access',
			'mid|midi' => 'audio/midi',
			'mov|qt' => 'video/quicktime',
			'mp3|m4a' => 'audio/mpeg',
			'mp4|m4v' => 'video/mp4',
			'mpeg|mpg|mpe' => 'video/mpeg',
			'mpp' => 'application/vnd.ms-project',
			'otf' => 'application/x-font-otf',
			'_otf' => 'application/vnd.ms-opentype',
			'odb' => 'application/vnd.oasis.opendocument.database',
			'odc' => 'application/vnd.oasis.opendocument.chart',
			'odf' => 'application/vnd.oasis.opendocument.formula',
			'odg' => 'application/vnd.oasis.opendocument.graphics',
			'odp' => 'application/vnd.oasis.opendocument.presentation',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ogg' => 'audio/ogg',
			'pdf' => 'application/pdf',
			'png' => 'image/png',
			'pot|pps|ppt|pptx' => 'application/vnd.ms-powerpoint',
			'ra|ram' => 'audio/x-realaudio',
			'svg|svgz' => 'image/svg+xml',
			'swf' => 'application/x-shockwave-flash',
			'tar' => 'application/x-tar',
			'tif|tiff' => 'image/tiff',
			'ttf|ttc' => 'application/x-font-ttf',
			'_ttf' => 'application/vnd.ms-opentype',
			'wav' => 'audio/wav',
			'wma' => 'audio/wma',
			'wri' => 'application/vnd.ms-write',
			'woff' => 'application/font-woff',
			'woff2' => 'application/font-woff2',
			'xla|xls|xlsx|xlt|xlw' => 'application/vnd.ms-excel',
			'zip' => 'application/zip'
		);
	}
	
	private static function _is_loadable()
	{
		$allowed_in_admin = false;

		if (is_admin() && !$allowed_in_admin)
			return false;

		if (!did_action('template_redirect'))
			return true;

		if (!empty($_GET['geo_mashup_content'])
			&& 'render-map' == $_GET['geo_mashup_content'])
			return false;

		if (!empty($_GET['aec_page']))
			return false;

		if (defined('SPVERSION') && function_exists('sp_get_option'))
		{
			$sp_page = sp_get_option('sfpage');
			if (is_page($sp_page))
				return false;
		}

		if (slz_is_maintenance_on())
		{
			return false;
		}

		return true;

	}
}
new SLZ_Browser_Cache();
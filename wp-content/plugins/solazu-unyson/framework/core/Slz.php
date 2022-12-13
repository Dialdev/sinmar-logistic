<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main framework class that contains everything
 *
 * Convention: All public properties should be only instances of the components (except special property: manifest)
 */
final class _Slz
{
	/** @var bool If already loaded */
	private static $loaded = false;

	/** @var SLZ_Framework_Manifest */
	public $manifest;

	/** @var _SLZ_Component_Extensions */
	public $extensions;

	/** @var _SLZ_Component_Backend */
	public $backend;

	/** @var _SLZ_Component_Theme */
	public $theme;

	public function __construct()
	{
		if (self::$loaded) {
			trigger_error('Framework already loaded', E_USER_ERROR);
		} else {
			self::$loaded = true;
		}

		$slz_dir = slz_get_framework_directory();

		// manifest
		{
			require $slz_dir .'/core/class-slz-manifest.php';

			require $slz_dir .'/manifest.php';
			/** @var array $manifest */

			$this->manifest = new SLZ_Framework_Manifest($manifest);

			add_action('slz_init', array($this, '_check_requirements'), 1);
		}

		require $slz_dir .'/core/extends/class-slz-extension.php';
		require $slz_dir .'/core/extends/interface-slz-option-handler.php'; // option handler (experimental)

		// components
		{
			require $slz_dir .'/core/components/extensions.php';
			$this->extensions = new _SLZ_Component_Extensions();

			require $slz_dir .'/core/components/backend.php';
			$this->backend = new _SLZ_Component_Backend();

			require $slz_dir .'/core/components/theme.php';
			$this->theme = new _SLZ_Component_Theme();
		}
	}

	/**
	 * @internal
	 */
	public function _check_requirements()
	{
		if (is_admin() && !$this->manifest->check_requirements()) {
			SLZ_Flash_Messages::add(
				'slz_requirements',
				__('Framework requirements not met:', 'slz') .' '. $this->manifest->get_not_met_requirement_text(),
				'warning'
			);
		}
	}
}

/**
 * @return _SLZ Framework instance
 */
function slz() {
	static $SLZ = null; // cache

	if ($SLZ === null) {
		$SLZ = new _Slz();
	}

	return $SLZ;
}

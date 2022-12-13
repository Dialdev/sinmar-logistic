<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $lists
 * @var string $link
 * @var array $nonces
 * @var mixed $display_default_value
 * @var string $default_thumbnail
 * @var bool $can_install
 */

// Set extensions order same as in available extensions list
{
	$ordered = array(
		'active' => array(),
		'installed' => array(),
	);

	foreach ($lists['available'] as $name => &$_ext) {
		foreach ($ordered as $type => &$_exts) {
			if (isset($lists[$type][$name])) {
				$ordered[$type][$name] = $lists[$type][$name];
			}
		}
	}

	foreach ($ordered as $type => &$_exts) {
		if (!empty($ordered[$type])) {
			$lists[$type] = array_merge($ordered[$type], $lists[$type]);
		}
	}

	unset($ordered, $name, $_ext, $_exts, $type);
}

$dir = dirname(__FILE__);
$extension_view_path = $dir .'/extension.php';

$displayed = array();
?>

<div class="uns-featured-section">
	<h2 class="heading-title"><?php echo esc_html__('Welcome to', 'slz'); ?> <?php echo esc_html( slz()->theme->manifest->get('name') ); ?></h2>
	<div class="description">
		<?php echo esc_html( slz()->theme->manifest->get('description') ); ?>
	</div>
	<ul class="nav nav-tabs nav-justified">
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->theme->manifest->get('id') ) ); ?>">
				<span><?php echo esc_html__('Plugins', 'slz'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->theme->manifest->get('log_page_id') ) ); ?>">
				<span><?php echo esc_html__('Changes Log', 'slz'); ?></span>
			</a>
		</li>
		<li class="active">
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->extensions->manager->get_page_slug() ) ); ?>">
				<span><?php echo esc_html__('Extension Manager', 'slz'); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz()->backend->_get_settings_page_slug() ) ); ?>">
				<span><?php echo esc_html__('Theme Settings', 'slz'); ?></span>
			</a>
		</li>
		<?php if ( slz()->extensions->_get_db_active_extensions('backups') ) : ?>
			<li>
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Backup Data', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( slz()->extensions->_get_db_active_extensions('backups-demo') ) : ?>
			<li>
				<a href="<?php echo esc_url ( admin_url( 'admin.php?page=' . slz_ext('backups-demo')->get_page_slug() ) ); ?>">
					<span><?php echo esc_html__('Demo Install', 'slz'); ?></span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>

<h3 class="tab-heading"><?php _e('Active Extensions', 'slz') ?></h3>
<?php
$display_active_extensions = array();

foreach ($lists['active'] as $name => &$data) {
	if (true !== slz_akg('display', $data['manifest'], $display_default_value)) {
		continue;
	}

	$display_active_extensions[$name] = &$data;
}
unset($data);
?>

<?php if (empty($display_active_extensions)): ?>
	<div class="slz-extensions-no-active">
		<div class="slz-text-center slz-extensions-title-icon"><span class="dashicons dashicons-screenoptions"></span></div>
		<p class="slz-text-center slz-text-muted"><em><?php _e('No extensions activated yet', 'slz'); ?><br/><?php _e('Check the available extensions below', 'slz'); ?></em></p>
	</div>
<?php else: ?>
	<div class="slz-row slz-extensions-list">
		<?php
		foreach ($display_active_extensions as $name => &$data) {
			slz_render_view($extension_view_path, array(
				'name' => $name,
				'title' => slz_ext($name)->manifest->get_name(),
				'description' => slz_ext($name)->manifest->get('description'),
				'link' => $link,
				'lists' => &$lists,
				'nonces' => $nonces,
				'default_thumbnail' => $default_thumbnail,
				'can_install' => $can_install,
			), false);

			$displayed[$name] = true;
		}
		unset($data);
		?>
	</div>
<?php endif; ?>

<div id="slz-extensions-list-available">
	<hr class="slz-extensions-lists-separator"/>
	<h3><?php _e('Available Extensions', 'slz') ?></h3><!-- This "available" differs from technical "available" -->
	<div class="slz-row slz-extensions-list">
		<?php $something_displayed = false; ?>
		<?php
		{
			$theme_extensions = array();

			foreach ($lists['disabled'] as $name => &$data) {
				if (!$data['is']['theme']) {
					continue;
				}

				$theme_extensions[$name] = array(
					'name' => slz_akg('name', $data['manifest'], slz_id_to_title($name)),
					'description' => slz_akg('description', $data['manifest'], '')
				);
			}
			unset($data);

			foreach ($theme_extensions + $lists['supported'] as $name => $data) {
				if (isset($displayed[$name])) {
					continue;
				} elseif (isset($lists['installed'][$name])) {
					if (true !== slz_akg('display', $lists['installed'][$name]['manifest'], $display_default_value)) {
						continue;
					}
				} else {
					if (isset($lists['available'][$name])) {
						if (!$can_install) {
							continue;
						}
					} else {
						//trigger_error(sprintf(__('Supported extension "%s" is not available.', 'slz'), $name));
						continue;
					}
				}

				slz_render_view($extension_view_path, array(
					'name' => $name,
					'title' => $data['name'],
					'description' => $data['description'],
					'link' => $link,
					'lists' => &$lists,
					'nonces' => $nonces,
					'default_thumbnail' => $default_thumbnail,
					'can_install' => $can_install,
				), false);

				$displayed[$name] = $something_displayed = true;
			}

			unset($theme_extensions);
		}

		foreach ($lists['disabled'] as $name => &$data) {
			if (isset($displayed[$name])) {
				continue;
			} elseif (true !== slz_akg('display', $data['manifest'], $display_default_value)) {
				continue;
			}

			slz_render_view($extension_view_path, array(
				'name' => $name,
				'title' => slz_akg('name', $data['manifest'], slz_id_to_title($name)),
				'description' => slz_akg('description', $data['manifest'], ''),
				'link' => $link,
				'lists' => &$lists,
				'nonces' => $nonces,
				'default_thumbnail' => $default_thumbnail,
				'can_install' => $can_install,
			), false);

			$displayed[$name] = $something_displayed = true;
		}
		unset($data);

		if ($can_install) {
			foreach ( $lists['available'] as $name => &$data ) {
				if ( isset( $displayed[ $name ] ) ) {
					continue;
				} elseif ( isset( $lists['installed'][ $name ] ) ) {
					continue;
				} elseif ( $data['display'] !== true ) {
					continue;
				}

				/**
				 * fixme: remove this in the future when this extensions will look good on any theme
				 */
				if ( in_array( $name, array( 'styling', 'megamenu' ) ) ) {
					if ( isset( $lists['supported'][ $name ] ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
					} else {
						continue;
					}
				}

				slz_render_view( $extension_view_path, array(
					'name'              => $name,
					'title'             => $data['name'],
					'description'       => $data['description'],
					'link'              => $link,
					'lists'             => &$lists,
					'nonces'            => $nonces,
					'default_thumbnail' => $default_thumbnail,
					'can_install'       => $can_install,
				), false );

				$something_displayed = true;
			}
			unset($data);
		}
		?>
	</div>

	<?php if ($something_displayed && apply_filters('slz_extensions_page_show_other_extensions', true)): ?>
		<!-- show/hide not compatible extensions -->
		<p class="slz-text-center toggle-not-compat-ext-btn-wrapper"><?php
			echo slz_html_tag(
				'a',
				array(
					'href' => '#',
					'onclick' => 'return false;',
					'class' => 'button toggle-not-compat-ext-btn',
					'style' => 'box-shadow:none;'
				),
				'<span class="the-show-text">'. __('Show other extensions', 'slz') .'</span>'.
				'<span class="the-hide-text slz-hidden">'. __('Hide other extensions', 'slz') .'</span>'
			);
			?></p>
		<script type="text/javascript">
			jQuery(function($){
				if (
					!$('.slz-extensions-list .slz-extensions-list-item.not-compatible').length
					||
					<?php echo empty($lists['supported']) ? 'true' : 'false' ?>
				) {
					// disable the show/hide feature
					$('#slz-extensions-list-wrapper .toggle-not-compat-ext-btn-wrapper').addClass('slz-hidden');
				} else {
					$('#slz-extensions-list-wrapper .slz-extensions-list .slz-extensions-list-item.not-compatible').fadeOut('fast');

					$('#slz-extensions-list-wrapper .toggle-not-compat-ext-btn-wrapper').on('click', function(){
						$('#slz-extensions-list-wrapper .slz-extensions-list .slz-extensions-list-item.not-compatible')[
							$(this).find('.the-hide-text').hasClass('slz-hidden') ? 'fadeIn' : 'fadeOut'
							]();

						$(this).find('.the-show-text, .the-hide-text').toggleClass('slz-hidden');
					});
				}
			});
		</script>
		<!-- end: show/hide not compatible extensions -->
	<?php else: ?>
		<script type="text/javascript">
			jQuery(function($){
				$('#slz-extensions-list-available').remove();
			});
		</script>
	<?php endif; ?>
</div>

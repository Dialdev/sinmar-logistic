<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var array $options
 * @var array $values
 * @var string $reset_input_name
 * @var bool $ajax_submit
 * @var bool $side_tabs
 */
?>

<?php
if (!function_exists('_action_slz_theme_settings_footer_scripts')):

function _action_slz_theme_settings_footer_scripts() {
	?>
	<script type="text/javascript">
		(function ($) {
			var slzLoadingId = 'slz-theme-settings';

			{
				slz.loading.show(slzLoadingId);

				slzEvents.one('slz:options:init', function (data) {
					slz.loading.hide(slzLoadingId);
				});
			}

			$(function ($) {
				$(document.body).on({
					'slz:settings-form:before-html-reset': function () {
						slz.loading.show(slzLoadingId);
					},
					'slz:settings-form:reset': function () {
						slz.loading.hide(slzLoadingId);
					}
				});
			});
		})(jQuery);
	</script>
<?php
}
add_action('admin_print_footer_scripts', '_action_slz_theme_settings_footer_scripts', 20);

endif;

$texts = apply_filters('slz_settings_form_texts', array(
	'save_button' => __('Save Changes', 'slz'),
	'reset_button' => __('Reset Options', 'slz'),
));
?>

<?php if ($side_tabs): ?>
	<div class="slz-settings-form-header slz-row">
		<div class="slz-col-xs-12 slz-col-sm-6">
			<h2><?php echo slz()->theme->manifest->get_name() ?>
				<?php if (slz()->theme->manifest->get('author')): ?>
					<?php
					if (slz()->theme->manifest->get('author_uri')) {
						echo slz_html_tag('a', array(
							'href' => slz()->theme->manifest->get('author_uri'),
							'target' => '_blank'
						), '<small>'. __('by', 'slz') .' '. slz()->theme->manifest->get('author') .'</small>');
					} else {
						echo '<small>'. slz()->theme->manifest->get('author') .'</small>';
					}
					?>
				<?php endif; ?>
			</h2>
		</div>
		<div class="slz-col-xs-12 slz-col-sm-6">
			<div class="form-header-buttons">
				<?php
				/**
				 * Make sure firs submit button is Save button
				 * because the first button is "clicked" when you press enter in some input
				 * and the form is submitted.
				 * So to prevent form Reset on input Enter, make Save button first in html
				 */

				echo slz_html_tag('input', array(
					'type' => 'submit',
					'name' => '_slz_save_options',
					'class' => 'slz-hidden',
				));
				?>
				<?php
				echo implode(
					'<i class="submit-button-separator"></i>',
					apply_filters('slz_settings_form_header_buttons', array(
						slz_html_tag('input', array(
							'type' => 'submit',
							'name' => '_slz_reset_options',
							'value' => $texts['reset_button'],
							'class' => 'button-secondary button-large submit-button-reset',
						)),
						slz_html_tag('input', array(
							'type' => 'submit',
							'name' => '_slz_save_options',
							'value' => $texts['save_button'],
							'class' => 'button-primary button-large submit-button-save',
						))
					))
				);
				?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(function($){
			slzEvents.on('slz:options:init', function(data){
				data.$elements.find('.slz-settings-form-header:not(.initialized)').addClass('initialized');
			});
		});
	</script>
<?php endif; ?>

<?php echo slz()->backend->render_options($options, $values); ?>

<div class="form-footer-buttons">
<!-- This div is required to follow after options in order to have special styles in case options will contain tabs (css adjacent selector + ) -->
<?php echo implode(
	$side_tabs ? ' ' : ' &nbsp;&nbsp; ',
	apply_filters('slz_settings_form_footer_buttons', array(
		slz_html_tag('input', array(
			'type' => 'submit',
			'name' => '_slz_save_options',
			'value' => $texts['save_button'],
			'class' => 'button-primary button-large',
		)),
		slz_html_tag('input', array(
			'type' => 'submit',
			'name' => '_slz_reset_options',
			'value' => $texts['reset_button'],
			'class' => 'button-secondary button-large',
		))
	))
); ?>
</div>

<!-- reset warning -->
<script type="text/javascript">
	jQuery(function($){
		$(document.body).on('click.slz-reset-warning', 'form[data-slz-form-id="slz_settings"] input[name="<?php echo esc_js($reset_input_name) ?>"]', function(e){
			/**
			 * on confirm() the submit input looses focus
			 * slzForm.isAdminPage() must be able to select the input to send it in _POST
			 * so use alternative solution http://stackoverflow.com/a/5721762
			 */
			{
				$(this).closest('form').find('[clicked]:submit').removeAttr('clicked');
				$(this).attr('clicked', '');
			}

			if (!confirm('<?php
				echo esc_js(__("Click OK to reset.\nAll settings will be lost and replaced with default settings!", 'slz'))
			?>')) {
				e.preventDefault();
				$(this).removeAttr('clicked');
			}
		});
	});
</script>
<!-- end: reset warning -->

<script type="text/javascript">
	jQuery(function($){
		var $form = $('form[data-slz-form-id="slz_settings"]:first'),
			timeoutId = 0;

		$form.on('change.slz_settings_form_delayed_change', function(){
			clearTimeout(timeoutId);
			/**
			 * Run on timeout to prevent too often trigger (and cpu load) when a bunch of changes will happen at once
			 */
			timeoutId = setTimeout(function () {
				$form.trigger('slz:settings-form:delayed-change');
			}, 333);
		});
	});
</script>

<?php if ($ajax_submit): ?>
<!-- ajax submit -->
<div id="slz-settings-form-ajax-save-extra-message"
     data-html="<?php echo slz_htmlspecialchars(apply_filters('slz_settings_form_ajax_save_loading_extra_message', '')) ?>"></div>
<script type="text/javascript">
	jQuery(function ($) {
		function isReset($submitButton) {
			return $submitButton.length && $submitButton.attr('name') == '<?php echo esc_js($reset_input_name) ?>';
		}

		var formSelector = 'form[data-slz-form-id="slz_settings"]',
			loadingExtraMessage = $('#slz-settings-form-ajax-save-extra-message').attr('data-html');

		$(formSelector).addClass('prevent-all-tabs-init'); // fixes https://github.com/ThemeFuse/Unyson/issues/1491

		slzForm.initAjaxSubmit({
			selector: formSelector,
			loading: function(elements, show) {
				if (show) {
					var title, description;

					if (isReset(elements.$submitButton)) {
						title = '<?php echo esc_js(__('Resetting', 'slz')) ?>';
						description =
							'<?php echo esc_js(__('We are currently resetting your settings.', 'slz')) ?>'+
							'<br/>'+
							'<?php echo esc_js(__('This may take a few moments.', 'slz')) ?>';
					} else {
						title = '<?php echo esc_js(__('Saving', 'slz')) ?>';
						description =
							'<?php echo esc_js(__('We are currently saving your settings.', 'slz')) ?>'+
							'<br/>'+
							'<?php echo esc_js(__('This may take a few moments.', 'slz')); ?>';
					}

					slz.soleModal.show(
						'slz-options-ajax-save-loading',
						'<h2 class="slz-text-muted">'+
							'<img src="'+ slz.img.loadingSpinner +'" alt="Loading" class="wp-spinner" /> '+
							title +
						'</h2>'+
						'<p class="slz-text-muted"><em>'+ description +'</em></p>'+ loadingExtraMessage,
						{
							autoHide: 60000,
							allowClose: false
						}
					);

					return 500; // fixes https://github.com/ThemeFuse/Unyson/issues/1491
				} else {
					// slz.soleModal.hide('slz-options-ajax-save-loading'); // we need to show loading until the form reset ajax will finish
				}
			},
			afterSubmitDelay: function (elements) {
				slzEvents.trigger('slz:options:init:tabs', {$elements: elements.$form});
			},
			onErrors: function() {
				slz.soleModal.hide('slz-options-ajax-save-loading');
			},
			onAjaxError: function(elements, data) {
				{
					var message = String(data.errorThrown);

					if (data.jqXHR.responseText && data.jqXHR.responseText.indexOf('Fatal error') > -1) {
						message = $(data.jqXHR.responseText).text().split(' in ').shift();
					}
				}

				slz.soleModal.hide('slz-options-ajax-save-loading');
				slz.soleModal.show(
					'slz-options-ajax-save-error',
					'<p class="slz-text-danger">'+ message +'</p>'
				);
			},
			onSuccess: function(elements, ajaxData) {
				/**
				 * Display messages
				 */
				do {
					/**
					 * Don't display the "Settings successfully saved" message
					 * users will click often on the Save button, it's obvious it was saved if no error is shown.
					 */
					delete ajaxData.flash_messages.success.slz_settings_form_save;

					if (
						_.isEmpty(ajaxData.flash_messages.error)
						&&
						_.isEmpty(ajaxData.flash_messages.warning)
						&&
						_.isEmpty(ajaxData.flash_messages.info)
						&&
						_.isEmpty(ajaxData.flash_messages.success)
					) {
						// no messages to display
						break;
					}

					var noErrors = _.isEmpty(ajaxData.flash_messages.error) && _.isEmpty(ajaxData.flash_messages.warning);

					slz.soleModal.show(
						'slz-options-ajax-save-success',
						'<div style="margin: 0 35px;">'+ slz.soleModal.renderFlashMessages(ajaxData.flash_messages) +'</div>',
						{
							autoHide: noErrors
								? 1000 // hide fast the message if everything went fine
								: 10000,
							showCloseButton: false,
							hidePrevious: noErrors ? false : true // close and open popup when there are errors
						}
					);
				} while(false);

				/**
				 * Refresh form html on Reset
				 */
				if (isReset(elements.$submitButton)) {
					jQuery.ajax({
						type: "GET",
						dataType: 'text'
					}).done(function(html){
						slz.soleModal.hide('slz-options-ajax-save-loading');

						var $form = jQuery(formSelector, html);
						html = undefined; // not needed anymore

						if (!$form.length) {
							alert('Can\'t find the form in the ajax response');
							return;
						}

						// waitSoleModalFadeOut -> formFadeOut -> formReplace -> formFadeIn
						setTimeout(function(){
							elements.$form.css('transition', 'opacity ease .3s');
							elements.$form.css('opacity', '0');
							elements.$form.trigger('slz:settings-form:before-html-reset');

							setTimeout(function() {
								var scrollTop = jQuery(window).scrollTop();

								// replace form html
								{
									elements.$form.css({
										'display': 'block',
										'height': elements.$form.height() +'px'
									});
									elements.$form.get(0).innerHTML = $form.get(0).innerHTML;
									$form = undefined; // not needed anymore
									elements.$form.css({
										'display': '',
										'height': ''
									});
								}

								slzEvents.trigger('slz:options:init', {$elements: elements.$form});

								jQuery(window).scrollTop(scrollTop);

								// fadeIn
								{
									elements.$form.css('opacity', '');
									setTimeout(function(){
										elements.$form.css('transition', '');
										elements.$form.css('visibility', '');
									}, 300);
								}

								elements.$form.trigger('slz:settings-form:reset');
							}, 300);
						}, 300);
					}).fail(function(jqXHR, textStatus, errorThrown){
						slz.soleModal.hide('slz-options-ajax-save-loading');
						elements.$form.css({
							'opacity': '',
							'transition': '',
							'visibility': ''
						});
						console.error(jqXHR, textStatus, errorThrown);
						alert('Ajax error (more details in console)');
					});
				} else {
					slz.soleModal.hide('slz-options-ajax-save-loading');
					elements.$form.trigger('slz:settings-form:saved');
				}
			}
		});
	});
</script>
<!-- end: ajax submit -->
<?php endif; ?>

<?php if ($side_tabs && apply_filters('slz:settings-form:side-tabs:open-all-boxes', true)): ?>
<!-- open all postboxes -->
<script type="text/javascript">
	jQuery(function ($) {
		var execTimeoutId = 0;

		slzEvents.on('slz:options:init', function(data){
			// use timeout to be executed after the script from backend-options.js
			clearTimeout(execTimeoutId);
			execTimeoutId = setTimeout(function(){
				// undo not first boxes auto close
				data.$elements.find('.slz-backend-postboxes > .slz-postbox:not(:first-child)').removeClass('closed');
			}, 10);
		});
	});
</script>
<?php endif; ?>

<?php if (!empty($_GET['_focus_tab'])): ?>
<script type="text/javascript">
	jQuery(function($){
		slzEvents.one('slz:options:init', function(){
			setTimeout(function(){
				$('a[href="#<?php echo esc_js($_GET['_focus_tab']); ?>"]').trigger('click');
			}, 90);
		});
	});
</script>
<?php endif; ?>

<?php do_action('slz_settings_form_footer'); ?>

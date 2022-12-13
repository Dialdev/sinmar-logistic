<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class _SLZ_Customizer_Control_Option_Wrapper extends WP_Customize_Control {
	public function render_content() {
		slz()->backend->_set_default_render_design('customizer');
		?>
		<div class="slz-backend-customizer-option">
			<input class="slz-backend-customizer-option-input" type="hidden" <?php $this->link() ?> />
			<div class="slz-backend-customizer-option-inner slz-force-xs">
				<?php
				echo slz()->backend->render_options(
					array($this->id => $this->setting->get_slz_option()),
					array(
						$this->id => $this->value()
					),
					array(),
					'customizer'
				);
				?>
			</div>
		</div>
		<?php
		slz()->backend->_set_default_render_design();
	}
}

<div class="sc_tabs slz-tab slz_shortcode <?php echo esc_attr( $data['block_cls'] ); ?>">
	<?php
		$tab_align = 'text-l';
		if ($data['tab_align'] == 'text-c') {
			$tab_align = 'text-c'; 
		} else if ($data['tab_align'] == 'text-r') {
			$tab_align = 'text-r';
		} else {
			$tab_align = 'text-l';
		}
	?>
	<div class="tab-list-wrapper <?php echo esc_attr($tab_align) ?>">
		<?php
			echo ( $data['tab'] );
		?>
	</div>
	<div class="tab-content">
		<?php echo ( $data['content'] ); ?>
	</div>
	<div class="clearfix"></div>
</div>
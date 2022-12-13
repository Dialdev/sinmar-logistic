<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); } ?>
<?php
$column = !empty($data['column']) ? $data['column'] : '6'; ?>

<div class="slz-list-block slz-column-<?php echo esc_attr($column); ?> slz-list-logo">
    <?php SLZ_Shortcode_Partner::render_partner_item_sc($data); ?>
</div>

<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $data
 * @var array $option
 * @var string $id
 */

$attr  = $option['attr'];
?>
<div <?php echo slz_attr_to_html( $attr ); ?>>
	<div class="items-wrapper">
		<div class="item">
			<div class="input-wrapper">
				<?php echo slz()->backend->option_type( 'hidden' )->render( $id, array( 'value' => $data['value'] ), $data );?>
			</div>
			<div class="content button"><?php echo $option['button']; ?></div>
		</div>
	</div>
</div>
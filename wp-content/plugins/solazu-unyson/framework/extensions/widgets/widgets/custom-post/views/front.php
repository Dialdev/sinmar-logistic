<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$out = '';
$id = get_the_ID();


switch ($data['post_type']) {
	case 'slz-team':
		$model = new SLZ_Team();
		break;
	case 'slz-portfolio':
		$model = new SLZ_Portfolio();
		break;
	case 'slz-service':
		$model = new SLZ_Service();
		break;
	case 'slz-recruiment':
		$model = new SLZ_Recruitment();
		break;
	default:
		break;
}

$model->init($data);


if( $model->query->have_posts() ) {
	while ( $model->query->have_posts() ) {
		$model->query->the_post();
		$model->loop_index();
		if( $model->post_id == $id ){
			$html_options['title_format'] = '<a href="%2$s" class="active">%1$s</a>';
		}else{
			$html_options['title_format'] = '<a href="%2$s">%1$s</a>';
		}
		$model->html_format = $model->set_default_options( $html_options );
		$out .= sprintf( '<li>%1$s</li>',
			$model->get_title( $model->html_format )
		);
	}
	$model->reset();
}

echo $before_widget;?>
	<div class="slz-widget-custom-post">
		<?php echo wp_kses_post($title); ?>
	
			<div class="widget-content">
				<ul>
					<?php echo wp_kses_post($out);?>
				</ul>
			</div>
		
	</div>

<?php echo $after_widget;?>
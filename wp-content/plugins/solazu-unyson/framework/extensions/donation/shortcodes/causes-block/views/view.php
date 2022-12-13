<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Forbidden' ); }

switch ( $data['layout'] ) {
	case 'layout-1':
		if( $data['column_1'] == '4' ) {
			$data['image_size'] = array(
				'large'           => '263x174',
				'no-image-large'  => '263x174'
			);
		}elseif ( $data['column_1'] == '2' ) {
			$data['image_size'] = array(
				'large'           => '560x370',
				'no-image-large'  => '560x370'
			);
		}elseif ( $data['column_1'] == '3' ) {
			$data['image_size'] = array(
				'large'           => '360x238',
				'no-image-large'  => '360x238'
			);
		}else {
			$data['image_size'] = array(
				'large'           => '750x495',
				'no-image-large'  => '750x495'
			);
		}
		break;
	case 'layout-2':
		$data['image_size'] = array(
			'large'           => '560x370',
			'no-image-large'  => '560x370'
		);
		break;
	default:
		break;
}

$model = new SLZ_Causes();
$model->init( $data );

$uniq_id = $model->attributes['uniq_id'];
$block_cls = $model->attributes['extra_class'] . ' ' . $uniq_id;
$data['block_cls'] = $block_cls;
$data['uniq_id'] = $uniq_id;
$data['model'] = $model;


if( ! empty( $data['show_donation_button'] ) && $data['show_donation_button'] == 'yes' ) {
    $data['modal_html'] = '
	    <div id="donate-modal-'. esc_attr( $data['uniq_id'] ) .'" tabindex="-1" role="dialog" class="modal fade">
           <div role="document" class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                       <h4 class="modal-title">'. esc_html__( 'Donation', 'slz' ) .'</h4>
                   </div>
                   <div class="slz-donate-submit slz-form-donate">
                       <div class="modal-body">
                           <div class="form-group">
                               <span class="gdlr-head">How much would you like to donate?</span>
                               <div class="donation-button-segment-group slz-form-donate">
                                   '.slz_theme_render_price_payppal('valueDonation', 4).'
                                   <input type="hidden" name="slz_causes_post_id" value="" class="slz_causes_post_id"/>
                               </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="slz-btn btn-block-donate slz_money_donate_btn">'. esc_html__( 'Donate now', 'slz' ) .'</button>
                       </div>
                   </div>
               </div>
           </div>
        </div>	
	';
    $custom_css = '
        .slz-shortcode.sc_causes {
            z-index: inherit;
        }
    ';
    if ( !empty( $custom_css ) ) {
        do_action('slz_add_inline_style', $custom_css);
    }
}




switch ( $data['layout'] ) {
	case 'layout-1':
		echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
		break;
	case 'layout-2':
		echo slz_render_view( $instance->locate_path('/views/layout-2.php'), compact('data'));
		break;
	case 'layout-3':
		echo slz_render_view( $instance->locate_path('/views/layout-3.php'), compact('data'));
		break;
    default:
        echo slz_render_view( $instance->locate_path('/views/layout-1.php'), compact('data'));
        break;
}


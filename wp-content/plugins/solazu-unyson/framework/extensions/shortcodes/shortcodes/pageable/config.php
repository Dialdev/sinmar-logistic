<?php

if ( ! defined( 'ABSPATH' ) ) {
	die ( 'Forbidden' );
}

$cfg = array ();

$cfg ['page_builder'] = array (
	'title' => esc_html__( 'SLZ Pageable Container', 'slz' ),
	'description' => esc_html__( 'Custom pageable content container.', 'slz' ),
	'tab' => slz()->theme->manifest->get('name'),
	'icon' => 'icon-slzcore-pageable slz-vc-slzcore',
	'tag' => 'slz_pageable',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'vc_tta_section',
	),
	'class'=>'wpb_vc_tta_pageable',
	'js_view' => 'VcBackendTtaPageableView',
	'custom_markup' => '
		<div class="vc_tta-container vc_tta-o-non-responsive" data-vc-action="collapse">
			<div class="vc_general vc_tta vc_tta-tabs vc_tta-pageable vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
				<div class="vc_tta-tabs-container">'
			                   . '<ul class="vc_tta-tabs-list">'
			                   . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
			                   . '</ul>
				</div>
				<div class="vc_tta-panels vc_clearfix {{container-class}}">
				  {{ content }}
				</div>
			</div>
		</div>',
	'default_content' => '
		[vc_tta_section title="' . sprintf( '%s %d', esc_html__( 'Section', 'slz' ), 1 ) . '"][/vc_tta_section]
	',
);

$cfg ['styles'] = array (
	'style-1' => esc_html__( 'Florida', 'slz' ),
	'style-2' => esc_html__( 'California', 'slz' ),
);

$cfg ['default_value'] = array (
	'style'             => 'style-1',
	'bottom'            => '',
	'extra_class'       => ''
);
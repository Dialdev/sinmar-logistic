<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Rows with options
 */
class SLZ_Option_Type_Select_Link extends SLZ_Option_Type {
    public function get_type() {
        return 'slz-select-link';
    }

    /**
     * @internal
     * {@inheritdoc}
     */
    protected function _enqueue_static( $id, $option, $data ) {
        wp_enqueue_style(
            'slz-option-'. $this->get_type() .'-select-link',
            slz_get_framework_directory_uri('/includes/option-types/'. $this->get_type() .'/static/css/styles.css'),
            array(),
            slz()->manifest->get_version()
        );
    }

    /**
     * @param string $id
     * @param array $option
     * @param array $data
     *
     * @return string
     *
     * @internal
     */
    protected function _render( $id, $option, $data ) {
        $option['value'] = $data['value'];

        if ( !isset ( $option['attr']['data-saved-value'] ) )
            $option['attr']['data-saved-value'] = $data['value'];

        $option['value'] = $option['attr']['data-saved-value'];

        unset(
            $option['attr']['value'],
            $option['attr']['multiple']
        );

        if ( ! isset( $option['choices'] ) ) {
            $option['choices'] = array();
        }

        $html_link = '';
        if ( isset($option['link']) && isset($option['link_image']) ) {
            $html_link = '<a class="img-link" href="'.esc_attr($option['link']).'"><img src="'.$option['link_image'].'"/></a>';
        }

        $html = '<select ' . slz_attr_to_html( $option['attr'] ) . '>' .
            $this->render_choices( $option['choices'], $option['value'] ) .
            '</select>'.$html_link;

        return $html;
    }

    /**
     * @param array $option
     * @param array|null|string $input_value
     *
     * @return string
     *
     * @internal
     */
    protected function _get_value_from_input( $option, $input_value ) {
        if ( is_null( $input_value ) ) {
            return $option['value'];
        }

        if ( empty( $option['no-validate'] ) ) {
            $all_choices = $this->get_choices( $option['choices'] );

            if ( ! isset( $all_choices[ $input_value ] ) ) {
                if (
                    empty( $all_choices ) ||
                    isset( $all_choices[ $option['value'] ] )
                ) {
                    $input_value = $option['value'];
                } else {
                    reset( $all_choices );
                    $input_value = key( $all_choices );
                }
            }

            unset( $all_choices );
        }

        return (string) $input_value;
    }

    /**
     * Extract recursive from optgroups all choices as one level array
     *
     * @param array|null $choices
     *
     * @return array
     *
     * @internal
     */
    protected function get_choices( $choices ) {
        $result = array();

        foreach ( $choices as $cid => $choice ) {
            if ( is_array( $choice ) && isset( $choice['choices'] ) ) {
                // optgroup
                $result += $this->get_choices( $choice['choices'] );
            } else {
                $result[ $cid ] = $choice;
            }
        }

        return $result;
    }

    protected function render_choices( &$choices, &$value ) {
        if ( empty( $choices ) || ! is_array( $choices ) ) {
            return '';
        }

        $html = '';

        foreach ( $choices as $c_value => $choice ) {
            if ( is_array( $choice ) ) {
                if ( ! isset( $choice['attr'] ) ) {
                    $choice['attr'] = array();
                }

                if ( isset( $choice['choices'] ) ) { // optgroup
                    $html .= '<optgroup ' . slz_attr_to_html( $choice['attr'] ) . '>' .
                        $this->render_choices( $choice['choices'], $value ) .
                        '</optgroup>';
                } else { // choice as array (with custom attributes)
                    $choice['attr']['value'] = $c_value;

                    unset( $choice['attr']['selected'] ); // this is not allowed

                    $html .= '<option ' . slz_attr_to_html( $choice['attr'] ) . ' ' .
                        ( $c_value == $value ? 'selected="selected" ' : '' ) . '>' .
                        htmlspecialchars( isset( $choice['text'] ) ? $choice['text'] : '', ENT_COMPAT, 'UTF-8' ) .
                        '</option>';
                }
            } else { // simple choice
                $html .= '<option value="' . esc_attr( $c_value ) . '" ' .
                    ( $c_value == $value ? 'selected="selected" ' : '' ) . '>' .
                    htmlspecialchars( $choice, ENT_COMPAT, 'UTF-8' ) .
                    '</option>';
            }
        }

        return $html;
    }

    /**
     * @internal
     */
    protected function _get_defaults() {
        return array(
            'value'   => '',
            'choices' => array()
        );
    }
}
SLZ_Option_Type::register('SLZ_Option_Type_Select_Link');

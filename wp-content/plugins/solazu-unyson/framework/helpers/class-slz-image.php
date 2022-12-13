<?php
/**
 * Helper class
 *
 */
class SLZ_Image {
	/**
	 * Regenerate old image width new image sizes
	 *
	 * @param int $attachment_id Attachment Id to process.
	 * @param string $file Filepath of the Attached image.
	 */
	public function regenerate_attachment_sizes( $attachment_id, $thumb_size ) {
		if( empty( $attachment_id ) ) return;
		if( function_exists('image_get_intermediate_size' ) && function_exists( 'file_is_displayable_image' ) ) {
			//check size exists
			if ( image_get_intermediate_size($attachment_id, $thumb_size) ) {
				return;
			}
			// thumb size is not exists
			$file = get_attached_file( $attachment_id );
			$attachment = get_post( $attachment_id );

			$metadata = array ();
			if ( preg_match( '!^image/!', get_post_mime_type( $attachment ) ) && file_is_displayable_image( $file ) ) {
				$imagesize = getimagesize( $file );
				$metadata ['width'] = $imagesize [0];
				$metadata ['height'] = $imagesize [1];
				list ( $uwidth, $uheight ) = wp_constrain_dimensions( $metadata ['width'], $metadata ['height'], 128, 96 );
				$metadata ['hwstring_small'] = "height='$uheight' width='$uwidth'";
			
				// Make the file path relative to the upload dir
				$metadata ['file'] = _wp_relative_upload_path( $file );
			
				// make thumbnails and other intermediate sizes
				global $_wp_additional_image_sizes;
			
				foreach ( get_intermediate_image_sizes() as $s ) {
					$sizes [$s] = array (
						'width' => '',
						'height' => '',
						'crop' => FALSE
					);
					if ( isset( $_wp_additional_image_sizes [$s] ['width'] ) ) {
						// For theme-added sizes
						$sizes [$s] ['width'] = intval( $_wp_additional_image_sizes [$s] ['width'] );
					} else {
						// For default sizes set in options
						$sizes [$s] ['width'] = get_option( "{$s}_size_w" );
					}
					if ( isset( $_wp_additional_image_sizes [$s] ['height'] ) ) {
						// For theme-added sizes
						$sizes [$s] ['height'] = intval( $_wp_additional_image_sizes [$s] ['height'] );
					} else {
						// For default sizes set in options
						$sizes [$s] ['height'] = get_option( "{$s}_size_h" );
					}
					if ( isset( $_wp_additional_image_sizes [$s] ['crop'] ) ) {
						// For theme-added sizes
						$sizes [$s] ['crop'] = intval( $_wp_additional_image_sizes [$s] ['crop'] );
					} else {
						// For default sizes set in options
						$sizes [$s] ['crop'] = get_option( "{$s}_crop" );
					}
				}
			
				$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );
			
				// Only generate image if it does not already exist
				$attachment_meta = wp_get_attachment_metadata( $attachment_id );
			
				foreach ( $sizes as $size => $size_data ) {
					if ( isset( $attachment_meta ['sizes'] [$size] ) ) {
						// Size already exists
						$metadata ['sizes'] [$size] = $attachment_meta ['sizes'] [$size];
					} else {
						// Generate new image
						$resized = image_make_intermediate_size( $file, $size_data ['width'], $size_data ['height'], $size_data ['crop'] );
						if ( $resized ) {
							$metadata ['sizes'] [$size] = $resized;
						}
					}
				}
			
				if ( isset( $attachment_meta ['image_meta'] ) ) {
					$metadata ['image_meta'] = $attachment_meta ['image_meta'];
				}
				$attachment_metadata = apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
				wp_update_attachment_metadata( $attachment_id, $attachment_metadata );
			}
		}
	}

	// upload single image
	public function upload_single_image( $name, $value, $html_options = array() ) {
		$img_src = '';
		$img_show = 'hide';
		$no_img_show = 'show';
		if( ! empty( $value )) {
			$attachment_image = wp_get_attachment_image_src($value, 'medium');
			$img_src = $attachment_image[0];
			$img_show = '';
			$no_img_show = 'hide';
		}
		$output = '<div class="screenshot  slz-image-upload-wrapper '.$img_show.'" ><img src="'.esc_url($img_src).'"/></div>';
		$output .= '<div class="screenshot  slz-no-image '.$no_img_show.'" ></div>';
		$img_id_name = $name . '_id';
		if( !empty( $prefix ) ) {
			$img_id_name = $prefix . '[' . $img_id_name . ']';
		}
		$output .= '
			<input type="button" data-rel="' . $html_options['data-rel'] .'" class="button slz-image-upload-btn slz-btn-upload " value="'. esc_html__( 'Upload Image', 'slz' ) .'" />
			<input type="button" data-rel="' . $html_options['data-rel'] .'" class="button slz-image-upload-btn slz-btn-remove '.$img_show.'" value="'. esc_html__( 'Remove', 'slz' ) .'" />
			';
		unset($html_options['data-rel']);
		$output .= '<input type="hidden"  name="'.$name.'" value="'.$value.'" id="'.$html_options['id'].'" />';
		return $output;
	}
	

	//custom class SLZ_Image - can insert attachment
	public function upload_single_attachment( $name, $attachments, $html_options = array()) {
		$output = '';
		$remove_show = empty($attachments)?'hide':'';
		echo '
			<input type="button" data-name= "'. $name .'" data-rel="' . $html_options['data-rel'] .'" class="button slz-image-upload-btn slz-btn-upload-attachment " value="'. esc_html__( 'Add File', 'slz' ) .'" />
			<input type="button" data-name= "'. $name .'" data-rel="' . $html_options['data-rel'] .'" class="button slz-image-upload-btn slz-btn-remove-attachment '.$remove_show.'" value="'. esc_html__( 'Remove All', 'slz' ) .'" />
			';
		unset($html_options['data-rel']);
		unset($html_options['data-name']);
		?>
	        <div class="slz-attachment-upload-wrapper" >
	        <?php
	        if(!empty($attachments)):
	            foreach ($attachments as $key => $value):
	        ?>
	            <div class="slz-attachment-preview" id="attachment-<?php echo $key; ?>">
	                <input type="hidden" value="<?php echo $value; ?>" name="<?php echo $name.'['.$key.']'; ?>" data-form="<?php echo $name; ?>">
	                <a href="<?php echo wp_get_attachment_url($value); ?>"><?php echo get_the_title($value); ?></a>
	                <input type="button" style="float: right;" class="button slz-image-upload-btn slz-btn-remove-file" value= "<?php echo esc_html__( 'Remove File', 'slz' )?>" />
	                <div style="clear: both"></div>
	            </div>
	        <?php
	            endforeach;
	        endif;
	        ?>
	        </div>
	        <?php
	}
}	
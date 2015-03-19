<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Features
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * This function hooks to the brick css output. If it is supposed to be a 'feature', then it will add the css for those features to the brick's css
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_css_features( $css_output, $post_id, $first_content_type, $second_content_type ){

	if ( $first_content_type != 'features' && $second_content_type != 'features' ){
		return $css_output;	
	}
	
	//Get Features Metabox Repeater Array
	$features_repeaters = get_post_meta($post_id, 'mp_features_repeater', true);
	
	//If no features have been set up, return
	if ( empty( $features_repeaters ) ){
		return $css_output;
	}
	
	//Features per row
	$features_per_row = get_post_meta($post_id, 'features_per_row', true);
	$features_per_row = empty( $features_per_row ) ? '4' : $features_per_row;
	
	//Features icon size
	$feature_icon_size = get_post_meta($post_id, 'feature_icon_size', true);
	$feature_icon_size = empty( $feature_icon_size ) ? '30' : $feature_icon_size;
	
	//Features Icon Vertical Alignment
	$feature_icon_vertical_alignment = mp_core_get_post_meta( $post_id, 'feature_icon_vertical_alignment', 'middle' );
	
	//Features title size
	$feature_title_size = get_post_meta($post_id, 'feature_title_size', true);
	$feature_title_size = empty( $feature_title_size ) ? '130%' : $feature_title_size . 'px';
	
	//Features text size
	$feature_text_size = get_post_meta($post_id, 'feature_text_size', true);
	$feature_text_size = empty( $feature_text_size ) ? '100%' : $feature_text_size . 'px';
	
	//Feature text area's max-width
	$feature_text_area_max_width = mp_core_get_post_meta( $post_id, 'feature_text_area_max_width', 'none' );
	$feature_text_area_max_width = $feature_text_area_max_width == 'none' ? '' : 'max-width:' . $feature_text_area_max_width . 'px;';
	
	//Feature spacing
	$feature_spacing = mp_core_get_post_meta($post_id, 'feature_spacing', '20');
	
	//Feature alignment
	$feature_alignment = mp_core_get_post_meta($post_id, 'feature_alignment', 'center');
	
	//CSS for alignment
	$css_display = $feature_alignment == 'left' ? 'table-cell' : 'inline-block';
	
	//Icon padding bottom
	$icon_bottom_padding = $feature_alignment == 'left' ? '0' : '10';
	
	//Get the radius this image should be
	$feature_icon_corner_radius = mp_core_get_post_meta( $post_id, 'feature_icon_corner_radius', 0 );
	$radius_css = 'border-radius: ' . ( $feature_icon_corner_radius / 2 ) . '%; ';
	
	//Get the items a stroke should be applied to
	$apply_strokes_to = json_decode( mp_core_get_post_meta( $post_id, 'feature_icon_stroke_apply_to' ) );	
	$apply_strokes_to = is_array( $apply_strokes_to ) ? $apply_strokes_to : array();
	$images_stroke = in_array( 'images', $apply_strokes_to ) ? true : false;
	$icons_stroke = in_array( 'icons', $apply_strokes_to ) ? true : false;
			
	//Get the stroke css
	$stroke_css = mp_core_stroke_css( $post_id, 'feature_icon_' );
	
	//Set the font size for icons fonts based on the stroke size (so there isn't overlap of the stroke over the icon)
	$stroke_size = mp_core_get_post_meta( $post_id, 'feature_icon_stroke_size', 0 );
	
	//If the stroke should be applied to icon fonts
	if ( $icons_stroke ){
		$font_icon_padding = $stroke_size != 0 ? 13 : 0;
		$font_icon_size = $stroke_size != 0 ? ( $feature_icon_size - ( ( $stroke_size * 2 ) + 26 ) ) : $feature_icon_size;
		$font_icon_stroke_css = $stroke_css;
	}
	//If the stroke should not be applied to icon fonts
	else{
		$font_icon_padding = 0;
		$font_icon_size = $feature_icon_size;
		$font_icon_stroke_css = NULL;
	}
	
	//If the stroke should be applied to images
	if ( $images_stroke ){
		$images_stroke_css = $stroke_css;
	}
	//If the stroke should not be applied to images
	else{
		$images_stroke_css = NULL;
	}
	
	//Get the items a Drop Shadow should be applied to
	$apply_shadows_to = json_decode( mp_core_get_post_meta( $post_id, 'feature_shadow_apply_to' ) );	
	$apply_shadows_to = is_array( $apply_shadows_to ) ? $apply_shadows_to : array();
	$images_shadow = in_array( 'images', $apply_shadows_to ) ? true : false;
	$icons_shadow = in_array( 'icons', $apply_shadows_to ) ? true : false;
	$titles_shadow = in_array( 'titles', $apply_shadows_to ) ? true : false;
	$descriptions_shadow = in_array( 'descriptions', $apply_shadows_to ) ? true : false;
			
	//Get the stroke css
	$shadow_css = mp_core_drop_shadow_css( $post_id, 'feature_' );
		
	//If the shadow should be applied to icon fonts
	$font_icon_shadow_css = $icons_shadow ? $shadow_css : NULL;
	$images_shadow_css = $images_shadow ? $shadow_css : NULL;
	$titles_shadow_css = $titles_shadow ? $shadow_css : NULL;
	$descriptions_shadow_css = $descriptions_shadow ? $shadow_css : NULL;
	
	//Feature text color:
	$feature_text_color = mp_core_get_post_meta($post_id, 'feature_text_color', true);
		
	//Get Features Output
	$css_features_output = '
		#mp-brick-' . $post_id . ' .mp-stacks-features{ 
			text-align: ' . $feature_alignment . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-feature{ 
			color:' . get_post_meta($post_id, 'feature_text_color', true) . ';
			width:' . (100/$features_per_row) .'%;
			text-align:' . $feature_alignment . ';
			padding: ' . $feature_spacing . 'px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-feature a,
		#mp-brick-' . $post_id . ' .mp-stacks-feature a:hover
		{ 
			color:' . get_post_meta($post_id, 'feature_text_color', true) . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-features-icon-container{
			display:' . $css_display . ';
			width:' . $feature_icon_size . 'px;
			padding-bottom: ' . $icon_bottom_padding . 'px;
			vertical-align: ' . $feature_icon_vertical_alignment . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-features-icon {
			width: ' . $feature_icon_size . 'px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-feature img{' . 
			$radius_css . $images_shadow_css . $images_stroke_css . '
			box-sizing: border-box;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-features-icon:before {' . 
			$radius_css . $font_icon_shadow_css . $font_icon_stroke_css . '
			font-size:' . $font_icon_size . 'px;
			padding:' . $font_icon_padding . 'px;
			box-sizing: border-box;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-features-title-text-area{
			display:' . $css_display . ';
		}		
		#mp-brick-' . $post_id . ' .mp-stacks-features-title {
			font-size:' . $feature_title_size . '; ' . $titles_shadow_css . '
		}
		#mp-brick-' . $post_id . ' .mp-stacks-features-text {
			font-size:' . $feature_text_size . '; ' . $descriptions_shadow_css  . '
			' . $feature_text_area_max_width . '
		}
		@media screen and (max-width: 600px){
			#mp-brick-' . $post_id . ' .mp-stacks-feature{ 
				width:' . '100%;
			}
		}';
		
	$css_features_output .= $feature_alignment != 'left' ? NULL : '#mp-brick-' . $post_id . ' .mp-stacks-features-icon{ margin: 0px 10px 0px 0px; }';
		
	return $css_features_output . $css_output;
		
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_features', 10, 4);


/**
 * This function hooks to the brick output. If it is supposed to be a 'feature', then it will output the features
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_features($default_content_output, $mp_stacks_content_type, $post_id){
	
	//If this stack content type is set to be an image	
	if ($mp_stacks_content_type == 'features'){
		
		//Set default value for $content_output to NULL
		$content_output = NULL;	
		
		//Get Features Metabox Repeater Array
		$features_repeaters = get_post_meta($post_id, 'mp_features_repeater', true);
		
		//Features per row
		$features_per_row = get_post_meta($post_id, 'features_per_row', true);
		$features_per_row = empty( $features_per_row ) ? '4' : $features_per_row;
		
		//Features icon size
		$feature_icon_size = get_post_meta($post_id, 'feature_icon_size', true);
		$feature_icon_size = empty( $feature_icon_size ) ? '30' : $feature_icon_size;
		
		//Feature alignment
		$feature_alignment = mp_core_get_post_meta($post_id, 'feature_alignment', 'center' );
		$feature_alignment = empty( $feature_alignment ) ? 'left' : $feature_alignment;
		
		//Get Features Output
		$features_output = '<div class="mp-stacks-features">';
		
		//Set counter to 0
		$counter = 1;
		
		if ($features_repeaters ){
			
			//Loop through each feature
			foreach( $features_repeaters as $features_repeater ){
							
					$features_output .= '<div class="mp-stacks-feature">';
					
						$features_output .= '<div class="mp-stacks-feature-inner">';
			
							//If the user has saved an open type
							if ( !empty($features_repeater['feature_icon_link_type'])){
								
								//Set Image Open Type for Lightbox
								if ( $features_repeater['feature_icon_link_type'] == 'lightbox'){
									$class_name = ' mp-stacks-lightbox-link'; 
									$target = '';
								}
								else if($features_repeater['feature_icon_link_type'] == 'blank'){
									$target = '_blank';
									$class_name = '';	
								}
								else{
									$class_name = '';	
									$target = '_parent';	
								}
							}
							//If they haven't saved an open type
							else{
								$class_name = '';	
								$target = '_parent';
							}
														
								$features_output .= '<div class="mp-stacks-features-icon-container">';
									
									$features_output .= !empty($features_repeater['feature_icon_link']) ? '<a href="' . $features_repeater['feature_icon_link'] . '" class="mp-stacks-features-icon-link ' . $class_name . '" target="' . $target . '">' : NULL;
									
										//If we should use an image as the featured icon
										if ( $features_repeater['feature_icon_type'] == 'feature_image' ){
											$features_output .= '<img src="' . $features_repeater['feature_image'] . '" width="100%"/>';
										}
										//If we should use an icon from the icon font
										else{
											
											$features_output .= '<div class="mp-stacks-features-icon ' . $features_repeater['feature_icon'] . '">';
											
												$features_output .= '<div class="mp-stacks-features-icon-title">' . $features_repeater['feature_title'] . '</div>';
											
											$features_output .= '</div>';
										
										}
									
									$features_output .= !empty($features_repeater['feature_icon_link']) ? '</a>' : NULL;
								
								$features_output .= '</div>';
													
							$features_output .= $feature_alignment == 'center' ? '<div class="mp-stacks-features-clearedfix"></div>' : NULL;
							
							$features_output .= '<div class="mp-stacks-features-title-text-area">';
							
								//If there's a title
								if ( !empty($features_repeater['feature_title']) ){
									
									$features_output .= '<div class="mp-stacks-features-title">';
									
										$features_output .= !empty($features_repeater['feature_icon_link']) ? '<a href="' . $features_repeater['feature_icon_link'] . '" class="mp-stacks-features-icon-link ' . $class_name . '" target="' . $target . '">' : NULL;
									
											$features_output .= $features_repeater['feature_title'];
											
										$features_output .= !empty($features_repeater['feature_icon_link']) ? '</a>' : NULL;
										
									$features_output .= '</div>';
									
									//Add clear div to bump features below title and icon
									$features_output .= '<div class="mp-stacks-features-clearedfix"></div>';
								
								}
								
								//If there's a description
								if ( !empty($features_repeater['feature_text']) ){
									
									$features_output .= '<div class="mp-stacks-features-text">';
																	
										$features_output .= do_shortcode( html_entity_decode($features_repeater['feature_text']) );
											
									$features_output .= '</div>';
									
								}
								
							$features_output .= '</div>';
					
						$features_output .= '</div>';
						
					$features_output .= '</div>';
					
					if ( $features_per_row == $counter ){
						
						//Add clear div to bump a new row
						$features_output .= '<div class="mp-stacks-features-clearedfix"></div>';
						
						//Reset counter
						$counter = 1;
					}
					else{
						
						//Increment Counter
						$counter = $counter + 1;
						
					}
					
			}
		}
		
		$features_output .= '</div>';
		
		//Content output
		$content_output .= $features_output;
		
		//Return
		return $content_output;
	}
	else{
		//Return
		return $default_content_output;
	}
}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_features', 10, 3);
<?php 
/**
 * This file contains the function which hooks to a brick's media output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Features
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2013, Move Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * This function hooks to the brick output. If it is supposed to be a 'feature', then it will output the features
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_media_output_features($default_media_output, $mp_stacks_media_type, $post_id){
	
	//If this stack media type is set to be an image	
	if ($mp_stacks_media_type == 'features'){
		
		//Set default value for $media_output to NULL
		$media_output = NULL;	
		
		//Get Features Metabox Repeater Array
		$features_repeaters = get_post_meta($post_id, 'mp_features_repeater', true);
		
		//Features per row
		$features_per_row = get_post_meta($post_id, 'features_per_row', true);
		$features_per_row = empty( $features_per_row ) ? '2' : $features_per_row;
		
		//Feature alignment
		$feature_alignment = get_post_meta($post_id, 'feature_alignment', true);
		$feature_alignment = empty( $feature_alignment ) ? 'left' : $feature_alignment;
		
		//Get Features Output
		$features_output = '<div class="mp-stacks-features">';
		
		//Get Features Output
		$features_output .= '
		<style scoped>
			.mp-stacks-feature{ 
				color:' . get_post_meta($post_id, 'feature_text_color', true) . ';
				width:' . (100/$features_per_row) .'%;
				text-align:' . $feature_alignment . ';
			}
			@media screen and (max-width: 600px){
				.mp-stacks-feature{ 
					width:' . '100%;
				}
			}';
			
			$features_output .= $feature_alignment != 'left' ? NULL : '.mp-stacks-features-icon{ margin: 0px 10px 0px 0px; }';
		$features_output .= '</style>';
		
		//Set counter to 0
		$counter = 1;
		
		if ($features_repeaters ){
			
			//Loop through each feature
			foreach( $features_repeaters as $features_repeater ){
							
					$features_output .= '<div class="mp-stacks-feature">';
					
						$features_output .= '<div class="mp-stacks-features-icon ' . $features_repeater['feature_icon'] . '">';
							
							$features_output .= '<div class="mp-stacks-features-icon-title">' . $features_repeater['feature_title'] . '</div>';
							
						$features_output .= '</div>';
						
						$features_output .= $feature_alignment == 'center' ? '<div class="mp-stacks-features-clearedfix"></div>' : NULL;
						
						$features_output .= '<div class="mp-stacks-features-title">';
						
							$features_output .= $features_repeater['feature_title'];
							
						$features_output .= '</div>';
						
						//Add clear div to bump features below title and icon
						$features_output .= '<div class="mp-stacks-features-clearedfix"></div>';
						
						$features_output .= '<div class="mp-stacks-features-text">';
						
							$features_output .= $features_repeater['feature_text'];
								
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
		
		//Media output
		$media_output .= $features_output;
		
		//Return
		return $media_output;
	}
	else{
		//Return
		return $default_media_output;
	}
}
add_filter('mp_stacks_brick_media_output', 'mp_stacks_brick_media_output_features', 10, 3);
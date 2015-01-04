<?php
/**
 * This page contains functions for modifying the metabox for features as a media type
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks Features
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add Features as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    array $args See link for description.
 * @return   void
 */
function mp_stacks_features_create_meta_box(){
	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_stacks_features_add_meta_box = array(
		'metabox_id' => 'mp_stacks_features_metabox', 
		'metabox_title' => __( '"Features" Content-Type', 'mp_stacks_features'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	//If a stack id has been passed to the URL
	if ( isset( $_GET['mp_stack_id'] ) ){
				
		//Get all the brick titles in this stack
		$brick_titles_in_stack = mp_stacks_get_brick_titles_in_stack( $_GET['mp_stack_id'] );
		
	}
	else{
		
		$brick_titles_in_stack = array();
	}	
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_stacks_features_items_array = array(
		array(
			'field_id'			=> 'feature_settings_description',
			'field_title' 	=> __( 'Overall Feature Settings', 'mp_stacks_features'),
			'field_description' 	=> '<br />Choose the overall settings for your features' ,
			'field_type' 	=> 'basictext',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'features_per_row',
			'field_title' 	=> __( 'Features Per Row', 'mp_stacks_features'),
			'field_description' 	=> 'How many features do you want from left to right before a new row starts?',
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_text_color',
			'field_title' 	=> __( 'Feature Text Colors', 'mp_stacks_features'),
			'field_description' 	=> 'Enter the text color for all of these features',
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_alignment',
			'field_title' 	=> __( 'Feature Alignments', 'mp_stacks_features'),
			'field_description' 	=> 'Select how you want the features to be aligned' ,
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'left' => 'Left', 'center' => 'Center' ),
		),
		array(
			'field_id'			=> 'feature_spacing',
			'field_title' 	=> __( 'Feature Spacing', 'mp_stacks_features'),
			'field_description' 	=> 'How many pixels should be between features? Default: 20' ,
			'field_type' 	=> 'number',
			'field_value' => '20',
		),
		array(
			'field_id'			=> 'feature_icon_size',
			'field_title' 	=> __( 'Feature Icon Sizes', 'mp_stacks_features'),
			'field_description' 	=> 'How many pixels wide should each icon be?' ,
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_icon_vertical_alignment',
			'field_title' 	=> __( 'Feature Icon Vertical Alignment', 'mp_stacks_features'),
			'field_description' 	=> 'Should this icon sit vertically centered beside the feature text or align to the top of it?' ,
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'middle' => __( 'Center', 'mp_stacks_features' ), 'top' => __( 'Top', 'mp_stacks_features' ), 'bottom' => __( 'Bottom', 'mp_stacks_features' ) ),
		),
		array(
			'field_id'			=> 'feature_title_size',
			'field_title' 	=> __( 'Feature Title Sizes', 'mp_stacks_features'),
			'field_description' 	=> 'What should the font size of each feature\'s title be? (Pixels)' ,
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_text_size',
			'field_title' 	=> __( 'Feature Text Sizes', 'mp_stacks_features'),
			'field_description' 	=> __( 'What should the font size of each feature\'s text area be? (Pixels)', 'mp_stacks_features' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_description',
			'field_title' 	=> '<br />' . __( 'Add Your Features Below', 'mp_stacks_features'),
			'field_description' 	=> '<br />' . __( 'Open up the following areas to add/remove new features.', 'mp_stacks_features'),
			'field_type' 	=> 'basictext',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_title',
			'field_title' 	=> __( 'Feature Title', 'mp_stacks_features'),
			'field_description' 	=> __( 'Enter the title of this feature', 'mp_stacks_features' ),
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_type',
			'field_title' 	=> __( 'Feature Icon Type', 'mp_stacks_features'),
			'field_description' 	=> __( 'Select the type of icon to use for this.', 'mp_stacks_features' ),
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array('feature_icon' => 'Icon', 'feature_image' => 'Custom Image'),
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon',
			'field_title' 	=> __( 'Feature Icon', 'mp_stacks_features'),
			'field_description' 	=> __( 'Select the icon to use for this feature', 'mp_stacks_features' ),
			'field_type' 	=> 'iconfontpicker',
			'field_value' => '',
			'field_select_values' => mp_stacks_features_get_font_awesome_icons(),
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_image',
			'field_title' 	=> __( 'Feature Icon', 'mp_stacks_features'),
			'field_description' 	=> __( 'Upload the icon image to use for this feature', 'mp_stacks_features' ),
			'field_type' 	=> 'mediaupload',
			'field_value' => '',
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_link',
			'field_title' 	=> __( 'Feature Icon Link', 'mp_stacks_features'),
			'field_description' 	=> __( 'Optional: Enter a URL which should be visited when the icon is clicked.', 'mp_stacks_features' ),
			'field_type' 	=> 'datalist',
			'field_value' => '',
			'field_select_values' => $brick_titles_in_stack,
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_link_type',
			'field_title' 	=> __( 'Feature Icon Link\'s Open Type', 'mp_stacks_features'),
			'field_description' 	=> __( 'Optional: How should this link open?', 'mp_stacks_features' ),
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'lightbox' => __( 'Open in Lightbox', 'mp_stacks_features' ), 'parent' => __( 'Open in current Window/Tab', 'mp_stacks_features' ), 'blank' => __( 'Open in New Window/Tab', 'mp_stacks_features' ) ),
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_text',
			'field_title' 	=> __( 'Feature Text (HTML Allowed)', 'mp_stacks_features'),
			'field_description' 	=> __( 'Enter the text for this feature.', 'mp_stacks_features' ),
			'field_type' 	=> 'wp_editor',
			'field_value' => '',
			'field_repeater' => 'mp_features_repeater'
		),
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_stacks_features_add_meta_box = has_filter('mp_stacks_features_meta_box_array') ? apply_filters( 'mp_stacks_features_meta_box_array', $mp_stacks_features_add_meta_box) : $mp_stacks_features_add_meta_box;
	
	//Globalize the and populate mp_stacks_features_items_array (do this before filter hooks are run)
	global $global_mp_stacks_features_items_array;
	$global_mp_stacks_features_items_array = $mp_stacks_features_items_array;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_stacks_features_items_array = has_filter('mp_stacks_features_items_array') ? apply_filters( 'mp_stacks_features_items_array', $mp_stacks_features_items_array) : $mp_stacks_features_items_array;
	
	/**
	 * Create Metabox class
	 */
	global $mp_stacks_features_meta_box;
	$mp_stacks_features_meta_box = new MP_CORE_Metabox($mp_stacks_features_add_meta_box, $mp_stacks_features_items_array);
}
add_action('mp_brick_metabox', 'mp_stacks_features_create_meta_box');
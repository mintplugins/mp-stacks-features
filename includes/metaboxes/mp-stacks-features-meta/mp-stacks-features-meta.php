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
	
	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$subject = file_get_contents( plugins_url( '/fonts/font-awesome-4.0.3/css/font-awesome.css', dirname( dirname( __FILE__ ) ) ) );
	
	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
	
	$icons = array();

	foreach($matches as $match){
		$icons[$match[1]] = $match[1];
	}	
	
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
			'field_id'			=> 'feature_icon_size',
			'field_title' 	=> __( 'Feature Icon Sizes', 'mp_stacks_features'),
			'field_description' 	=> 'How many pixels wide should each icon be?' ,
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_description',
			'field_title' 	=> __( '<br />Add Your Features Below', 'mp_stacks_features'),
			'field_description' 	=> '<br />Open up the following areas to add/remove new features.' ,
			'field_type' 	=> 'basictext',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_title',
			'field_title' 	=> __( 'Feature Title', 'mp_stacks_features'),
			'field_description' 	=> 'Enter the title of this feature',
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_type',
			'field_title' 	=> __( 'Feature Icon Type', 'mp_stacks_features'),
			'field_description' 	=> 'Select the type of icon to use for this.',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array('feature_icon' => 'Icon', 'feature_image' => 'Custom Image'),
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon',
			'field_title' 	=> __( 'Feature Icon', 'mp_stacks_features'),
			'field_description' 	=> 'Select the icon to use for this feature',
			'field_type' 	=> 'iconfontpicker',
			'field_value' => '',
			'field_select_values' => $icons,
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_image',
			'field_title' 	=> __( 'Feature Icon', 'mp_stacks_features'),
			'field_description' 	=> 'Upload the icon image to use for this feature',
			'field_type' 	=> 'mediaupload',
			'field_value' => '',
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_link',
			'field_title' 	=> __( 'Feature Icon Link', 'mp_stacks_features'),
			'field_description' 	=> 'Optional: Enter a URL which should be visited when the icon is clicked.',
			'field_type' 	=> 'datalist',
			'field_value' => '',
			'field_select_values' => $brick_titles_in_stack,
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_icon_link_type',
			'field_title' 	=> __( 'Feature Icon Link\'s Open Type', 'mp_stacks_features'),
			'field_description' 	=> 'Optional: Enter a URL which should be visited when the icon is clicked.',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'lightbox' => __( 'Open in Lightbox', 'mp_stacks_features' ), 'parent' => __( 'Open in current Window/Tab', 'mp_stacks_features' ), 'blank' => __( 'Open in New Window/Tab', 'mp_stacks_features' ) ),
			'field_repeater' => 'mp_features_repeater'
		),
		array(
			'field_id'			=> 'feature_text',
			'field_title' 	=> __( 'Feature Text (HTML Allowed)', 'mp_stacks_features'),
			'field_description' 	=> 'Enter the text for this feature.',
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
add_action('wp_loaded', 'mp_stacks_features_create_meta_box');
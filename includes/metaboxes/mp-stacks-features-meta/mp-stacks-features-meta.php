<?php
/**
 * This page contains functions for modifying the metabox for features as a media type
 *
 * @link http://moveplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks Features
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2013, Move Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add Features as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://moveplugins.com/doc/
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
		'metabox_title' => __( '"Features"  - Media Type', 'mp_stacks_features'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$subject = file_get_contents( plugins_url( '/fonts/font-awesome-4.0.3/css/font-awesome.css', dirname( dirname( __FILE__ ) ) ) );
	
	preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
	
	//echo plugins_url( '/fonts/font-awesome-4.0.3/css/font-awesome.css', dirname( dirname( __FILE__ ) ) );

	
	$icons = array();

	foreach($matches as $match){
		$icons[$match[1]] = $match[1];
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
			'field_title' 	=> __( 'Feature Text Color', 'mp_stacks_features'),
			'field_description' 	=> 'Enter the text color for all of these features',
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'feature_alignment',
			'field_title' 	=> __( 'Feature Alignment', 'mp_stacks_features'),
			'field_description' 	=> 'Select how you want the features to be aligned' ,
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( 'left' => 'Left', 'center' => 'Center' ),
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
			'field_id'			=> 'feature_icon',
			'field_title' 	=> __( 'Feature Icon', 'mp_stacks_features'),
			'field_description' 	=> 'Select the icon to use for this feature',
			'field_type' 	=> 'iconfontpicker',
			'field_value' => '',
			'field_select_values' => $icons,
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
add_action('plugins_loaded', 'mp_stacks_features_create_meta_box');
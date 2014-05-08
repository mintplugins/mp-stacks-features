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
 * Add Features as a Content Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://moveplugins.com/doc/
 * @param    array $mp_stacks_brick_rows_array The array used to generate the brick row metabox
 * @return   array $mp_stacks_brick_rows_array
 */
function mp_stacks_features_add_content_type( $mp_stacks_content_items_array ){	
	
	$counter = 0;
		
	//Loop through each field in the incoming/outgoing array
	foreach ( $mp_stacks_content_items_array as $content_type ){
	
		//If this field is a content-type selector	 - checked using stringendswith as seen here:
		//http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
		if ( '_content_type' === "" || substr($content_type['field_id'], -strlen('_content_type')) === '_content_type' ){
			
			//Add "Features" to this selector
			$mp_stacks_content_items_array[$counter]['field_select_values']['features'] = 'Features';
		}
		
		$counter = $counter + 1;
		
	}
	
	return $mp_stacks_content_items_array;

}
add_filter('mp_stacks_content_types_array', 'mp_stacks_features_add_content_type');
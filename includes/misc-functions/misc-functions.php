<?php
/**
 * Functions used to work with the MP Stacks Developer Plugin
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package     MP Stacks + Features
 * @subpackage  Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */

/**
 * Make Features Content Type Centered by default
 *
 * @access   public
 * @since    1.0.0
 * @param    $centered_content_types array - An array containing a string for each content-type that should default to centered brick alignment.
 * @param    $centered_content_types array - An array containing a string for each content-type that should default to centered brick alignment.
 */
function mp_stacks_features_centered_by_default( $centered_content_types ){

	$centered_content_types['features'] = 'features';

	return $centered_content_types;

}
add_filter( 'mp_stacks_centered_content_types', 'mp_stacks_features_centered_by_default' );

/**
 * Function which returns an array of font awesome icons
 */
function mp_stacks_features_get_font_awesome_icons(){

    //Get all font styles in the css document and put them in an array
    $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';

    $path = MP_STACKS_PLUGIN_DIR . 'includes/fonts/font-awesome/css/font-awesome.css';

    // We gotta get fancy here to include the CSS the way we need it. Standard wp_remote_get methods fail because it's local
    ob_start();
    include( $path );
    $response = ob_get_clean();

    preg_match_all($pattern, $response, $matches, PREG_SET_ORDER);

    $icons = array();

    foreach($matches as $match){
        $icons[$match[1]] = $match[1];
    }

    return $icons;
}

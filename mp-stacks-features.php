<?php
/*
Plugin Name: MP Stacks + Features
Plugin URI: http://moveplugins.com
Description: Content-Type Add-on for MP Stacks which displays "features" about an item in a brick.
Version: beta1.0.0.9
Author: Move Plugins
Author URI: http://moveplugins.com
Text Domain: mp_stacks_features
Domain Path: languages
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@moveplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Move Plugins Core.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
// Plugin version
if( !defined( 'MP_STACKS_FEATURES_VERSION' ) )
	define( 'MP_STACKS_FEATURES_VERSION', '1.0.0.0' );

// Plugin Folder URL
if( !defined( 'MP_STACKS_FEATURES_PLUGIN_URL' ) )
	define( 'MP_STACKS_FEATURES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Folder Path
if( !defined( 'MP_STACKS_FEATURES_PLUGIN_DIR' ) )
	define( 'MP_STACKS_FEATURES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin Root File
if( !defined( 'MP_STACKS_FEATURES_PLUGIN_FILE' ) )
	define( 'MP_STACKS_FEATURES_PLUGIN_FILE', __FILE__ );

/*
|--------------------------------------------------------------------------
| GLOBALS
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function mp_stacks_features_textdomain() {

	// Set filter for plugin's languages directory
	$mp_stacks_features_lang_dir = dirname( plugin_basename( MP_STACKS_FEATURES_PLUGIN_FILE ) ) . '/languages/';
	$mp_stacks_features_lang_dir = apply_filters( 'mp_stacks_features_languages_directory', $mp_stacks_features_lang_dir );


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'mp-stacks-features' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'mp-stacks-features', $locale );

	// Setup paths to current locale file
	$mofile_local  = $mp_stacks_features_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/mp-stacks-features/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/mp-stacks-features folder
		load_textdomain( 'mp_stacks_features', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/mp-stacks-features/languages/ folder
		load_textdomain( 'mp_stacks_features', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'mp_stacks_features', false, $mp_stacks_features_lang_dir );
	}

}
add_action( 'init', 'mp_stacks_features_textdomain', 1 );

/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/
function mp_stacks_features_include_files(){
	/**
	 * If mp_core or mp_stacks aren't active, stop and install it now
	 */
	if (!function_exists('mp_core_textdomain') || !function_exists('mp_stacks_textdomain')){
		
		/**
		 * Include Plugin Checker
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . '/includes/plugin-checker/class-plugin-checker.php' );
		
		/**
		 * Include Plugin Installer
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . '/includes/plugin-checker/class-plugin-installer.php' );
		
		/**
		 * Check if mp_core in installed
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/plugin-checker/included-plugins/mp-core-check.php' );
		
		/**
		 * Check if mp_stacks is installed
		 */
		include_once( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/plugin-checker/included-plugins/mp-stacks.php' );
		
	}
	/**
	 * Otherwise, if mp_core and mp_stacks are active, carry out the plugin's functions
	 */
	else{
		
		/**
		 * Update script - keeps this plugin up to date
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/updater/mp-stacks-features-update.php' );
		
		/**
		 * enqueue scripts
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/misc-functions/enqueue-scripts.php' );
		
		/**
		 * Media Filters for features
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/misc-functions/content-filters.php' );
		
		/**
		 * Metabox for features
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/metaboxes/mp-stacks-features-meta/mp-stacks-features-meta.php' );
		
		/**
		 * Metabox which adds features as a content type
		 */
		require( MP_STACKS_FEATURES_PLUGIN_DIR . 'includes/metaboxes/mp-stacks-content/mp-stacks-content.php' );
				
	}
}
add_action('plugins_loaded', 'mp_stacks_features_include_files', 9);
<?php
/*
Plugin Name: GIGX Cloudfiles
Plugin URI: http://gigx.co.uk/plugins/gigx-cloudfiles
Description: WordPress Rackspace Cloudfiles management plugin
Version: 0.0.1
Author: GIGX
Author URI: http://gigx.co.uk
License: GPLv2

  Copyright 2012 GIGX (info@gigx.co.uk)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class GIGXCloudfiles {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
		load_plugin_textdomain( 'gigx-cloudfiles', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_scripts' ) );
		
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );
		
	    /*
	     * TODO:
	     * Define the custom functionality for your plugin. The first parameter of the
	     * add_action/add_filter calls are the hooks into which your code should fire.
	     *
	     * The second parameter is the function name located within this class. See the stubs
	     * later in the file.
	     *
	     * For more information: 
	     * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
	     */
	    add_action( 'media_upload_gigx_cloudfiles', array( $this, 'menu_handle' ) ); //media_upload_tabname (as defined in media_menu method)
	    add_filter( 'media_upload_tabs', array( $this, 'media_menu' ) );    

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here		
	} // end deactivate
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_register_style( 'gigx-cloudfiles-admin-styles', plugins_url( 'gigx-cloudfiles/css/admin.css' ) );
		wp_enqueue_style( 'gigx-cloudfiles-admin-styles' );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {	
		wp_register_script( 'gigx-cloudfiles-admin-script', plugins_url( 'gigx-cloudfiles/js/admin.js' ) );
		wp_enqueue_script( 'gigx-cloudfiles-admin-script' );
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_register_style( 'gigx-cloudfiles-plugin-styles', plugins_url( 'gigx-cloudfiles/css/display.css' ) );
		wp_enqueue_style( 'gigx-cloudfiles-plugin-styles' );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
		wp_register_script( 'gigx-cloudfiles-plugin-script', plugins_url( 'gigx-cloudfiles/js/display.js' ) );
		wp_enqueue_script( 'gigx-cloudfiles-plugin-script' );
	
	} // end register_plugin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
 	 * Note:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *		  WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *		  Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 */

        /**
         * This holds the tab content.
         * Must start with media, otherwise css won't get loaded
         */
        function media_process() {
            media_upload_header();
            echo 'hello';
        }
        /**
         * this points to the content of the tab
         *
         */
        function menu_handle() {
	    return wp_iframe( array( &$this, 'media_process' ));
        }
	
	/**
	 * Note:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *		  WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *		  Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 */
	function filter_method_name() {
	    // TODO define your filter method here
	} // end filter_method_name
        /**
         * adds new tab to media uploader
         * see http://axcoto.com/blog/article/tag/media_upload_tabs
         */
        function media_menu($tabs) {
            $newtab = array('gigx-cloudfiles' => __('GIGX Cloudfiles', 'gigx_cloudfiles'));// tabname: gigx-cloudfiles
            return array_merge($tabs, $newtab);
        }
        
        
  
} // end class

// TODO: update the instantiation call of your plugin to the name given at the class definition
new GIGXCloudfiles();
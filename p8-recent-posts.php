<?php
/**
 * Plugin Name:        Recent Posts by Timeframe
 * Plugin URI:         https://www.github.com/pixleight/p8-recent-posts
 * Description:        WordPress widget to display posts published within a recent timeframe
 * Version:            0.1.1
 * Author:             Chris Violette
 * Author URI:         https://pixleight.com
 *
 * License:            GNU General Public License, version 2
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package    P8_Recent_Posts
 * @since      0.1
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, Chris Violette
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Pixleight;

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class P8RP {
  public function __construct() {
    // Set the constants needed by the plugin.
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

    // Register widget.
		add_action( 'widgets_init', array( &$this, 'register_widget' ) );

    // Load the functions files.
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );
  }

  /**
	 * Defines constants used by the plugin.
	 *
	 * @since  0.1
	 */
	public function constants() {

		// Set constant path to the plugin directory.
		define( 'P8RP_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		// Set the constant path to the plugin directory URI.
		define( 'P8RP_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// Set the constant path to the includes directory.
		define( 'P8RP_INCLUDES', P8RP_DIR . trailingslashit( 'includes' ) );

		// Set the constant path to the includes directory.
		define( 'P8RP_CLASS', P8RP_DIR . trailingslashit( 'classes' ) );

		// Set the constant path to the assets directory.
		define( 'P8RP_ASSETS', P8RP_URI . trailingslashit( 'assets' ) );

	}

  /**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since  0.1
	 */
	public function includes() {
		require_once( P8RP_INCLUDES . 'functions.php' );
	}

  /**
	 * Register the widget.
	 *
	 * @since  0.1
	 */
	public function register_widget() {
		require_once( P8RP_CLASS . 'widget.php' );
		register_widget( 'p8_recent_posts' );
	}
}

new P8RP;

<?php
/**
 * Plugin Name:        Recent Posts by Timeframe
 * Plugin URI:         https://www.github.com/pixleight/p8-recent-posts
 * Description:        WordPress widget to display posts published within a recent timeframe
 * Version:            0.1.0
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

//namespace Pixleight\RecentPostsWidget;

class P8_Recent_Posts extends WP_Widget {

  /**
	 * Sets up the widgets.
	 *
	 * @since 0.1
	 */
  public function __construct() {

    /* Set up the widget options */
    $widget_options = array(
      'classname' => 'p8-recent-posts-widget',
      'description' => __( 'Displays posts published within a recent timeframe', 'p8rp' ),
      'customize_selective_refresh' => true
    );

    /* Register the widget */
    parent::__construct(
      'p8_recent_posts',
      __( 'Recent Posts in Timeframe' , 'p8rp' ),
      $widget_options
    );
  }

  /**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1
	 */
  public function widget( $args, $instance ) {
    extract( $args );

    $recent = p8rp_get_recent_posts( $instance );

    $title = apply_filters( 'widget_title', $instance[ 'title' ]);
    $blog_title = get_bloginfo( 'name' );
    $tagline = get_bloginfo( 'description' );

    // Open the theme's widget wrapper
    echo $before_widget;

    // If both title and title url is not empty, display it.
    if ( ! empty( $instance['title_url'] ) && ! empty( $instance['title'] ) ) {
      echo $before_title . '<a href="' . esc_url( $instance['title_url'] ) . '" title="' . esc_attr( $instance['title'] ) . '">' . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . '</a>' . $after_title;

    // If the title not empty, display it.
    } elseif ( ! empty( $instance['title'] ) ) {
      echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
    }

    echo $recent;

    // Close the theme's widget wrapper
    echo $after_widget;
  }

  /**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1
	 */
  public function update( $new_instance, $old_instance ) {
    // Validate post_type submissions
		$name = get_post_types( array( 'public' => true ), 'names' );
		$types = array();
		foreach( $new_instance['post_type'] as $type ) {
			if ( in_array( $type, $name ) ) {
				$types[] = $type;
			}
		}
		if ( empty( $types ) ) {
			$types[] = 'post';
		}

		$instance                     = $old_instance;
    $instance['title']            = sanitize_text_field( $new_instance['title'] );
		$instance['title_url']        = esc_url_raw( $new_instance['title_url'] );
    $instance['exclude_current']  = isset( $new_instance['exclude_current'] ) ? (bool) $new_instance['exclude_current'] : 0;
    $instance['post_status']      = stripslashes( $new_instance['post_status'] );
    $instance['limit']            = intval( $new_instance['limit'] );
    $instance['offset']           = intval( $new_instance['offset'] );
    $instance['days_offset']      = intval( $new_instance['days_offset'] );
    $instance['date']             = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;
    $instance['date_relative']    = isset( $new_instance['date_relative'] ) ? (bool) $new_instance['date_relative'] : false;
    $instance['date_modified']    = isset( $new_instance['date_modified'] ) ? (bool) $new_instance['date_modified'] : false;

    return $instance;
  }

  /**
  * Displays the widget control options in the Widgets admin screen.
  *
  * @since 0.1
  */
  public function form( $instance ) {
    // Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, p8rp_get_default_args() );

		// Extract the array to allow easy use of variables.
		extract( $instance );

    // Loads the widget form.
		include( P8RP_INCLUDES . 'form.php' );
  }
}

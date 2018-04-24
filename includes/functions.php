<?php
/**
 * Various functions used by the plugin.
 *
 * @package    P8_Recent_Posts
 * @since      0.1.0
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, Chris Violette
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
* Sets up the default arguments.
*
* @since  0.1
*/
function p8rp_get_default_args() {
  $defaults = array(
    'title'             => esc_attr__( 'Recent Posts', 'p8rp' ),
    'title_url'         => '',

    'limit'             => 5,
    'offset'            => 0,
    'order'             => 'DESC',
    'orderby'           => 'date',
    'post_type'         => array( 'post' ),
    'post_status'       => 'publish',
    'ignore_sticky'     => 1,
    'exclude_current'   => 1,
    'days_offset'       => 30,

    'date'              => true,
    'date_relative'     => false,
    'date_modified'     => false,

    'before'            => '',
    'after'             => '',
  );

  // Allow plugins/themes developer to filter the default arguments.
  return apply_filters( 'p8rp_default_args', $defaults );
}

/**
 * The posts query.
 *
 * @since  0.1
 * @param  array  $args
 * @return array
 */
function p8rp_get_posts( $args = array() ) {

  // Query arguments
  $query = array(
    'offset'              => $args['offset'],
    'posts_per_page'      => $args['limit'],
    'orderby'             => $args['orderby'],
    'order'               => $args['order'],
    'post_type'           => $args['post_type'],
    'post_status'         => $args['post_status'],
    'ignore_sticky_posts' => $args['ignore_sticky'],
    'date_query'          => array(
      array(
        'after'           => '-'.$args['days_offset'].' days',
        'column'          => 'post_date',
      )
    )
  );

  // Exclude current post
  if ( $args['exclude_current'] ) {
    $query['post__not_in'] = array( get_the_ID() );
  }

  // Allow plugins/themes developer to filter the default query.
  $query = apply_filters( 'p8rp_default_query_arguments', $query );

  // Perform the query.
  $posts = new WP_Query( $query );

  return $posts;
}

/**
 * Generates the posts markup.
 *
 * @since 0.1
 * @param array $args
 * @return string|array The HTML for the posts.
 */
function p8rp_get_recent_posts( $args = array() ) {

  // Set up a default, empty variable
  $html = '';

  // Merge the input arguments and the defaults.
  $args = wp_parse_args( $args, p8rp_get_default_args() );

  // Extract the array to allow easy use of variables.
  extract( $args );

  // Allow devs to hook in stuff before the loop.
  do_action( 'p8rp_before_loop' );

  // Get the posts query.
  $posts = p8rp_get_posts( $args );

  if( $posts->have_posts() ) :
    $html .= '<div class="p8rp">';
      $html .= '<ul class="p8rp__posts">';

        while( $posts->have_posts() ) : $posts->the_post();
          $html .= '<li class="p8rp__post">';

            $html .= '<h4 class="p8rp__post-title"><a href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Read: %s', 'p8rp' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">' . esc_attr( get_the_title() ) . '</a></h4>';

            if( $args['date'] ) :
              $date = get_the_date();
              if( $args['date_relative'] ) :
                $date = sprintf( __( '%s ago', 'p8rp' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
              endif;
              $html .= '<time class="rpwe-time published" datetime="' . esc_html( get_the_date( 'c' ) ) . '">' . esc_html( $date ) . '</time>';
            elseif( $args['date_modified'] ) : // if both date functions are provided, we use date to be backwards compatible
              $date = get_the_modified_date();
              if ( $args['date_relative'] ) :
                $date = sprintf( __( '%s ago', 'p8rp' ), human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) ) );
              endif;
              $html .= '<time class="rpwe-time modfied" datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '">' . esc_html( $date ) . '</time>';
            endif;

          $html .= '</li>';

        endwhile;

      $html .= '</ul>';
    $html .= '</div>';

  endif;

  // Restore original Post Data.
  wp_reset_postdata();

  // Allow devs to hook in stuff after the loop.
  do_action( 'p8rp_after_loop' );

  // Return the  posts markup.
  return wp_kses_post( $args['before'] ) . apply_filters( 'p8rp_markup', $html ) . wp_kses_post( $args['after'] );
}

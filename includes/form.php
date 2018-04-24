<?php
/**
 * Widget forms.
 *
 * @package    P8_Recent_Posts
 * @since      0.1.0
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, Chris Violette
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
?>

<div class="p8rp__form">
  <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
			<?php _e( 'Title', 'p8_recent_posts' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'title_url' ); ?>">
			<?php _e( 'Title URL', 'p8_recent_posts' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title_url' ); ?>" name="<?php echo $this->get_field_name( 'title_url' ); ?>" type="text" value="<?php echo esc_url( $instance['title_url'] ); ?>" />
	</p>

  <p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['exclude_current'], 1 ); ?> id="<?php echo $this->get_field_id( 'exclude_current' ); ?>" name="<?php echo $this->get_field_name( 'exclude_current' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'exclude_current' ); ?>">
			<?php _e( 'Exclude current post', 'p8_recent_posts' ); ?>
		</label>
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'post_status' ); ?>">
			<?php _e( 'Post Status', 'p8_recent_posts' ); ?>
		</label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'post_status' ); ?>" name="<?php echo $this->get_field_name( 'post_status' ); ?>" style="width:100%;">
			<?php foreach ( get_available_post_statuses() as $status_value => $status_label ) { ?>
				<option value="<?php echo esc_attr( $status_label ); ?>" <?php selected( $instance['post_status'], $status_label ); ?>><?php echo esc_html( ucfirst( $status_label ) ); ?></option>
			<?php } ?>
		</select>
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
			<?php _e( 'Number of posts to show', 'p8_recent_posts' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" step="1" min="-1" value="<?php echo (int)( $instance['limit'] ); ?>" />
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'offset' ); ?>">
			<?php _e( 'Offset', 'p8_recent_posts' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="number" step="1" min="0" value="<?php echo (int)( $instance['offset'] ); ?>" />
		<small><?php _e( 'The number of posts to skip', 'p8_recent_posts' ); ?></small>
	</p>

  <p>
		<label for="<?php echo $this->get_field_id( 'days_offset' ); ?>">
			<?php _e( 'Days to show', 'p8_recent_posts' ); ?>
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'days_offset' ); ?>" name="<?php echo $this->get_field_name( 'days_offset' ); ?>" type="number" step="1" min="1" value="<?php echo (int)( $instance['days_offset'] ); ?>" />
		<small><?php _e( 'Show posts within the range of days in the past.', 'p8_recent_posts' ); ?></small>
	</p>

  <p>
		<input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" <?php checked( $instance['date'] ); ?> />
		<label for="<?php echo $this->get_field_id( 'date' ); ?>">
			<?php _e( 'Display Date', 'p8_recent_posts' ); ?>
		</label>
	</p>

	<p>
		<input id="<?php echo $this->get_field_id( 'date_modified' ); ?>" name="<?php echo $this->get_field_name( 'date_modified' ); ?>" type="checkbox" <?php checked( $instance['date_modified'] ); ?> />
		<label for="<?php echo $this->get_field_id( 'date_modified' ); ?>">
			<?php _e( 'Display Modification Date', 'p8_recent_posts' ); ?>
		</label>
	</p>

	<p>
		<input id="<?php echo $this->get_field_id( 'date_relative' ); ?>" name="<?php echo $this->get_field_name( 'date_relative' ); ?>" type="checkbox" <?php checked( $instance['date_relative'] ); ?> />
		<label for="<?php echo $this->get_field_id( 'date_relative' ); ?>">
			<?php _e( 'Use Relative Date. eg: 5 days ago', 'p8_recent_posts' ); ?>
		</label>
	</p>
</div>

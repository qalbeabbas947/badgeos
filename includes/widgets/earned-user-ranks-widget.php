<?php
//widget displays achievements earned for the logged in user
class earned_user_ranks_widget extends WP_Widget {

	//process the new widget
	function __construct() {
		$widget_ops = array(
			'classname' => 'earned_user_ranks_class',
			'description' => __( 'Displays ranks earned by the logged in user', 'badgeos' )
		);
		parent::__construct( 'earned_user_ranks_widget', __( 'BadgeOS Earned User Ranks', 'badgeos' ), $widget_ops );
	}

	//build the widget settings form
	function form( $instance ) {
		$defaults = array( 'title' => __( 'My Ranks', 'badgeos' ), 'set_point_type' => '', 'point_total' => '', 'set_ranks' => []);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = $instance['title'];
		$point_total = $instance['point_total'];
		$set_point_type = ( isset( $instance['total_points_type'] ) ) ? $instance['total_points_type'] : '';
		$set_ranks = 	( isset( $instance['set_ranks'] ) ) ? (array) $instance['set_ranks'] : array();
		?>
		<p><label><input type="checkbox" id="<?php echo esc_attr( $this->get_field_name( 'point_total' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'point_total' ) ); ?>" <?php checked( $point_total, 'on' ); ?> /> <?php _e( 'Display user\'s total points', 'badgeos' ); ?></label></p>
		<p>
			<?php
			/**
			 * get all credit types
			 */
			$point_types = badgeos_get_point_types();
			if ( is_array( $point_types ) && ! empty( $point_types ) ) { 
				?>
				<select id="total_points_type" name="<?php echo esc_attr( $this->get_field_name( 'total_points_type' ) ); ?>" class="widget-total-points-type">
					<option value=""><?php _e( 'Select Points Type' ); ?></option>
					<?php

						foreach ( $point_types as $key => $point_type ) {
							?>
								<option value="<?php echo $point_type->ID; ?>" <?php echo selected( $set_point_type, $point_type->ID ); ?> ><?php echo $point_type->post_title; ?></option>
							<?php
						}
					?>
				</select>
				<br />
				<span class="tool-hint"><?php _e( 'Total points of selected type will be displayed on frontend.', 'badgeos' ); ?></span>
			<?php } ?>
		</p>

		<p><label><?php _e( 'Display only the following User Rank Types:', 'badgeos' ); ?></label></p>
		<p>
			<?php
				//get all registered achievements
				$ranks = badgeos_get_rank_types_slugs_detailed();
				
				//loop through all registered achievements
				foreach ( $ranks as $rank_slug => $rank ) {
					
					//if rank displaying exists in the saved array it is enabled for display
					$checked = checked( in_array( $rank_slug, $set_ranks ), true, false );

					echo '<label for="' . esc_attr( $this->get_field_name( 'set_ranks' ) ) . '_' . esc_attr( $rank_slug ) . '">'
						. '<input type="checkbox" name="' . esc_attr( $this->get_field_name( 'set_ranks' ) ) . '[]" id="' . esc_attr( $this->get_field_name( 'set_ranks' ) ) . '_' . esc_attr( $rank_slug ) . '" value="' . esc_attr( $rank_slug ) . '" ' . $checked . ' />'
						. ' ' . esc_html( ucfirst( $rank[ 'plural_name' ] ) )
						. '</label><br />';

				}
			?>
		</p>
		<?php
	}

	//save and sanitize the widget settings
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

        if( !isset( $new_instance['set_ranks'] ) || empty( $new_instance['set_ranks'] ) ) {
            $new_instance['set_ranks'] = [];
        }
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['set_ranks'] = array_map( 'sanitize_text_field', $new_instance['set_ranks'] );
		$instance['total_points_type'] = sanitize_text_field( $new_instance['total_points_type'] );
		$instance['point_total'] = ( ! empty( $new_instance['point_total'] ) ) ? sanitize_text_field( $new_instance['point_total'] ) : '';
		

        return $instance;
	}

	//display the widget
	function widget( $args, $instance ) {
		global $user_ID;

		if( array_key_exists( 'before_widget', $args ) )
			echo $args['before_widget'];

        $badgeos_settings = ( $exists = badgeos_utilities::get_option( 'badgeos_settings' ) ) ? $exists : array();
		$title = apply_filters( 'widget_title', $instance['title'] );
		//user must be logged in to view earned badges and points
		if ( is_user_logged_in() ) {

			//display user's points if widget option is enabled
			if ( $instance['point_total'] == 'on' && !empty( $instance['total_points_type'] ) ) {
				$earned_points = badgeos_get_points_by_type( $instance['total_points_type'], get_current_user_id() );
                $plural_name = badgeos_utilities::get_post_meta( $instance['total_points_type'], '_point_plural_name', true );
                if( !empty( $plural_name ) ) {
                    $point_title = $plural_name;
                } else {
                    $point_title = get_the_title( $instance['total_points_type'] );
                }
				$badge_image = badgeos_get_point_image( $instance['total_points_type'], 50,50 );
				$badge_image = apply_filters( 'badgeos_profile_points_image', $badge_image, 'front-widget' , $instance['total_points_type']  );

                ?>
                <div class="badgeos_earned_points_only">
					<table>
						<tr>
							<td valign="middle" width="30%"><?php echo $badge_image; ?></td>
							<td valign="middle" width="40%"><?php echo $point_title; ?></td>
							<td valign="middle" width="40%">
								<div class="badgeos-earned-credit">
									<span><?php echo number_format( $earned_points ); ?></span>
								</div>
							</td>
						</tr>
					</table>
                </div> 
			<?php }

			if( isset( $instance['set_ranks'] ) && is_array( $instance['set_ranks'] ) && count( $instance['set_ranks'] ) > 0 ) {
					$user_ranks = badgeos_get_user_ranks( array( 'rank_type'=> $instance['set_ranks'] ) );
					if( isset( $user_ranks ) && count( $user_ranks ) > 0 ) {
						?>
						<div class="badgeos-user-ranks-only">
						<?php if( !empty( $rank_section_title ) ) { ?>
							<h3><?php echo $rank_section_title;?></h3>
						<?php } ?>
						<?php
						echo '<ul class="widget-ranks-listing">';
	                    $rank_width = '50';
	                    if( isset( $badgeos_settings['badgeos_rank_global_image_width'] ) && intval( $badgeos_settings['badgeos_rank_global_image_width'] ) > 0 ) {
	                        $rank_width = intval( $badgeos_settings['badgeos_rank_global_image_width'] );
	                    }

	                    $rank_height = '50';
	                    if( isset( $badgeos_settings['badgeos_rank_global_image_height'] ) && intval( $badgeos_settings['badgeos_rank_global_image_height'] ) > 0 ) {
	                        $rank_height = intval( $badgeos_settings['badgeos_rank_global_image_height'] );
	                    }

	                    foreach ( $user_ranks as $rank ) {

	                        $img    = badgeos_get_rank_image( $rank->rank_id, $rank_width, $rank_height );
										$img_permalink = 'javascript:;';
										if ( ! function_exists( 'post_exists' ) ) {
											require_once( ABSPATH . 'wp-admin/includes/post.php' );
										}
										if( post_exists( get_the_title( $rank->rank_id ) ) ) {
											$img_permalink = get_permalink( $rank->rank_id );
										}
									
										$thumb      = $img ? '<a class="badgeos-item-thumb" href="'. $img_permalink .'">' . $img .'</a>' : '';
										$class      = 'widget-badgeos-item-title';
										$item_class = $thumb ? ' has-thumb' : '';
			
										$rank_title = get_the_title( $rank->rank_id );
										if( empty( $rank_title ) ) {
	                                        $rank_title = '<a class="widget-badgeos-item-title '. esc_attr( $class ) .'" href="javascript:;">'. esc_html( $rank->rank_title ) .'</a>';
										} else {
											$permalink  = get_permalink( $rank->rank_id );
											$rank_title = '<a class="widget-badgeos-item-title '. esc_attr( $class ) .'" href="'. esc_url( $permalink ) .'">'. esc_html( $rank_title ) .'</a>';
										}
			
										echo '<li id="widget-rank-listing-item-'. absint( $rank->rank_id ) .'" class="widget-rank-listing-item'. esc_attr( $item_class ) .'">';
	                                    
	                                    echo $thumb;

	                                    echo $rank_title;
										
										do_action('badgeos_widget_ranks_listing', $rank);
	                                    echo '</li>';
									}
									echo '</ul>';
								?>
							</div>
						<?php
					}
				}
			} else {
				//user is not logged in so display a message
				echo '<p>'. _e( 'You must be logged in to view earned ranks and points', 'badgeos' ) . '</p>'; 
				

			}

			if( array_key_exists( 'after_widget', $args ) )
				echo $args['after_widget'];

	}

}

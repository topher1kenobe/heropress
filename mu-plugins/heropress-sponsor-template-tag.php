<?php
/*
Plugin Name: HeroPress Partner Information Template Tag
Description: Creates a template tag called heropress_essay_partner()
Author: Topher
Version: 1.0
Author URI: http://heropress.com
*/

/**
 * Creates a template tag called heropress_essay_partner()
 *
 * @package heropress_essay_partner
 * @since heropress_essay_partner 1.0
 * @author Topher
 */


/**
 * Front-end display of widget.
 */
function heropress_essay_partner() {

	$current_object = get_queried_object();

	// Find connected pages
	$connected = new WP_Query( array(
		'connected_type'  => 'essays_to_sponsors',
		'connected_items' => $current_object,
		'connected_query' => array( 'post_status' => 'any' ),
		'nopaging'        => true,
	) );

	// Display connected pages
	if ( $connected->have_posts() ) :

	?>

	<div class="heropress-partner">

	<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>

		<h3><?php _e( 'Featured Partner:', 'heropress' ); ?> <?php echo get_the_title(); ?></h3>

		<?php

			$meta = get_post_custom();

			// check to see if we're aligning left
			$align_left = '';
			if ( ! empty( $meta['_heropress_align_right'][0] ) ) {
				$align_left = ' alignleft';
			}


            if ( ! empty( $meta['_heropress_sponsor_url'][0] ) ) {
				$url_start = '<a class="' . trim( $align_left ) . '" href="' . esc_url( $meta['_heropress_sponsor_url'][0] ) . '?utm_source=heropress&utm_medium=heropress-sponsorship&utm_content=' . $current_object->post_name . '">';
				$url_end = '</a>';
            } else {
				$url_start = '';
				$url_end = '';
			}
		?>

		<?php echo $url_start; ?><?php the_post_thumbnail( 'heropress-sponsor-logo' ); ?><?php echo $url_end; ?>

		<?php echo wpautop( get_the_content() ); ?>

		<?php
			if ( ! empty( $meta['_heropress_sponsor_url'][0] ) ) {
		?>
		<h6><?php echo $url_start; ?><?php _e( 'Visit', 'heropress' ); ?> <?php echo get_the_title(); ?><?php echo $url_end; ?></h6>
		<?php
			}
		?>

	<?php endwhile; ?>

	</div>

	<?php 
	// Prevent weirdness
	wp_reset_postdata();

	endif;

}


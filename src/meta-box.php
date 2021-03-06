<?php
/**
 * Meta Box Basics
 *
 * @package     KnowTheCode\MetaBoxBasics
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */

namespace KnowTheCode\MetaBoxBasics;

use WP_Post;

add_action( 'admin_menu', __NAMESPACE__ . '\register_meta_box' );
/**
 * Register the meta box.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_meta_box() {
	add_meta_box(
		'mbbasics_subtitle',
		__( 'New Subtitle', 'mbbasics' ),
		__NAMESPACE__ . '\render_meta_box',
		array('post'),
		'normal',
		'high'
	);
}

/**
 * Render the meta box
 *
 * @since 1.0.0
 *
 * @param WP_Post $post     Instance of the post for this meta box
 * @param array   $meta_box Array of meta box arguments
 *
 * @return void
 */
function render_meta_box( WP_Post $post, array $meta_box ) {
	// Security with a nonce
	wp_nonce_field( 'mbbasics_save', 'mbbasics_nonce' );

	// Get the metadata
	$new_subtitle = get_post_meta( $post->ID, 'new-subtitle', true );
	$show_subtitle = get_post_meta( $post->ID, 'show-subtitle', true );

	if ( ! $new_subtitle && $new_subtitle !== '0' ) {
		$new_subtitle = '';
	}

	// Do any processing that needs to be done

	// Load the view file
	include METABOXBASICS_DIR . 'src/view.php';
}

add_action( 'save_post', __NAMESPACE__ . '\save_meta_box', 10, 2 );
/**
 * Description.
 *
 * @since 1.0.0
 *
 * @param integer  $post_id Post ID.
 * @param stdClass $post    Post object.
 *
 * @return void
 */
function save_meta_box( $post_id ) {

	// If there's no data, return false.
	if ( ! array_key_exists( 'mbbasics', $_POST ) ) {
		return;
	}

	// If the nonce doesn't match, return false.
	if ( ! wp_verify_nonce( $_POST['mbbasics_nonce'], 'mbbasics_save' ) ) {
		die( __( 'Security Check Failed - Unverified nonce!', 'mbbasics') );
	}

	// Defaults
	$metadata = wp_parse_args(
		$_POST['mbbasics'],
		[
			'new-subtitle'  => '',
			'show-subtitle' => null,
		]
	);

	foreach ( $metadata as $meta_key => $value ) {

		if ( $value === '' || $value === null ) {
			delete_post_meta( $post_id, $meta_key );
			continue;
		}

		$value = 'new-subtitle' === $meta_key
			? sanitize_text_field( $value )
			: $value;

		update_post_meta( $post_id, $meta_key, $value );
	}
	return;
}

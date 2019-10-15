<?php

/**
 * Additional code for the child theme goes in here.
 */

add_action( 'wp_enqueue_scripts', 'enqueue_child_styles', 99);

function enqueue_child_styles() {
	$css_creation = filectime(get_stylesheet_directory() . '/style.css');

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [], $css_creation );
}

const BLOCK_WHITELIST = [
	'post' => [
		// E.g.: 'gpnl/blockquote'.
	],
	'page' => [],
	'campaign' => []
];

const BLOCK_BLACKLIST = [
	'post' => [
		// E.g.: 'planet4-blocks/gallery' or 'core/quote'.
	],
	'page' => [],
	'campaign' => []
];

function set_child_theme_allowed_block_types( $allowed_block_types, $post ) {
	if ( ! empty( BLOCK_WHITELIST[ $post->post_type ] )) {
		$allowed_block_types = array_merge( $allowed_block_types, BLOCK_WHITELIST[$post->post_type] );
	}

	if ( ! empty( BLOCK_BLACKLIST[ $post->post_type ] )) {
		$allowed_block_types = array_filter( $allowed_block_types, function ( $element ) use ( $post ) {
			return !in_array( $element, BLOCK_BLACKLIST[ $post->post_type ] );
		} );
	}

	// array_values is required as array_filter removes indexes from the array.
	return array_values($allowed_block_types);
}

add_filter( 'allowed_block_types', 'set_child_theme_allowed_block_types', 15, 2 );

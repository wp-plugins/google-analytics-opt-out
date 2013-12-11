<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checks if a shortcode is used in a string
 *
 * @param string $shortcode
 * @param string $content
 *
 * @return bool
 */
function gaoo_has_shortcode( $shortcode, $content = '' ) {
	if ( stripos( $content, '[' . $shortcode ) !== false ) {
		return true;
	}
	return false;
}

/**
 * Adds the shortcodes
 *
 * @since 0.1
 * @return void
 */
function gaoo_init_shortcodes() {
	add_shortcode( 'google_analytics_optout', 'gaoo_shortcode' );
}

add_action( 'init', 'gaoo_init_shortcodes' );


/**
 * Creating the shortcode content
 *
 * @param array  $atts
 * @param string $content
 *
 * @since 0.1
 *
 * @return string
 */
function gaoo_shortcode( $atts, $content = '' ) {
	//$atts = shortcode_atts( array(), $atts );

	if ( empty( $content ) ) {
		$content = __( 'Click here to opt out.', 'gaoo' );
	}

	$ua_code = gaoo_get_ua_code();

	if ( empty( $ua_code ) ) {
		return '<span style="cursor: help; border: 0 none; border-bottom-width: 1px; border-style: dashed;" title="' . __( 'No UA-Code has been entered. Please ask the admin to solve this issue!', 'gaoo' ) . '">' . do_shortcode( $content ) . '</span>';
	}

	return '<a class="gaoo-opt-out google-analytics-opt-out" href="javascript:gaoo_analytics_optout();">' . do_shortcode( $content ) . '</a>';
}

/**
 * Doing shortcodes in the text widget, too
 */
add_filter( 'widget_text', 'do_shortcode' );
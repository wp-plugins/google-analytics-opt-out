<?php

/**
 * Checks if the Yoast Analytics Plugin is active
 * @since 0.1
 * @return bool
 */
function gaoo_yoast_plugin_active() {
	global $ga_admin, $yoast_ga;

	if ( ( isset( $ga_admin ) && is_a( $ga_admin, 'GA_Admin' ) ) OR ( isset( $yoast_ga ) && is_a( $yoast_ga, 'GA_Filter' ) ) ) {
		return true;
	}

	return true;
}

/**
 * Return the UA from Yoast settings, if Yoast Analytics plugin is installed
 * If Yoast Analytics is not installed this will return an empty string
 *
 * @since 0.1
 * @return string
 */
function gaoo_get_yoast_ua() {

	if ( ! gaoo_yoast_plugin_active() ) {
		return '';
	}

	if ( is_admin() ) {
		global $ga_admin;

		if ( ! isset( $ga_admin->optionname ) ) {
			return '';
		}

		$yoast_settings = get_option( $ga_admin->optionname );

		if ( ! isset( $yoast_settings['uastring'] ) ) {
			return '';
		}

		return $yoast_settings['uastring'];
	}

	global $yoast_ga;

	if ( ! isset( $yoast_ga->options['uastring'] ) ) {
		return '';
	}

	return $yoast_ga->options['uastring'];

}

/**
 * Returns the UA-Code
 * @since 0.1
 * @return string
 */
function gaoo_get_ua_code() {

	if ( gaoo_yoast_plugin_active() ) {
		return apply_filters( 'gaoo_get_ua_code', gaoo_get_yoast_ua() );
	}

	// if yoast returns an empty string OR if the checkbox was set to 0 return the textbox content
	return apply_filters( 'gaoo_get_ua_code', esc_attr( get_option( 'gaoo_property', '' ) ) );

}
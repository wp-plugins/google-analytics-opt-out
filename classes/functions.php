<?php

/**
 * Checks if the Yoast Analytics Plugin is active
 * @since 0.1
 * @return bool
 */
function gaoo_yoast_plugin_active() {
	return defined( 'GAWP_VERSION' );
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

	$ua_code = '';

	if ( is_admin() ) {
		global $yoast_ga_admin;

		if ( method_exists( $yoast_ga_admin, 'get_tracking_code' ) ) {
			$ua_code = $yoast_ga_admin->get_tracking_code();
		}

	} else {
		global $yoast_ga_frontend;

		if ( method_exists( $yoast_ga_frontend, 'get_tracking_code' ) ) {
			$ua_code = $yoast_ga_frontend->get_tracking_code();
		}

	}

	return $ua_code;
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
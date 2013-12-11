<?php

/**
 * Checks if the Yoast Analytics Plugin is active
 * @since 0.1
 * @return bool
 */
function gaoo_yoast_plugin_active() {
	global $ga_admin;

	if ( ! isset( $ga_admin ) ) {
		return false;
	}

	if ( ! $ga_admin instanceof GA_Admin ) {
		return false;
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

/**
 * Returns the UA-Code
 * @since 0.1
 * @return string
 */
function gaoo_get_ua_code() {

	$use_yoast = get_option( 'gaoo_yoast', null );

	// if the plugin is used the first time, this value is NULL
	if ( is_null( $use_yoast ) ) {
		$use_yoast = 1;
	}

	// if yoast should be used, try to get the ua code from the plugin
	if ( 1 == intval( $use_yoast ) ) {
		$yoast_code = gaoo_get_yoast_ua();

		if ( ! empty( $yoast_code ) ) {
			return apply_filters( 'gaoo_get_ua_code', $yoast_code );
		}
	}

	// if yoast returns an empty string OR if the checkbox was set to 0 return the textbox content
	return apply_filters( 'gaoo_get_ua_code', esc_attr( get_option( 'gaoo_property', '' ) ) );

}
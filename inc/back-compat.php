<?php
/**
 * Twenty Seventeen back compat functionality
 *
 * Prevents Twenty Seventeen from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 */

 
/**
 * Prevent switching to Twenty Seventeen on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Tikva7 0.1
 */
function tikva7_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'tikva7_upgrade_notice' );
}
add_action( 'after_switch_theme', 'tikva7_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Twenty Seventeen on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function tikva7_upgrade_notice() {
	$message = sprintf( __( 'Tikva7 requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'tikva' ), phpversion() );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function tikva7_customize() {
	wp_die( sprintf( __( 'Tikva7 requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), phpversion() ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'tikva7_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function tikva7_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Tikva7 requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'tikva' ), phpversion() ) );
	}
}
add_action( 'template_redirect', 'tikva7_preview' );

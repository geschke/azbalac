<?php
/**
 * Azbalac One PHP compatibility functionality.
 *
 * Prevents the theme from running on unsupported PHP versions.
 *
 * @package Azbalac_One
 * @since 0.1
 */

 
/**
 * Prevents switching to Azbalac One on unsupported PHP versions.
 *
 * Switches to the default theme.
 *
 * @since 0.1
 */
function azbalac_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'azbalac_upgrade_notice' );
}
add_action( 'after_switch_theme', 'azbalac_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update notice after an unsuccessful attempt to switch themes.
 *
 * @since 0.1
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_upgrade_notice() {
	$message = sprintf( __( 'Azbalac One requires at least PHP version 8.1. You are running version %s. Please upgrade and try again.', 'azbalac-one' ), phpversion() );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on unsupported PHP versions.
 *
 * @since 0.1
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_customize() {
	wp_die( sprintf( __( 'Azbalac One requires at least PHP version 8.1. You are running version %s. Please upgrade and try again.', 'azbalac-one' ), phpversion() ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'azbalac_customize' );

/**
 * Prevents the Theme Preview from being loaded on PHP versions prior to 8.1.
 *
 * @since 0.1
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Azbalac One requires at least PHP version 8.1. You are running version %s. Please upgrade and try again.', 'azbalac-one' ), phpversion() ) );
	}
}
add_action( 'template_redirect', 'azbalac_preview' );

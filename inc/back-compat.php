<?php
/**
 * Azbalac back compat functionality
 *
 * Prevents Twenty Seventeen from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Azbalac
 * @since Azbalac 0.1
 */

 
/**
 * Prevent switching to Twenty Seventeen on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since azbalac 0.1
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
 * Prints an update nag after an unsuccessful attempt to switch to
 * Twenty Seventeen on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_upgrade_notice() {
	$message = sprintf( __( 'Azbalac requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'azbalac' ), phpversion() );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_customize() {
	wp_die( sprintf( __( 'Azbalac requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), phpversion() ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'azbalac_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Twenty Seventeen 1.0
 *
 * @global string $wp_version WordPress version.
 */
function azbalac_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Azbalac requires at least PHP version 7.0.0. You are running version %s. Please upgrade and try again.', 'azbalac' ), phpversion() ) );
	}
}
add_action( 'template_redirect', 'azbalac_preview' );

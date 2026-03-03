<?php
/**
 * Main plugin bootstrap for What Would Seth Godin Do.
 *
 * @package           what-would-seth-godin-do
 * @author            James Hunt
 * @copyright         2006-2026 Richard K Miller, 2026 James Hunt
 * @license           GPL-2.0-or-later
 */

declare( strict_types=1 );

namespace WWSGD;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstraps the plugin by registering all WordPress hooks.
 */
class WWSGD_Plugin {

	/**
	 * Registers all plugin hooks.
	 *
	 * Called on the plugins_loaded action.
	 *
	 * @return void
	 */
	public static function init(): void {
		// Seed default settings on first activation.
		WWSGD_Settings::get_settings();

		// Admin.
		add_action( 'admin_menu', array( WWSGD_Admin::class, 'register_options_page' ) );

		// Frontend.
		add_action( 'wp_footer', array( WWSGD_Frontend::class, 'enqueue_script' ) );
		add_filter( 'the_content', array( WWSGD_Frontend::class, 'filter_content' ) );
	}
}

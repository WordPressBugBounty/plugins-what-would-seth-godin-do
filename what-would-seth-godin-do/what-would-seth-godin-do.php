<?php
/**
 * What Would Seth Godin Do
 *
 * @package           what-would-seth-godin-do
 * @author            James Hunt
 * @copyright         2006-2026 Richard K Miller, 2026 James Hunt
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       What Would Seth Godin Do
 * Description:       Displays a custom welcome message to new visitors and another to return visitors.
 * Version:           2.2.0
 * Author:            James Hunt
 * Author URI:        https://www.thetwopercent.co.uk
 * Text Domain:       what-would-seth-godin-do
 * Requires PHP:      7.4
 * Requires at least: 6.0
 * Tested up to:      6.9
 * License:           GPL-2.0-or-later
 *
 * Copyright (c) 2006-2026 Richard K Miller
 * Copyright (c) 2026 James Hunt
 * Released under the GNU General Public License (GPL)
 * http://www.gnu.org/licenses/gpl.txt
 */

declare( strict_types=1 );

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WWSGD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WWSGD_PLUGIN_VERSION', '2.2.0' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-wwsgd-plugin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wwsgd-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wwsgd-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wwsgd-frontend.php';

add_action( 'plugins_loaded', array( 'WWSGD\\WWSGD_Plugin', 'init' ) );

/**
 * Template tag: outputs the new/return visitor message markup directly.
 *
 * Usage: <?php wwsgd_the_message(); ?>
 *
 * @return void
 */
function wwsgd_the_message(): void {
	echo \WWSGD\WWSGD_Frontend::get_message(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- content is sanitised via wp_kses_post inside get_message()
}

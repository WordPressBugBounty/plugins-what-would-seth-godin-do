<?php
/**
 * Frontend output for What Would Seth Godin Do.
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
 * Handles frontend content filtering and script enqueueing.
 */
class WWSGD_Frontend {

	/**
	 * Filters post content to prepend or append the visitor message.
	 *
	 * Mirrors the logic of the original wwsgd_filter_content() function.
	 *
	 * @param string $content The post content.
	 * @return string Filtered content.
	 */
	public static function filter_content( string $content = '' ): string {
		static $message_already_displayed = false;

		if ( ! in_the_loop() ) {
			return $content;
		}

		if ( ! is_home() && ! is_front_page() && ! is_single() && ! is_page() ) {
			return $content;
		}

		$settings = WWSGD_Settings::get_settings();

		$excluded_ids = array_filter(
			explode( ' ', str_replace( ',', ' ', $settings['wwsgd_exclude_ids'] ) )
		);

		$template_tag_only  = ( 'template_tag_only' === $settings['message_location'] );
		$all_pages_excluded = ( is_page() && 'no' === $settings['include_pages'] );
		$this_post_excluded = in_array( (string) get_the_ID(), $excluded_ids, true );

		if ( $template_tag_only || $all_pages_excluded || $this_post_excluded ) {
			return $content;
		}

		if ( $message_already_displayed ) {
			return $content;
		}

		$message_already_displayed = true;

		$message = self::get_message();

		return ( 'after_post' === $settings['message_location'] )
			? $content . $message
			: $message . $content;
	}

	/**
	 * Returns the HTML markup for both visitor message containers.
	 *
	 * Both divs are hidden by default; JavaScript reveals the appropriate one.
	 *
	 * @return string HTML markup.
	 */
	public static function get_message(): string {
		$settings = WWSGD_Settings::get_settings();

		return '<div class="wwsgd_new_visitor" style="display:none;">'
			. wp_kses_post( $settings['new_visitor_message'] )
			. '</div>'
			. '<div class="wwsgd_return_visitor" style="display:none;">'
			. wp_kses_post( $settings['return_visitor_message'] )
			. '</div>';
	}

	/**
	 * Registers, localises, and enqueues the visitor-tracking script.
	 *
	 * Hooked to wp_footer at priority 10, before wp_print_footer_scripts (priority 20).
	 *
	 * @return void
	 */
	public static function enqueue_script(): void {
		$settings = WWSGD_Settings::get_settings();

		$url         = wp_parse_url( get_bloginfo( 'url' ) );
		$cookie_path = isset( $url['path'] ) ? rtrim( $url['path'], '/' ) . '/' : '/';

		wp_register_script(
			'wwsgd',
			WWSGD_PLUGIN_URL . 'assets/js/wwsgd.js',
			array(),
			WWSGD_PLUGIN_VERSION,
			true
		);

		wp_localize_script(
			'wwsgd',
			'wwsgd_vars',
			array(
				'repetition'  => absint( $settings['repetition'] ),
				'cookie_path' => $cookie_path,
			)
		);

		wp_enqueue_script( 'wwsgd' );
	}
}

<?php
/**
 * Settings management for What Would Seth Godin Do.
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
 * Manages plugin settings stored in the WordPress options table.
 */
class WWSGD_Settings {

	/**
	 * Option name used to store settings.
	 *
	 * @var string
	 */
	const OPTION_NAME = 'wwsgd_settings';

	/**
	 * Returns the current settings, initialising defaults on first run.
	 *
	 * @return array<string,string>
	 */
	public static function get_settings(): array {
		$settings = get_option( self::OPTION_NAME );

		if ( ! is_array( $settings ) ) {
			return self::initialize_defaults();
		}

		return $settings;
	}

	/**
	 * Seeds the option with default values and returns them.
	 *
	 * @return array<string,string>
	 */
	public static function initialize_defaults(): array {
		$defaults = array(
			'new_visitor_message'    => '<p style="border:thin dotted black; padding:3mm;">If you\'re new here, you may want to subscribe to my <a href="' . esc_url( get_option( 'home' ) ) . '/feed/">RSS feed</a>. Thanks for visiting!</p>',
			'return_visitor_message' => '',
			'message_location'       => 'before_post',
			'include_pages'          => 'yes',
			'repetition'             => '5',
			'wwsgd_exclude_ids'      => '',
		);

		add_option( self::OPTION_NAME, $defaults );

		return $defaults;
	}

	/**
	 * Sanitises and persists settings from submitted form data.
	 *
	 * @param array<string,mixed> $post_data Raw POST data (e.g. $_POST).
	 * @return void
	 */
	public static function update_settings( array $post_data ): void {
		$settings = self::get_settings();

		$settings['new_visitor_message']    = wp_kses_post( wp_unslash( (string) ( $post_data['wwsgd_new_visitor_message'] ?? '' ) ) );
		$settings['return_visitor_message'] = wp_kses_post( wp_unslash( (string) ( $post_data['wwsgd_return_visitor_message'] ?? '' ) ) );
		$settings['message_location']       = sanitize_key( (string) ( $post_data['wwsgd_message_location'] ?? '' ) );
		$settings['include_pages']          = sanitize_key( (string) ( $post_data['wwsgd_message_include_pages'] ?? '' ) );
		$settings['repetition']             = (string) absint( $post_data['wwsgd_repetition'] ?? 5 );

		$raw_ids = wp_unslash( (string) ( $post_data['wwsgd_exclude_ids'] ?? '' ) );
		if ( trim( $raw_ids ) === '' ) {
			$settings['wwsgd_exclude_ids'] = '';
		} else {
			$id_parts                      = preg_split( '/\s*,\s*/', $raw_ids );
			$settings['wwsgd_exclude_ids'] = implode( ',', array_map( 'absint', is_array( $id_parts ) ? $id_parts : array() ) );
		}

		update_option( self::OPTION_NAME, $settings );
	}

	/**
	 * Deletes saved settings and re-seeds with defaults.
	 *
	 * @return void
	 */
	public static function reset_settings(): void {
		delete_option( self::OPTION_NAME );
		self::initialize_defaults();
	}
}

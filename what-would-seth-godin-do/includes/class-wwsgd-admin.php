<?php
/**
 * Admin UI for What Would Seth Godin Do.
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
 * Handles admin menu registration and the options page UI.
 */
class WWSGD_Admin {

	/**
	 * Registers the plugin's options sub-page under Settings.
	 *
	 * @return void
	 */
	public static function register_options_page(): void {
		add_options_page(
			__( 'What Would Seth Godin Do', 'what-would-seth-godin-do' ),
			__( 'WWSGD', 'what-would-seth-godin-do' ),
			'manage_options',
			'what-would-seth-godin-do',
			array( __CLASS__, 'render_options_page' )
		);
	}

	/**
	 * Processes form submissions then renders the options page.
	 *
	 * @return void
	 */
	public static function render_options_page(): void {
		// Handle save.
		if ( isset( $_POST['wwsgd_save_settings'] ) ) {
			check_admin_referer( 'wwsgd_update_options' );
			WWSGD_Settings::update_settings( $_POST ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitization handled inside update_settings()
		}

		// Handle reset.
		if ( isset( $_POST['wwsgd_reset_settings'] ) ) {
			check_admin_referer( 'wwsgd_reset_options' );
			WWSGD_Settings::reset_settings();
		}

		$settings = WWSGD_Settings::get_settings();
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
			<h2><?php esc_html_e( 'What Would Seth Godin Do', 'what-would-seth-godin-do' ); ?></h2>

			<p>"One opportunity that's underused is the idea of using cookies to treat returning visitors differently than newbies…." — <a target="_blank" href="https://seths.blog/2006/08/in_the_middle_s/">Seth Godin, August 17, 2006</a></p>

			<form method="post" action="<?php echo esc_url( admin_url( 'options-general.php?page=what-would-seth-godin-do' ) ); ?>">
				<input type="hidden" name="wwsgd_save_settings" value="true" />
				<?php wp_nonce_field( 'wwsgd_update_options' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="wwsgd_new_visitor_message"><?php esc_html_e( 'Message to New Visitors', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<textarea rows="3" cols="80" name="wwsgd_new_visitor_message" id="wwsgd_new_visitor_message"><?php echo esc_textarea( $settings['new_visitor_message'] ); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="wwsgd_repetition"><?php esc_html_e( '# of Repetitions', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<p>
								<?php esc_html_e( 'Show the above message the first', 'what-would-seth-godin-do' ); ?>
								<input type="text" name="wwsgd_repetition" id="wwsgd_repetition" value="<?php echo esc_attr( $settings['repetition'] ); ?>" size="3" />
								<?php esc_html_e( 'times the user visits your blog. Then display the message below.', 'what-would-seth-godin-do' ); ?>
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="wwsgd_return_visitor_message"><?php esc_html_e( 'Message to Return Visitors', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<textarea rows="3" cols="80" name="wwsgd_return_visitor_message" id="wwsgd_return_visitor_message" placeholder="<?php esc_attr_e( 'Welcome back!', 'what-would-seth-godin-do' ); ?>"><?php echo esc_textarea( $settings['return_visitor_message'] ); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label><?php esc_html_e( 'Location of Message', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<label>
								<input type="radio" name="wwsgd_message_location" value="before_post" <?php checked( $settings['message_location'], 'before_post' ); ?> />
								<?php esc_html_e( 'Before Post', 'what-would-seth-godin-do' ); ?>
							</label>
							&nbsp;
							<label>
								<input type="radio" name="wwsgd_message_location" value="after_post" <?php checked( $settings['message_location'], 'after_post' ); ?> />
								<?php esc_html_e( 'After Post', 'what-would-seth-godin-do' ); ?>
							</label>
							&nbsp;
							<label>
								<input type="radio" name="wwsgd_message_location" value="template_tag_only" <?php checked( $settings['message_location'], 'template_tag_only' ); ?> />
								<?php
								printf(
									/* translators: %s: PHP template tag code */
									esc_html__( 'Only where I use the %s template tag', 'what-would-seth-godin-do' ),
									'<code>&lt;?php wwsgd_the_message(); ?&gt;</code>'
								);
								?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label><?php esc_html_e( 'Show Message on Pages?', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<label>
								<input type="radio" name="wwsgd_message_include_pages" value="yes" <?php checked( $settings['include_pages'], 'yes' ); ?> />
								<?php esc_html_e( 'On Posts and Pages', 'what-would-seth-godin-do' ); ?>
							</label>
							&nbsp;
							<label>
								<input type="radio" name="wwsgd_message_include_pages" value="no" <?php checked( $settings['include_pages'], 'no' ); ?> />
								<?php esc_html_e( 'On Posts Only', 'what-would-seth-godin-do' ); ?>
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="wwsgd_exclude_ids"><?php esc_html_e( 'Posts/Pages to Exclude', 'what-would-seth-godin-do' ); ?></label>
						</th>
						<td>
							<input type="text" name="wwsgd_exclude_ids" id="wwsgd_exclude_ids" value="<?php echo esc_attr( $settings['wwsgd_exclude_ids'] ); ?>" size="60" placeholder="<?php esc_attr_e( 'Post or page IDs separated by spaces or commas', 'what-would-seth-godin-do' ); ?>" />
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Settings', 'what-would-seth-godin-do' ); ?>" class="button-primary" />
				</p>
			</form>

			<h3><?php esc_html_e( 'Reset Settings', 'what-would-seth-godin-do' ); ?></h3>
			<form method="post" action="<?php echo esc_url( admin_url( 'options-general.php?page=what-would-seth-godin-do' ) ); ?>">
				<input type="hidden" name="wwsgd_reset_settings" value="true" />
				<?php wp_nonce_field( 'wwsgd_reset_options' ); ?>
				<input type="submit" name="submit" value="<?php esc_attr_e( 'Reset Settings', 'what-would-seth-godin-do' ); ?>" class="button-primary" />
			</form>

			<br />
			<h3><?php esc_html_e( 'I ♥ WWSGD', 'what-would-seth-godin-do' ); ?></h3>
			<p>
				<?php
				printf(
					/* translators: %s: link to plugin's WordPress.org page */
					esc_html__( 'Please %s on WordPress.org.', 'what-would-seth-godin-do' ),
					'<a href="https://wordpress.org/plugins/what-would-seth-godin-do/">' . esc_html__( 'rate this plugin', 'what-would-seth-godin-do' ) . '</a>'
				);
				?>
			</p>
			<p>
				<?php
				printf(
					/* translators: %s: link to Acumen Fund donation page */
					esc_html__( 'If you love this plugin, please make a small donation to the %s, a charity with which Seth Godin works. In the "Referred by" field, enter "Seth Godin".', 'what-would-seth-godin-do' ),
					'<a href="https://acumen.org/donate/">' . esc_html__( 'Acumen Fund', 'what-would-seth-godin-do' ) . '</a>'
				);
				?>
			</p>
			<p>
				<?php
				printf(
					/* translators: %s: link to WordPress.org support forum */
					esc_html__( 'For questions, bug reports, or other feedback about this plugin, please use the %s.', 'what-would-seth-godin-do' ),
					'<a href="https://wordpress.org/support/plugin/what-would-seth-godin-do/">' . esc_html__( 'WordPress.org support forum', 'what-would-seth-godin-do' ) . '</a>'
				);
				?>
			</p>

			<br />
			<h3><?php esc_html_e( 'Additional Reading', 'what-would-seth-godin-do' ); ?></h3>
			<p><a href="https://seths.blog/2007/07/you-can-ask-fir/"><?php esc_html_e( 'You can ask, "First time here?"', 'what-would-seth-godin-do' ); ?></a> <?php esc_html_e( 'by Seth Godin', 'what-would-seth-godin-do' ); ?></p>
			<p><a href="https://seths.blog/2008/03/where-do-we-beg/"><?php esc_html_e( 'Where do we begin?', 'what-would-seth-godin-do' ); ?></a> <?php esc_html_e( 'by Seth Godin', 'what-would-seth-godin-do' ); ?></p>
		</div>
		<?php
	}
}

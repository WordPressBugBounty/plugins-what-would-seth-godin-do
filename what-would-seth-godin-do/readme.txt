=== What Would Seth Godin Do ===
Plugin Name: What Would Seth Godin Do
Contributors: bonkerz, richardkmiller
Tags: visitors, welcome, welcome message, personalization, marketing
Version: 2.2.0
Stable tag: 2.2.0
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Displays a custom welcome message to new visitors and a different message to return visitors using a simple cookie.

== Description ==

**What Would Seth Godin Do** lets you greet first-time visitors with a tailored welcome message — like an invitation to subscribe to your RSS feed — and show a different (or no) message to people who have already been to your site before.

The plugin stores a small cookie that counts how many times a visitor has been to your site. While the count is at or below the "# of Repetitions" threshold you configure, the *new visitor* message is shown. Once the visitor exceeds that threshold, the *return visitor* message appears instead.

Inspired by Seth Godin's 2006 blog post: [...in the middle, Starting](https://seths.blog/2006/08/in_the_middle_s/).

**Features:**

* Separate, fully customisable messages for new and returning visitors.
* Configurable repetition threshold — choose how many visits count as "new".
* Choose whether messages appear before or after post content, or only where you place the `<?php wwsgd_the_message(); ?>` template tag.
* Option to show or hide messages on Pages (vs. Posts only).
* Exclude specific post or page IDs from showing any message.
* No external dependencies; lightweight vanilla JavaScript.

== Installation ==

1. Install directly through the WordPress **Plugins → Add New** screen, or download the zip and upload via **Plugins → Add New → Upload Plugin**.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Go to **Settings → WWSGD** to configure your messages and display options.

== Frequently Asked Questions ==

= How does the plugin know if someone is a new or returning visitor? =

It sets a cookie called `wwsgd_visits` that increments by 1 on each page load. Visitors whose count is at or below your configured "# of Repetitions" see the new-visitor message; everyone else sees the return-visitor message.

= Will this work if a visitor deletes their cookies? =

Yes — if the cookie is deleted the visitor will simply be treated as new again.

= Can I use the message in a widget or template file instead of automatic insertion? =

Yes. Set **Location of Message** to "Only where I use the template tag" and place `<?php wwsgd_the_message(); ?>` wherever you want the messages to appear in your theme.

= Can I show a message to returning visitors only and nothing to new visitors? =

Yes. Leave the **Message to New Visitors** field blank. New visitors will see nothing; return visitors will see your return-visitor message.

= Does WWSGD work with pages as well as posts? =

By default, yes. You can restrict it to posts only via the **Show Message on Pages?** setting.

== Screenshots ==

1. What Would Seth Godin Do - Settings Page.
2. What Would Seth Godin Do - Frontend display of message.

== Upgrade Notice ==

= 2.2.0 =
Refactored to a modern class-based architecture. Settings and behaviour are unchanged. No action required after upgrading.

== Changelog ==

= 2.2.0 (2026.03.03) =
* Remove adoption notices. New maintainer: James Hunt.
* Refactored to modern class-based architecture with PSR-4 autoloading.
* Added escaping and nonce verification throughout.
* Extracted inline JavaScript to a separately enqueued asset file.
* Adding language POT file.
* Updated minimum WordPress requirement to 6.0.
* Tested with PHP 8.4.

= 2.1.8 =
* Add adoption notices to admin.

= 2.1.7 =
* Reducing tags to 4.

= 2.1.6 =
* Add contact info for plugin adoption

= 2.1.5 =
* Make plugin available for adoption.

= 2.1.4 =
* Update copyright to 2026
* Tested with WordPress 6.9

= 2.1.3 =
* Fix issue where WordPress's magic slashes were not being unslashed.

= 2.1.1 =
* Fixing a vulnerability, as reported by Patchstack
* Tested with WordPress 6.0

= 2.1.0 =
* Updated for WordPress 4.6+.

= 2.0.3 =
* Improved sanitisation of excluded post/page IDs.

= 2.0.2 =
* Fixed cookie path detection for WordPress installations in a subdirectory.

= 2.0.1 =
* Minor code clean-up.

= 2.0.0 =
* Rewrote cookie logic in vanilla JavaScript (removed jQuery dependency).
* Added return-visitor message and repetition threshold.
* Added option to exclude specific posts and pages.

= 1.0.0 =
* Initial release by Richard K Miller.
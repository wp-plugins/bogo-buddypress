=== Bogo BuddyPress ===
Contributors: mechter
Donate link: http://www.markusechterhoff.com/donation/
Tags: bogo, buddypress
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Multilingual BuddyPress with Bogo

== Description ==

Make your multilingual WordPress site have a multilingual social network, with Bogo and BuddyPress.

If your default language BuddyPress is at `http://www.example.com/members/`, then a German localized version would be at `http://www.example.com/de/members/`. If you have also added Spanish to Bogo, then that version would be found at `http://www.example.com/es/BuddyPress/`. Note that the language switcher widget/shortcode is currently not supported for BuddyPress, you'll have to link manually.

Translate your BuddyPress Extended Profiles: Admin Panel -> Users -> BogoBP XProfile

== Installation ==

1. Install [Bogo](https://wordpress.org/plugins/bogo/) and [BuddyPress](https://wordpress.org/plugins/buddypress/)
2. Install [BuddyPress language files](https://codex.buddypress.org/translations/)
3. Install this plugin

== Frequently Asked Questions ==

= I can't find the BogoBP XProfile page =
Make sure you have activated the Extended Profiles Component in the BuddyPress settings screen

== Changelog ==

= 2.0 =

- you can now translate your BuddyPress Extended Profiles
- added localization support

= 1.3 =

- added workaround for BuddyPress bug that causes some ajax calls to fail on localized pages

= 1.2 =

- removal of unused rewrite rules code

= 1.1 =

- bugfix: removed duplicate parentheses (bogo_get_lang_regex() already returns parentheses)

= 1.0 =

- initial release

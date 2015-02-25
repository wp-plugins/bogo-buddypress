=== Bogo BuddyPress ===
Contributors: mechter
Donate link: http://www.markusechterhoff.com/donation/
Tags: bogo, buddypress
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 2.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Multilingual BuddyPress with Bogo

== Description ==

Make your multilingual WordPress site have a multilingual social network, with Bogo and BuddyPress.

Say your default language BuddyPress is located at `/members/` and you have German and Spanish translations of your website, then the localized BuddyPress versions can be viewed at `/de/members/` and `/es/members/` respectively.

Translate your BuddyPress Extended Profiles: Admin Panel -> Users -> BogoBP XProfile

== Installation ==

1. Install [Bogo](https://wordpress.org/plugins/bogo/) and [BuddyPress](https://wordpress.org/plugins/buddypress/)
2. Install [BuddyPress language files](https://codex.buddypress.org/translations/)
3. Install this plugin

== Frequently Asked Questions ==

= I can't find the BogoBP XProfile page =
Make sure you have activated the Extended Profiles Component in the BuddyPress settings screen

== Changelog ==

= 3.0 =

- added support for language switcher

= 2.1 =

- made the BogoBP XProfile settings a little prettier

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

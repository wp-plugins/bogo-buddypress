=== Bogo BuddyPress ===
Contributors: mechter
Donate link: http://www.markusechterhoff.com/donation/
Tags: bogo, buddypress
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 3.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Multilingual BuddyPress with Bogo

== Description ==

Make your multilingual WordPress site have a multilingual social network, with Bogo and BuddyPress.

Say your default language BuddyPress is located at `/members/` and you have German and Spanish translations of your website, then the localized BuddyPress versions can be viewed at `/de/members/` and `/es/members/` respectively.

Translate your BuddyPress Extended Profiles: Admin Panel -> Users -> BogoBP XProfile

All email notifications are localized to the language the user set in their profile. Also localizes URLs contained in emails where appropriate.

Known limitation: Parts of the activity stream are not localized. I haven't looked at the details and I'll probably not fix it. Let me know if you do and I'll apply your patch.

Development status: This plugin was developed because I thought it was a solution to my problem. It wasn't. Turns out what I really needed was a multisite setup with separate languages and BP_ENABLE_MULTIBLOG enabled. When I found out, I was close the version 3.0 release of Bogo BuddyPress, so I finished up and released it. Please understand that I am busy with other projects now, do not rely on my support or maintenance of this plugin. If you fix a bug and send me a patch, I will gladly apply it. If you pay good money and I've got some time, I might fix or add something for you. Other than that, you're on your own.

== Installation ==

1. Install [Bogo](https://wordpress.org/plugins/bogo/), [BuddyPress](https://wordpress.org/plugins/buddypress/) and [BogoXLib](https://wordpress.org/plugins/bogoxlib/)
2. Install [BuddyPress language files](https://codex.buddypress.org/translations/)
3. Install this plugin

== Frequently Asked Questions ==

= I can't find the BogoBP XProfile page =
Make sure you have activated the Extended Profiles Component in the BuddyPress settings screen

== Changelog ==

= 3.1 =

* updated to work with BogoXLib 1.1

= 3.0 =

* now using BogoXLib
* added email notification translation
* added automatic redirection to localized forum URLs for logged in users
* fixed XProfile options not being displayed on XProfile translation admin page
* added support for custom group/field/option order on XProfile translation admin page
* added support for Bogo language switcher (requires Bogo > 2.4.2 to work)

= 2.1 =

* made the BogoBP XProfile settings a little prettier

= 2.0 =

* you can now translate your BuddyPress Extended Profiles
* added localization support

= 1.3 =

* added workaround for BuddyPress bug that causes some ajax calls to fail on localized pages

= 1.2 =

* removal of unused rewrite rules code

= 1.1 =

* bugfix: removed duplicate parentheses (bogo_get_lang_regex() already returns parentheses)

= 1.0 =

* initial release

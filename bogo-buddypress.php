<?php
/*
Plugin Name: Bogo BuddyPress
Description: Make Bogo work with BuddyPress
Plugin URI: http://wordpress.org/extend/plugins/bogo-buddypress/
Author: Markus Echterhoff
Author URI: http://www.markusechterhoff.com
Version: 3.1
License: GPLv3 or later
*/

require_once( 'includes/registered-strings.php' );
require_once( 'includes/admin-xprofile.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_action( 'admin_notices', 'bogobud_bogoxlib_check' );
function bogobud_bogoxlib_check() {
	if ( !is_plugin_active( 'bogoxlib/bogoxlib.php' ) ) {
		echo '<div class="error"><p>Bogo BuddyPress requires BogoXLib to work. <a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=bogoxlib' . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about BogoXLib">Install BogoXLib</a>, activate it and then re-activate Bogo BuddyPress. <b>Deactivated</b>.</p></div>';
		deactivate_plugins( 'bogo-buddypress/bogo-buddypress.php' );
	}
}

register_activation_hook( __FILE__, 'bogobud_activate');
function bogobud_activate() {
	// rename xprofile data option from Bogo BuddyPress versions < 3.0
	global $wpdb;
	$wpdb->query( "UPDATE {$wpdb->options} SET option_name='bogobud_xprofile_data' WHERE option_name='bogobp_xprofile_data'" );
}
	
add_filter( 'bp_uri', 'bogobud_extract_lang_from_path_to_var', 11 ); // queued after regular filters
function bogobud_extract_lang_from_path_to_var( $uri ) {

	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) || !is_plugin_active( 'bogoxlib/bogoxlib.php' ) ) {
		return $uri;
	}

	// workaround for https://buddypress.trac.wordpress.org/ticket/6252#ticket
	if ( substr( $uri, 0, 1 ) != '/' ) {
		$uri = '/' . $uri;
	}

	$uri = bogoxlib_move_lang_slug_from_path_to_query_string( $uri );

	return $uri;
}

/* add lang to bp root domain */
add_filter( 'bp_core_get_root_domain', 'bogobud_append_lang_to_url', 11 ); // queued after regular filters
function bogobud_append_lang_to_url( $url ) {
	
	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		return $url;
	}
	
	// append '/de' to bp root
	// note: $url does not have trailing slash and no trailing slash should be returned to avoid double slashes
	$locale = get_locale();
	if ( $locale !=  bogo_get_default_locale() ) {
		return $url . '/' . bogo_lang_slug( $locale );
	}

	return $url;
}

add_filter( 'bp_xprofile_get_groups', 'bogobud_translate_xprofile_groups' );
function bogobud_translate_xprofile_groups( $groups ) {
	
	// leave them in default language in admin screen, no matter the currently active locale
	if ( is_admin() ) {
		return $groups;
	}

	$option = get_option( 'bogobud_xprofile_data' );
	if ( $option  === false ) {
		return $groups;
	}

	$locale = get_locale();

	foreach ( $groups as $group ) {
		if ( isset( $option[$locale][$group->id][0][0]['name'] ) ) {
			$group->name = $option[$locale][$group->id][0][0]['name'];
		}
		if ( isset( $option[$locale][$group->id][0][0]['dsc'] ) ) {
			$group->description = $option[$locale][$group->id][0][0]['dsc'];
		}
		foreach ( $group->fields as $field ) {
			if ( isset( $option[$locale][$group->id][$field->id][0] ) ) {
				$field->name = $option[$locale][$group->id][$field->id][0]['name'];
			}
			if ( isset( $option[$locale][$group->id][$field->id][0]['dsc'] ) ) {
				$field->description = $option[$locale][$group->id][$field->id][0]['dsc'];
			}
		}
	}

	return $groups;
}

add_filter( 'bp_xprofile_field_get_children', 'bogobud_translate_xprofile_children' );
function bogobud_translate_xprofile_children( $children ) {

	$option = get_option( 'bogobud_xprofile_data' );
	if ( $option  === false ) {
		return $children;
	}
	
	$locale = get_locale();

	foreach ( $children as $child ) {
		if ( isset( $option[$locale][$child->group_id][$child->parent_id][$child->id]['name'] ) ) {
			$child->name = $option[$locale][$child->group_id][$child->parent_id][$child->id]['name'];
		}
	}
	
	return $children;
}

add_action( 'template_redirect', 'bogobud_redirect_to_localized_url', 9 );
function bogobud_redirect_to_localized_url() {
	if ( !is_buddypress() ) {
		return;
	}
	bogoxlib_redirect_user_to_localized_url();
}

add_filter( 'bogo_language_switcher_links', 'bogobud_fix_language_switcher_links', 10, 2 );
function bogobud_fix_language_switcher_links( $links, $args ) {
	if ( is_buddypress() ) {
		return bogoxlib_fix_language_switcher_links( $links );
	}
	return $links;
}

add_action( 'plugins_loaded' , 'bogobud_translate_emails', ~PHP_INT_MAX );
function bogobud_translate_emails() {
	if ( !is_plugin_active( 'bogoxlib/bogoxlib.php' ) ) {
		return;
	}
	$slugs = array_map ( function($s){return '/'.$s.'/';}, array_keys( get_option( 'bp-pages' ) ) );
	bogoxlib_localize_emails_for( 'buddypress', $slugs, bogobud_registered_strings() );
}

?>

<?php
/*
Plugin Name: Bogo BuddyPress
Description: Make Bogo work with BuddyPress
Author: Markus Echterhoff
Author URI: http://www.markusechterhoff.com
Version: 2.1
License: GPLv3 or later
Text Domain: bogobp
Domain Path: /languages
*/
require_once( 'includes/admin-xprofile.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
add_filter( 'bp_uri', 'bogo_buddypress_localize_bp_uri', 11 );
function bogo_buddypress_localize_bp_uri( $uri ) {

	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		return $uri;
	}

	// workaround for https://buddypress.trac.wordpress.org/ticket/6252#ticket
	if ( substr( $uri, 0, 1 ) != '/' ) {
		$uri = '/' . $uri;
	}

	$site_url_parts = parse_url(site_url());
	if ( isset( $site_url_parts['path'] ) ) {
		$uri = preg_replace( '@^('.$site_url_parts['path'].')/'.bogo_get_lang_regex().'(/.*)$@', '$1$3?lang=$2', $uri );
	} else {
		$uri = preg_replace( '@^/'.bogo_get_lang_regex().'(/.*)$@', '$2?lang=$1', $uri );
	}

	return $uri;
}

add_filter( 'bp_core_get_root_domain', 'bogo_buddypress_localize_bp_root_domain', 11 );
function bogo_buddypress_localize_bp_root_domain( $url ) {

	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		return $url;
	}
	
	$locale = get_locale();
	if ( $locale !=  bogo_get_default_locale() ) {
		return $url . '/' . bogo_lang_slug( $locale );
	}
	
	return $url;
}

add_filter( 'bp_xprofile_get_groups', function( $groups ) {
	
	if ( is_admin() ) {
		return $groups;
	}
	
	$option = get_option( 'bogobp_xprofile_data' );
	if ( $option  === false ) {
		return $groups;
	}
	
	$locale = get_locale();

	foreach ( $groups as $group ) {
		$key = 'g' . $group->id;
		if ( isset( $option[$locale][$key]['name'] ) ) {
			$group->name = $option[$locale][$key]['name'];
		}
		if ( isset( $option[$locale][$key]['dsc'] ) ) {
			$group->description = $option[$locale][$key]['dsc'];
		}
		foreach ( $group->fields as $field ) {
			$key = 'f' . $field->id;
			if ( isset( $option[$locale][$key]['name'] ) ) {
				$field->name = $option[$locale][$key]['name'];
			}
			if ( isset( $option[$locale][$key]['dsc'] ) ) {
				$field->description = $option[$locale][$key]['dsc'];
			}
		}
	}

	return $groups;
});

?>

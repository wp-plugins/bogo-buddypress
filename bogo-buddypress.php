<?php
/*
Plugin Name: Bogo BuddyPress
Description: Make Bogo work with BuddyPress
Author: Markus Echterhoff
Author URI: http://www.markusechterhoff.com
Version: 3.0
License: GPLv3 or later
*/

require_once( 'includes/admin-xprofile.php' );
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
add_filter( 'bp_uri', 'bogo_buddypress_extract_lang_from_path_to_var', 11 ); // queued after regular filters
function bogo_buddypress_extract_lang_from_path_to_var( $uri ) {

	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		return $uri;
	}

	// workaround for https://buddypress.trac.wordpress.org/ticket/6252#ticket
	if ( substr( $uri, 0, 1 ) != '/' ) {
		$uri = '/' . $uri;
	}

	// transform /wordpress/de/ to /wordpress/?lang=de
	$uri = preg_replace( '@^('.trailingslashit(bogo_buddypress_get_site_path()).')'.bogo_get_lang_regex().'/(.*)$@', '$1$3?lang=$2', $uri );

	return $uri;
}

/* add lang to bp root domain */
add_filter( 'bp_core_get_root_domain', 'bogo_buddypress_append_lang_to_url', 11); // queued after regular filters
function bogo_buddypress_append_lang_to_url( $url ) {
	
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

add_filter( 'bp_xprofile_get_groups', 'bogo_buddypress_translate_xprofile_groups' );
function bogo_buddypress_translate_xprofile_groups( $groups ) {
	
	// leave them in default language in admin screen, no matter the currently active locale
	if ( is_admin() ) {
		return $groups;
	}

	$option = get_option( 'bogobp_xprofile_data' );
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

add_filter( 'bp_xprofile_field_get_children', 'bogo_buddypress_translate_xprofile_children' );
function bogo_buddypress_translate_xprofile_children( $children ) {

	$option = get_option( 'bogobp_xprofile_data' );
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

add_filter( 'bogo_language_switcher', 'bogo_buddypress_fix_language_switcher_links' );
function bogo_buddypress_fix_language_switcher_links( $output ) {

	if ( !is_buddypress() ) {
		return $output;
	}
	
	$dom = new DOMDocument;
	$dom->loadHTML( $output );
	foreach( $dom->getElementsByTagName( 'li' ) as $li) { // $li is of class DOMNode
	
		list( $item_locale_css, $item_lang ) = explode( ' ', $li->attributes->getNamedItem( 'class' )->value);
		$item_locale = str_replace( '-', '_', $item_locale_css);
		
		// skip item belonging to current locale
		$current_lang = get_query_var( 'lang' );
		if ( $current_lang == $item_lang ) {
			continue;
		}

		// construct uri
		$uri_site_path = bogo_buddypress_get_site_path();
		$path_remaining = substr( $_SERVER['REQUEST_URI'], strlen( $uri_site_path ), strlen( $_SERVER['REQUEST_URI'] ) - strlen( $uri_site_path ) );
		if ( $item_locale == bogo_get_default_locale() ) {
			$path_remaining = substr( $path_remaining, 3, strlen( $path_remaining ) - 3 );
			$uri =  $uri_site_path . $path_remaining;
		} else {
			$uri = $uri_site_path . '/'. $item_lang . $path_remaining;
		}
		
		$a = $dom->createDocumentFragment();
		$a->appendXML( '<a href="' . esc_url( $uri ) . '" hreflang="' . $item_locale_css . '" rel="alternate">' . $li->nodeValue . '</a>');
		$li->nodeValue = '';
		$li->appendChild( $a );
	}
	
	return $dom->saveHTML();
}

function bogo_buddypress_get_site_path() {
	$parts = parse_url( site_url() );
	if ( !isset( $parts['path'] ) ) {
		return '/';
	}
	return $parts['path'];
}

?>

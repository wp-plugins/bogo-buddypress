<?php

add_action('admin_menu', function() {
	
	if( !is_plugin_active( 'buddypress/bp-loader.php' ) ||
			!is_plugin_active( 'bogo/bogo.php' ) ||
			!bp_is_active( 'xprofile' ) ) {
		return;
	}
	
	$page_hook = add_users_page( _x( 'Bogo BuddyPress Extended Profile translation', 'admin page title', 'bogobp' ), 'BogoBP XProfile', 'manage_options', 'bogobp-xprofile-translation', 'bogobud_admin_display_xprofile_translation_page' );
	
	add_action( 'admin_print_styles-' . $page_hook, function() {
		wp_enqueue_style( 'bogobp-admin-xprofile', plugins_url( 'admin-xprofile.css', __FILE__ ) );
	});
});

function bogobud_admin_display_xprofile_translation_page() {
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		wp_die( __( 'Both Bogo and BuddyPress must be active to translate your Extended Profiles.' ) );
	}
	
	echo '<div id="bogobp-xprofile">';
	echo '<h1>Bogo BuddyPress Extended Profile translation</h1>';
	
	$default_locale = bogo_get_default_locale();
	$languages = array( $default_locale => bogo_get_language( $default_locale ) ) + bogo_available_languages();

	// adapted from BP_XProfile_Field::get_children() in bp-xrofile-classes.php
	global $wpdb, $bp;
	
	$group_objects = $wpdb->get_results( "SELECT * FROM {$bp->profile->table_name_groups} ORDER BY group_order;" );
	$groups = array();
	foreach ( $group_objects as $go ) {
		$groups[$go->id]['name'] = $go->name;
		$groups[$go->id]['dsc'] = $go->description;
		$groups[$go->id]['fields'] = array();
	}
	
	$field_objects = $wpdb->get_results( "SELECT * FROM {$bp->profile->table_name_fields} ORDER BY option_order, field_order, group_id;" );
	foreach ( $field_objects as $fo ) {
		if ( $fo->parent_id == 0 ) {
			$groups[$fo->group_id]['fields'][$fo->id]['name'] = $fo->name;
			$groups[$fo->group_id]['fields'][$fo->id]['dsc'] = $fo->description;
		} else {
			$groups[$fo->group_id]['fields'][$fo->parent_id]['children'][$fo->id]['name'] = $fo->name;
			$groups[$fo->group_id]['fields'][$fo->parent_id]['children'][$fo->id]['dsc'] = $fo->description;
		}
	}

	$option = get_option( 'bogobud_xprofile_data' );
	
	if ( isset( $_GET['save'] ) ) {
	
		$new_option = array();
		foreach ( $_POST as $id => $translation ) {
			list( $locale, $group_id, $field_id, $parent_id, $type ) = explode( '%', $id );
			$translation = sanitize_text_field( $translation );
			if ( $translation ) {
				$new_option[$locale][$group_id][$field_id][$parent_id][$type] = $translation;
			}
		}

		$success = true;
		if ( $new_option != $option ) {
			if ( $option === false ) {
				$success = add_option( 'bogobud_xprofile_data', $new_option, '', 'no' );
			} else {
				$success = update_option( 'bogobud_xprofile_data', $new_option );
			}
		}
		
		$option = $new_option;

		if ( $success ) {
			echo '<p class="success">' . __( 'Your translations have been saved.', 'bogobp' ) . '</span>';
		} else {
			echo '<p class="failure">' . __( 'An error occurred, please try again.', 'bogobp' ) . '</span>';
		}
	}
	
	echo '<form method="post" action="users.php?page=bogobp-xprofile-translation&save=1">';
		echo '<table><thead>';
			foreach ( $languages as $locale => $language ) {
				echo '<th>' . $language . '</th>';
			}
		echo '</thead><tbody>';
			echo '<tr class="empty"><td>&nbsp;</td></tr>';
			foreach ( $groups as $group_id => $group ) {
				bogobud_admin_display_xprofile_item_name( $languages, $default_locale, $option, $group, $group_id, 0, 0 );
				if ( isset( $group['dsc'] ) && !empty( $group['dsc'] ) ) {
					bogobud_admin_display_xprofile_item_description( $languages, $default_locale, $option, $group, $group_id, 0, 0 );
				}
				if ( !isset( $group['fields'] ) ) {
					continue;
				}
				foreach ( $group['fields'] as $field_id => $field ) {
					bogobud_admin_display_xprofile_item_name( $languages, $default_locale, $option, $field, $group_id, $field_id, 0 );
					if ( isset( $field['dsc'] ) && !empty( $field['dsc'] ) ) {
						bogobud_admin_display_xprofile_item_description( $languages, $default_locale, $option, $field, $group_id, $field_id, 0 );
					}
					if ( !isset( $field['children'] ) ) {
						continue;
					}
					foreach ( $field['children'] as $parent_id => $child ) {
						bogobud_admin_display_xprofile_item_name( $languages, $default_locale, $option, $child, $group_id, $field_id, $parent_id );
						if ( isset( $child['dsc'] ) && !empty( $child['dsc'] ) ) {
							bogobud_admin_display_xprofile_item_description( $languages, $default_locale, $option, $child, $group_id, $field_id, $parent_id );
						}
					}
				}
				echo '<tr class="empty"><td>&nbsp;</td></tr>';
			}
		echo '</tbody></table>';
		
		echo '<p class="submit"><input type="submit" class="button-primary" value="' . _x( 'Save Changes', 'admin save', 'bogobp' ) . '" /></p>';
		
	echo '</form>';
	echo '</div>';
}

function bogobud_admin_display_xprofile_item_name( $languages, $default_locale, $option, $item, $group_id, $field_id, $parent_id ) {
	echo '<tr>';
	foreach ( $languages as $locale => $language ) {
		echo '<td>';
		if ( $locale == $default_locale ) {
			echo '<span class="' . ( $field_id == 0 ? 'group' : ( $parent_id == 0 ? 'field' : 'child' ) ) . '">' . stripslashes_deep( esc_html( $item['name'] ) ) . '</span>';
		} else {
			$val = isset( $option[$locale][$group_id][$field_id][$parent_id]['name'] ) ? $option[$locale][$group_id][$field_id][$parent_id]['name'] : '';
			echo '<input name="' . $locale . '%' . $group_id . '%' . $field_id . '%' . $parent_id . '%name' . '" type="text" value="' . $val .'" />';
		}
		echo '</td>';
	}
	echo '</tr>';
}

function bogobud_admin_display_xprofile_item_description( $languages, $default_locale, $option, $item, $group_id, $field_id, $parent_id ) {
	echo '<tr>';
	foreach ( $languages as $locale => $language ) {
		echo '<td>';
		if ( $locale == $default_locale ) {
			echo '<p class="' . ( $field_id == 0 ? 'group' : ( $parent_id == 0 ? 'field' : 'child' ) ) . '">' . stripslashes_deep( esc_html( $item['dsc'] ) ) . '</p>';
		} else {
			$val = isset( $option[$locale][$group_id][$field_id][$parent_id]['dsc'] ) ? $option[$locale][$group_id][$field_id][$parent_id]['dsc'] : '';
			echo '<textarea name="' . $locale . '%' . $group_id . '%' . $field_id . '%' . $parent_id . '%dsc' . '">' . $val . '</textarea>';
		}
		echo '</td>';
	}
	echo '</tr>';
}

?>

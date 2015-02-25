<?php

add_action('admin_menu', function() {
	if( !is_plugin_active( 'buddypress/bp-loader.php' ) ||
			!is_plugin_active( 'bogo/bogo.php' ) ||
			!bp_is_active( 'xprofile' ) ) {
		return;
	}
	add_users_page( _x( 'Bogo BuddyPress Extended Profile translation', 'admin page title', 'bogobp' ), 'BogoBP XProfile', 'manage_options', 'bogobp-xprofile-translation', 'bogobp_admin_display_xprofile_translation_page' );
});

function bogobp_admin_display_xprofile_translation_page() {
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	if( !is_plugin_active( 'buddypress/bp-loader.php' ) || !is_plugin_active( 'bogo/bogo.php' ) ) {
		wp_die( __( 'Both Bogo and BuddyPress must be active to translate your Extended Profiles.' ) );
	}

	echo '<h1 style="margin-bottom:1.5em;">Bogo BuddyPress Extended Profile translation</h1>';
	
	$default_locale = bogo_get_default_locale();
	$languages = array( $default_locale => bogo_get_language( $default_locale ) ) + bogo_available_languages();
	
	$groups = bp_xprofile_get_groups( array(
			'hide_empty_groups'      => false,
			'hide_empty_fields'      => false,
			'fetch_fields'           => true,
		)
	);

	$option = get_option( 'bogobp_xprofile_data' );
	
	if ( isset( $_GET['save'] ) ) {
	
		$new_option = array();
		foreach ( $_POST as $locale_key => $translation ) {
			list( $locale, $key, $type ) = explode( '%', $locale_key );
			$translation = sanitize_text_field( $translation );
			if ( $translation ) {
				$new_option[$locale][$key][$type] = $translation;
			}
		}

		$success = true;
		if ( $new_option != $option ) {
			if ( $option === false ) {
				$success = add_option( 'bogobp_xprofile_data', $new_option, '', 'no' );
			} else {
				$success = update_option( 'bogobp_xprofile_data', $new_option );
			}
		}
		
		$option = $new_option;

		if ( $success ) {
			echo '<p style="color:green;font-size:1.5em;">' . __( 'Your translations have been saved.', 'bogobp' ) . '</span>';
		} else {
			echo '<p style="color:red;font-size:1.5em;">' . __( 'An error occurred, please try again.', 'bogobp' ) . '</span>';
		}
	}
	
	echo '<form method="post" action="users.php?page=bogobp-xprofile-translation&save=1">';
		echo '<table><thead>';
			foreach ( $languages as $locale => $language ) {
				echo '<th style="padding-bottom:10px;">' . $language . '</th>';
			}
		echo '</thead><tbody>';
			foreach ( $groups as $group ) {
				bogobp_display_xprofile_item_name( $languages, $default_locale, $option, $group );
				if ( isset( $group->description ) && !empty( $group->description ) ) {
					bogobp_display_xprofile_item_description( $languages, $default_locale, $option, $group );
				}
				foreach ( $group->fields as $field ) {
					bogobp_display_xprofile_item_name( $languages, $default_locale, $option, $field );
					if ( isset( $field->description ) && !empty( $field->description ) ) {
						bogobp_display_xprofile_item_description( $languages, $default_locale, $option, $field );
					}
				}
				echo '<tr><td>&nbsp;</td></tr>';
			}
		echo '</tbody></table>';
		
		echo '<p class="submit"><input type="submit" class="button-primary" value="' . _x( 'Save Changes', 'admin save', 'bogobp' ) . '" /></p>';
		
	echo '</form>';
}

function bogobp_display_xprofile_item_name( $languages, $default_locale, $option, $item ) {
	echo '<tr>';
	foreach ( $languages as $locale => $language ) {
		echo '<td>';
		if ( $locale == $default_locale ) {
			echo '<b>' . $item->name . '</b>';
		} else {
			$key = ( isset( $item->group_id ) ? 'f' : 'g' ) . $item->id;
			$val = isset( $option[$locale][$key]['name'] ) ? $option[$locale][$key]['name'] : '';
			echo '<input name="' . $locale . '%' . $key . '%name' . '" type="text" value="' . $val .'" />';
		}
		echo '</td>';
	}
	echo '</tr>';
}

function bogobp_display_xprofile_item_description( $languages, $default_locale, $option, $item ) {
	echo '<tr>';
	foreach ( $languages as $locale => $language ) {
		echo '<td>';
		if ( $locale == $default_locale ) {
			echo '<p style="max-width:250px;">' . $item->description . '</p>';
		} else {
			$key = ( isset( $item->group_id ) ? 'f' : 'g' ) . $item->id;
			$val = isset( $option[$locale][$key]['dsc'] ) ? $option[$locale][$key]['dsc'] : '';
			echo '<textarea name="' . $locale . '%' . $key . '%dsc' . '">' . $val . '</textarea>';
		}
		echo '</td>';
	}
	echo '</tr>';
}

?>

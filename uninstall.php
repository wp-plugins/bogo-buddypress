<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( 'bogobp_xprofile_data' );

?>

<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
/*===================
Clean up
====================*/
global $wpdb;
// Delete checkout fields settings
delete_option( 'expcod_fields' );
// Delete checkout stylings
delete_option( 'expcod_stylings' );
// Delete checkout Thank you page
delete_option( 'expcod_redirections' );
// Delete checkout Thank you page
delete_option( 'expcod_sheets' );
// Delete product meta 
$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'expcod\_%';" );
wp_cache_flush();
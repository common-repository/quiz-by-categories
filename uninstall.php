<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}csqsmquiz");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}csqsmsuitequiz");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}csqsmreponsesuite");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}csqsmusertoken");

?>

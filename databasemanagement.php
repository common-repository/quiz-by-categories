<?php
function csqsmmy_plugin_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'csqsmquiz';
/*
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		views smallint(5) NOT NULL,
		clicks smallint(5) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";*/

	$sql = "CREATE TABLE $table_name (
	  idquiz int(11) NOT NULL AUTO_INCREMENT,
	  idsuitequiz int(11) DEFAULT NULL,
	  question text NOT NULL,
	  reponse1 text NOT NULL,
	  reponse2 text NOT NULL,
	  reponse3 text NOT NULL,
	  reponse4 text NOT NULL,
	  reponse5 text NOT NULL,
	  bonne_reponse int(11) DEFAULT NULL,
	  texte_bonne_reponse text NOT NULL,
	  texte_mauvaise_reponse text NOT NULL,
		UNIQUE KEY idquiz (idquiz)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );


	$table_name = $wpdb->prefix . 'csqsmsuitequiz';

	$sql = "CREATE TABLE $table_name (
		idsuitequiz int(11) NOT NULL AUTO_INCREMENT,
		idcategorie int(11) NOT NULL,
		nomsuitequiz text NOT NULL,
		ishidden boolean NOT NULL DEFAULT 0,
		UNIQUE KEY idsuitequiz (idsuitequiz)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$table_name = $wpdb->prefix . 'csqsmreponsesuite';

	$sql = "CREATE TABLE $table_name (
		idreponsesuite int(11) NOT NULL AUTO_INCREMENT,
		iduser int(11) NOT NULL,
		idsuitequiz int(11) NOT NULL,
		nbrquestionsrepondues int(11) NOT NULL,
		nbrbonnesreponses int(11) NOT NULL,
		UNIQUE KEY idreponsesuite (idreponsesuite)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$table_name = $wpdb->prefix . 'csqsmusertoken';

	$sql = "CREATE TABLE $table_name (
		iduser int(11) NOT NULL AUTO_INCREMENT,
		token text NOT NULL,
		currentip INT UNSIGNED NOT NULL,
		lastupdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		UNIQUE KEY iduser (iduser)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
/*
function csqsmdestroydatabase(){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $sql = "DROP TABLE $table_name ";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $sql = "DROP TABLE $table_name ";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $sql = "DROP TABLE $table_name ";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  $table_name = $wpdb->prefix . 'csqsmusertoken';
  $sql = "DROP TABLE $table_name ";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );


}
*/


?>

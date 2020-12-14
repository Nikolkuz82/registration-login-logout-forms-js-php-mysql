<?php
//////////////////////////////////////////////////////////////////////////
/////================= Database connection settings =================/////
//////////////////////////////////////////////////////////////////////////

require_once('config.php');	// Includes configuration file of the project settings

$GLOBALS['db_link'] = mysqli_connect(	$GLOBALS['config']['db_con_sets']['db_server'],
										$GLOBALS['config']['db_con_sets']['db_user'],
										$GLOBALS['config']['db_con_sets']['db_user_password'],
										$GLOBALS['config']['db_con_sets']['db_title']);
mysqli_query($GLOBALS['db_link'], "SET character_set_results = 'utf8', 
							character_set_client = 'utf8', 
							character_set_connection = 'utf8',
							character_set_database = 'utf8', 
							character_set_server = 'utf8'");
?>
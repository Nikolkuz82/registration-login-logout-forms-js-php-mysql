<?php
//////////////////////////////////////////////////////////////////////////
/////================== Project configuration file ==================/////
//////////////////////////////////////////////////////////////////////////

$GLOBALS['config'] = array(                                                                                     // GLOBAL CONFIG
							'title' => 'RegMe',                                                         // Title of the project
							'db_con_sets' => array(                                                         // DB connection settings
													'db_server' => 'server_adress',                     // DB server adress
													'db_user' => 'username',		                    // DB username
													'db_user_password' => 'user_pass',				    // DB user password
													'db_title' => 'reg_auth_db',                        // DB title
													),
							'db_tbls' => array(                                                             // DB tables names
                                                'db_tbl_users' => 'users',                              // Name of DB table for user data
                                                'db_tbl_countries' => 'countries',                      // Name of DB table for countries data
												),
							'sv_unhashed_pass' => true,                                                 // Create field in users DB table and save unhashed user password: 'true' - yes, 'false' - no
							'db_tbl_crtr_pass' => 'password',	                                        // Password for table creation with db_table_creator.php script
							'hash_settings' => array(                                                       // Hash settings
														'options' => array('cost' => 10),               // Cost of password hash (default: 10)
														'algo' => PASSWORD_BCRYPT,                      // Algorithm for password hash (default: PASSWORD_BCRYPT)
														//'hash' => null,
													),
						);
?>
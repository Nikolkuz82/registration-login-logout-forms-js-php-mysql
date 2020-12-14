<?php
/////////////////////////////////////////////////////////////////////////////////
/////=========== Handler of registration and authorization forms ===========/////
/////=================== This script checks if user has ====================/////
/////========= pushed an authorization or registration button and ==========/////
/////============ processes registration or authorization form =============/////
/////////////////////////////////////////////////////////////////////////////////

function save_user_form_value($field){ // Saves the value of the form field entered by the user
	return isset($_POST[$field]) ? $_POST[$field] : null;
}

// Saves the values of the form fields entered by the user
function save_user_form_values($arr_name){
	if(!isset($_SESSION[$arr_name])){
		$_SESSION[$arr_name] = array();
	}
	$_SESSION[$arr_name]['name'] = save_user_form_value('name');
    $_SESSION[$arr_name]['email'] = save_user_form_value('email');
    $_SESSION[$arr_name]['login'] = save_user_form_value('login');
	$_SESSION[$arr_name]['birth_date'] = save_user_form_value('birth_date');
	$_SESSION[$arr_name]['country'] = save_user_form_value('country');
	$_SESSION[$arr_name]['password'] = save_user_form_value('password');
	$_SESSION[$arr_name]['password_2'] = save_user_form_value('password_2');
}

// Makes form value fields safe
function get_safe_post_fields(){
	$func_safe_post_fields_arr = array();
	$func_safe_post_fields_arr['name'] = make_post_field_safe('name'); // Makes form value [name] safe
    $func_safe_post_fields_arr['email'] = make_post_field_safe('email'); // Makes form value [email] safe
    $func_safe_post_fields_arr['login'] = make_post_field_safe('login'); // Makes form value [login] safe
    $func_safe_post_fields_arr['password'] = make_post_field_safe('password'); // Makes form value [password] safe
	$func_safe_post_fields_arr['password_2'] = make_post_field_safe('password_2'); // Makes form value [password_2] safe
	$func_safe_post_fields_arr['birth_date'] = make_post_field_safe('birth_date'); // Makes form value [birth_date] safe
	$func_safe_post_fields_arr['country'] = make_post_field_safe('country'); // Makes form value [country] safe
	return $func_safe_post_fields_arr;
}

function declare_registration_errors_arr(){ // Declares an array of registration errors
	if(!isset($_SESSION['registration_errors[]'])){
		$_SESSION['registration_errors[]'] = array();
	}
}

function set_error($error){ // Sets error to the array of registration errors
	declare_registration_errors_arr();
	array_push($_SESSION['registration_errors[]'], $error);
}

function set_error_field($error_field){ // Sets names of registration error fields and values(true/false) to the array
	declare_registration_error_fields_arr();
	$_SESSION['registration_error_fields_arr'][$error_field] = true;
}

// Checks the validity of registration fields.
//	Returns true if all fields are valid, otherwise
//	 sets an error array and returns false.
function registration_fields_valid(){
	$registration_fields_valid_flag = true;
	if($_POST['name'] == ''){
        set_error_field('name');
        $registration_fields_valid_flag = false;
    }
    if($_POST['email'] == ''){
        set_error_field('email');
        $registration_fields_valid_flag = false;
    }
    if($_POST['login'] == ''){
        set_error_field('login');
        $registration_fields_valid_flag = false;
    }
    if($_POST['password'] == ''){
        set_error_field('password');
        $registration_fields_valid_flag = false;
    }
    if($_POST['password_2'] == ''){
        set_error_field('password_2');
        $registration_fields_valid_flag = false;
	}
	if(!isset($_POST['country'])){
        set_error_field('country');
        $registration_fields_valid_flag = false;
    }
    if($registration_fields_valid_flag === false) {
        set_error("Fields marked with '*' must be filled in!");
    }    
	if($_POST['password'] != $_POST['password_2']){
        set_error_field('password');
        set_error_field('password_2');
		set_error("'Password' and 'Confirm password' fields do not match!");
		$registration_fields_valid_flag = false;
	}
	if(!preg_match("/(?=.*[0-9])(?=.*[a-z])[0-9a-zA-Z!@#$%^&*]{6,35}/", $_POST['password'])){
        set_error_field('password');
		set_error("Password does not meet the requirements! The password must be at least 6 and no more than 35 characters, consist of at least one digit and one lowercase Latin letter.");
		$registration_fields_valid_flag = false;
	}
	if(!preg_match("/(?=.*[a-z])[0-9a-zA-Z!@#$%^&*]{3,20}/", $_POST['login'])){
        set_error_field('login');
		set_error("Login is too short / long. Login must be at least 3 and no more than 20 characters, and consist of at least one Latin letter in lower case.");
		$registration_fields_valid_flag = false;
	}
	if(iconv_strlen($_POST['name'], 'utf-8') < 2 || iconv_strlen($_POST['name'], 'utf-8') > 30){
        set_error_field('name');
		set_error("Name is too short / long. The name must be at least 2 and no more than 30 characters.");
		$registration_fields_valid_flag = false;
	}
	if(!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email']) || iconv_strlen($_POST['email'], 'utf-8') > 50){
        set_error_field('email');
		set_error("E-mail does not meet the requirements! E-mail must contain the mailbox name, '@', server address, and be no more than 50 characters.");
		$registration_fields_valid_flag = false;
	}
	if(!preg_match("/^(\d{1,4})(\/|-)(\d{1,2})(\/|-)(\d{2})$/", $_POST['birth_date'])){
		set_error_field('birth_date');
		set_error("Birth date does not meet the requirements! Birth date must be like 'yyyy-mm-dd'.");
		$registration_fields_valid_flag = false;
	}
	if(!isset($_POST['terms_agree'])){
        set_error_field('terms_agree');
		set_error("No agreement with the terms! To register, you must agree to the terms.");
		$registration_fields_valid_flag = false;
	}
    return $registration_fields_valid_flag;
}

function login_or_email_registered(){ // Checks if a login or an email is in a database
	$safe_post_fields_arr = get_safe_post_fields();
	$email = $safe_post_fields_arr['email'];
	$login = $safe_post_fields_arr['login'];
	$sql_res = mysqli_query($GLOBALS['db_link'], "SELECT `id` FROM `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` WHERE `login`='".$login."' OR `email`='".$email."'") or die(mysqli_error($GLOBALS['db_link']));
    if(mysqli_num_rows($sql_res) != 0 ){ // Checks if there is a user record in the database with this $login or $email
		set_error_field('email');
		set_error_field('login');
		set_error("A user with this login and / or email already exists!");
		$login_or_email_registered_flag = true;
	}
	return $login_or_email_registered_flag;
}

function col_exists_in_db_tbl($table_name, $col_name){ // Checks if a column exists in the database
	$sql_res = mysqli_query($GLOBALS['db_link'], "SHOW COLUMNS FROM `".$table_name."` LIKE '".$col_name."'");
	return boolval(mysqli_num_rows($sql_res));
}

function add_new_user_to_database(){
	$add_user_error_flag = false; // Indicates an error occurred while adding a new user to the database
	$safe_post_fields_arr = get_safe_post_fields();
	$name = $safe_post_fields_arr['name'];
	$email = $safe_post_fields_arr['email'];
	$login = $safe_post_fields_arr['login'];
	$password = $safe_post_fields_arr['password'];
	$password_2 = $safe_post_fields_arr['password_2'];
	$birth_date = $safe_post_fields_arr['birth_date'];
	$country = $safe_post_fields_arr['country'];
	$password_hashed = password_hash($password, $GLOBALS['config']['hash_settings']['algo'], $GLOBALS['config']['hash_settings']['options']); //	Returns the hash of the $password
	$password_2_hashed = password_hash($password_2, $GLOBALS['config']['hash_settings']['algo'], $GLOBALS['config']['hash_settings']['options']); //	Returns the hash of the $password_2
	$timestamp = time(); // Stores Unix timestamp at $timestamp variable
	if(password_verify($password, $password_hashed) && // Verifies that $password matches $password_hashed
	   password_verify($password_2, $password_2_hashed)){ // Verifies that $password_2 matches $password_2_hashed	
		// Writes to a database table
		if(($GLOBALS['config']['sv_unhashed_pass'] === true) && (col_exists_in_db_tbl($GLOBALS['config']['db_tbls']['db_tbl_users'], 'password'))){
			$db_query = "INSERT INTO `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` SET `name`='".$name."',
																						   `email`='".$email."', 
																						   `login`='".$login."', 
																						   `password`='".$password."',											   
																						   `password_hash`='".$password_hashed."',											   
																						   `birth_date`='".$birth_date."', 
																						   `country`='".$country."',
																						   `timestamp`='".$timestamp."'";
		}
		else{
			$db_query = "INSERT INTO `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` SET `name`='".$name."',
																						   `email`='".$email."', 
																						   `login`='".$login."',											   
																						   `password_hash`='".$password_hashed."',											   
																						   `birth_date`='".$birth_date."', 
																						   `country`='".$country."',
																						   `timestamp`='".$timestamp."'";
			}
		$sql_res = mysqli_query($GLOBALS['db_link'], $db_query);
		if($sql_res != false ){	// Checks if the request was successful					   
			// Defines a new id
			$id = mysqli_insert_id($GLOBALS['db_link']); // Returns the auto generated id from the database table used in the latest query
			$sql_res = mysqli_query($GLOBALS['db_link'], "SELECT * FROM `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` WHERE `id`='".$id."'"); // Gets a value from a database table
			if($sql_res != false ){	// Checks if the request was successful
				$usr_data_arr = mysqli_fetch_assoc($sql_res);	// Sets an array of user data		
				$_SESSION['id'] = $usr_data_arr['id']; // Stores the id in the session
				$id = $_SESSION['id']; // Assigns the id to $id variable
			}
			else{
				$add_user_error_flag = true;
			}
		}
		else{
			$add_user_error_flag = true;
		}
	}
	if($add_user_error_flag === false){
		set_message("You are registered successfully!"); // Sets a registration message
	}		
	else{
		set_message("Oops! Something went wrong ... Try again."); // Sets a registration message
	}
}


require_once('../settings/config.php');	// Includes configuration file of the project settings
require_once('../settings/db_connection.php');	// Includes file with database connection settings
require_once('../inclusions/functions.php');	// Includes file with custom functions

session_start();	// Stars a session

// Registration form handler
if(isset($_POST['btn_try_reg'])){ // Checks if user has pushed a registration button
	if(!registration_fields_valid()){	// If registration fields are not valid then
		save_user_form_values('user_reg_form_values_arr'); // save the values of the form fields entered by the user
		forward_to_location('registration_authorization.php');	// redirect to the === Registration-Authorization page ===
	}
    else{
		if(login_or_email_registered()){ // If login or email is occupied then
			save_user_form_values('user_reg_form_values_arr'); // save the values of the form fields entered by the user
			forward_to_location('registration_authorization.php');	// redirect to the === Registration-Authorization page ===
		}
        else{
			add_new_user_to_database('user_reg_form_values_arr');	// Adds a new record to database table
			forward_to_location('index.php');	// Redirect to the === User page ===
		}
	}
}

// Authorization form handler
elseif(isset($_POST['btn_try_auth'])){	// Checks if user has pushed an authorization button
	$safe_post_fields_arr = get_safe_post_fields();
	$login = $safe_post_fields_arr['login'];
	$password = $safe_post_fields_arr['password'];
	$password_hashed = password_hash($password, $GLOBALS['config']['hash_settings']['algo'], $GLOBALS['config']['hash_settings']['options']); // Returns the hash of the $password
	$sql_res = mysqli_query($GLOBALS['db_link'], "SELECT * FROM `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` WHERE `login`='".$login."' OR `email`='".$login."'") or die(mysqli_error($GLOBALS['db_link']));	// Gets a value from a database table
    if(mysqli_num_rows($sql_res) != 0 ){	// Checks if there is a user record in the database with this $login
        $usr_data_arr = mysqli_fetch_assoc($sql_res);	// Sets an array of user data
		if(password_verify($password, $password_hashed)) {	// Verifies that $password matches $password_hashed
			if(password_verify($password, $usr_data_arr['password_hash'])){ // Verifies that $password matches password_hash from the array of user data
				$_SESSION['id'] = $usr_data_arr['id']; // Stores the id in the session
				forward_to_location('index.php');	// If success then redirect === User page ===
			}
			else{
				save_user_form_values('user_auth_form_values_arr'); // Save the values of the form fields entered by the user
				set_message("Invalid username and / or password!");	// Sets an authorization message
				forward_to_location('registration_authorization.php');	// Redirect to the === Registration-Authorization page ===
			}
		}
		else{
			save_user_form_values('user_auth_form_values_arr'); // Save the values of the form fields entered by the user
			set_message("Oops! Something went wrong ... Try again."); // Sets a registration message
			forward_to_location('registration_authorization.php');	// Redirect to the === Registration-Authorization page ===
		}
	}
	else{
		save_user_form_values('user_auth_form_values_arr');
		set_message("User not found!");	// Sets an authorization message
		forward_to_location('registration_authorization.php');	// Redirect to the === Registration-Authorization page ===
	}
}

// Checks if user has pushed a 'refresh page' button
elseif(isset($_POST['btn_rfrsh_pg'])){
	unset($_GET['btn_rfrsh_pg']);
	clean_arr('user_reg_form_values_arr');
	clean_arr('user_auth_form_values_arr');
	clean_arr('registration_error_fields_arr');
	forward_to_location('registration_authorization.php'); // Redirect to the === Registration-Authorization page ===
}

// If no button has been pushed check if user is authorized and redirect
else{
	if(user_authorized()){
		forward_to_location('index.php'); // Redirect to the === User page ===
	}
	else{
		forward_to_location('registration_authorization.php'); // Redirect to the === Registration-Authorization page ===
	}
}
?>
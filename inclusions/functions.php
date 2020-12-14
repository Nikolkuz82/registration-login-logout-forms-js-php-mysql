<?php
//////////////////////////////////////////////////////////////////////////
/////======================= Custom functions =======================/////
//////////////////////////////////////////////////////////////////////////

require_once('../settings/config.php');	// Includes configuration file of the project settings
require_once('../settings/db_connection.php');	// Includes file with database connection settings

// For forwarding to new location
function forward_to_location($location){
	header("location: $location"); 
	exit;
}

// Checks if user is logged in
function user_authorized(){
    return isset($_SESSION['id']);
}

// Retrieves data from the database table and forms an array
function get_tbl_data($table_name){
    $func_sql_res = mysqli_query($GLOBALS['db_link'], "SELECT * FROM ".$table_name."");
    $tbl_arr = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($func_sql_res)) {
        $tbl_arr[$i]['name'] = $row["name"];
        $tbl_arr[$i]['alpha2_code'] = $row["alpha2_code"];
        $i++;
    }
    return $tbl_arr;
}

// Sets message
function set_message($message){
    $_SESSION['msg'] = $message;
}

// Shows message
function show_message(){
    if(isset($_SESSION['msg'])){
        echo '<br /><span class="message-title">Message:</span><span class="message-item"> ' . $_SESSION['msg'] . '</span><br />';
        unset ($_SESSION['msg']);
    }
}

// Cleans the array
function clean_arr($arr_name){
    if(isset($_SESSION[$arr_name])){
        unset ($_SESSION[$arr_name]);
    }
}

// Declares an array of registration error fields names
function declare_registration_error_fields_arr(){
	if(!isset($_SESSION['registration_error_fields_arr'])){
        $_SESSION['registration_error_fields_arr'] = array( 'name' => false,
                                                            'email' => false,
                                                            'login' => false,
                                                            'password' => false,
                                                            'password_2' => false,
                                                            'country' => false,
                                                            'birth_date' => false,
                                                            'terms_agree' => false,
                                                            );
	}
}

// Checks if the field name is in an array of registration error fields names
function is_error_field($field){
    declare_registration_error_fields_arr();
    return $_SESSION['registration_error_fields_arr'][$field] === true ? true : false;
}

// Returns the value of the form field entered by the user
function get_user_form_value($arr_name, $field){
	return isset($_SESSION[$arr_name][$field]) ? $_SESSION[$arr_name][$field] : null;
}

// Sets the 'value' option of the form field
function set_user_form_value($arr_name, $field){
    $value = get_user_form_value($arr_name, $field);
    $value = !empty($value) ? ('value="' . $value . '"') : '';
    return $value;
}

// Changes the color of the border of the form field depending on the correct value
function set_border_style($field){
    $value = is_error_field($field) ? 'style="border: rgb(202, 36, 36) 1px solid;"' : '';
    return $value;
}

// Sets dynamic parameters of an HTML tag
function form_dynamic_html_options($arr_name, $field){
    $border_style = set_border_style($field);
    $user_form_value = set_user_form_value($arr_name, $field);
    echo $border_style . ' ' . $user_form_value;
}

// Makes form value [$field] safe
function make_post_field_safe($field){
	return isset($_POST[$field]) ? mysqli_real_escape_string($GLOBALS['db_link'], $_POST[$field]) : null;
}

// For encoding html special chars (XSS injections protection)
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_HTML5);
//
function encode_html($string){
    return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}

// Prints the $arr_name array from the $global_arr_name global array 
// Used for debugging
/* Usage examples:
    print_ses_arr($GLOBALS, 'config'); // Prints the 'config' array from the '$GLOBALS' global array
    print_ses_arr($_SESSION, 'registration_error_fields_arr'); // Prints the 'registration_error_fields_arr' array from the '$_SESSION' global array
    print_ses_arr($_SESSION, 'registration_errors'); // Prints the 'registration_errors' array from the '$_SESSION' global array
    print_ses_arr($_SESSION, 'user_reg_form_values_arr'); // Prints the 'user_reg_form_values_arr' array from the '$_SESSION' global array
    print_ses_arr($_SESSION, 'user_auth_form_values_arr'); // Prints the 'user_auth_form_values_arr' array from the '$_SESSION' global array
*/
/*
function print_ses_arr($global_arr_name, $arr_name) {
    echo '<br />';
    if(isset($global_arr_name[$arr_name])) {
        echo "Array $arr_name: ";
        print_r($global_arr_name[$arr_name]);
        echo '<br />';
    }
    elseif(empty($global_arr_name[$arr_name])) {
        echo "Array $arr_name is empty";
        echo '<br />';
    }
    else {
        echo "Array $arr_name is not set";
        echo '<br />';
    }
    echo '<br />';
}
*/
?>
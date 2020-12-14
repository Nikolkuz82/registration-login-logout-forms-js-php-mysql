<?php
/////////////////////////////////////////////////////////////////////////////////
/////=================== Registration-Authorization page ===================/////
/////==================== This script checks if user is ====================/////
/////===== authenticated and calls registration or authorization form ======/////
/////=== or a custom banner page, e.g. suggestion to register or log in, ===/////
/////============= shows registration or authorization errors ==============/////
/////////////////////////////////////////////////////////////////////////////////

require_once('../settings/config.php');	// Includes configuration file of the project settings
require_once('../inclusions/functions.php');	// Includes file with custom functions

header("content-type: text/html; charset=utf-8");	// Sets encoding of the page

session_start();	// Stars a session

if (user_authorized()){	// If user is logged in then redirect
	forward_to_location('index.php');	// to the === User page ===
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="../images/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?=$GLOBALS['config']['title']?> — Registration - Authorization</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>

    <body>
    <div class="centered">
        <form action="" method="post">
            <button class="btn" name="btn_auth" type="submit">Log in</button>
            <button class="btn" name="btn_reg" type="submit">Register</button>
        </form>
        <br />
	
<?php
// Show registration or authorization errors or message
show_message(); // Show message
 
// Show registration errors
if(isset($_SESSION['registration_errors[]'])){
	if(!empty($_SESSION['registration_errors[]'])){
		echo '<br /><span class="message-title">Registration errors:</span><br />';
		foreach($_SESSION['registration_errors[]'] as $arr_key => $arr_value){
			echo '<span class= "sz-16-pt">' . ($arr_key + 1) . '. ' . $arr_value . '</span><br />';
		}
		echo '<br />';
	}
	unset ($_SESSION['registration_errors[]']);
}

// Show registration or authorization form or a custom banner page
// Show authorization form
if(isset($_POST['btn_auth'])){ // Checks if user has pushed an authorization button
    require_once('authorization.php'); // Includes file of with authorization form
    unset($_GET['btn_auth']);
    clean_arr('user_auth_form_values_arr');
    clean_arr('user_reg_form_values_arr');
    clean_arr('registration_error_fields_arr');
}

// Show registration form
elseif(isset($_POST['btn_reg'])){ // Checks if user has pushed a registration button
    require_once('registration.php'); // Includes file of with registration form
	unset($_GET['btn_reg']);
    clean_arr('user_reg_form_values_arr');
    clean_arr('user_auth_form_values_arr');
    clean_arr('registration_error_fields_arr');
}

// Show a custom banner page
else{
	require_once('banner.php'); // Includes file with banner message
}
?>

        </div>
    </body>
</html>
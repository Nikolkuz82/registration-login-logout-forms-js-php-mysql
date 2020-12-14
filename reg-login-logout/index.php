<?php
/////////////////////////////////////////////////////////////////////////////////
/////============================== User page ==============================/////
/////==================== This script checks if user is ====================/////
/////================= authenticated and greets him / her ==================/////
/////========= or redirects to the Registration-Authorization page =========/////
/////////////////////////////////////////////////////////////////////////////////

require_once('../settings/config.php');	// Includes configuration file of the project settings
require_once('../settings/db_connection.php');	// Includes file with database connection settings
require_once('../inclusions/functions.php');	// Includes file with custom functions

header("content-type: text/html; charset=utf-8");	// Sets encoding of the page

session_start();	// Stars a session

if(!user_authorized()){	// If user is not logged in then redirect
	forward_to_location('registration_authorization.php');	// to the === Registration-Authorization page ===
}
$id = $_SESSION['id'];	// Sets user $id from the session
$usr_data_arr = mysqli_fetch_assoc(mysqli_query($GLOBALS['db_link'], "SELECT * FROM `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` WHERE `id`='$id'"));	// Gets a value from a database table and sets an array of user data
if(isset($_GET['btn_logout'])){	// Checks if user has pushed an 'Log out' button
	session_destroy();	// Destroys session (unsets session variables)
	unset($_GET['btn_logout']);
	forward_to_location('registration_authorization.php');	// Redirect to the === Registration-Authorization page ===
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="../images/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?=$GLOBALS['config']['title']?> — Greeting Authorized User</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>

    <body>
        <div class="centered greeting">
            <p>
                Welcome, <span class="bold-text"><?=encode_html($usr_data_arr['name'])?></span>!
            </p>
            <p>
<?php
show_message(); // Show message
?>
            </p>
            <br />
            <p>
                <span class="bold-text">Your info:</span>
            </p>
            <p>
                <span class="bold-text">Name:</span> <?=encode_html($usr_data_arr['name'])?>
            </p>
            <p>
                <span class="bold-text">E-mail:</span> <?=encode_html($usr_data_arr['email'])?>
            </p>
            <br /> <br />
            <form action="" method="get">
                <input class="btn" name="btn_logout" value="Log out" type="submit">
            </form>
        </div>
    </body>
</html>

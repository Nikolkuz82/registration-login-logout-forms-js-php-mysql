<?php
require_once('settings/config.php');	// Includes configuration file of the project settings
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="images/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= $GLOBALS['config']['title'] ?> — Main Page</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
    <div class="centered">
        <a class = "btn" href="reg-login-logout/registration_authorization.php">Log in</a>
    </div>
    </body>
</html>
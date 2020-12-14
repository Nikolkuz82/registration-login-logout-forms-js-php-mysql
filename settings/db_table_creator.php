<?php
/////////////////////////////////////////////////////////////////////////////////
/////======================= Database table creator ========================/////
/////========================= This script creates =========================/////
/////=========== database tables required for the project to run ===========/////
/////=========== and loads countries data to the 'country' table ===========/////
/////////////////////////////////////////////////////////////////////////////////

require_once('config.php');	// Includes configuration file of the project settings

header("content-type: text/html; charset=utf-8");	// Sets encoding of the page
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="../images/favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=$GLOBALS['config']['title']?> — Database Tables Creator</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
  <div class="centered">

<?php
echo "<br /><span style=\"font-size:16pt;
                          font-weight:bold;\">Type the correct password in the 'Password' field and click the button below to create all the database tables required to run the '".$GLOBALS['config']['title']."' project.<br />Wait until you see the result message.</span><br /><br />";
?>

		<form action="" method="post">
			<p style="margin-bottom:5px;">
                <input class="reg-auth-inpt" style="width:215px;
                                                    text-align:center;" name="db_tbl_crtr_password" type="password" placeholder="Password">
			</p>
            <button class="btn" name="btn_crt_tbls" type="submit">Create DB tables</button>
			<button class="btn" name="btn_rfrsh_pg" type="submit">Refresh this page</button>
		</form>
		<br />

<?php
if(isset($_POST['btn_crt_tbls'])){
	$_SESSION['db_tbls_crt_result[]'] = array();
	if(isset($_POST['db_tbl_crtr_password'])){
		$db_tbl_crtr_password = $_POST['db_tbl_crtr_password'];
		unset($_POST['db_tbl_crtr_password']);
	}
	else{
		$db_tbl_crtr_password = null;
	}
	if($db_tbl_crtr_password === $GLOBALS['config']['db_tbl_crtr_pass']) { 
        require_once('db_connection.php');	// Includes file with database connection settings
        require_once('../inclusions/countries.php');	// Includes file with an array of countries
        
        function table_exists($table_name) { // Checks if table exists in DB
			$func_sql_res = mysqli_query($GLOBALS['db_link'], "SELECT 1 FROM `".$table_name."` LIMIT 1");
			return $func_sql_res !== false ? true : false;
        }
        
        function db_tbl_empty($table_name){ // Checks if table DB table is empty
            $tbl_arr_row = mysqli_fetch_assoc(mysqli_query($GLOBALS['db_link'], "SELECT * FROM `".$table_name."`"));
            return empty($tbl_arr_row) !== false ? true : false;
        }
        
        // Table 'users'
		if(!table_exists($GLOBALS['config']['db_tbls']['db_tbl_users'])){
			if($GLOBALS['config']['sv_unhashed_pass'] === true){
				$db_query = "CREATE TABLE IF NOT EXISTS `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` (
										`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique user ID',
										`name` varchar(30) NOT NULL COMMENT 'Username',
										`login` varchar(20) NOT NULL COMMENT 'User login',
										`password` varchar(35) NOT NULL DEFAULT '--- COLUMN NOT IN USE ---' COMMENT 'User password',
										`password_hash` varchar(255) NOT NULL COMMENT 'User password hash',
										`email` varchar(50) NOT NULL COMMENT 'User email',
										`birth_date` date NOT NULL COMMENT 'User Birth Date',
										`country` varchar(35) NOT NULL COMMENT 'User Country',
                                        `timestamp` int NOT NULL COMMENT 'Unix timestamp',
										PRIMARY KEY (`id`)
										)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 DEFAULT COLLATE=utf8_general_ci;";
			}
			else{
				$db_query = "CREATE TABLE IF NOT EXISTS `".$GLOBALS['config']['db_tbls']['db_tbl_users']."` (
										`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique user ID',
										`name` varchar(30) NOT NULL COMMENT 'Username',
										`login` varchar(20) NOT NULL COMMENT 'User login',
										`password_hash` varchar(255) NOT NULL COMMENT 'User password hash',
										`email` varchar(50) NOT NULL COMMENT 'User email',
										`birth_date` date NOT NULL COMMENT 'User birth date',
										`country` varchar(35) NOT NULL COMMENT 'User country',
                                        `timestamp` int NOT NULL COMMENT 'Unix timestamp',
										PRIMARY KEY (`id`)
										)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 DEFAULT COLLATE=utf8_general_ci;";
			}
			if(mysqli_query($GLOBALS['db_link'], $db_query) === true){
				if($GLOBALS['config']['sv_unhashed_pass'] === true) {
					array_push($_SESSION['db_tbls_crt_result[]'], "The '".$GLOBALS['config']['db_tbls']['db_tbl_users']."' table has been successfully created. A field for an unhashed user password has been created and will be used during user registration.");
				}
				else {
					array_push($_SESSION['db_tbls_crt_result[]'], "The '".$GLOBALS['config']['db_tbls']['db_tbl_users']."' table has been successfully created. A field for an unhashed user password has not been created and will not be used during user registration.");
				}
			}
        }
        else{
            array_push($_SESSION['db_tbls_crt_result[]'], "The '".$GLOBALS['config']['db_tbls']['db_tbl_users']."' table already exists.");
        }

        // Table 'countries'
        if(!table_exists($GLOBALS['config']['db_tbls']['db_tbl_countries'])){
            $db_query = "CREATE TABLE IF NOT EXISTS `".$GLOBALS['config']['db_tbls']['db_tbl_countries']."` (
                                    `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique country ID',
                                    `name` varchar(50) NOT NULL COMMENT 'Country name',
                                    `alpha2_code` varchar(2) NOT NULL COMMENT 'Country Alpha-2 code',
                                    PRIMARY KEY (`id`)
                                    )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 DEFAULT COLLATE=utf8_general_ci;";        
            if(mysqli_query($GLOBALS['db_link'], $db_query) === true){
                array_push($_SESSION['db_tbls_crt_result[]'], "The '".$GLOBALS['config']['db_tbls']['db_tbl_countries']."' table has been successfully created.");
            }
        }
        else{
            array_push($_SESSION['db_tbls_crt_result[]'], "The '".$GLOBALS['config']['db_tbls']['db_tbl_countries']."' table already exists.");
        }

        // Fill the 'countries' table from the 'countries_arr' array
        if(table_exists($GLOBALS['config']['db_tbls']['db_tbl_countries']) && db_tbl_empty($GLOBALS['config']['db_tbls']['db_tbl_countries'])){
            $countries_tbl_arr = mysqli_fetch_assoc(mysqli_query($GLOBALS['db_link'], "SELECT * FROM `".$GLOBALS['config']['db_tbls']['db_tbl_countries']."` ORDER BY `id`"));	// Gets a values from a database table and sets an array of countries
            $countries_loaded = false;
            foreach($countries_arr as $arr_key => $arr_value){
                $db_query = "INSERT INTO `".$GLOBALS['config']['db_tbls']['db_tbl_countries']."` SET `name`='".$arr_value."',
                                                                                                   `alpha2_code`='".$arr_key."'";
                if(mysqli_query($GLOBALS['db_link'], $db_query) === true){
                    $countries_loaded = true;
                }
            }
            if($countries_loaded === true){
                array_push($_SESSION['db_tbls_crt_result[]'], "Names and Alpha-2 codes of the countries has been loaded to the '".$GLOBALS['config']['db_tbls']['db_tbl_countries']."' table.");
            }
            else{
                array_push($_SESSION['db_tbls_crt_result[]'], "Names and Alpha-2 codes of the countries has not been loaded to the '".$GLOBALS['config']['db_tbls']['db_tbl_countries']."' table.");
                }
        }

        $res = db_tbl_empty($GLOBALS['config']['db_tbls']['db_tbl_countries']);        

		mysqli_close($GLOBALS['db_link']);
    }
	else{
		array_push($_SESSION['db_tbls_crt_result[]'], "Wrong Password! Try again.");
	}
	unset($_POST['btn_crt_tbls']);
}
elseif(isset($_POST['btn_rfrsh_pg'])){ // Checks if user has pushed a 'refresh page' button
	if(isset($_POST['db_tbl_crtr_password'])){
		unset($_POST['db_tbl_crtr_password']);
	}
	unset($_POST['btn_rfrsh_pg']);
	header('location: db_table_creator.php');
	exit;
}
// Shows result message
if(isset($_SESSION["db_tbls_crt_result[]"])){
	if(!empty($_SESSION["db_tbls_crt_result[]"])){
		echo "<br /><span style = \"font-size:18pt;
							 font-weight:bold;
							 text-decoration:underline;\">RESULT:</span><br />";
		foreach($_SESSION['db_tbls_crt_result[]'] as $arr_key => $arr_value){
			echo "<span style = \"font-size:16pt;\">" . ($arr_key + 1) . ". " . $arr_value . "</span><br />";
		}
		echo "<br />";
	}
	unset ($_SESSION['db_tbls_crt_result[]']);
}
?>	
	
	</div>
</body>
</html>
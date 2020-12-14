<?php
/////////////////////////////////////////////////////////////////////////////////
/////============================= Banner page =============================/////
/////=========================== This script is ============================/////
/////============== a part of Registration-Authorization page ==============/////
/////================= It welcomes the user to the project =================/////
/////////////////////////////////////////////////////////////////////////////////

require_once('../settings/config.php');	// Includes configuration file of the project settings
?>
<div class="greeting">
	<p class="sz-18-pt">Welcome to the <span class="bold-text"><?=$GLOBALS['config']['title']?></span> project!</p>
	<p class="sz-16-pt">Please log in or register to continue.</p>
</div>
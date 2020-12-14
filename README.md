# registration-login-logout-forms-js-php
Registration / Login / Logout forms built with JS / PHP / MySQL / HTML / CSS

---

## How to use
1. **Copy all files except '_.gitignore_' and '_README.md_' from the repository to the root folder of the web-server (e.g. 'www').** **Note:** _do not change the location of files in directories._
2. **Consider whether you want to store unhashed user passwords in the database (default is to store).** To customize it, change the '_sv_unhashed_pass_' key value: _true_ - option is **enabled**, _false_ - option is **disabled** (**default** is '_true_'). If you just want to see how the project works, you can leave this option enabled. If the option was enabled in this step (before step 5), it can be disabled during project execution (enabling this option after step 5 will not produce the desired result). **Note:** _do not put 'true' and 'false' inside the quotes (correct: true, false; incorrect: 'true', 'false')._ 
**Note:** _to store unprotected (unhashed) passwords might be dangerous._
3. **Create MySQL database and user, grant all privileges to the user in the database.** Make a note of the following: MySQL server address, database name, username and user password.
4. **Change the database connection settings.** Open the project configuration file ('_web server directory/settings/config.php_') and change the values of the following keys: '_db_server_', '_db_user_', '_db_user_password_', '_db_title_' to the values obtained in the previous step. Just replace the lines '_server_adress_', '_username_', '_user_pass_', '_reg_auth_db_'. **Template:** '_setting_' => '_value_'. **Note:** Don't forget about single quotes.
5. **Change password needed to create required database tables.** Open configuration file of the project ('_web_server_root/settings/config.php_') and replace value '_password_' of the key '_db_tbl_crtr_pass_' with your new password.
6. **Create the database tables required to run the project.** Start your web-server, go to your web-browser and enter the following address: '_your_web_server_adress/settings/db_table_creator.php_'. Enter the password that you set in step 4 into the field, click the '_Create DB tables_' button and wait until you see the result message.
7. **(Optional) Delete unnecessary files.** Delete the following files:
    - '_countries.php_' from '_web_server_root/inclusions/_'
    - '_db_table_creator.php_' from '_web_server_root/inclusions/_'
8. **Start using.** Open a new tab and enter the following adress: '_your_web_server_adress_'. Click the '_Log in_' button. After that click the '_Register_' or '_Log in_' button and follow the instructions.
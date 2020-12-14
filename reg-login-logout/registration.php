<?php
/////////////////////////////////////////////////////////////////////////////////
/////========================== Registration page ==========================/////
/////=========================== This script is ============================/////
/////============== a part of Registration-Authorization page ==============/////
/////=================== It generates registration form ====================/////
/////////////////////////////////////////////////////////////////////////////////
?>
<div class = "reg-auth-form">
	<p class="rules">
		<span class="rules-title">Fields input requirements:</span>
		<ol class="rules-list">
			<li>Fields marked with '*' must be filled in.</li>
			<li>The 'Password' and 'Confirm password' fields are used to confirm the password. Both must be filled in and have the same value.</li>
			<li>The password must be at least 6 and no more than 35 characters, consist of at least one digit and one lowercase Latin letter.</li>
			<li>Login must be at least 3 and no more than 20 characters, and consist of at least one Latin letter in lower case.</li>
			<li>The name must be at least 2 and no more than 30 characters.</li>
			<li>E-mail must contain the mailbox name, '@', server address, and be no more than 50 characters.</li>
            <li>The phone number must be no more than 16 characters.</li>
            <li>Birth date must be like 'yyyy-mm-dd'.</li>
            <li>To register, you must agree to the terms.</li>
		</ol>
	</p>

  <form action="handler.php" method="post">
    <p>
        <input class="reg-auth-inpt" name="email" type="email" placeholder="* E-mail" <?= form_dynamic_html_options('user_reg_form_values_arr', 'email'); ?>>
    <p>
    <p>
        <input class="reg-auth-inpt" name="login" type="text" placeholder="* Login" <?= form_dynamic_html_options('user_reg_form_values_arr', 'login'); ?>>
    </p>
    <p>
        <input class="reg-auth-inpt" name="name" type="text" placeholder="* Real name" <?= form_dynamic_html_options('user_reg_form_values_arr', 'name'); ?>>
    </p>
    <p>
        <input class="reg-auth-inpt" name="password" type="password" placeholder="* Password" <?= $border_style = set_border_style('password');
                                                                                                    echo $border_style ?>>
    </p>
    <p>
        <input class="reg-auth-inpt" name="password_2" type="password" placeholder="* Confirm password" <?= $border_style = set_border_style('password_2');
                                                                                                            echo $border_style ?>>
    </p>
    <p>
         <input class="reg-auth-inpt" name="birth_date" type="date" placeholder="Birth Date" <?= form_dynamic_html_options('user_reg_form_values_arr', 'birth_date'); ?>>
    </p>
    <p>
        <select class="reg-auth-inpt-slct" name="country" <?= $border_style = set_border_style('country');
                                                                echo $border_style ?>>  

<?php
    $countries_arr = get_tbl_data('countries'); // Get data from 'countries' database table

    // Form <option> tags
    $country = get_user_form_value('user_reg_form_values_arr', 'country');
    $country_val_set = true; // Flag for checking if the 'country' field has been entered by the user
    if(empty($country)){ // If the $country variable is empty
        $country_val_set = false; // Set the flag to 'false'
        echo '<option selected disabled>* Choose your country</option>'; // Form a tag for a prompt option and select it
    }
    else{ // If the $country variable is not empty
        echo '<option disabled>* Choose your country</option>'; // Form a tag for a prompt option
    }
    // Form other <option> tags
    for($i = 0; $i < (count($countries_arr)); $i++){
        if(($country_val_set) && ($countries_arr[$i]['alpha2_code'] === $country)){ // If the flag set to the true
            echo '<option selected value="'.$countries_arr[$i]['alpha2_code'].'">'.$countries_arr[$i]['name'].'</option>'; // then select this country option
            continue;
        }
        echo '<option value="'.$countries_arr[$i]['alpha2_code'].'">'.$countries_arr[$i]['name'].'</option>'; // Form the <option> tag
    }
?>
            
        </select>
    </p>
    <p class="al-left">
        <input class="check-box" name="terms_agree" type="checkbox">
            <span class="terms"> Agree with terms and conditions</span>
        </input>
    </p>
    <p>
        <button class="btn" name="btn_try_reg" type="submit">Register</button>
        <button class="btn" name="btn_rfrsh_pg" type="submit">Refresh page</button>
    </p>
  </form>
</div>
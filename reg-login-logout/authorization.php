<?php
/////////////////////////////////////////////////////////////////////////////////
/////========================= Authorization page ==========================/////
/////=========================== This script is ============================/////
/////============== a part of Registration-Authorization page ==============/////
/////=================== It generates registration form ====================/////
/////////////////////////////////////////////////////////////////////////////////
?>
<div class = "reg-auth-form">
  <form action="handler.php" method="post">
    <p>
      <input class = "reg-auth-inpt" name="login" type="text" placeholder="Login or E-mail" <?= set_user_form_value('user_auth_form_values_arr', 'login'); ?>>
    </p>
    <p>
      <input class = "reg-auth-inpt" name="password" type="password" placeholder="Password">
    </p>
    <p>
      <button class="btn" name="btn_try_auth" type="submit">Log in</button>
      <button class="btn" name="btn_rfrsh_pg" type="submit">Refresh page</button>
    </p>
  </form>
</div>
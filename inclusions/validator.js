'use strict'
// Checks the validity of registration fields.
//	Returns true if all fields are valid, otherwise
//	 returns false.
function validate_reg_form() {
    let registration_fields_valid_flag = true;
    // Save fields values from a form to letiables
    let name = document.forms["reg_form"]["name"].value;
    let email = document.forms["reg_form"]["email"].value;
    let login = document.forms["reg_form"]["login"].value;
    let birth_date = document.forms["reg_form"]["birth_date"].value;
    let country = document.forms["reg_form"]["country"].value;
    let password = document.forms["reg_form"]["password"].value;
    let password_2 = document.forms["reg_form"]["password_2"].value;
    let terms_agree = document.getElementById("terms_checkbox");
    // Set regular expressions to validate form fields
    let email_REGEX = /^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/;
    let login_REGEX = /(?=.*[a-z])[0-9a-zA-Z!@#$%^&*]{3,20}/;
    let password_REGEX = /(?=.*[0-9])(?=.*[a-z])[0-9a-zA-Z!@#$%^&*]{6,35}/;
    let birth_date_REGEX = /^(\d{1,4})(\/|-)(\d{1,2})(\/|-)(\d{2})$/;
    // Check form fields
    if ((name == "") ||
        (email == "") ||
        (login == "") ||
        (birth_date == "") ||
        (country == "") ||
        (password == "") ||
        (password_2 == "") ||
        (terms_agree == "")) {
            registration_fields_valid_flag = false;
        }
    if ((email_REGEX.test(email) === false) || email.length > 50) {
        registration_fields_valid_flag = false;
    }
    if (login_REGEX.test(login) === false) {
        registration_fields_valid_flag = false;
    }
    if (name.length < 2 || name.length > 30) {
        registration_fields_valid_flag = false;
    }
    if (password != password_2) {
        registration_fields_valid_flag = false;
    }
    if (password_REGEX.test(password) === false) {
        registration_fields_valid_flag = false;
    }
    if (birth_date_REGEX.test(birth_date) === false) {
        registration_fields_valid_flag = false;
    }
    if (terms_agree.checked === false) {
        registration_fields_valid_flag = false;
    }
    // Show message if there are input errors
    if (registration_fields_valid_flag === false) {
        alert("Errors were found while validating input fields. Click 'OK' for details.");
    }
    return registration_fields_valid_flag;
}
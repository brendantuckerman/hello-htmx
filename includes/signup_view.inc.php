<?php

declare(strict_types=1);

/*
    View file for displaying to the user
*/

function check_signup_errors(){
    if(isset($_SESSION["error_signup"])){
        $errors = $_SESSION["error_signup"];

        echo "<br>";

        foreach ($errors as $error) {
           echo '<p class="form-error>' . $error . '</p>';
        }

        //remove the erros from the session
        unset($$_SESSION["error_signup"]);
    }
}
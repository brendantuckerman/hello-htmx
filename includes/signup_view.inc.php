<?php

declare(strict_types=1);

/*
    View file for displaying to the user
*/


function signup_inputs(){
    
    //Send data back to inputs on unsuccessful attempt to sign up;

    if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["error_signup"]["username_taken"])){

        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';

    } else{

        echo '<input type="text" name="username" placeholder="Username">';
    }

    echo '<input type="password" name="pwd" placeholder="Password">';

    if(isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["error_signup"]["email_taken"]) && !isset($_SESSION["error_signup"]["invalid_email"])){

        echo '<input type="email" name="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '">';

    } else{

        echo '<input type="email" name="email" placeholder="Email">';
    }
}

function check_signup_errors(){
    if(isset($_SESSION["error_signup"])){
        
        $errors = $_SESSION["error_signup"];

        echo "<br>";
        foreach ($errors as $error) {

           echo '<p class="form-error">' . $error . '</p>';
        }

        //remove the erros from the session
        unset($_SESSION["error_signup"]);

    } elseif(isset($_GET["signup"]) && $_GET["signup"] === "success" ){
        echo '<br>';
        echo '<p class="form-success"> Signup success!</p>';

    }
}
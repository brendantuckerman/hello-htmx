<?php

//Prevent user accessing via url etc, so check form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Grab the data that was posted
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    /*
    Just for noting, when ouptuting data,
    it is secure to sanitise the data in the 
    following way:

    echo htmlspecialchars($username);

    This is not needed when posting to the DB
    */

    try {
        
        //Grab the connection to the DB
        require_once "dbh.inc.php"; 
        require_once "signup_model.inc.php"; 
        //view goes here if needed
        require_once "signup_contr.inc.php"; 

       
        //Error handlers -defined in contr
        $errors = [];

        //Check for empty entries
        if(is_input_empty($username, $pwd, $email)){
            $errors["empty_input"] = "Fill in all fields.";
        }
        //Check for valid email
        if(is_email_invalid($email)){
            $errors["invalid_email"] = "Email is not in a valid format.";
        }   
        //Check whether username is taken
        if(is_username_taken($pdo, $username)){
            $errors["username_taken"] = "That username is already taken.";
        }

        //Check whether email is taken
        if(is_email_registered($pdo, $email)){
            $errors["email_taken"] = "That email is already in use.";
        }

        //Need to start a session here to add errors to it
        require_once 'config.inc.php';

        if($errors){
            $_SESSION["error_signup"] = $errors;

            $signupData = [ //store data so user does not have to reenter
               "username" => $username,
               "email" => $email
            ]; 

            $_SESSION["signup_data"] = $signupData;

            header("Location: ../index.php");
            die();
        }
        
        create_user($pdo, $username, $pwd, $email);
               
        
        //Kill the connection to the DB
        $pdo = NULL;
        $stmnt =NULL;
        
        //Send user to front page
        header("Location: ../index.php?signup=success");

        //Die for connections, exit() for other
        die();

    } catch (PDOException $e) {
        //throw $e;
        die("Query failed: " . $e->getMessage());
    }


} else{
    //Was the form submitted correctly? If not take them home
    header("Location: ../index.php");
    die();
}
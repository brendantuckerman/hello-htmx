<?php

//Prevent user accessing via url etc, so check form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST"){

  //Grab the data that was posted
  $username = $_POST["username"];
  $pwd = $_POST["pwd"];

  try {
    //MVC

    require_once 'dbh.inc.php'; //db connection needed first
    require_once 'login_model.inc.php';
    require_once 'login_contr.inc.php';
    
     //Error handlers -defined in contr
     $errors = [];

     //Check for empty entries
     if(is_input_empty($username, $pwd)){
         $errors["empty_input"] = "Fill in all fields.";
     }

     $result = get_user($pdo, $username);

     if (is_username_wrong($result)) {
        $errors["login_incorrect"] = "Incorrect login info!";
     }

     if (!is_username_wrong($result) && is_password_wrong($pwd, result['pwd'])) {
      $errors["login_incorrect"] = "Incorrect login info!";
    }
    
     //Need to start a session here to add errors to it
     require_once 'config.inc.php';

     if($errors){
         $_SESSION["error_signup"] = $errors;
        
         header("Location: ../index.php");
         die();
     }

     //After changes to a site (such as login), regenerate the session cookie
     $newSessionId = session_create_id();
     


  } catch (PDOException $e) {
    //throw $e;
    die("Query failed: " . $e->getMessage());
}



}  else{
    header("Location: ../index.php");
    die();
}
<?php

declare(strict_types=1);

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

     if (!is_username_wrong($result) && is_password_wrong($pwd, $result['pwd'])) {
      $errors["login_incorrect"] = "Incorrect login info!";
    }
    
     //Need to start a session here to add errors to it
     require_once 'config.inc.php';

     if($errors){
         $_SESSION["errors_login"] = $errors;
        
         header("Location: ../index.php");
         die();
     }

     /*After changes to a site (such as login), regenerate the session cookie
     *  In this example, we append a new session id 
     * with the users id, found in the DB search
     * This way we always ahve an identifier for this
     * specific user in the sessionId
     */
    
    //  var_dump($_SESSION);
     $newSessionId = session_create_id();
     $sessionId = $newSessionId .  "-" . $result["id"];
     //TODO: Add user id to session cookie to allow for
     // infomraiton on the user to be served
    //  $customId = session_create_id() . "-" . $result["id"];
    //  setcookie("custom_session_id", $customId, 0, "/", "", true, true);
     session_id(); //Create the new session
     
     $_SESSION["user_id"] =  $result["id"];
     $_SESSION["user_username"] =  htmlspecialchars($result["username"]); //sanitize for security
     
     //Reset the time for cookie regen
     $_SESSION['last_regeneration'] = time();

     header("Location: ../index.php?login=success");

     //Close off connection on success
     $pdo = null;
     $stmnt = null;

     die();


  } catch (PDOException $e) {
    //throw $e;
    die("Query failed: " . $e->getMessage());
  }



}  else{
    header("Location: ../index.php");
    die();
}
<?php


 /*
    Security: to prevent attackers from using
    the url to 'fix' a session, we can use the 
    following (which is also available in the php.ini file)
  */

 
  ini_set('session.use_only_cookies', 1);  //Only allow cookies (rather than url)

  //Only use  a session id from server & increase complexity
  ini_set('session.use_strict_mode', 1);

  //Set cookie parameters
  session_set_cookie_params([
    'lifetime' => 1800,  //in seconds
    'domain' => 'localhost',
    'path' => '/',  //any path within the domain
    'secure' =>  true,
    'httponly' => true
  ]);

  session_start();

  //Check to see whether user logged in
  if(isset($_SESSION["user_id"])){
    //logged in 
    if (!isset($_SESSION['last_regeneration'])) {
      
      //strengthen protection
      regenerate_session_id_loggedin();
  
    } else{
  
      $interval = 60 * 30; //After 30 minutes
    
      //Regenerate session id after 30 minutes
      if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session_id_loggedin();
      }
    }

  } else{
    //Not logged in

    //If last_regeneration is not set, this is the first viewing of the page
    if (!isset($_SESSION['last_regeneration'])) {
      
      //strengthen protection
      regenerate_session_id();
  
    } else{
  
      $interval = 60 * 30; //After 30 minutes
    
      //Regenerate session id after 30 minutes
      if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session_id();
      }
   }

  }

  function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
  }

  function regenerate_session_id_loggeddin(){
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];

    $newSessionId = session_create_id();
    $sessionId = $newSessionId .  "-" . $userId;
    session_id($sessionId); //Create the new session

    $_SESSION['last_regeneration'] = time();
  }

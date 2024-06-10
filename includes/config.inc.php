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

  //If last_regernation is not set, this is the first viewing of the page
  if (!isset($_SESSION['last_regeneration'])) {
    
    //strengthen protection
    egenerate_session_id();

  } else{

    $interval = 60 * 30; //After 30 minutes
  
    //Regernarte session id after 30 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
      regenerate_session_id();
    }
  }

  function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
  }

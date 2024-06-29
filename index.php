<?php

  require_once 'includes/config.inc.php';
  require_once 'includes/signup_view.inc.php';
  require_once 'includes/login_view.inc.php';

  //Start the session
  //session_start();

  //Set a session variable
  //$_SESSION["username"] = "furiousB";

  //unset a single var
  // unset($_SESSION["username"]);

  //To purge all session data:
  // session_unset();
  
  //To end the session (on leaving the page)
  // session_destroy();
  

?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup and Sign in with PHP</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script src="https://unpkg.com/htmx.org@1.6.0"></script>
</head>
<body>
  <header>

      <h3>
          <?php
            output_username();
          ?>
      </h3>



     <?php
        
          if(!isset($_SESSION["user_id"])){  ?>
            
            <h3>Login</h3>
            <form class='login-form' action='includes/login.inc.php' method='post'>
            <input required id='loginUsername' type='text' name='username' placeholder='Enter your username'>
            <input required id='loginPwd' type='password' name='pwd' placeholder='Enter your password'>
            <button>Login</button>
           </form>
                 
          
           <?php } else { ?>
             
            <form class='logout-form' action='includes/logout.inc.php' method='post'>
            <button>Logout</button>
            </form>
          <?php }

          check_login_errors();
        ?>

     <form class="search-form" action="pages/search.php" method="post">
      <label for="search">Search for user:</label>
      <input id="search" type="text" name="usersearch" placeholder="Search...">
      <button>Search</button>
     </form>
  </header>
  <main>
    
    
   
    <div>
      <h3>Sign up</h3>
      <form action="includes/signup.inc.php" method="post">
          <?php 
            signup_inputs();
          ?>
          <button>Signup</button>

          <?php
            check_signup_errors();
          ?>
      </form>
    </div>
    <div>
      <h3>Update account</h3>
      <form action="includes/updateuser.inc.php" method="post">
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="pwd" placeholder="Password">
          <input type="email" name="email" placeholder="Email">
          <button>Update</button>
          
      </form>
    </div>
    <div>
      <h3>Delete account</h3>
      <form action="includes/deleteuser.inc.php" method="post">
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="pwd" placeholder="Password">
          <button>Delete (Warning: cannot be undone)</button>
      </form>
    </div>
  </main>
    
    
</body>
</html>

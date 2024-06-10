<?php

  require_once 'config.php';
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
  <title>HTMX with PHP</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <script src="https://unpkg.com/htmx.org@1.6.0"></script>
</head>
<body>
  <header>
     <?php

        if(!$_SESSION["username"]){
            $_SESSION["username"] = "Guest";
        }

        echo "<h1>Welcome to HTMX with PHP, " . $_SESSION["username"] 
         . "</h1>";
     ?>
        <?php
          if($_SESSION["username"] === "Guest"){
            echo "
            <form class='login-form' action='includes/login.inc.php' method='post'>
            <input id='loginUsername' type='text' name='username' placeholder='Enter your username'>
            <input id='loginPwd' type='password' name='pwd' placeholder='Enter your password'>
            <button>Login</button>
           </form>
                 
            ";
          }
        ?>

     <form class="search-form" action="pages/search.php" method="post">
      <label for="search">Search for user:</label>
      <input id="search" type="text" name="usersearch" placeholder="Search...">
      <button>Search</button>
     </form>
  </header>
  <main>
    
    
    <button hx-get="/increment">Increment</button>
    <p id="counter"><?php echo $count ?? 0; ?></p>
  
    <div>
      <h3>Sign up</h3>
      <form action="includes/formhandler.inc.php" method="post">
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="pwd" placeholder="Password">
          <input type="email" name="email" placeholder="Email">
          <button>Signup</button>
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
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_HX_REQUEST'])) {
      $count = isset($_POST['count']) ? intval($_POST['count']) : 0;
      $count++;
      echo $count;
    }
    ?>
</body>
</html>

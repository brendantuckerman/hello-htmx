<?php
  

  //Prevent user accessing via url etc, so check form was submitted
  
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
      
      //Grab the data that was posted
      $usersearch = $_POST["usersearch"];

  
      /*
      Just for noting, when ouptuting data,
      it is secure to sanitise the data in the 
      following way:
  
      echo htmlspecialchars($username);
  
      This is not needed when posting to the DB
      */
      try {
          
          //Grab the connection to the DB
          require_once "../includes/dbh.inc.php"; 
  
          /*
              Other alternatives to require_once:
              require 
              include
              include_once
          */
  
          
          $query = "SELECT * FROM comments WHERE username = :usersearch;";
          
          //These are 'prepared' statements
          // that support the above
          $stmnt = $pdo->prepare($query);
  
          //bind the :PARAMs given in $query
          $stmnt->bindParam(":usersearch", $usersearch);

          
          $stmnt->execute();


          //Grab the data as an associative array
          $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);
          
          //Kill the connection to the DB
          $pdo = NULL;
          $stmst = NULL;
          
  
      } catch (PDOException $th) {
          //throw $th;
          die("Query failed: " . $th->getMessage());
      }
  
  
  } else{
      //Was the form submitted? If not take them home
      header("Location: ../index.php");
  }


?>

<!DOCTYPE html>
<html>
<head>
  <title>HTMX with PHP</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="../css/reset.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="https://unpkg.com/htmx.org@1.6.0"></script>
</head>
<body>
  <header>
     <h1>Search Page!</h1>
     <form class="search-form" action="search.php" method="post">
      <label for="search">Search for user:</label>
      <input id="search" type="text" name="usersearch" placeholder="Search...">
      <button>Search</button>
     </form>
  </header>
  <main>
 <a href="/">Home</a>

  <section>
    <h3>Search Results:</h3>

    <?php
        if (empty($results)) {
            echo "<div class='no-results'>";
            echo "<p>No results. </p>";
            echo "<div>";
        } else {
            foreach ($results as $row) {
                //htmlspecial chars prevents JS/ SQL / Cross Site Scripting
                echo ("<div class='results-item'>");
                echo "<h4>" . htmlspecialchars($row["username"]) . "</h4>";
                echo "<p>" . htmlspecialchars($row["comment_text"]) . "</p>";
                echo "<p>" . htmlspecialchars($row["created_at"]) . "</p>"; 
                echo ("</div>");
            }
        }
        
    ?>
  </section>
   
</body>
</html>

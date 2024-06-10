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

        /*
            Other alternatives to require_once:
            require 
            include
            include_once
        */

        //The ??? is to prevent SQL injection
        
        $query = "UPDATE users SET username= :username, pwd = :pwd
        , email = :email WHERE id = 2;";
        
        //These are 'prepared' statements
        // that support the above
        $stmnt = $pdo->prepare($query);

        //Hash the pwd
        $options = [
            'cost' => 12
        ];
        
            /*
             Auto provided salt & hash. PASSWORD_DEFAULT will update when php updates. $options must be an array and can include cost (usually between 10-12). The higher the more difficult to brute force;
            */
          
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        //bind the :PARAMs given in $query
        $stmnt->bindParam(":username", $username);
        $stmnt->bindParam(":pwd", $hashedPwd);
        $stmnt->bindParam(":email", $email);
        
        
        $stmnt->execute();
        
        //Kill the connection to the DB
        $pdo = NULL;
        $stmst = NULL;
        
        //Send user to front page
        header("Location: ../index.php");

        //Die for connections, exit() for other
        die();

    } catch (PDOException $th) {
        //throw $th;
        die("Query failed: " . $th->getMessage());
    }


} else{
    //Was the form submitted? If not take them home
    header("Location: ../index.php");
}
<?php

//Prevent user accessing via url etc, so check form was submitted

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Grab the data that was posted
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

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
        
        $query = "DELETE FROM users WHERE username = :username AND
        pwd = :pwd;";
        
        //These are 'prepared' statements
        // that support the above
        $stmnt = $pdo->prepare($query);

        //bind the :PARAMs given in $query
        $stmnt->bindParam(":username", $username);
        $stmnt->bindParam(":pwd", $pwd);        
        
        $stmnt->execute();
        
        //Kill the connection to the DB
        $pdo = NULL;
        $stmst =NULL;
        
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
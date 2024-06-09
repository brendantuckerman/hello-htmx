<?php

$host = 'db'; // The hostname of the database service defined in docker-compose.yml
$dbname = 'ronnie'; // The name of your database
$dbusername = "root";
$dbpassword = "secret"; 

try {
    /* $pdo is a faster, more flxible way
    of connecting to different types 
    of dbs (instead of MySqli) 

    It allows the creation of a new PDO object 
    that tuyrns the connection into an object
    */

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    
    //Set the PDO to throw an exception if there is an error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $th) {
    //throw $th;
    echo "Connection failed: " . $th->getMessage();
}
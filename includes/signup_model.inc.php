<?php

declare(strict_types=1);

/*
    Model file for querying the DB
*/

//The object being passed in here is a PDO object (i.e. the connection to the DB, created at signup.inc.php)
function get_username(object $pdo, string $username){

    $query = "SELECT username FROM users WHERE username= :username;";
    
    //Secure preparation of query
    $stmnt  = $pdo->prepare($query);
    //Bind and excute
    $stmnt->bindParam(":username", $username);
    $stmnt->execute();

    $result = $stmnt->fetch(PDO::FETCH_ASSOC); //The first result as an associative array
    return $result;
}

function get_email(object $pdo, string $username){

    $query = "SELECT username FROM users WHERE email= :email;";
    
    //Secure preparation of query
    $stmnt  = $pdo->prepare($query);
    //Bind and excute
    $stmnt->bindParam(":email", $email);
    $stmnt->execute();

    $result = $stmnt->fetch(PDO::FETCH_ASSOC); //The first result as an associative array
    return $result;
}

function set_user(object $pdo, string $username, string $pwd, string $email){
    
    $query =  "INSERT INTO users (username, pwd, email) VALUES (:username , :pwd, :email);";
    
    //Secure preparation of query
    $stmnt  = $pdo->prepare($query);

    //Options for hashing
    $options = [
        'cost'=> 12
    ];

     /*
        Auto provided salt & hash. PASSWORD_DEFAULT will update when php updates. $options must be an array and can include cost (usually between 10-12). The higher the more difficult to brute force;
    */
 
    $hashedPwd  = password_hash($pwd, PASSWORD_BCRYPT, $options);

    //Bind and excute
    $stmnt->bindParam(":username", $username);
    $stmnt->bindParam(":pwd", $hashedPwd);
    $stmnt->bindParam(":email", $email);
    $stmnt->execute();
}


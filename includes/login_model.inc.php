<?php

    declare(strict_types=1);
    // Model for login

    function get_user(object $pdo, string $username ){

      $query = "SELECT * FROM users WHERE username = :username;";
      //Secure preparation of query
      $stmnt  = $pdo->prepare($query);
      //Bind and excute
      $stmnt->bindParam(":username", $username);
      $stmnt->execute();

      $result = $stmnt->fetch(PDO::FETCH_ASSOC); //The first result as an associative array
      return $result;

    }
<?php

    /*
    * Specific hashing for passwords
    * See hashgeneral.inc.php for more general
    * hashing.
    */
  
  $pwdSignup = "password123";

  $options = [
    'cost' => 12
  ];

    /*
     Auto provided salt & hash. PASSWORD_DEFAULT will update when php updates. $options must be an array and can include cost (usually between 10-12). The higher the more difficult to brute force;
    */
  
  $hashedPwd = password_hash($pwdSignup, PASSWORD_BCRYPT, $options);

  // Verify a password that has been attempted

  $pwdLogin = "password123";
  password_verify($pwdLogin, $hashedPwd);

  if (password_verify($pwdLogin, $hashedPwd)) {
    echo "They are the same";
  } else {
    echo "They are not the same";
  }
  


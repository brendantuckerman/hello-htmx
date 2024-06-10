<?php

    /*
        General hashing (non-pw)
        Provides a hashing of the $sensitiveData
        and then compares it to a verification
        from the user (here represented by $verificationHash)
    */

    $sensitiveData = "aUserString";
    $salt = bin2hex(random_bytes(16)); //generate random salt
    $pepper = "ASecretPepperString";

    $dataToHash  = $sensitiveData . $salt . $pepper;

    $hash =  hash("sha256", $dataToHash);

    // To compare a general hash:
    
    $verification = "aUserString";
    $verificationHash =  hash("sha256", $verifciation);

    if($verificationHash === $hash){
        echo "The hashes match";
    } else{
        echo "The hashes do not match";
    }
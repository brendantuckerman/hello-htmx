<?php

declare(strict_types=1);

/*
    Controller file for supporting logic
*/

function is_input_empty(string $username, string $pwd, string $email): bool
{

    if(empty($username) || empty($pwd) || empty($email)) {
        return true;
    }else{
        return false;
    }
}

function is_email_invalid(string $email): bool{

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }else{
        return false;
    }
}

function is_username_taken(object $pdo, string $username): bool{

    //Query to DB must be handled in model via get_username

    if(get_username($pdo, $username)){
        return true;
    }else{
        return false;
    }
               
}

function is_email_registered(object $pdo, string $email): bool{

    if(get_email($pdo, $email)){
        return true;
    }else{
        return false;
    }
        
}

function create_user(object $pdo, string $username, string $pwd, string $email){
    
    set_user($pdo, $username, $pwd, $email);
}
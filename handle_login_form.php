<?php
session_start();
include 'functions_user.php';
include 'functions_input.php';
include 'connect.php';

$uName = $_POST["username"];
$pass = $_POST["password"];


if (inputIsComplete())
{
    if (isValidInput($uName))
    {
    $currentUser = getUserData($con, $uName);
    if ($currentUser == false)
    {
      echo 'No such user!';
    }
    
    if (checkPass($con, $pass, $currentUser))
    {
      /*
        * Log the user in for the current session
        */
            
        $_SESSION['usr'] = $currentUser;
            $_SESSION['justLoggedIn'] = true;
      header("Location: index.php");
        //session_write_close()
        //var_dump($currentUser);
        //var_dump($_SESSION);
    }
    }
}

/**
*  Uses a regex to strip any punctuation from the users input to prevent SQL injection
*  @param string $unameInput This is a string containing the input from the username field
*/
function isValidInput($unameInput)
{
    $unameValid = preg_replace("/[^a-zA-Z 0-9]+/", " ", $unameInput);
    return ($unameValid == $unameInput);
}

?>
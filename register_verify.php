<?php
session_start();
include 'functions_input.php';
include 'connect.php';
include 'functions_user.php';


$desiredName = $_POST["dUsername"];
$pass = $_POST["dPassword"];
$secondPass = $_POST["rPassword"];
$emailAddress = $_POST["email"];


if (inputIsComplete())
{
    //echo 'complete input';
    if (isValidInput($_POST["dUsername"]))
    {
        if (userIsNotTaken($desiredName, $con))
        {
          insertIntoDB($con, $desiredName, $emailAddress, $pass);
          $currentUser = getUserData($con, $desiredName);
          $_SESSION['usr'] = $currentUser;
          header('Location: index.php');
          
            //$password = encryptPassword($_POST['dPassword']);
            //$username = $_POST['dUsername'];
            //insertIntoDB($con, $username, $password, $emailAddress);
    }
    }
}  
      /*
    *
    * Validates the user input by first stripping any invalid punctuation values from
    * the desired username, if there are none, the script checks for matching passwords
    *
    *
    */
    function isValidInput($unameInput)
    {
        
        $unameValid = preg_replace("/[^a-zA-Z 0-9_.-]+/", " ", $unameInput);
        
        if ($unameInput == $unameValid)
        {
            $maxUnameLength = 30;
            
            function checkPassword()
            {
                return ($_POST["dPassword"] == $_POST["rPassword"]);
            }
            
            function isValidLength($uname, $maxLen)
            {
                return (strlen($uname) < (int)$maxLen);
            }
            
            if (!checkPassword())
            {
                echo 'Passwords do not match!';
            }
            else if (isValidLength($unameInput, $maxUnameLength))
            {
                return true;
                echo 'valid input';
            }
            else
            {
                echo 'Username must not be more than 30 characters!</br>';
            }
        }
        else
        {
            echo 'Username must be a combination of letters and numbers only!';
        }
    }

?>
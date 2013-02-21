<?php session_start();
/**
*  @author: Tom Nash
*/
    error_reporting(0);
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    $emailAddress = $_POST["email"];
    
    include 'connect.php';
	include 'functions_user.php';
	include 'functions_input.php';
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
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
        else
        {
            echo 'All forms must be filled in!';
        }
    }
    else
    {
        
    }
    
    function showForm() 
    {
        echo '<form method="post" action="'; echo $PHP_SELF; echo '">
              <label for="desired_username">Your desired username:</label><br>
              <input type="text" name="dUsername" id="desired_username" value="';
              echo $_POST["dUsername"];
              echo '"><br>
              <label for="pass">Password:</label><br>
              <input type="password" name="dPassword" id="pass" value=""><br>
              <label for="retyped_pass">Retype your password:</label><br>
              <input type="password" name="rPassword" id="retyped_pass" value=""><br>
              <label for="email_address">Your email address:</label><br>
              <input type="text" name="email" id="email_address" value="';
			  echo $_POST["email"];
              echo '"><br>
              <input type="submit" name="submit" value="Submit">
              </form>';
    }
	
	/*function inputIsComplete()
    {  
        $emptyFields = array();
        foreach ($_POST as $value)
        {
            if (empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        {
            return true;
        }
        else
        {
			echo 'input is not complete';
            return false;
        }
    }*/
    
    /*
    *
    * Validates the user input by first stripping any invalid punctuation values from
    * the desired username, if there are none, the script checks for matching passwords
    *
    *
    */
    function isValidInput($unameInput)
    {
        
        $unameValid = preg_replace("/[^a-zA-Z 0-9]+/", " ", $unameInput);
        
        if ($unameInput == $unameValid)
        {
            $maxUnameLength = 100;
            
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
                echo 'Username must not be more than 15 characters!</br>';
            }
        }
        else
        {
            echo 'Username must be a combination of letters and numbers only!';
        }
    }
?> 

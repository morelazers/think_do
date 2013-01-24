<?php
/**
  Author: Tom Nash
*/
    error_reporting(0);
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    $emailAddress = $_POST["email"];
    
    include 'connect.php';
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
            if (isValidInput($_POST["dUsername"]))
            {
                if (userIsNotTaken())
                {
                	$password = encryptData($pass);
                	echo $password;
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
              <input type="text" name="email" id="email_address" value=""><br>
              <input type="submit" name="submit" value="Submit">
              </form>';
    }
    
    function emailNewUser($eA)
    {
	$subject = "Welcome to thinkdo!";
	$message = "Thanks for signing up to thinkdo!";
	$from = "admin@think.do";
	$headers = "From: " . $from;
	mail($eA, $subject, $message, $headers);
    }
    
    function insertIntoDB($c, $u, $p, $e)
    {
        $sql="INSERT INTO user (username, email, password) VALUES ('$u', '$e', '$p')";
        if (!mysql_query($sql, $c))
        {
        	echo 'Failed to add record';
    		die('Error: ' . mysql_error());
    	}
        else
        {
            echo 'You are registered!<br>Please login';
            emailNewUser($e);
            sleep(2.5);
            header('Location: index.php') ;
        }
        mysql_close($con);
    }
    
 
   function encryptData($value)
   { 
   	$key = "pleasedontcrackme"; 
   	$text = $value;
   	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB); 
   	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
   	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
   	echo $crypttext;
   	return $crypttext;
   }


    
/*    function encryptPassword($p)
    {
        //Encrypt password!
        $p = hash("sha512", $p);
        return $p;
    }
*/    
    function inputIsComplete()
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
            return false;
        }
    }
    
    function userIsNotTaken($u)
    {
        //Query database to check if username is taken
        $sql = "SELECT username FROM user WHERE user ='".$username."'";
    	$userTaken = mysql_query($sql, $con);
    	//If username is not taken, add new user to database
    	if($userTaken==null)
        {
            return true;
        }
        else
        {
            return false;
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

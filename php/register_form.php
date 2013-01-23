<?php
/**
	Author: Tom Nash
*/
    error_reporting(0);
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    

    $con = mysql_connect("127.0.0.1:3306","root","");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    
    mysql_select_db("thinkdo", $con);
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
            if (isValidInput($_POST["dUsername"]))
            {
                if (userIsNotTaken())
                {
                    $password = encryptPassword($_POST['dPassword']);
    				$username = $_POST['dUsername'];
                    insertIntoDB($username, $password);
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
              <input type="submit" name="submit" value="Submit">
              </form>';
    }
    
    function insertIntoDB($u, $p)
    {
        $sql="INSERT INTO user (username, password) VALUES ('$u', '$p')";
        if (!mysql_query($sql, $con))
        {
    		die('Error: ' . mysql_error());
    		echo 'failed to add record';
    	}
        else
        {
            echo 'You are registered!<br>Please login';
            header( 'Location: http://www.yoursite.com/new_page.html' ) ;
        }
        mysql_close($con);
    }
    
    function encryptPassword($p)
    {
        //Encrypt password!
        $p = hash("sha512", $p);
        return $p;
    }
    
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
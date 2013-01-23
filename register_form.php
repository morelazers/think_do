<?php
/**
	Author: Tom Nash
*/
    error_reporting(0);
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    
	include 'connect.php';
    
    mysql_select_db("thinkdo", $con);
    
    $emptyFields = array();
    
    if (isset($_POST["submit"]))
    {
        foreach ($_POST as $value)
        {
            if (empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        {
            if (isValidInput($_POST["dUsername"]))
            {
				//Query database to check if username is taken
				$sql = "SELECT username FROM user WHERE user ='".$username."'";
				$userTaken = mysql_query($sql, $con);
				//If username is not taken, add new user to database
				if($userTaken==null)
				{
					$password = $_POST['dPassword'];
					$username = $_POST['dUsername'];
					echo 'submitted to the database';
					$sql="INSERT INTO user (username, password) VALUES ('$username', '$password')";
					if (!mysql_query($sql, $con))
					{
						die('Error: ' . mysql_error());
						echo 'failed to add record';
					}
					mysql_close($con);
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
            $maxUnameLength = 20;
            
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
<?php
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    

    $con = mysql_connect("localhost:3306","root","p");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    
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
            /*
            * php to add the idea into the database
            */
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
            $password = $_POST['dPassword'];
            
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
                    echo 'submitted to the database';
                    $sql="INSERT INTO user (uname, password)
                    VALUES ('$unameInput', '$password')";
                    if (!mysql_query($sql, $con))
                    {
                        die('Error: ' . mysql_error());
                    }
                    echo "1 record added";
                    
                    mysql_close($con);
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
    /*
    *                {
                    return FALSE;
                    echo strlen($unameValid);
                }
                else
                {
                    return TRUE;
                    echo strlen($unameValid);
                }
    */
?> 
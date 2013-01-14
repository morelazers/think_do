<?php
    showForm();
    $desiredName = $_POST["dUsername"];
    $pass = $_POST["dPassword"];
    $secondPass = $_POST["rPassword"];
    
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
           
            function checkPassword()
            {
                return ($_POST["dPassword"] == $_POST["rPassword"]);
            }
            
            function isValidLength()
            {
                $unameLength = (strlen($unameValid));
                $maxLength = 15;
                if ($unameLength > $maxLength)
                {
                    return false;
                }
                else
                {
                    return true; 
                }
            }
            
            if (!checkPassword())
            {
                echo 'Passwords do not match';
            }
            
            else if (isValidLength())
                {
                    echo 'submitted';
                    echo strlen($unameValid);
                }
                else
                {
                    echo 'Username must not be more than 15 characters!</br>';
                    echo strlen($unameValid);
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
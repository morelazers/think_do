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
            /*
            * php to add the idea into the database
            */
            if (checkPassword())
            {
                echo 'User created!';
            }
            else
            {
                echo 'Passwords do not match';
            }
            
        }
        else
        { 
            echo 'All forms must be filled in!';
        }
    } 
    
    //this function should probably be in another function validateRegister()
    //which should validate everything, including length, whether the username
    //is already in use, etc.
    function checkPassword()
    {
        return ($_POST["dPassword"] == $_POST["rPassword"]);
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
?> 
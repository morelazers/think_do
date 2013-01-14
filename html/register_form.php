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
            echo 'User created!';
        }
        else
        { 
            echo 'All forms must be filled in!';
        }
        if ($_POST["dPassword)
    } 
    function showForm() 
    {
        echo '<form method="post" action="'; echo $PHP_SELF; echo '">
              <label for="idea_title">Your desired username:</label><br>
              <input type="text" name="dUsername" id="idea_title" value="';
              echo $_POST["dUsername"];
              echo '"><br>
              <label for="idea_desc">Password:</label><br>
              <input type="text" name="dPassword" id="desired_pass" value=""><br>
              <label for="skills">Retype your password:</label><br>
              <input type="text" name="rPassword" id="retyped_pass" value=""><br>
              <label for="tags">Tags:</label><br>
              <input type="submit" name="submit" value="Submit">
              </form>';
    }
?> 
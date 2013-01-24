<?php 
    showForm();
    $uName = $_POST["username"];
    $pass = $_POST["password"];
    
    include 'connect.php';
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
            if (isValidInput($uName))
            {
                if (validateLogin($con, $uName, $pass))
                {
                    /*
                    * Log the user in for the current session
                    */
                    echo 'Logged in!';
                }
                else
                {
                    echo 'Your login could not be validated for some reason';
                }
            }
            else
            {
                echo 'Invalid username input';
            }
        }
        else
        {   
            echo 'All fields must be filled in!';
        }
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
    
     function showForm() 
    {
        echo '<form method="post" action="'; 
            echo $PHP_SELF; 
            echo '">
            <label for="input_username">Username:</label><br>
            <input type="text" name="dUsername" id="input_username" value="';
            echo $_POST["dUsername"];
            echo '"><br>
            <label for="input_password">Password:</label><br>
            <input type="password" name="password" id="input_password" value=""><br>
            <input type="submit" name="submit" value="Login">
            </form>';
    }
    
    function isValidInput($unameInput)
    {
        $unameValid = preg_replace("/[^a-zA-Z 0-9]+/", " ", $unameInput);
        echo $unameValid;
        echo '<br>';
        echo $unameInput;
        return ($unameValid == $unameInput);
    }
    
    function validateLogin($c, $u, $p)
    {
        //Query database to check if passwords are equal
        $sql = "SELECT password FROM user WHERE username ='".$u."'";
        echo $sql;
        echo '<br>';
        $storedPass = mysql_query($sql, $c);
        //Hash the inputted password and check if it is equal to the one stored in the DB
        $encryptedPass = hash("sha512", $p);
        echo $storedPass;
        echo '<br>';
        echo $encryptedPass;
        echo '<br>';
        return ($encryptedPass == $storedPass);
    }
?> 

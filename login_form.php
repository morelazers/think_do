<?php 
    showForm();
    $uName = $_POST["username"];
    $pass = $_POST["password"];
    $emptyFields = array();
    
    include 'connect.php';
    
    if (isset($_POST["submit"]))
    {
        foreach ($_POST as $value)
        {
            if (!empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        {
            //validate login
            if (isValidInput($uName))
            {
                validateLogin($uName);
            }
        }
        else
        {   
            echo 'All fields must be filled in!';
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
        return ($unameValid == $unameInput);
    }
    
    function validateLogin($u)
    {
        //Query database to check if passwords are equal
    	$sql = "SELECT password FROM user WHERE user ='".$username."'";
        $storedPass = mysql_query($sql, $con);
        return ($storedPass == $pass);
        /*
        * incomplete, needs encryption
        */
    }
    
    
?> 

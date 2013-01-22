<?php 
    showForm();
    $uName = $_POST["username"];
    $pass = $_POST["password"];
    $emptyFields = array();
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
?> 
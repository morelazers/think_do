<?php 

    $uName = $_POST["username"];
    $pass = $_POST["password"];
    
    $eKey = 'TOPSECRET';
    
    include 'connect.php';
  include 'functions_user.php';
  include 'functions_input.php';
  
    showForm();

    /**
  *  This function declares an empty array then adds each empty _POST value
  *  to the array. The function then checks to see if the array is empty at
  *  the end, returning true if it is, false if has any values in it.
  */
    /*function inputIsComplete()
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
            return true;
        }
        else
        {
            return false;
        }
    }*/
    
  /**
  *  This function is responsible for outputting the login form to the page
  */
    function showForm() 
    {
        echo '<div id="loginform"><form method="post" action="login_verify.php">
            <label for="input_username">Username:</label><br>
            <input type="text" name="username" id="input_username" value="';
            echo $_POST["username"];
            echo '"><br>
            <label for="input_password">Password:</label><br>
            <input type="password" name="password" id="input_password" value=""><br>
            <input type="submit" name="submit" value="Login">
            </form></div>';
    }

?> 

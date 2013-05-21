<?php session_start();
/**
*  @author: Tom Nash
*/
    error_reporting(0);
    include 'connect.php';
  include 'functions_user.php';
  include 'functions_input.php';

    showForm();
    
    function showForm() 
    {
        echo '<form width="300px" method="post" action="handle_register_form.php">
              <label for="desired_username">Your desired username:</label><br>
              <input type="text" name="dUsername" id="desired_username" value="';
              echo $_POST["dUsername"];
              echo '"><br>
              <label for="pass">Password:</label><br>
              <input type="password" name="dPassword" id="pass" value=""><br>
              <label for="retyped_pass">Retype your password:</label><br>
              <input type="password" name="rPassword" id="retyped_pass" value=""><br>
              <label for="email_address">Your email address:</label><br>
              <input type="text" name="email" id="email_address" value="';
        echo $_POST["email"];
              echo '"><br>
              <input type="submit" name="submit" value="Submit">
              </form>';
    }


/**
*  Function to check if the inputs from a $_POST form are all filled in
*/
/*function inputIsComplete()
{
    //Add all empty fields to an array
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
        echo 'All forms must be filled in!';
        return false;
    }
}*/
?> 

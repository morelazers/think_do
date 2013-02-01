<?php session_start();
    showForm();
    $uName = $_POST["username"];
    $pass = $_POST["password"];
    $eKey = 'TOPSECRET';
    
    include 'connect.php';
	include 'mysql_functions.php';
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
            if (isValidInput($uName))
            {
		$currentUser = getUserData($con, $uName);
		if (checkPass($pass, $currentUser, $eKey))
		{
			/*
        		* Log the user in for the current session
        		*/
        		$_SESSION['usr'] = $currentUser;
        		//session_write_close()
        		echo 'Logged in!';
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
	
    /**
	*	This function declares an empty array then adds each empty _POST value
	*	to the array. The function then checks to see if the array is empty at
	*	the end, returning true if it is, false if has any values in it.
	*/
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
    
	/**
	*	This function is responsible for outputting the login form to the page
	*/
    function showForm() 
    {
        echo '<form method="post" action="'; 
            echo $PHP_SELF; 
            echo '">
            <label for="input_username">Username:</label><br>
            <input type="text" name="username" id="input_username" value="';
            echo $_POST["dUsername"];
            echo '"><br>
            <label for="input_password">Password:</label><br>
            <input type="password" name="password" id="input_password" value=""><br>
            <input type="submit" name="submit" value="Login">
            </form>';
    }
    
	/**
	*	Uses a regex to strip any punctuation from the users input to prevent SQL injection
	*	@param string $unameInput This is a string containing the input from the username field
	*/
    function isValidInput($unameInput)
    {
        $unameValid = preg_replace("/[^a-zA-Z 0-9]+/", " ", $unameInput);
        return ($unameValid == $unameInput);
    }
?> 

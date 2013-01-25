<?php 
    showForm();
    $uName = $_POST["username"];
    $pass = $_POST["password"];
    $eKey = 'TOPSECRET';
    
    include 'connect.php';
    
    if (isset($_POST["submit"]))
    {
        if (inputIsComplete())
        {
            if (isValidInput($uName))
            {
                if (validateLogin($con, $uName, $pass, $eKey))
                {
                    /*
                    * Log the user in for the current session
                    */
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
    
    /**
	*	Handles the validation of a users login attempt. It queries the database to obtain the
	*	stored password for the entered username, then compares that with a hashed version of
	*	the password from the login form.
	*
	*	@param MySQLConnection $c Connection to MySQL database, necessary to perform queries
	*	@param string $u Username from the login form
	*	@param string $p Password from the login form
	*	@param string $k Secret key which is hashed to become the salt
	*/
    function validateLogin($c, $u, $p, $k)
    {
        //Query database to check if passwords are equal
        $sql = "SELECT password FROM user WHERE username = '" . $u . "'";
        $resultRow = mysql_query($sql, $c);
        //If there is no user with the inputted name in the database
        if ($resultRow == null)
        {
        	echo 'No such user!';
        	return false;
        }
        //Get the row with the user's data
        $user = mysql_fetch_assoc($resultRow);
        //Get the password
        $storedPass = $user['password'];
        if(checkPass($p, $storedPass))
        {
        	return true;
        }
        else
        {
        	return false;
        }
        
    }
	
    /**
	*	Hashes the input password and compares it to the stored password to determine if
	*	the login is valid.
	*	@param string $text Password from the login form
	*	@param string $sP Hashed password from the database
	*/
    function checkPass($text, $sP)
    {
		global $eKey;
		$salt = md5($eKey);
		$decPass = (sha1($salt.$text));
		/*
		*	Replaced '==' comparison with strcmp() and surrounded the args with trim()
		*	to ensure an accurate comparison
		*	-Nathan
		*/
		if (strcmp(trim($sP), trim($decPass)) == 0)
		{
			return true;
		}
		else
		{
			echo 'Your password is incorrect!';
		  	return false;
		}
    }
?> 

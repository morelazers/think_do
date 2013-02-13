<?php 
session_start();
if (isset($_SESSION['usr']))
{
	
	$currentUser = $_SESSION['usr'];
	
	showPassForm();
	
	showAboutMeForm($currentUser);
	
	$oldPass = $_POST["oldPass"];
	$pass1 = $_POST["newPass"];
	$pass2 = $_POST["newPass2"];
   
	include 'connect.php';
	include 'mysql_functions.php';
    
    	if (isset($_POST["submitPass"]))
    	{
        	if (inputIsComplete())
        	{
		
			if (checkPass($oldPass, $currentUser, $eKey))
			{
				changePass($currentUser, $pass1);
			}
        	}
        	else
        	{   
        		echo 'All fields must be filled in!';
        	}
    	}
}
else
{
	header('Location: login.php');
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
function showPassForm() 
{
	echo '<form method="post" action="'; 
        echo $PHP_SELF; 
        echo '">
        <label for="old_password">Old password:</label><br>
        <input type="password" name="oldPass" id="old_password" value=""><br>
	<label for="new_password">New password:</label><br>
        <input type="password" name="newPass" id="new_password" value=""><br>
	<label for="new_password2">Retype new password:</label><br>
        <input type="password" name="newPass2" id="new_password2" value=""><br>
        <input type="submit" name="submitPass" value="Change">
        </form>';
}

function showAboutMeForm($u)
{	
	echo '<form method="post" action="'; 
        echo $PHP_SELF; 
        echo '">
        <label for="about_me">Describe yourself:</label><br>
        <input type="text" name="oldPass" id="old_password" value="';
        echo $u['aboutme'];
        echo '"><br>
	<label for="interests">What are you interested in?</label><br>
        <input type="text" name="interests" id="interests" value="';
        echo $u['interests'];
        echo '"><br>
	<label for="skills">What skills do you have?</label><br>
        <input type="text" name="skills" id="skills" value="';
        echo $u['skills'];
        echo '"><br>
        <input type="submit" name="submitAboutMe" value="Update">
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

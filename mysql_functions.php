<?php

/*
 *  MySQL functions for connecting to and querying the database for various attributes
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *	@param string $u Username for the current user
 */
 function getUserData($c, $u)
 {
    //Query database get the data for the user (will use sessions later)
    $sql = "SELECT password FROM user WHERE username = '" . $u . "'";
    $resultRow = mysql_query($sql, $c);
	
    //Get the row with the user's data
    $user = mysql_fetch_assoc($resultRow);
	
	//If there is no user with the inputted name in the database
	if ($user == null)
    {
    	echo 'No such user!';
       	return false;
    }
	else
	{
		return $user;
	}
 }
 
/*
 *  MySQL function to verify that the entered password is correct during a login attempt
 *	@param password $text the user's entered password
 *	@param string $user the current user as returned by getUserData
 *  @param string $k the secret key which is hashed to become the salt
 */
function checkPass($text, $user, $k)
{
	$salt = md5($k);
	$decPass = (sha1($salt.$text));
	/*
	*	Replaced '==' comparison with strcmp() and surrounded the args with trim()
	*	to ensure an accurate comparison
	*	-Nathan
	*/
	if (strcmp(trim($user['password']), trim($decPass)) == 0)
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

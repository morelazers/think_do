<?php

    $eKey = 'TOPSECRET';

/**
 *  MySQL function for connecting to and querying the database for user data
 *  @param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *  @param string $u Username for the current user
 *	@return either false, if there is no such user, or an assosciative array containing all the fields from the users table
 */
 function getUserData($c, $u)
 {
    //Query database get the data for the user (will use sessions later)
    $sql = "SELECT * FROM user WHERE username = '" . $u . "'";
    $resultRow = mysql_query($sql, $c);

    //Get the row with the user's data
    $user = mysql_fetch_array($resultRow);

	//If there is no user with the inputted name in the database
	if ($user == null)
    {
    	echo 'no user';
       	return false;
    }
	else
	{
		return $user;
	}
 }

/**
 *  MySQL function for getting the data for an idea from the database using the URL as input
 *	@return either redirect the user to the error page, if there is no such idea, or an assosciative array containing all the fields from the idea table
 */
 function getIdea()
 {
	//Check for 'pid' parameter in URL
	if(array_key_exists("pid", $_GET))
	{
		$ideaID = $_GET["pid"];
		$idea = mysql_query("SELECT * FROM idea WHERE ideaID =" . $ideaID);
		//Get project data for the project from the database
		$ideaArray = mysql_fetch_array($idea);
		
		if ($ideaArray == null)
    	{
       		header('Location: error_page.php');
	    }
		else
		{
			return $ideaArray;
		}
	}
}
 /**
 *  MySQL function for getting comments for an idea
 *	@return either redirect the user to the error page, if there is no such idea, or an assosciative array containing all the fields from the idea table
 */
 function getComments()
 {
	//Check for 'pid' parameter in URL
	if(array_key_exists("pid", $_GET))
	{
		$ideaID = $_GET["pid"];
		$comments = mysql_query("SELECT * FROM comments WHERE ideaID =" . $ideaID);

		while(($commentArray = mysql_fetch_array($comments)) != null)
    	{
    		echo '<table border = "0" width="100%">';
       		echo '<tr><td>' . $commentArray['upVotes'] . '</td>';
       		echo '<td>' . $commentArray['username'] . '</td>';
       		echo '<td>' . $commentArray['datePosted'] . '</td></tr>';
       		echo '<tr><td colspan = "3">' . $commentArray['content'] . '</td></tr>';
       		echo '</table>';
		}
	}
}

/**
 *  MySQL function to verify that the entered password is correct during a login attempt
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *	@param string $text the entered password
 *  @param user $user the the current user
 */
function checkPass($c, $text, $user)
{
	global $eKey;
	$salt = md5($eKey);
	$decPass = (sha1($salt.$text));
	/*
	$sql = "SELECT password FROM user WHERE username = '" . $user['username'] . "'";
    $resultRow = mysql_query($sql, $c);
    $pass = mysql_fetch_assoc($resultRow);
    var_dump($pass);
    var_dump($decPass);
    */
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

/**
 *  MySQL function to change a user's password
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param user $user the entered username
 *  @param password $newpass the entered password
 */
function changePass($c, $user, $newpass)
{
	$encP = encrypt_data($newPass);
	$sql="UPDATE user SET password='".$encP."' WHERE username='".trim($user['username'])."'";
	if(!mysql_query($sql, $c))
    {
       	echo "could not update password";
       	die('Error: ' . mysql_error());
    }
    $user['password'] = $encP;
}

/**
 *  MySQL function to change the current user's profile information
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param string $a the user's 'About Me'
 *  @param string $i the user's interests, as comma-seperated indices
 *	@param string $s the user's skills, as comma-seperated indices
 */
function updateProfileInfo($c, $a, $i, $s)
{
	$u = $_SESSION['usr'];
	$sql = "UPDATE user SET aboutMe ='".$a."', interests = '".$i."', skills = '".$s."' WHERE username='".$u['username']."'";
    
	if(!mysql_query($sql, $c))
    {
       	echo "could not update profile information";
       	die('Error: ' . mysql_error());
    }
}

/**
*  Function to check if the inputs from a $_POST form are all filled in
*/
function inputIsComplete()
{
    //Add all empty fields to an array
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
}


/**
 *  MySQL function to change the information assosciated with an idea
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param string $d the description of the idea
 *  @param string $i any assosciated interests, as comma-seperated indices
 *	@param string $s any useful skills, as comma-seperated indices
 */
function updateIdeaInfo($c, $d, $i, $s)
{
	$sql = "UPDATE idea SET description ='".$d."', skillsRequired = '".$s."', interests = '".$i."'";
    
	if(!mysql_query($sql, $c))
    {
       	echo "could not update profile information";
       	die('Error: ' . mysql_error());
    }
}

/**
 *  Fcuntion to encrypt string data
 *	@param string $str string to be encrypted
 *  @return hexadecimal string
 */
function encrypt_data($str)
{
	global $eKey;
	$salt = md5($eKey);
	$encrypted_text = sha1($salt.$str);
	return $encrypted_text;
}

/**
 *  MySQL function to insert the data from the register form into the database
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param string $u the entered username
 *  @param string $e the entered email address
 *  @param string $p the entered password
 */
function insertIntoDB($c, $u, $e, $p)
{
	$encP = encrypt_data($p);

	function emailNewUser($eA)
   	{
		$subject = "Welcome to thinkdo!";
		$message = "Thanks for signing up to thinkdo!";
		$from = "admin@think.do";
		$headers = "From: " . $from;
		mail($eA, $subject, $message, $headers);
    }

    $sql="INSERT INTO user (username, email, password) VALUES ('$u', '$e', '$encP')";
    if (!mysql_query($sql, $c))
    {
       	echo 'Failed to add record';
   		die('Error: ' . mysql_error());
  	}
    else
    {
        echo 'You are registered!<br>Please login';
        emailNewUser($e);
        header('Location: index.php');
    }
    mysql_close($con);
}


/**
 *  MySQL function to check that an inputted username has not already been taken
 *	@param string $u the entered username
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function userIsNotTaken($u, $c)
{
    //Query database to check if username is taken
    $sql = "SELECT username FROM user WHERE username ='".$u."'";
  	$result = mysql_query($sql, $c);
  	$user = mysql_fetch_assoc($result);
  	//If username is not taken, add new user to database
   	if($user == null)
    {
        return true;
    }
    else
    {
	echo 'Username is already taken!';
        return false;
    }
}


/**
 *  MySQL function to get the details of an idea using it's unique ID
 *	@param string $id the idea's unique ID
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@return an assosciative array containing all the fields from the ideas table
 */
function getIdeaData($id, $c)
{
	$sql = "SELECT * FROM idea WHERE ideaID ='".$id."'";
	$result = mysql_query($sql, $c);
  	$idea = mysql_fetch_assoc($result);
  	return $idea;
}

/**
 *  MySQL function to get the number of upvotes for a particular idea
 *	@param Idea $i the given idea
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function incrementIdeaUpvotes($i, $u, $c)
{
	$i['upVotes']++;
	$sql = "UPDATE idea SET upVotes = ".$i['upVotes']." WHERE ideaID =".$i['ideaID']."";
	$result = mysql_query($sql, $c)
	or die(mysql_error());
	if($u['ideasVotedFor'] == null)
	{
		$sql = "UPDATE users SET ideasVotedFor = ".$i['ideaID']."";
	}
	else
	{
		$sql = "UPDATE users SET ideasVotedFor = ".$u['ideasVotedFor'].",".$i['ideaID']."";
	}
	$result = mysql_query($sql, $c)
	or die(mysql_error());
}

/**
 *  MySQL function to get the data for a particular comment from the database
 *	@param int $comid the comment's ID
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@return an assosciative array containing all the fields from the comments table
 */
function getCommentData($comid, $c)
{
	$sql = "SELECT * FROM comments WHERE commentID ='".$comid."'";
	$result = mysql_query($sql, $c);
  	$comment = mysql_fetch_assoc($result);
  	return $comment;
}

/**
 *  MySQL function to increment the upvotes on a particular comment
 *	@param comment $com the array of comment data, as returned by getCommentData
 *	@param user $u the user that has incremented the upvotes, as returned by getUserData (should already be in the session variable $_SESSION['usr'])
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function incrementCommentUpvotes($com, $u, $c)
{
	$com['upVotes']++;
	$sql = "UPDATE comments SET upVotes = ".$com['upVotes']." WHERE commentID =".$com['ideaID']."";
	$result = mysql_query($sql, $c)
	or die(mysql_error());
	if($u['commentVotes'] == null)
	{
		$sql = "UPDATE users SET commentVotes = ".$com['commentID']."";
	}
	else
	{
		$sql = "UPDATE users SET commentVotes = ".$u['commentVotes'].",".$com['commentID']."";
	}
	$result = mysql_query($sql, $c)
	or die(mysql_error());
}

/**
 *  Function to output the data from the idea to the page
 *  @param idea $i assosciative array containing the fields fom thr idea table
 */
function showIdea($i)
{
	//Output project information with appropriate markup
	echo '<h2>'.$i['ideaName'].'</h2><br>';
	echo '<h3>Idea Description:</h3><br>';
	echo '<p>'.$i['description'].'</p><br>';
	echo '<h3>Skills Needed:</h3><br>';
	echo '<p>'.$i['skillsRequired'].'</p><br>';
	echo '<h3>Idea Tags:</h3><br>';
	echo '<p>'.$i['interests'].'</p>';
}
?>

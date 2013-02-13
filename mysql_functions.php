<?php

    $eKey = 'TOPSECRET';

/*
 *  MySQL functions for connecting to and querying the database for various attributes
 *    @param MySQLConnection $c Connection to MySQL database, necessary to perform queries
 *	@param string $u Username for the current user
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
 
/*
 *  MySQL function to verify that the entered password is correct during a login attempt
 *	@param password $text the user's entered password
 *	@param string $user the current user as returned by getUserData
 *  @param string $k the secret key which is hashed to become the salt
 */
function checkPass($text, $user)
{
	global $eKey;
	$salt = md5($eKey);
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

/*
 *  MySQL function to change a user's password
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param user $user the entered username
 *  @param password $newpass the entered password
 */
function changePass($c, $user, $newpass)
{
	$encP = encrypt_data($newPass);
	$sql="UPDATE user SET password='".$encP."' WHERE username='".$user['username']."'";
	if(!mysql_query($c, $sql))
    	{
        	echo "could not update password";
    	}
}

function updateProfileInfo($c, $a, $i, $s)
{
	$sql = "UPDATE user SET aboutMe ='".$a."', interests = '".$i."', skills = '".$s."'";
    
	if(!mysql_query($c, $sql))
    	{
        	echo "could not update profile information";
    	}
}

function encrypt_data($str)
{
	global $eKey;
	$salt = md5($eKey);
	$encrypted_text = sha1($salt.$str);
	return $encrypted_text;
}

/*
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


/*
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


/*
 *  MySQL function to get the details of an idea using it's unique ID
 *	@param string $id the idea's unique ID
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function getIdeaData($id, $c)
{
	$sql = "SELECT * FROM idea WHERE ideaID ='".$id."'";
	$result = mysql_query($sql, $c);
  	$idea = mysql_fetch_assoc($result);
  	return $idea;
}

/*
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

function getCommentData($comid, $c)
{
	$sql = "SELECT * FROM comments WHERE commentID ='".$comid."'";
	$result = mysql_query($sql, $c);
  	$comment = mysql_fetch_assoc($result);
  	return $comment;
}

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
 
?>

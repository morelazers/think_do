<?php

 /**
 *  MySQL function for getting comments for an idea
 */
 function getComments()
 {
	//Check for 'pid' parameter in URL
	if(array_key_exists("pid", $_GET))
	{
		$ideaID = $_GET["pid"];
		$comments = mysql_query("SELECT * FROM comments WHERE ideaID =" . $ideaID . " ORDER BY upVotes DESC");

		while(($commentArray = mysql_fetch_array($comments)) != null)
    	{
			$user = mysql_query("SELECT * FROM user WHERE username ='" . $commentArray['username'] . "'");
			$userArray = mysql_fetch_array($user);
			echo '<div style="width:100%">';
       		echo '<div style="float:left"><img width="50px" height="50px" src="' . $userArray['avatarLocation'] . '"/></div>';
       		echo '<div style="float:right"><h2>' . $commentArray['username'] . '</h2></br>';
       		echo  $commentArray['content'] . '</div>';
       		echo '</div>';
		}
	}
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


?>

<?php

function userHasVotedOnComment($c, $u){

	if(strcmp($u['commentVotes'], $c['commentID']) == 0){
    	return true;
    }
	$votedArray = explode(",", $u['commentVotes']);
	if(in_array($c['commentID'], $votedArray)){
		return true;
	}
	return false;
}

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
		echo '<div class="allComments">';
		while(($commentArray = mysql_fetch_array($comments)) != null)
    	{
			$user = mysql_query("SELECT * FROM user WHERE username ='" . $commentArray['username'] . "'");
			$userArray = mysql_fetch_array($user);
            
			echo '<div class="commentContainer" id="'.$commentArray["commentID"].'">';
            echo '<div id="voteContainer">';
            echo '<div class="buttonContainer"><input type="button" id="upvoteOn" class="';
            
            if(userHasVotedOnComment($commentArray, $_SESSION['usr']))
            {
              	echo 'commentVote voted';
            }
            else
            {
            	echo 'commentVote';
            }
            
            echo '" onclick="upvoteCommentFunction('.$commentArray['commentID'].')" ';
            
            if(!isset($_SESSION['usr']))
            {
            	echo 'disabled';
            }
                       
            echo '></div><div class="voteamount">'.$commentArray['upVotes'].'</div></div>';
       		echo '<div class="commentAvatar"><img src="' . $userArray['avatarLocation'] . '"/></div>';
               
       		echo '<div class="commentText"><h3><a href="./profile.php?user=' . $commentArray['username'] . '">' . $commentArray['username'] . '</a></h3>';
       		echo  $commentArray['content'] . '</div>';
       		echo '<br>';
       		echo '</div>';
		}
    echo' </div>';
	}
}


/**
 *  MySQL function to get the data for a particular comment from the database
 *	@param int $comid the comment's ID
 *	@return an assosciative array containing all the fields from the comments table
 */
function getCommentData($comid)
{
	$sql = "SELECT * FROM comments WHERE commentID =".$comid;
	$result = mysql_query($sql);
  	$comment = mysql_fetch_array($result);
  	return $comment;
}

/**
 *  MySQL function to increment the upvotes on a particular comment
 *	@param comment $com the array of comment data, as returned by getCommentData
 *	@param user $u the user that has incremented the upvotes, as returned by getUserData (should already be in the session variable $_SESSION['usr'])
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 */
function incrementCommentUpvotes($com, $u)
{
	$com['upVotes']++;
	$sql = "UPDATE comments SET upVotes=".$com['upVotes']." WHERE commentID=".$com['commentID'];
	mysql_query($sql) or die(mysql_error());
	if($u['commentVotes'] == '')
	{
		$sql = "UPDATE user SET commentVotes='".$com['commentID']."' WHERE userID=".$u['userID'];
	}
	else
	{
		$sql = "UPDATE user SET commentVotes='".$u['commentVotes'].",".$com['commentID']."' WHERE userID=".$u['userID'];
	}
	$result = mysql_query($sql) or die(mysql_error());
}


function decrementCommentUpvotes($com, $u)
{
	$com['upVotes']--;
	$sql = "UPDATE comments SET upVotes = ".$com['upVotes']." WHERE commentID =".$com['commentID'];
	mysql_query($sql) or die(mysql_error());
	$sql = "SELECT commentVotes FROM user WHERE userID = ".$u['userID'];
	$res = mysql_query($sql) or die(mysql_error());
	$commentsString = mysql_fetch_array($res);
	$commentsArray = explode(',', $commentsString['commentVotes']);
    
	$count = 0;

	$id = $com['commentID'];

	$newUpvoteArray = array();

	for($count; $count < count($commentsArray); $count++)
	{
		if($commentsArray[$count] == $id)
		{
			$commentsArray[$count] = null;
		}
		else
		{
			$newUpvoteArray[] = $commentsArray[$count];
		}
	}
	$commentsString = implode(',', $newUpvoteArray);

	$sql = "UPDATE user SET commentVotes = '".$commentsString."' WHERE userID = ".$u['userID'];
	mysql_query($sql) or die(mysql_error());
}

?>

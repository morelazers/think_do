<?php

/**
 *  MySQL function for getting the data for an idea from the database using the URL as input
 *  @return either redirect the user to the error page, if there is no such idea, or an assosciative array containing all the fields from the idea table
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


function getHomepageIdeas($c)
{
	$sql = "SELECT * FROM idea WHERE isOpen = 1 ORDER BY upVotes DESC LIMIT 10";
	//var_dump($sql);
	$res = mysql_query($sql, $c) or die(mysql_error());
	//var_dump($res);
	if($res != null)
	{
		outputIdeas($res);
	}
}

function outputIdeas(&$ideas)
{
	$count = 0;
	//Create a table and output the project creator, created date and project name to table. The project name is linked to the project page
	while($ideasArray = mysql_fetch_array($ideas))
	{
		$iName = $ideasArray['ideaName'];
		$createdBy = $ideasArray['createdBy'];
		$dateCreated = $ideasArray['dateCreated'];
		$iID = $ideasArray['ideaID'];
		$iVotes = $ideasArray['upVotes'];
		echo '<div class="idea">';
		echo '<div class="ideaVotes">' .$iVotes. '</div>';
		echo '<div class="ideaText"><h2><a href="./view_ideas.php?pid='.$iID.'">'.$iName.'</a></h2></br>';
		echo 'Shared by: ' .$createdBy. ' on: ' .$dateCreated. '</div>';
		echo '</div>';
		$count++;
	}
	if($count == 0)
	{
		echo '<h2>There seem to be no ideas that suit your interests,
		<br>
		try updating them to include a few more areas, or share an idea of your own!</h2>';
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
function incrementIdeaUpvotes($i, &$u, $c)
{
	$i['upVotes']++;
	//var_dump($i);
	$sql = "UPDATE idea SET upVotes = ".$i['upVotes']." WHERE ideaID =".$i['ideaID'];
	//var_dump($sql);
	mysql_query($sql, $c) or die(mysql_error());
	if($u['ideasVotedFor'] == '')
	{
		$sql = "UPDATE user SET ideasVotedFor = ".$i['ideaID']." WHERE userID = ".$u['userID'];
		$u['ideasVotedFor'] = $i['ideaID'];
		
	}
	else
	{
		$sql = "UPDATE user SET ideasVotedFor = '".$u['ideasVotedFor'].",".$i['ideaID']."' WHERE userID = ".$u['userID'];
		$u['ideasVotedFor'] = $u['ideasVotedFor'] . ',' . $i['ideaID'];
	}
	//var_dump($sql);
	mysql_query($sql, $c) or die(mysql_error());
}

function decrementIdeaUpvotes($i, &$u, $c)
{
	$i['upVotes']--;
	$sql = "UPDATE idea SET upVotes = ".$i['upVotes']." WHERE ideaID =".$i['ideaID'];
	mysql_query($sql, $c) or die(mysql_error());
	$sql = "SELECT ideasVotedFor FROM user WHERE userID = ".$u['userID'];
	$res = mysql_query($sql) or die(mysql_error());
	$ideasString = mysql_fetch_array($res);

	var_dump($ideasString);
	
	$ideasArray = explode(',', $ideasString['ideasVotedFor']);
	$count = 0;

	var_dump($ideasArray);

	for($count; $count <= count($ideasArray); $count++)
	{
		if(strcmp($ideasArray[$count], $i['$ideaID']) == 0)
		{
			$ideasArray[$count] = null;
		}
	}

	var_dump($ideasArray);

	$ideasString = implode(',', $ideasArray);

	var_dump($ideasString);

	$sql = "UPDATE user SET ideasVotedFor = '".$ideasString."' WHERE userID = ".$u['userID'];
	$u['ideasVotedFor'] = $ideasString;
	
	mysql_query($sql, $c) or die(mysql_error());
}

function userHasVoted($i, $u){
	$votedArray = explode(",", $u['ideasVotedFor']);
	if(in_array($i['ideaID'], $votedArray)){
		return true;
	}
	return false;
}

function joinIdeaTeam($i, $u, $c){
	if($i['helpers'] == '')
	{
		$sql = "UPDATE idea SET helpers = ".$u['userID']." WHERE ideaID = ".$i['ideaID'];
	}
	else
	{
		$sql = "UPDATE idea SET helpers = '".$i['helpers'].",".$u['userID']."' WHERE ideaID = ".$i['ideaID'];
	}
	mysql_query($sql, $c) or die(mysql_error());
}

/**
 *	Function checks the member status of the user and idea. Returns 1 if the
 *	user is a helper, 2 if the user is a moderator and 0 if the user is not 
 *	currently part of the idea team
 */
function userMemberStatus($i, $u, $c){
	//Check if user is a helper
	$helpersArray = explode(",", $i['helpers']);
	if(in_array($u['userID'], $helpersArray)){
		return 1;
	}
	
	//Check if user is a moderator
	$moderatorArray = explode(",", $i['moderators']);
	if(in_array($u['userID'], $moderatorArray)){
		return 2;
	}
	
	return 0;
}

/**
 *  Function to output the data from the idea to the page
 *  @param idea $i assosciative array containing the fields fom thr idea table
 */
function showIdea($i)
{
	//Output project information with appropriate markup
	echo '<h2>'.$i['ideaName'].'</h2>';
	echo '<p>'.$i['description'].'</p><br>';
}

function showSidebarContent($i)
{
	echo '<h2>Skills Needed:</h2>';
	echo '<p>'.$i['skillsRequired'].'</p><br>';
	echo '<h3>Idea Tags:</h3>';
	echo '<p>'.getInterestsAsStrings($i['interests']).'</p>';	
}

?>

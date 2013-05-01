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

function getIdeaAvatar($i)
{
	$user = mysql_query("SELECT * FROM user WHERE username ='" . $i['createdBy'] . "'");
	$userArray = mysql_fetch_array($user);
	echo '<div style="float:left; padding-right:5px;"><img width="70px" height="70px" src="' . $userArray['avatarLocation'] . '"/></div>' 
	. '<div style="float:right;width:165px; height:80px; overflow:hidden"><h2>Shared by: </h2><h1>'. $i['createdBy']. "</h1></div>" ;
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
		$dateCreated = date("d m Y", $dateCreated);
		$iID = $ideasArray['ideaID'];
		$iVotes = $ideasArray['upVotes'];
		echo '<div class="idea">';
		echo '<div class="ideaVotes">' .$iVotes. '</div>';
		echo '<div class="ideaText"><h2><a href="./view_ideas.php?pid='.$iID.'">'.$iName.'</a></h2></br>';
		echo 'Shared by: ' .$createdBy. '</div>';
		echo '</div>';
		$count++;
	}
	if($count == 0)
	{
		echo '<h2>There seem to be no ideas here!<br><br></h2>';
	}

}

/**
 *  MySQL function to change the information assosciated with an idea
 *	@param MySQLConnection $c Connection to MySQL database, necessary to perform operations
 *	@param string $d the description of the idea
 *  @param string $i any assosciated interests, as comma-seperated indices
 *	@param string $s any useful skills, as comma-seperated indices
 */
function updateIdeaInfo($c, $i)
{
	$sql = "UPDATE idea SET description ='".$i['description']."', skillsRequired = '".$i['skillsRequired']."', interests = '".$i['interests']."' WHERE ideaID = ".$i['ideaID'];
    //LOOK HERE PLEASE
	mysql_query($sql) or die(mysql_error());
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
	$ideasArray = explode(',', $ideasString['ideasVotedFor']);
	$count = 0;

	/*var_dump($i['ideaID']);
	echo '<br>';*/
	$id = $i['ideaID'];
	/*var_dump(count($ideasArray));
	echo '<br>';*/

	$newUpvoteArray = array();

	for($count; $count < count($ideasArray); $count++)
	{

		/*var_dump($ideasArray[$count]);
		echo '<br>';*/

		
		if($ideasArray[$count] == $id)
		{
			/*echo 'found the array value!';*/
			$ideasArray[$count] = null;
			//break;
		}
		else
		{
			$newUpvoteArray[] = $ideasArray[$count];
		}
	}

	/*var_dump($newUpvoteArray);
	echo '<br>';*/

	$ideasString = implode(',', $newUpvoteArray);

	/*var_dump($ideasString);
	echo '<br>';*/

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
 *	Function to check whether the current user is the creator of the idea
 *	@param $u - the current user
 *	@param $i - the current idea
 */
function currentUserIsIdeaCreator($u, $i)
{
	if(strcmp($u['username'], $i['createdBy']) == 0)
	{
		return true;
	}
	return false;
}

/**
 *  Function to output the data from the idea to the page
 *  @param idea $i assosciative array containing the fields fom thr idea table
 */
function showIdea($i)
{
	//Output project information with appropriate markup
	echo '<h2 id="ideaName">'.$i['ideaName'].'</h4>';
	echo '<p id="ideaDescription">'.$i['description'].'</p><br>';
}

function showSidebarContent($i)
{
	echo '<h2>Skills Needed:</h2>';
	echo '<p>'.$i['skillsRequired'].'</p><br>';
	echo '<h2>Related Interests:</h3>';
	echo '<p>'.getInterestsAsStrings($i['interests']).'</p>';	
}

function showIdeaForm($i) 
{
    echo '<form method="post" name="ideaForm" action="'; echo $PHP_SELF; echo '">
    <label for="idea_title"><h2>Name it</h2></label>
    <input type="text" name="ideaName" id="idea_title" title="What&#39;s the name of your idea?" value="';
	echo $i["ideaName"];
    echo '"><br>
    <label for="idea_desc"><h2>Describe it</h2></label>
    <textarea rows="10" cols="30" name="ideaDescription" id="idea_desc" title="How would you describe it?" value="';
    echo $i["ideaDescription"]; 
    echo '"></textarea><br>
    <label for="skills"><h2>Desirable Skills</h2></label>
    <input type="text" name="iSkills" id="skills" title="What skills are you looking for?" value="';
    echo $i["iSkills"];
    echo '"><br><div class="ui-helper-clearfix">
    <label for="interests"><h2>Interests:</h2></label>
    <input type="text" name="iInterests" id="interests" title="What interests would you want people to have?" value="';
    echo $i["iInterests"];
    echo '"></div><label for="Privacy"><h2>Hide it?</h2></label>';
    if(array_key_exists("iPrivacy", $i))
    {
	    if($i["iPrivacy"] == "public")
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public';
	    }
	    else
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="public">Public';
	    }
	    if($i["iPrivacy"] == "private")
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="private" checked="checked">Private';
	    }
	    else
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="private">Private';
	    }
    }
    else
    {
      	echo '<input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public
        <input type="radio" name="iPrivacy" id="privacy" value="private">Private';
	}
	echo '<br><input type="submit" name="submit" class="normalButton" value="Submit"></form></div>';
}

?>

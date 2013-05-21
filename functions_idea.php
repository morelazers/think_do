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
		return $ideaArray;
	}
}

function getIdeaFromID($id)
{
	$idea = mysql_query("SELECT * FROM idea WHERE ideaID =" . $id);
	
	if ($ideaArray == null)
	{
   		header('Location: error_page.php');
    }
	else
	{
		return $idea;
	}
}

function getIdeaAvatar($i)
{
	$user = mysql_query("SELECT * FROM user WHERE username ='" . $i['createdBy'] . "'");
	$userArray = mysql_fetch_array($user);
	echo '<div class="ideaAvatar"><img src="' . $userArray['avatarLocation'] . '"/></div>' 
	. '<div class="ideaCreatorHead"><h2>Shared by: </h2><h1><a class="idea-creator" href="./profile.php?user='. $i['createdBy']. '">'. $i['createdBy']. '</a></h1></div>' ;
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
	if($ideas != null)
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

            //echo '<a href="javascript:animatedcollapse.toggle('.$iID.')">';

            echo '<div class="idea">';
            echo '<div class="ideaVotes">' .$iVotes. '</div>';
            echo '<div class="ideaText"><h2><a href="./view_idea.php?pid='.$iID.'">'.$iName.'</a></h2>';
            echo 'Shared by: <a class="profile-link" href="./profile.php?user=' .$createdBy. '">'.$createdBy.'</a></div>';

            echo '</div>';
            //echo '</a>';

            /*echo '
            <div id="'.$iID.'" class="ideaDropdown" style="display:none">
            <p>'.$ideasArray['description'].'</p><br>
            </div>
            ';*/

            //echo "<script> animatedcollapse.addDiv(".$iID.") </script>";

            $count++;
        }
   }
   if($ideas == null or $count == 0)
   {
     	echo '<h2>There seem to be no ideas here!<br><br></h2>';
   }

   //echo "<script> animatedcollapse.init() </script>";

}

/**
 *  MySQL function to change the information assosciated with an idea
 *	@param $i - the array of the idea to update the database with
 *  @param $ID - the ID of the idea that is being edited
 */
function updateIdeaInfo($i, $ID)
{
	$iName = mysql_real_escape_string($i["ideaName"]);
    $iDesc = mysql_real_escape_string($i["description"]);
    $iSkills = mysql_real_escape_string($i["skillsRequired"]);
    $iInterests = mysql_real_escape_string($i["interests"]);
    $interestIDs = getInterestIDs($iInterests, $con);
    if($i["iPrivacy"]=="public")
    {
        $iOpen = 1;
    }
    else
    {
        $iOpen = 0;
    }
    $sql = "UPDATE idea SET ideaName = '".$iName."', 
    description ='".$iDesc."', 
    skillsRequired ='".$iSkills."', 
    interests ='".$interestIDs."', 
    isOpen='".$iOpen."' 
    WHERE ideaID =".$ID."";
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

function removeInterestInIdea($i, $u, $c)
{
	$sql = "SELECT helpers FROM idea WHERE ideaID = ".$i['ideaID'];
	$res = mysql_query($sql) or die(mysql_error());
	$helpersRow = mysql_fetch_array($res);
	$helpersArray = explode(',', $helpersRow['helpers']);
	$count = 0;

	$id = $u['userID'];

	$newHelperArray = array();

	for($count; $count < count($helpersArray); $count++)
	{
		if($helpersArray[$count] == $id)
		{
			$helpersArray[$count] = null;
		}
		else
		{
			$newHelperArray[] = $helpersArray[$count];
		}
	}

	$helpersString = implode(',', $newHelperArray);

	$sql = "UPDATE idea SET helpers = '".$helpersString."' WHERE ideaID = ".$i['ideaID'];
	
	mysql_query($sql, $c) or die(mysql_error());
}

function userHasVoted($i, $u){
	if(strcmp($u['ideasVotedFor'], $i['ideaID'])==0){
		return true;
	}
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
    echo '<div id ="ideaForm"><form method="post" name="ideaForm" action="handle_idea_form.php">
    <label for="idea_title"><h2>Name it</h2></label>
    <input type="text" name="ideaName" id="idea_title" title="What&#39;s the name of your idea?" value="';
	echo $i["ideaName"];
    echo '"><br>
    <label for="idea_desc"><h2>Describe it</h2></label>
    <textarea rows="10" cols="30" name="description" id="idea_desc" title="How would you describe it?">';
    echo $i["description"]; 
    echo '</textarea><br>
    <label for="skillsRequired"><h2>Desirable Skills</h2></label>
    <input type="text" name="skillsRequired" id="skillsRequired" title="What skills are you looking for?" value="';
    echo $i["skillsRequired"];
    echo '"><br><div class="ui-helper-clearfix">
    <label for="interests"><h2>Interests:</h2></label>
    <input type="text" name="interests" id="interests" title="What interests would you want people to have?" value="';
    if(isset($i['interests']))
    {
    	$interestsToDisplay = getInterestsAsStrings($i['interests']);
    	echo $interestsToDisplay;
    }
    else
    {
    	echo $i["interests"];
    }
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

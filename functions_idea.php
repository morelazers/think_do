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
	echo '<p>'.getInterestsAsStrings($i['interests']).'</p>';
}

function getInterestsAsStrings($IDString)
{
	$IDArray = explode(',', $IDString);
	$StringArray = array();
	foreach($IDArray as $val)
	{
		 $StringArray[] = $GLOBALS['interests'][$val];
	}
	$interestString = implode(', ', $StringArray);
	return $interestString;
}


?>

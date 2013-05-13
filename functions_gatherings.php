<?php

/*
* gets the data for a gathering given its ID
*/
function getGatheringData($ID)
{
	$sql = "SELECT * FROM gatherings WHERE gathID=".$ID;
	$res = mysql_query($sql) or die(mysql_error());
	return mysql_fetch_array($res);
}

/*
* adds a gathering to the database, given the idea and the gathering array
*/
function createGathering($i, $g)
{
		$gDesc = mysql_real_escape_string($g['gatheringDescription']);
		$gLoc = mysql_real_escape_string($g['gatheringLocation']);
		$date = $g['gatheringDate'];
		$time = $g['gatheringTime'];
		$sql = "INSERT INTO gatherings (gathDescription, gathLocation, gathDate, gathTime, proposedBy, forIdea)
		VALUES ('".$gDesc."', '".$gLoc."', '".$date."', '".$time."', '".$_SESSION['usr']['username']."', ".$i['ideaID'].")";
		mysql_query($sql) or die(mysql_error());
}

/*
* gets all the gatherings for the given idea
*/
function getIdeaGatherings($i)
{
	$sql = "SELECT * FROM gatherings WHERE forIdea = ".$i['ideaID'];
	$res = mysql_query($sql);
	//$gaths = mysql_fetch_array($res);
	return $res;
}

/*
* displays all the gatherings for a given idea
*/
function displayGatherings(&$g)
{
	$count = 0;
	while ($curGath = mysql_fetch_array($g))
	{
		//var_dump($curGath);
        echo '<a href="javascript:animatedcollapse.toggle(\'gath'.$count.'\')">';
		echo '<div class="gath">';
		echo '<div class="gathLocation">'.$curGath['gathLocation'].'</div>';

		//<a href="./view_gathering.php?pid='.$curGath['gathID'].'"></a>
		echo '</div>';
		echo '</a>';

		echo '
        <div id="gath'.$count.'" class="gathDropdown" style="display:none">
        <p><br>'.$curGath['gathDescription'].'<br></p>
        </div>
        ';

		echo '<div class="gathDate"><td><p>Proposed Date: '.$curGath['gathDate'].' </td>';
		echo '<td>Proposed Time: '.$curGath['gathTime'].' </p></td></div>';


        echo "<script> animatedcollapse.addDiv('gath".$count."') </script>";

		$count++;
	}
	
	if($count == 0)
	{
		echo '<h2>No gatherings have been proposed for this idea yet!</h2>';
	}

	echo "<script> animatedcollapse.init() </script>";
}

/*
* show a single gathering given its ID
*/
function showGathering($gID)
{
	//var_dump($gathID);
	$sql = "SELECT * FROM gatherings WHERE gathID =" . $gID;
	$res = mysql_query($sql) or die(mysql_error());
	//Get project data for the project from the database
	$gath = mysql_fetch_array($res);
	//var_dump($task);
	
	if ($gath == null)
	{
   		header('Location: error_page.php');
   		//echo 'help';
    }
	else
	{
		echo '<h2 id="gathLocation">'.$gath['gathLocation'].'</h2><br>';
		echo '<h3 id="motiveHeading">Motive:</h3><br>';
		echo '<p id="motive">'.$gath['gathDescription'].'</p><br>';
	}
}

/*
* returns true if the current user is attending the gathering with the given ID, otherwise returns false
*/
function userIsAttendingGathering($gID)
{
	$u = $_SESSION['usr'];
	$gathsArray = explode(',', $u['gathsAttending']);
	if(in_array($gID, $gathsArray))
	{
		return true;
	}
	return false;
}

/*
* shows the contents of the sidebar for the gathering with given ID
*/
function showGathSidebarContent($gID)
{
	if(isset($_SESSION['usr']))
	{
		if(!userIsAttendingGathering($gID))
		{
			echo '<form method="post" action="'; echo $PHP_SELF; echo '">
			<input type="submit" name="attendGath" value="I\'m going!">
		    </form><br><br>';
		}
		else
		{
			echo '<form method="post" action="'; echo $PHP_SELF; echo '">
			<input type="submit" name="cancelAttend" value="I\'m not going!">
		    </form><br><br>';
		}
	}
}

/*
* marks the gathering with given ID as being attended by the current user
*/
function markAsAttending($gathID)
{
	$u = $_SESSION['usr'];
	if(isset($u['gathsAttending']))
	{
		$sql = "UPDATE user SET gathsAttending='".$u['gathsAttending'].','.$gathID."' WHERE userID=".$u['userID'];
	}
	else
	{
		$sql = "UPDATE user SET gathsAttending='".$gathID."' WHERE userID=".$u['userID'];
	}
	mysql_query($sql) or die(mysql_error());
}

/*
* marks the gathering with given ID as no longer being attended by the current user
*/
function markAsNotAttending($gID)
{
	$u = $_SESSION['usr'];
	$gathArray = explode(',', $u['gathsAttending']);
	$newgathArray = array();
	$i = 0;
	for($i; $i < count($gathArray); $i++)
	{
		if($gathArray[$i] == $gID)
		{
			$gathArray[$i] = null;
		}
		else
		{
			$newgathArray[] = $gathArray[$i];
		}
	}
	$gathList = implode(',', $newgathArray);
	$sql = "UPDATE user SET gathsAttending='".$gathList."' WHERE userID=".$u['userID'];
	mysql_query($sql) or die(mysql_error());
}

/*
* updates the information for the current gathering
*/
function updateGathering($gath, $ID)
{
	$gDesc = mysql_real_escape_string($gath['gathDescription']);
	$gLoc = mysql_real_escape_string($gath['gathLocation']);
	$date = $gath['gathDate'];
	$time = $gath['gathTime'];
	$sql = "UPDATE gatherings SET gathDescription='".$gDesc."', gathLocation='".$gLoc."', gathDate='".$date."', gathTime='".$time."' WHERE gathID=".$ID;
	mysql_query($sql) or die(mysql_error());
}

/*
* returns true if the given user is the poster of the given gathering
*/
function currentUserIsGatheringProposer($u, $g)
{

	if(strcmp($u['username'], $g['proposedBy']) == 0)
	{
		return true;
	}
	return false;
}

/*
* shows the form with data from the given array
*/
function showGatheringForm($g)
{
	echo '<div id="gathForm"><form method="post" action="#tabs-3">
    <label for="gathDescription">What should the gathering accomplish?</label><br>
    <input type="text" name="gathDescription" id="gathDescription" value="';
    echo $g['gathDescription'];
    echo '"><br>
	<label for="gathLocation">Where will it be?</label><br>
    <input type="text" name="gathLocation" id="gathLocation" value="';
    echo $g['gathLocation'];
    echo '"><br>
	<label for="gathDate">On which date?</label><br>
    <input type="date" name="gathDate" id="gathDate" value="';
    echo $g['gathDate'];
    echo '"><br>
    <label for="gathTime">At what time?</label><br>
    <input type="time" name="gathTime" id="gathTime" value="';
    echo $g['gathTime'];
    echo '"><br>
    <input type="submit" name="submitGathering" value="Submit">
    </form></div><br><br>';
}

?>

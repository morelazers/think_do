<?php


function getGatheringData($ID)
{
	$sql = "SELECT * FROM gatherings WHERE gethID=".$ID;
	$res = mysql_query($sql) or die(mysql_error());
	return mysql_fetch_array($res);
}

function createGathering($i)
{
		$gDesc = mysql_real_escape_string($_POST['gatheringDescription']);
		$gLoc = mysql_real_escape_string($_POST['gatheringLocation']);
		$date = $_POST['gatheringDate'];
		$time = $_POST['gatheringTime'];
		$sql = "INSERT INTO gatherings (gathDescription, gathLocation, gathDate, gathTime, proposedBy, forIdea)
		VALUES ('".$gDesc."', '".$gLoc."', '".$date."', '".$time."', ".$_SESSION['usr']['userID'].", ".$i['ideaID'].")";
		mysql_query($sql) or die(mysql_error());
}


function getIdeaGatherings($i)
{
	$sql = "SELECT * FROM gatherings WHERE forIdea = ".$i['ideaID'];
	$res = mysql_query($sql);
	//$gaths = mysql_fetch_array($res);
	return $res;
}

function displayGatherings(&$g)
{
	$count = 0;
	while ($curGath = mysql_fetch_array($g))
	{
		//var_dump($curGath);
		echo '<tr>';
		echo '<td><h2><a href="./view_gathering.php?pid='.$curGath['gathID'].'">'.$curGath['gathLocation'].'</a></h2></td>';
		echo '<td>Proposed Date: '.$curGath['gathDate'].' </td>';
		echo '<td>Proposed Time: '.$curGath['gathTime'].' </td>';
		echo '</tr>';
		$count++;
	}
	
	if($count == 0)
	{
		echo '<h2>No gatherings have been proposed for this idea yet!</h2>';
	}
}

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


function showGatheringForm($g)
{
	echo '<div id="gathForm"><form method="post" action="#tabs-3">
    <label for="gatheringDescription">What should the gathering accomplish?</label><br>
    <input type="text" name="gatheringDescription" id="gatheringDescription" value="';
    echo $g['gatheringDescription'];
    echo '"><br>
	<label for="gatheringLocation">Where will it be?</label><br>
    <input type="text" name="gatheringLocation" id="gatheringLocation" value="';
    echo $g['gatheringLocation'];
    echo '"><br>
	<label for="gatheringDate">On which date?</label><br>
    <input type="date" name="gatheringDate" id="gatheringDate" value="';
    echo $g['gatheringDate'];
    echo '"><br>
    <label for="gatheringTime">At what time?</label><br>
    <input type="time" name="gatheringTime" id="gatheringTime" value="';
    echo $g['gatheringTime'];
    echo '"><br>
    <input type="submit" name="submitGathering" value="Submit">
    </form></div><br><br>';
}

?>

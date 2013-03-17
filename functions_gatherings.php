<?php

function createGathering()
{
		$gDesc = mysql_real_escape_string($_POST['gatheringDescription']);
		$gLoc = mysql_real_escape_string($_POST['gatheringLocation']);
		$date = $_POST['gatheringDate'];
		$time = $_POST['gatheringTime'];
		$sql = "INSERT INTO gatherings (gathDescription, gathLocation, gathDate, gathTime, proposedBy, forIdea)
		VALUES ('".$gDesc."', '".$gLoc."', '".$date."', '".$time."', ".$_SESSION['usr']['userID'].", ".$idea['ideaID'].")";
		mysql_query($sql) or die(mysql_error());
}


function getIdeaGatherings($i)
{
	$sql = "SELECT * FROM gatherings WHERE forIdea = ".$i['ideaID'];
	$res = mysql_query($sql);
	return $res;
}

function displayGatherings(&$g)
{
	$count = 0;
	while ($curGath = mysql_fetch_array($g))
	{
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
	$_SESSION['usr'] = getUserData($con, $u['username']);
}

?>
<?php

function getIdeaGatherings($i)
{
	$sql = "SELECT * FROM gatherings WHERE forIdea = ".$i['ideaID'];
	$res = mysql_query($sql);
	//$gaths = mysql_fetch_array($res);
	return $res;
}

function displayGatherings(&$g)
{
	while ($curGath = mysql_fetch_array($g))
	{
		//var_dump($curGath);
		echo '<tr>';
		echo '<td><h2><a href="./view_gathering.php?pid='.$curGath['gathID'].'">'.$curGath['gathLocation'].'</a></h2></td>';
		echo '<td>'.$curGath['gathDate'].'</td>';
		echo '<td>'.$curGath['gathTime'].'</td>';
		echo '</tr>';
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
<?php

function getIdeaGatherings($i)
{
	$sql = "SELECT * FROM gatherings WHERE forIdea = ".$i['ideaID'];
	$res = mysql_query($sql);
	$gaths = mysql_fetch_array($res);
	return $gaths;
}

function displayGatherings($g)
{
	while ($curGath = mysql_fetch_array($g))
	{
		echo '<tr>';
		echo '<td><h2><a href="./view_gathering.php?pid='.$curGath['taskID'].'">'.$curGath['gathLocation'].'</a></h2></td>';
		echo '<td>'.$curGath['gathDate'].'</td>';
		echo '<td>'.$curGath['gathTime'].'</td>';
		echo '</tr>';
	}
}

?>
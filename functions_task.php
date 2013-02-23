<?php


function createTask($i, $n, $d, $u, $c)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tasks (ideaID, taskName, username, taskDescription, complete, dateCreated)
	VALUES ('" . $i['ideaID'] . "', '".$n."', '". $u['username'] ."', '".$d."', '0', '".$now."' )";
	mysql_query($sql, $c)
	or die(mysql_error());
}


function getIdeaTasks($i)
{
	$sql = "SELECT * FROM tasks WHERE ideaID = ".$i['ideaID'];
	$res = mysql_query($sql);
	return $res;
}

function displayTasks(&$t)
{
	while ($curTask = mysql_fetch_array($t))
	{
		echo '<tr>';
		echo '<td><h2><a href="./view_task.php?pid='.$curTask['taskID'].'">'.$curTask['taskName'].'</a></h2></td>';
		echo '<td>'.$curTask['username'].'</td>';
		echo '<td>'.$curTask['dateCreated'].'</td>';
		echo '</tr>';
	}
}


?>
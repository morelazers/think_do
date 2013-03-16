<?php


function createTask($i, $n, $d, $dline, $u, $c)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tasks (ideaID, taskName, username, taskDescription, complete, deadline, dateCreated)
	VALUES ('".$i['ideaID']."', '".$n."', '".$u['username']."', '".$d."', 0, '".$dline."', '".$now."')";
	mysql_query($sql, $c) or die(mysql_error());
}


function getIdeaTasks($i)
{
	$sql = "SELECT * FROM tasks WHERE ideaID = ".$i['ideaID'];
	$res = mysql_query($sql);
	return $res;
}

function displayTasks(&$t)
{
	$count = 0;
	while ($curTask = mysql_fetch_array($t))
	{
		echo '<tr>';
		echo '<td><h2><a href="./view_task.php?pid='.$curTask['taskID'].'">'.$curTask['taskName'].'</a></h2></td>';
		echo '<td>Created by: '.$curTask['username'].' </td>';
		echo '<td>On: '.$curTask['dateCreated'].' </td>';
		if(isset($curTask['deadline']))
		{
			echo '<td>Deadline: '.$curTask['deadline'].'</td>';
		}
		else
		{
			echo '<td>No deadline has been specified for this task.</td>';
		}
		echo '</tr>';
		$count++;
	}
	
	if($count == 0)
	{
		echo '<h2>No tasks have been posted for this idea yet!</h2>';
	}
}

function doTask($tID)
{
	include 'functions_user.php';
	$u = $_SESSION['usr'];
	if (isset($u['doingTasks']))
	{
		$sql = "UPDATE user SET doingTasks='".$tID."'";
	}
	else
	{
		$sql = "UPDATE user SET doingTasks='".$u['doingTasks'].','.$tID."'";
	}
	mysql_query($sql) or die(mysql_error());
	$_SESSION['usr'] = getUserData($con, $u['username']);
}


?>
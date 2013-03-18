<?php


function createTask($i, $n, $d, $og, $dline, $u, $c)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tasks (ideaID, taskName, username, taskDescription, ongoing, complete, deadline, dateCreated)
	VALUES ('".$i['ideaID']."', '".$n."', '".$u['username']."', '".$d."', ".$og.", 0, '".$dline."', '".$now."')";
	mysql_query($sql, $c) or die(mysql_error());
	$tasks = getIdeaTasks($i);
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
		if(isset($curTask['deadline']) && strcmp($curTask['deadline'], '0000-00-00') != 0)
		{
			echo '<td>Deadline: '.$curTask['deadline'].'</td>';
		}
		else
		{
			echo '<td>No deadline has been specified for this task.</td>';
		}
		if($curTask['ongoing'] == 1)
		{
			echo '<br><td>This task is ongoing!</td>';
		}
		echo '</tr>';
		$count++;
	}
	
	if($count == 0)
	{
		echo '<h2>No tasks have been posted for this idea yet!</h2>';
	}
}

function displaySingleTask($tID)
{
	$sql = "SELECT * FROM tasks WHERE taskID =" . $tID;
	$res = mysql_query($sql) or die(mysql_error());
	//Get project data for the project from the database
	$task = mysql_fetch_array($res);
	//var_dump($task);
	
	if ($task == null)
	{
   		header('Location: error_page.php');
   		//echo 'help';
    }
	else
	{
		echo '<h2>'.$task['taskName'].'</h2><br>';
		echo '<h3>Task Description:</h3><br>';
		echo '<p>'.$task['taskDescription'].'</p><br>';
	}
}

function doTask($tID, $u)
{
	if (strcmp($u['doingTasks'], '') == 0)
	{
		$sql = "UPDATE user SET doingTasks='".$tID."' WHERE userID = ".$u['userID'];
	}
	else
	{
		$sql = "UPDATE user SET doingTasks='".$u['doingTasks'].",".$tID."' WHERE userID = ".$u['userID'];
	}
	mysql_query($sql) or die(mysql_error());
}

function undoTask($taskID, $u)
{
	$taskArray = explode(',', $u['doingTasks']);
	$i = 0;
	for($i; $i <= count($taskArray); $i++)
	{
		if($taskArray[$i] == $taskID)
		{
			$taskArray[$i] = null;
			break;
		}
	}
	$taskList = implode(',', $taskArray);
	$sql = "UPDATE user SET doingTasks='".$taskList."' WHERE userID=".$u['userID'];
	mysql_query($sql) or die(mysql_error());
}

function markTaskAsComplete($tID, $u)
{
	$sql = "UPDATE tasks SET complete=1 WHERE taskID=".$tID;
	mysql_query($sql) or die(mysql_error());
}

function taskIsComplete($tID)
{
	$sql = "SELECT complete FROM tasks WHERE taskID=".$tID;
	$res = mysql_query($sql) or die(mysql_error());
	$compl = mysql_fetch_array($res);
	if($compl)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function userIsDoingTask($tID, $u)
{
	$taskList = explode(',', $u['doingTasks']);
	$i = 0;
	for($i; $i <= count($taskList); $i++)
	{
		if($taskList[$i] == $tID)
		{
			return 1;
		}
	}
	return 0;
}


?>
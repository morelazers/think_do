<?php


function createTask($i, $task, $u)
{
	echo 'creating<br>';
	$tName = mysql_real_escape_string($task['taskName']);
	$tDesc = mysql_real_escape_string($task['taskDesc']);
    if(strcmp($tOngoing, "ongoing") == 0)
    {
        $og = 1;
    }
    else
    {
        $og = 0;
    }
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tasks (ideaID, taskName, username, taskDescription, ongoing, complete, deadline, dateCreated)
	VALUES ('".$i['ideaID']."', '".$tName."', '".$u['username']."', '".$tDesc."', ".$og.", 0, '".$task['deadline']."', '".$now."')";
	mysql_query($sql) or die(mysql_error());
	$tasks = getIdeaTasks($i);
}

function updateTaskInfo($t, $ID)
{
	$sql = "UPDATE tasks SET taskName='".$t['taskName']."', taskDescription='".$t['taskDescription']."', ongoing=".$t['ongoing'].", deadline='".$t['deadline']."' WHERE taskID=".$taskID;
	mysql_query($sql) or die(mysql_error());
}

function getTaskData($tID)
{
	$sql = "SELECT * FROM tasks WHERE taskID=".$tID;
	$res = mysql_query($sql) or die(mysql_error());
	return mysql_fetch_array($res);
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
		if(strcmp($curTask['complete'], '1') == 0)
		{
			/* task is complete, needs a visual indicator here */
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
		echo '<h2 id="taskName">'.$task['taskName'].'</h2><br>';
		echo '<h3 id="taskDescriptionHeading">Task Description:</h3><br>';
		echo '<p id="taskDescription">'.$task['taskDescription'].'</p><br>';
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
	$newTaskArray = array();
	$i = 0;
	for($i; $i < count($taskArray); $i++)
	{
		if($taskArray[$i] == $taskID)
		{
			$taskArray[$i] = null;
		}
		else
		{
			$newTaskArray[] = $taskArray[$i];
		}
	}
	$taskList = implode(',', $newTaskArray);
	$sql = "UPDATE user SET doingTasks='".$taskList."' WHERE userID=".$u['userID'];
	mysql_query($sql) or die(mysql_error());
}

function markTaskAsComplete($tID, $u)
{
	$sql = "UPDATE tasks SET complete=1 WHERE taskID=".$tID;
	mysql_query($sql) or die(mysql_error());
}

function markTaskAsNotComplete($tID, $u)
{
	$sql = "UPDATE tasks SET complete=0 WHERE taskID=".$tID;
	mysql_query($sql) or die(mysql_error());
}

function taskIsComplete($tID)
{
	$sql = "SELECT complete FROM tasks WHERE taskID=".$tID;
	$res = mysql_query($sql) or die(mysql_error());
	$compl = mysql_fetch_array($res);
	if(strcmp($compl['complete'], '1') == 0)
	{
		return true;
	}
	else
	{
		return false;
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


function showTaskForm($t)
{
    echo '<div id="taskForm"><form method="post" action="#tabs-2">
    <label for="taskName">Give the task a title:</label><br>
    <input type="text" name="taskName" id="taskName" value="';
    echo $t['taskName'];
    echo '"><br>
    <label for="taskDescription">What needs to be done?</label><br>
    <input type="text" name="taskDescription" id="taskDescription" value="';
    echo $t['taskDescription'];
    echo '"><br>
    <label for="deadline">Does this need to be done by a particular date? (Optional)</label><br>
    <input type="date" name="deadline" id="deadline" value="';
    echo $t['deadline'];
    echo '"><br>';
    if(array_key_exists("ongoing", $t))
    {
        if(strcmp($t['ongoing'], "ongoing") == 0)
        {
            echo '<input type="radio" name="ongoing" id="ongoingRB" value="ongoing" checked="checked">Ongoing task
            <input type="radio" name="ongoing" id="ongoingRB" value="single">Single task<br>';
        }
        else
        {
            echo '<input type="radio" name="ongoing" id="ongoingRB" value="ongoing">Ongoing task
            <input type="radio" name="ongoing" id="ongoingRB" value="single" checked="checked">Single task<br>';
        }
    }
    else
    {
        echo '<input type="radio" name="ongoing" id="ongoingRB" value="ongoing">Ongoing task
        <input type="radio" name="ongoing" id="ongoingRB" value="single">Single task<br>';
    }
    
    echo '<input type="submit" name="submitTask" value="Submit">
    </form></div><br><br>';
}


function currentUserIsTaskCreator($u, $t)
{
	if(strcmp($u['username'], $t['username']) == 0)
	{
		return true;
	}
	return false;
}


?>
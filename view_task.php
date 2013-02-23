<?php

	/*
	 *	We don't even really need to run an SQL query here if we use some JQuery
	 *	to have a drop down when the task is clicked
	 */

	if(array_key_exists("pid", $_GET))
	{
		$taskID = $_GET["pid"];
		var_dump($taskID);
		$sql = "SELECT * FROM tasks WHERE taskID =" . $taskID;
		$res = mysql_query($sql) or die(mysql_error());
		//Get project data for the project from the database
		$task = mysql_fetch_array($res);
		var_dump($task);
		
		if ($task == null)
    	{
       		//header('Location: error_page.php');
       		echo 'help';
	    }
		else
		{
			echo '<h2>'.$task['taskName'].'</h2><br>';
			echo '<h3>Task Description:</h3><br>';
			echo '<p>'.$task['taskDescription'].'</p><br>';
		}
	}

?>
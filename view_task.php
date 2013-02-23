<?php

	/*
	 *	We don't even really need to run an SQL query here if we use some JQuery
	 *	to have a drop down when the task is clicked
	 */

	if(array_key_exists("pid", $_GET))
	{
		$taskID = $_GET["pid"];
		$res = mysql_query("SELECT * FROM tasks WHERE taskID =" . $taskID);
		//Get project data for the project from the database
		$task = mysql_fetch_array($res);
		
		if ($task == null)
    	{
       		header('Location: error_page.php');
	    }
		else
		{
			echo '<h2>'.$task['taskName'].'</h2><br>';
			echo '<h3>Task Description:</h3><br>';
			echo '<p>'.$task['taskDescription'].'</p><br>';
		}
	}

?>
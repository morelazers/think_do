<?php

include 'header.php';
include 'functions_task.php';
include 'functions_user.php';

if(array_key_exists("pid", $_GET))
{
	$taskID = $_GET["pid"];

	if(isset($_POST['doTask']))
	{
		doTask($taskID, $_SESSION['usr']);
	}
	else if(isset($_POST['undoTask']))
	{
		undoTask($taskID, $_SESSION['usr']);
	}
	else if(isset($_POST['markAsComplete']))
	{
		markTaskAsComplete($taskID, $_SESSION['usr']);
	}
	else if(isset($_POST['notComplete']))
	{
		markTaskAsNotComplete($taskID);
	}
	$_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);



echo 
'<div class="clear"></div>
    <div id="post-container">
    	<div class="sidebar">';

		    if($ideaMember == 0)
			{
		        echo '<form method="post" action="'; 
		        echo $PHP_SELF; 
		        echo '">
		        <input type="submit" ';
		        if(!userIsDoingTask($taskID, $_SESSION['usr']))
		        {
		        	echo 'name="doTask" value="I\'ll help do this!">';
		        }
		        else
		        {
		        	echo 'name="undoTask" value="I can\'t do this!"><br>';
		        	echo '<input type="submit" ';
		        	if(!taskIsComplete($taskID))
		        	{
		        		echo 'name="markAsComplete" value="I\'ve completed this!"><br>';
		        	}
		        	else
		        	{
		        		echo 'name="notComplete" value="This isn\'t complete yet!"><br>';
		        	}
		        	
		        	/* 
		    		need some visual indicator both on the todolist and here to show whether the task is complete or not
		        	*/
		        }
		        echo '</form>';
		    }

		echo '</div>
		<div class="mainRight">';
			
		displaySingleTask($taskID);

		echo '</div>';
}

			echo '
        </div>
    </div>
</div>';
include 'footer.php';

?>
<?php

include 'header.php';
include 'functions_task.php';
include 'functions_user.php';

?>

<div class="clear"></div>
    <div id="post-container">
		<div class="post">
			<?php

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
					
					/* this needs to be in the sidebarrrrrrrrrrrrrrrrrr */
					if($ideaMember == 0)
					{
	                    echo '<form method="post" action="'; 
	                    echo $PHP_SELF; 
	                    echo '">
	                    <input type="submit" ';
	                    if(!userIsDoingTask($taskID, $_SESSION['usr']))
	                    {
	                    	echo 'name="doTask" value="I\'ll help do this task!">';
	                    }
	                    else
	                    {
	                    	echo 'name="undoTask" value="I can\'t do this task anymore!"><br>
	                    	<input type="submit" name="markAsComplete" value="I\'ve completed this task!"><br>';
	                    }
	                    echo '</form>';
	                }
	                displaySingleTask($taskID);
				}

			?>
        </div>
    </div>
</div>
<?php
include 'footer.php';

?>
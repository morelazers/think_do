<?php

include 'header.php';
include 'functions_task.php';

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
						doTask($taskID);
					}
					
					/* this needs to be in the sidebarrrrrrrrrrrrrrrrrr */
					if($ideaMember == 0)
					{
	                    echo '<form method="post" action="'; 
	                    echo $PHP_SELF; 
	                    echo '">
	                    <input type="submit" name="doTask" value="I\'ll help do this task!">
	                    </form>';
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
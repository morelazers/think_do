<?php

include 'header.php';

?>

<div class="clear"></div>
    <div id="post-container">
    	<div class="sidebar">
    	</div>
		<div class="mainRight">
			<?php
				/*
				 *	We don't even really need to run an SQL query here if we use some JQuery
				 *	to have a drop down when the task is clicked
				 */

				if(array_key_exists("pid", $_GET))
				{
					$gathID = $_GET["pid"];
					//var_dump($gathID);
					$sql = "SELECT * FROM gatherings WHERE gathID =" . $gathID;
					$res = mysql_query($sql) or die(mysql_error());
					//Get project data for the project from the database
					$gath = mysql_fetch_array($res);
					//var_dump($task);
					
					if ($gath == null)
			    	{
			       		header('Location: error_page.php');
			       		//echo 'help';
				    }
					else
					{
						echo '<h2>'.$gath['gathLocation'].'</h2><br>';
						echo '<h3>Motive:</h3><br>';
						echo '<p>'.$gath['gathDescription'].'</p><br>';
					}
				}
			?>
        </div>
    </div>
</div>
<?php
include 'footer.php';

?>
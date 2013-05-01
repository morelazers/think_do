<?php

include 'header.php';
include 'functions_gatherings.php';
include 'functions_user.php';

echo '<script language="javascript" type="text/javascript">
window.onload = function() 
{
    document.getElementById("gathForm").style.display="none";

    document.getElementById("editButton").onclick = function()
    {
        document.getElementById("gathLocation").style.display="none";
        document.getElementById("motiveHeading").style.display="none";
        document.getElementById("motive").style.display="none";
        document.getElementById("gathForm").style.display="block";
        return false;
    }
}
</script>';


if(array_key_exists("pid", $_GET))
{
	$gathID = $_GET["pid"];
}
/*else
{
	header("Location: error_page.php");
}*/

if(isset($_POST['submitGathering']))
{
	updateGathering($_POST, $gathID);
}


if(isset($_POST['attendGath']))
{
	markAsAttending($gathID);
	$_SESSION['usr'] = getUserData($con, $u['username']);
}
elseif(isset($_POST['cancelAttend']))
{
	markAsNotAttending($gathID);
	$_SESSION['usr'] = getUserData($con, $u['username']);
}

?>

<div class="clear"></div>
    <div id="post-container">
    	<div class="sidebar">
    		<?php

    		showGathSidebarContent($gathID);

    		?>
    	</div>
		<div class="mainRight">
			<?php
			/*
			 *	We don't even really need to run an SQL query here if we use some JQuery
			 *	to have a drop down when the task is clicked
			 */
			showGathering($gathID);
			$gath = getGatheringData($gathID);
			if(currentUserIsGatheringProposer($_SESSION['usr'], $gath))
			{
				showGatheringForm($gath);
				echo '<br><input type="button" value="Edit" id="editButton">';
			}
			else
			{
				echo 'wat';
			}
				
			?>
        </div>
    </div>
</div>
<?php

include 'footer.php';

?>
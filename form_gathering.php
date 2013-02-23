<?php

include 'functions_input.php';

/*  
 *  Needs some JQuery in here so that the form only displays if the user chooses
 */

showGatheringForm();

if(isset($_POST['submit']))
{
	if(inputIsComplete())
	{
		$gDesc = mysql_real_escape_string($_POST['gatheringDescription']);
		$gLoc = mysql_real_escape_string($_POST['gatheringLocation']);
		$date = $_POST['gatheringDate'];
		$time = $_POST['gatheringTime'];
		$sql = "INSERT INTO gatherings (gathDescription, gathLocation, gathDate, gathTime, proposedBy, forIdea)
		VALUES ('".$gDesc."', '".$gLoc."', '".$date."', '".$time."', ".$_SESSION['usr']['userID'].", ".$idea['ideaID'].")";
		mysql_query($sql, $con) or die(mysql_error());
	}
}

function showGatheringForm()
{
	echo '<form method="post" action="';
    echo $PHP_SELF;
    echo '">
    <label for="gatheringDescription">What should the gathering accomplish?</label><br>
    <input type="text" name="gatheringDescription" id="gatheringDescription" value=""><br>
	<label for="gatheringLocation">Where will it be?</label><br>
    <input type="text" name="gatheringLocation" id="gatheringLocation" value=""><br>
	<label for="gatheringDate">On which date?</label><br>
    <input type="date" name="gatheringDate" id="gatheringDate" value=""><br>
    <label for="gatheringTime">At what time?</label><br>
    <input type="time" name="gatheringTime" id="gatheringTime" value=""><br>
    <input type="submit" name="submitAboutMe" value="Update">
    </form>';
}

?>
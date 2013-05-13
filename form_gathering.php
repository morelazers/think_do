<?php

/*  
 *  Needs some JQuery tabs up in here 
 */

if(isset($_POST['submitGathering']))
{
	if(inputIsComplete())
	{
        createGathering($idea, $_POST);
	}
}

echo '<input type="button" class="proposeGatheringButton" value="Create a Gathering">';

showGatheringForm($_POST);

$gatherings = getIdeaGatherings($idea);

?>

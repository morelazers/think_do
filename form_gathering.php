<?php

/*  
 *  Needs some JQuery tabs up in here 
 */

if(isset($_POST['submitGathering']))
{
	if(inputIsComplete())
	{
        createGathering();
        $_POST['gatheringDescription'] = null;
        $_POST['gatheringLocation'] = null;
        $_POST['gatheringDate'] = null;
        $_POST['gatheringTime'] = null;
	}
}

$gatherings = getIdeaGatherings($idea);
displayGatherings($gatherings);
showGatheringForm();

function showGatheringForm()
{
	echo '<form method="post" action="#tabs-3">
    <label for="gatheringDescription">What should the gathering accomplish?</label><br>
    <input type="text" name="gatheringDescription" id="gatheringDescription" value="';
    echo $_POST['gatheringDescription'];
    echo '"><br>
	<label for="gatheringLocation">Where will it be?</label><br>
    <input type="text" name="gatheringLocation" id="gatheringLocation" value="';
    echo $_POST['gatheringLocation'];
    echo '"><br>
	<label for="gatheringDate">On which date?</label><br>
    <input type="date" name="gatheringDate" id="gatheringDate" value="';
    echo $_POST['gatheringDate'];
    echo '"><br>
    <label for="gatheringTime">At what time?</label><br>
    <input type="time" name="gatheringTime" id="gatheringTime" value="';
    echo $_POST['gatheringTime'];
    echo '"><br>
    <input type="submit" name="submitGathering" value="Submit">
    </form>';
}

/**
*  Function to check if the inputs from a $_POST form are all filled in
*/
/*function inputIsComplete()
{
    //Add all empty fields to an array
    $emptyFields = array();
    foreach ($_POST as $value)
    {
        if (empty($value))
        {
            array_push($emptyFields, $value);
        }
    }
    if (empty($emptyFields))
    { 
        return true;
    }
    else
    {
        echo 'All forms must be filled in!';
        return false;
    }
}*/

?>
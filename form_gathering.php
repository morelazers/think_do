<?php

/*  
 *  Needs some JQuery tabs up in here 
 */

$propGathClicked = 0;

if(isset($_POST['submitGathering']))
{
	if(inputIsComplete())
	{
        createGathering($idea, $_POST);
        /*$_POST['gatheringDescription'] = null;
        $_POST['gatheringLocation'] = null;
        $_POST['gatheringDate'] = null;
        $_POST['gatheringTime'] = null;*/
	}
}
elseif(isset($_POST['createGathering']))
{
    showGatheringForm($_POST);
    $propGathClicked = 1;
}

$gatherings = getIdeaGatherings($idea);
//showGatheringForm();
//displayGatherings($gatherings);

if(!$propGathClicked)
{
    echo 
    '<form method="post" action="#tabs-3">
    <input type="submit" name="createGathering" value="Propose a gathering!">
    </form><br><br>';
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

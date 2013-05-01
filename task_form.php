<?php

//include 'connect.php';

$createTaskClicked = 0;

$tName = $_POST['taskName'];
$tDesc = $_POST['taskDesc'];
$tDeadline = $_POST['taskDeadline'];
$tOngoing = $_POST['ongoing'];

if(isset($_POST['submitTask']))
{
    var_dump($_POST['taskName']);
	if(isset($tName) && isset($tDesc) && isset($tOngoing))
	{
		$tName = mysql_real_escape_string($tName);
		$tDesc = mysql_real_escape_string($tDesc);
        if(strcmp($tOngoing, "ongoing") == 0)
        {
            $taskIsOngoing = 1;
        }
        else
        {
            $taskIsOngoing = 0;
        }

		createTask($idea, $tName, $tDesc, $taskIsOngoing, $tDeadline, $_SESSION['usr'], $con);

        $_POST['taskName'] = null;
        $_POST['taskDesc'] = null;
        $_POST['taskDeadline'] = null;

       /* header("Location: #tabs-2");*/

        /*var_dump($PHP_SELF);*/
        
        //var_dump(mysql_fetch_array($tasks));

        //header("Location: #");
        //unset($_SESSION['taskToModify']);
	}
}
elseif(isset($_POST['createTask']))
{
    showTaskForm($_POST);
    $createTaskClicked = 1;
}

$tasks = getIdeaTasks($idea);
//showTaskForm();
//displayTasks($tasks);

if(!$createTaskClicked)
{
    echo 
    '<form method="post" action="#tabs-2">
    <input type="submit" name="createTask" value="Create a task!">
    </form><br><br>';
}

/**
*  Function to check if the inputs from a $_POST form are all filled in
*/
/*function inputIsComplete()
{
    //Add all empty fields to an array
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
}
*/

?>

<?php

//include 'connect.php';

$tName = $_POST['taskName'];
$tDesc = $_POST['taskDesc'];
$tDeadline = $_POST['taskDeadline'];

if(isset($_POST['submitTask']))
{
	if(isset($tName) && isset($tDesc))
	{
		$tName = mysql_real_escape_string($tName);
		$tDesc = mysql_real_escape_string($tDesc);

		createTask($idea, $tName, $tDesc, $tDeadline, $_SESSION['usr'], $con);

        $_POST['taskName'] = null;
        $_POST['taskDesc'] = null;
        $_POST['taskDeadline'] = null;

        /*var_dump($PHP_SELF);*/
        $tasks = getIdeaTasks($idea);
        displayTasks($tasks);
        //var_dump(mysql_fetch_array($tasks));

        header("Location: #");
        //unset($_SESSION['taskToModify']);
	}
}

showTaskForm();

function showTaskForm()
{
/*    if(isset($_SESSION['taskToModify']))
    {
        echo '<form method="post" action="'; 
        echo $PHP_SELF; 
        echo '">
        <label for="taskName">Give the task a title:</label><br>
        <input type="text" name="taskName" id="taskName" value="';
        echo $_SESSION['taskToModify']['taskName'];
        echo '"><br>
        <label for="taskDesc">What needs to be done?</label><br>
        <input type="text" name="taskDesc" id="taskDesc" value="';
        echo $_SESSION['taskToModify']['taskDescription'];
        echo '"><br>
        <input type="submit" name="submitTask" value="Submit">
        </form>';
    }
    else
    {*/
        echo '<form method="post" action="'; 
        echo $PHP_SELF;
        echo '">
        <label for="taskName">Give the task a title:</label><br>
        <input type="text" name="taskName" id="taskName" value="';
        echo $_POST['taskName'];
        echo '"><br>
        <label for="taskDesc">What needs to be done?</label><br>
        <input type="text" name="taskDesc" id="taskDesc" value="';
        echo $_POST['taskDesc'];
        echo '"><br>
        <label for="taskDeadline">Does this need to be done by a particular date?</label><br>
        <input type="date" name="taskDeadline" id="taskDeadline" value="';
        echo $_POST['taskDeadline'];
        echo '"><br>
        <input type="submit" name="submitTask" value="Submit">
        </form>';
   /* }*/
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

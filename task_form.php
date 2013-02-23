<?php

include 'functions_input.php';
include 'connect.php';

showTaskForm();

$tName = $_POST['taskName'];
$tDesc = $_POST['taskDesc'];

if(isset($_POST['submitTask']))
{
	if(inputIsComplete())
	{
		$tName = mysql_real_escape_string($tName);
		$tDesc = mysql_real_escape_string($tDesc);

		createTask($idea, $tName, $tDesc, $_SESSION['usr'], $con);
	}
}

function showTaskForm()
{
	echo '<form method="post" action="'; 
    echo $PHP_SELF; 
    echo '">
    <label for="taskName">Give the task a title:</label><br>
    <input type="text" name="taskName" id="taskName" value="';
    echo $u['taskName'];
    echo '"><br>
	<label for="taskDesc">What needs to be done?</label><br>
    <input type="text" name="taskDesc" id="taskDesc" value="';
    echo $u['taskDesc'];
    echo '"><br>
    <input type="submit" name="submitTask" value="Submit">
    </form>';
}


?>

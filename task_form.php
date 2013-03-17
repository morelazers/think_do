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
	}
}

$tasks = getIdeaTasks($idea);
displayTasks($tasks);
showTaskForm();

function showTaskForm()
{
    echo '<form method="post" action="#tabs-2">
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

}

?>

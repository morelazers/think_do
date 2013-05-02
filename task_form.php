<?php

//include 'connect.php';
/*include 'functions_task.php';*/

$createTaskClicked = 0;

if(isset($_POST['submitTask']))
{
	if(isset($_POST['taskName']) && isset($_POST['taskDescription']) && isset($_POST['ongoing']))
	{
		createTask($idea, $_POST, $_SESSION['usr']);

        /*$_POST['taskName'] = null;
        $_POST['taskDescription'] = null;
        $_POST['deadline'] = null;
        $_POST['ongoing'] = null;*/

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

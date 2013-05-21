<?php

include 'header.php';
include 'functions_task.php';
include 'functions_user.php';

?>

<script language="javascript" type="text/javascript">
window.onload = function() 
{
    document.getElementById("taskForm").style.display="none";

    document.getElementById("editButton").onclick = function()
    {
        document.getElementById("taskName").style.display="none";
        document.getElementById("taskDescriptionHeading").style.display="none";
        document.getElementById("taskDescription").style.display="none";
        document.getElementById("taskForm").style.display="block";
        return false;
    }
}
</script>

<?php


if(array_key_exists("pid", $_GET))
{
  $taskID = $_GET["pid"];
  $task = getTaskData($taskID);
  if(isset($_POST['submitTask']))
  {
      if(isset($_POST['taskName']) && isset($_POST['taskDescription']) && isset($_POST['ongoing']))
      {
          updateTaskInfo($_POST, $taskID);
      }
  }

  if(isset($_SESSION['usr']))
  {
    if(isset($_POST['doTask']))
    {
      doTask($taskID, $_SESSION['usr']);
    }
    else if(isset($_POST['undoTask']))
    {
      undoTask($taskID, $_SESSION['usr']);
    }
    else if(isset($_POST['markAsComplete']))
    {
      markTaskAsComplete($taskID, $_SESSION['usr']);
    }
    else if(isset($_POST['notComplete']))
    {
      markTaskAsNotComplete($taskID);
    }
    $_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);
  }
  



echo 
'<div class="clear"></div>
    <div id="post-container">
      <div class="sidebar">';

      if(isset($_SESSION['usr']))
        {
        if($ideaMember == 0)
        {
            echo '<form method="post" action="'; 
            echo $PHP_SELF; 
            echo '">
            <input type="submit" ';
            if(!userIsDoingTask($taskID, $_SESSION['usr']))
            {
              echo 'name="doTask" value="I\'ll help do this!">';
            }
            else
            {
              echo 'name="undoTask" value="I can\'t do this!"><br>';
              echo '<input type="submit" ';
              if(!taskIsComplete($taskID))
              {
                echo 'name="markAsComplete" value="I\'ve completed this!"><br>';
              }
              else
              {
                echo 'name="notComplete" value="This isn\'t complete yet!"><br>';
              }
              
              /* 
            need some visual indicator both on the todolist and here to show whether the task is complete or not
              */
            }
            echo '</form>';
        }
    }
    else
    {
        echo "<h2>Oops!</h2></br>
        You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can use this!
        <br>
        But don't worry, it will take you less than a minute!
        <br>";
    }

    echo '</div>
    <div class="mainRight">';
      
    displaySingleTask($taskID);
    $task = getTaskData($taskID);
        if(currentUserIsTaskCreator($_SESSION['usr'], $task))
    {
      showTaskForm($task);
      echo '<br><input type="button" value="Edit" id="editButton">';
    }

    echo '</div>';
}

      echo '
        </div>
    </div>
</div>';
include 'footer.php';

?>
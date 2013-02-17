<?php session_start();

if (isset($_SESSION['usr']))
{
/**
* @author: Tom Nash
*/
    error_reporting(0);
    showForm();
    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["ideaDescription"];
    $skills = $_POST["iSkills"];
    $interests = $_POST["iInterests"];
    $emptyFields = array();
  
    //Attempt database connection
    include 'connect.php';

    include 'mysql_functions';

    if (isset($_POST["submit"]))
    {
    //If no fields are empty, add to database
        if (inputIsComplete())
        {
            $iName = mysql_real_escape_string($ideaName);
            $iDesc = mysql_real_escape_string($ideaDesc);
      $iSkills = mysql_real_escape_string($skills);
      $iInterests = mysql_real_escape_string($interests);
      $iDate = date("Y-m-d H:i:s");
      if($_POST["iPrivacy"]=="public")
      {
        $iOpen = 1;
      }
      else
      {
        $iOpen = 0;
      }
            $sql="INSERT INTO idea (ideaName, description, skillsRequired, interests, dateCreated, isOpen) VALUES ('".$iName."', '".$iDesc."', '".$iSkills."', '".$iInterests."', '".$iDate."', '".$iOpen."')";
            if (!mysql_query($sql, $con))
      //If error durying query execution report error
            {
                echo 'failed to add record';
                die('Error: ' . mysql_error());
            }
            mysql_close($con);
            echo 'Idea submitted!';
        }
    }
}
else
{
  header('Location: login.php');
}


    function showForm() 
    {
        echo '<form method="post" action="'; echo $PHP_SELF; echo '">
        <label for="idea_title">Name your idea:</label><br>
        <input type="text" name="ideaName" id="idea_title" value="';
    echo $_POST["ideaName"];
        echo '"><br>
        <label for="idea_desc">Describe your idea:</label><br>
        <input type="text" name="ideaDescription" id="idea_desc" size="50" value="';
        echo $_POST["ideaDescription"]; 
        echo '"><br>
        <label for="skills">Beneficial Skills:</label><br>
        <input type="text" name="iSkills" id="skills" value="';
        echo $_POST["iSkills"];
        echo '"><br><div class="ui-widget">
        <label for="interests">Interests:</label><br>
        <input type="text" name="iInterests" id="interests" value="';
        echo $_POST["iInterests"];
    echo '"><br></div><label for="Privacy">Privacy:</label><br>';
    if(array_key_exists("iPrivacy", $_POST))
    {
      if($_POST["iPrivacy"] == "public")
      {
        echo '
          <input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public';
      }
      else
      {
        echo '
          <input type="radio" name="iPrivacy" id="privacy" value="public">Public';
      }
      if($_POST["iPrivacy"] == "private")
      {
        echo '
          <input type="radio" name="iPrivacy" id="privacy" value="private" checked="checked">Private';
      }
      else
      {
        echo '
          <input type="radio" name="iPrivacy" id="privacy" value="private">Private';
      }
    }
    else
    {
      echo '<input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public
        <input type="radio" name="iPrivacy" id="privacy" value="private">Private';
    }
    echo '<br><input type="submit" name="submit" value="Submit"></form>';
    }

?> 

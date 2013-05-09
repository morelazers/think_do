<?php

include "connect.php";
include "functions_input.php";
include "functions_idea.php";
include "functions_think.php";


if (inputIsComplete())
{
  $iName = mysql_real_escape_string($ideaName);
  $iDesc = mysql_real_escape_string($ideaDesc);
  $iSkills = mysql_real_escape_string($skills);
  $iInterests = mysql_real_escape_string($interests);
  $iDate = date("Y-m-d H:i:s");
  $u = $_SESSION['usr'];
  $uName = $u['username'];
  $uID = $u['userID'];
  if($_POST["iPrivacy"]=="public")
  {
    $iOpen = 1;
  }
  else
  {
    $iOpen = 0;
  }
  $interestIDs = getInterestIDs($iInterests, $con);
  
  $sql="INSERT INTO idea 
  (createdBy, ideaName, description, skillsRequired, 
  interests, isOpen, dateCreated, moderators) 
  VALUES 
  ('".$uName."', '".$iName."', '".$iDesc."', 
  '".$iSkills."', '".$interestIDs."', '".$iOpen."', 
  '".$iDate."', '".$uID."' )";
  
  //If error durying query execution report error
  if(!mysql_query($sql, $con))
  {
    echo 'failed to add record';
    die('Error: ' . mysql_error());
  }
  else
  {
    header('Location: index.php');
  }
  header('Location: index.php');
}

        
        ?>
<?php 

/**
* @author: Tom Nash
*/

session_start();

if (isset($_SESSION['usr']))
{


echo ' <script language="javascript" type="text/javascript">
	$(function() {
	    var availableInterests = [
	    ';
	   	foreach($GLOBALS['interests'] as $val){
	   		echo '"' . $val . '"';
	   		if ($val != "Zoology"){
	   			echo ', ';
	   		}
	   	}
	    echo '
	    ];
		$( "#interests" ).tagit({
			availableTags: availableInterests,
			allowSpaces: true,
			removeConfirmation: true
		});
	});
 </script>';

    error_reporting(0);
    if (isset($_SESSION['modIdea']))
	{
		showForm($_SESSION['modIdea']);
	}
	else
	{
		showForm($_POST);
	}
    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["ideaDescription"];
    $skills = $_POST["iSkills"];
    $interests = $_POST["iInterests"];
    $emptyFields = array();
  
    //Attempt database connection
    include 'connect.php';

    include 'functions_idea.php';
    include 'functions_input.php';

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
            $sql="INSERT INTO idea (createdBy, ideaName, description, skillsRequired, interests, isOpen, dateCreated, moderators) 
            		VALUES ('".$uName."', '".$iName."', '".$iDesc."', '".$iSkills."', '".$interestIDs."', '".$iOpen."', '".$iDate."', '".$uID."' )";
            if (!mysql_query($sql, $con))
      		//If error durying query execution report error
            {
                echo 'failed to add record';
                die('Error: ' . mysql_error());
            }
            mysql_close($con);
            echo 'Idea submitted!';
            header('Location: index.php');
        }
        else
        {
        	echo 'All fields must be filled in!';
        }
    }
}
else
{
  header('Location: login.php');
}


function getInterestIDs($i, $c)
{
	//$i = explode(', ', $i);
	$sql = "SELECT * FROM interests WHERE name IN ($i)";
	$result = mysql_query($sql, $c)
	or die(mysql_error());
	$IDs = mysql_fetch_array($result);
	$IDs = implode(',', $IDs);
	var_dump($IDs);
	return $IDs;
}

function showForm($i) 
{
    echo '<form method="post" action="'; echo $PHP_SELF; echo '">
    <label for="idea_title">Name your idea:</label><br>
    <input type="text" name="ideaName" id="idea_title" value="';
	echo $i["ideaName"];
    echo '"><br>
    <label for="idea_desc">Describe your idea:</label><br>
    <input type="text" name="ideaDescription" id="idea_desc" size="50" value="';
    echo $i["ideaDescription"]; 
    echo '"><br>
    <label for="skills">Beneficial Skills:</label><br>
    <input type="text" name="iSkills" id="skills" value="';
    echo $i["iSkills"];
    echo '"><br><div class="ui-helper-clearfix">
    <label for="interests">Interests:</label><br>
    <input type="text" name="iInterests" id="interests" value="';
    echo $i["iInterests"];
    echo '"><br></div><label for="Privacy">Privacy:</label><br>';
    if(array_key_exists("iPrivacy", $i))
    {
	    if($i["iPrivacy"] == "public")
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="public" checked="checked">Public';
	    }
	    else
	    {
	        echo '
	        <input type="radio" name="iPrivacy" id="privacy" value="public">Public';
	    }
	    if($i["iPrivacy"] == "private")
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

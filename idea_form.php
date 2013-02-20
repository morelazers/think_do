<?php 

/**
* @author: Tom Nash
*/

session_start();

if (isset($_SESSION['usr']))
{


echo ' 	<div class="sidebar">
	
	<h1>TOP TIPS</h1>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id nisl lectus. 
	Donec lacinia justo ut risus viverra mattis. Aliquam sed iaculis lorem. 
	Donec sit amet enim at massa iaculis auctor. Suspendisse posuere iaculis dictum. 
	Nulla in sapien sed diam sodales vehicula. 
	Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
	Etiam dictum mi ac tortor mattis tristique. Cras varius tempor odio ut malesuada. 
	Fusce at ligula velit, ac mollis eros. Quisque in nulla in leo dignissim pulvinar ut quis lacus. 
	Maecenas ornare sollicitudin libero, id molestie mauris iaculis ut. 
	Donec sit amet nulla eu ligula tristique congue. 
	Etiam justo nisl, pharetra id scelerisque in, elementum et magna. 
	Suspendisse potenti.
	
	</div>
	
	
	<div class="mainRight">
	<script language="javascript" type="text/javascript">
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
	$i = explode(',', $i);
	$iArray = array();
	
	//var_dump($i);
	
	foreach($i as $val)
	{
		$val = '"' .$val. '"';
		//var_dump($val);
		$iArray[] = $val;
	}
	
	$i = implode(',', $iArray);
	
	//var_dump($i);
	
	$sql = "SELECT ID FROM interests WHERE name IN ($i)";
	$result = mysql_query($sql, $c)
	or die(mysql_error());
	
	$IDArray = array();
	while ($ID = mysql_fetch_array($result))
	{
		var_dump($ID);
		$IDArray[] = $ID;
	}

	
	/*
	foreach($IDs as $val)
	{
		var_dump($val);
		//$val =  $val. ',';
		$IDArray[] = $val;
	}*/
	
	$ID = implode(',', $IDArray);
	var_dump($ID);
	
	return $ID;
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
	echo '<br><input type="submit" name="submit" value="Submit"></form></div>';
}

?> 

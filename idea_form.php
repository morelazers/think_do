<?php 

/**
* @author: Tom Nash
*/

session_start();

if (isset($_SESSION['usr']))
{


echo ' 	<div class="sidebar">
	
	<h1>TOP TIPS</h1></br>
	<b>Title</b></br>
	The title is the first thing people will see! Your idea could be revolutionary, make the title exciting!</br></br>
	<b>Description</b></br>
	You have hooked people in with your title, now continue to impress them! Try not to be boring, time is money after all!</br></br>
	<b>Beneficial Skills</b></br>
	What help do you need to get your idea out of your head and into the real world?</br></br>
	<b>Interests</b></br>
	Help us help you! People with similar interests are automatically matched to your idea!</br></br>
	
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
    }
}
else
{
  echo "You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can share an idea!
  <br>
  But don't worry, it will take you less than a minute!
  <br>";
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
		//var_dump($ID);
		$IDArray[] = $ID['ID'];
	}

	
	/*
	foreach($IDs as $val)
	{
		var_dump($val);
		//$val =  $val. ',';
		$IDArray[] = $val;
	}*/
	//var_dump($IDArray);
	$IDString = implode(',', $IDArray);
	//var_dump($IDString);
	
	return $IDString;
}

function showForm($i) 
{
    echo '<form method="post" action="'; echo $PHP_SELF; echo '">
    <label for="idea_title">Name your idea:</label><br>
    <input type="text" name="ideaName" id="idea_title" value="';
	echo $i["ideaName"];
    echo '"><br>
    <label for="idea_desc">Describe your idea:</label><br>
    <input type="textarea" rows="10" cols="30" name="ideaDescription" id="idea_desc" value="';
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
}*/

?> 

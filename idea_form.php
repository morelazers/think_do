<?php 

/**
* @author: Tom Nash
*/

session_start();

if (isset($_SESSION['usr']))
{


echo ' 	<div class="sidebar">
	
	<h1>TOP TIPS</h1></br>
	<b>Name it</b></br>
	The title is the first thing people will see! Your idea could be revolutionary, make the title exciting!</br></br>
	<b>Describe it</b></br>
	You have hooked people in with your title, now continue to impress them! Try not to be boring, time is money after all!</br></br>
	<b>Beneficial Skills</b></br>
	What help do you need to get your idea out of your head and into the real world?</br></br>
	<b>Interests</b></br>
	Help us help you! People with similar interests are automatically matched to your idea!</br></br>
	<b>Hide it?</b></br>
	Decide wether or not you want to reveal your idea to the whole world. Public ideas are displayed on think.do and will appear in search results.</br></br>
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
            
            //If error durying query execution report error
            if (!mysql_query($sql, $con))
            {
                echo 'failed to add record';
                die('Error: ' . mysql_error());
            }
            else
            {
            	header('Location: index.php');
            }
            //mysql_close($con);
            //echo 'Idea submitted!';
            //$sql = "SELECT ideaID FROM idea WHERE "
        }
    }
}
else
{
  echo "<div class=smallForm><h3>You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can share an idea!
  <br>
  But don't worry, it will take you less than a minute!</h3>
  </div>";
}


function showForm($i) 
{
    echo '<form method="post" action="'; echo $PHP_SELF; echo '">
    <label for="idea_title"><h2>Name it</h2></label>
    <input type="text" name="ideaName" id="idea_title" title="What&#39;s the name of your idea?" value="';
	echo $i["ideaName"];
    echo '"><br>
    <label for="idea_desc"><h2>Describe it</h2></label>
    <textarea rows="10" cols="30" name="ideaDescription" id="idea_desc" title="How would you describe it?" value="';
    echo $i["ideaDescription"]; 
    echo '"></textarea><br>
    <label for="skills"><h2>Desirable Skills</h2></label>
    <input type="text" name="iSkills" id="skills" title="What skills are you looking for?" value="';
    echo $i["iSkills"];
    echo '"><br><div class="ui-helper-clearfix">
    <label for="interests"><h2>Interests:</h2></label>
    <input type="text" name="iInterests" id="interests" title="What interests would you want people to have?" value="';
    echo $i["iInterests"];
    echo '"></div><label for="Privacy"><h2>Hide it?</h2></label>';
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
	echo '<br><input type="submit" name="submit" class="normalButton" value="Submit"></form></div>';
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

<?php 

/**
* @author: Tom Nash
* Edited by: Thomas Altmann 22.05.2013
*/

session_start();

if (isset($_SESSION['usr']))
{


?><div class="sidebar">
	
	<h1>TOP TIPS</h1><br />
	<b>Name it</b><br />
	The title is the first thing people will see! Your idea could be revolutionary, make the title exciting!<br /><br />
	<b>Describe it</b><br />
	You have hooked people in with your title, now continue to impress them! Try not to be boring, time is money after all!<br /><br />
	<b>Beneficial Skills</b><br />
	What help do you need to get your idea out of your head and into the real world?<br /><br />
	<b>Interests</b><br />
	Help us help you! People with similar interests are automatically matched to your idea!<br /><br />
	<b>Hide it?</b><br />
	Decide wether or not you want to reveal your idea to the whole world. Public ideas are displayed on think.do and will appear in search results.<br /><br />
    <div id="footer">
    <p><a href="about.php">About</a> &copy; Think.do 2013</p>
    </div>
    </div>
	
	
	<div class="mainRight">
	<script language="javascript" type="text/javascript">
	$(function() {
	    var availableInterests = [
	    
	    <?php
      $count = 0;
	    foreach($GLOBALS['interestsArray'] as $val)
	    {
	        $count++;
	        echo '"' . $val . '"';
	        if ($count <= $GLOBALS['maxInterestArrayIndex'])
	        {
	            echo ', ';
	        }
	    }
	    ?>
	    ];
	    $( "#interests" ).tagit({
	        availableTags: availableInterests,
	        allowSpaces: true,
	        removeConfirmation: true
	    });
	});
	
	</script>
   <?php
    error_reporting(0);
    /*if (isset($_SESSION['modIdea']))
	{
		showIdeaForm($_SESSION['modIdea']);
	}*/

    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["description"];
    $skills = $_POST["skillsRequired"];
    $interests = $_POST["interests"];
    $emptyFields = array();
  
    //Attempt database connection
    include 'connect.php';

    include 'functions_idea.php';
    include 'functions_input.php';

    if (isset($_POST["submit"]))
    {
    	if (inputIsComplete())
        {
            $iName = mysql_real_escape_string($ideaName);
            $iDesc = mysql_real_escape_string($ideaDesc);
		    $iSkills = mysql_real_escape_string($skills);
		    $iInterests = mysql_real_escape_string($interests);
		    $iDate = date("Y-m-d H:i:s");
		    $u = $_SESSION['usr'];
		    $uName = mysql_real_escape_string($u['username']);
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
                echo 'Something is broken on our end. We\'ll fix it soon, promise.';
                die('Error: ' . mysql_error());
            }
        }
    }
    showIdeaForm($_POST);
}
else
{
  ?>
  <div class=smallForm><h3>You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can share an idea!
  <br>
  But don't worry, it will take you less than a minute!</h3>
  </div>
  <?php
}
?> 

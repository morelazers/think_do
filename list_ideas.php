<?php
	/**
	*	@author: Nathan Emery
	*/

include 'header.php';
include 'functions_idea.php'; ?>
	
	<div class="sidebar">	
	<h1>Newest Ideas</h1>
	Here are the newest ideas. 
	<?php 
	if(!isset($_SESSION['usr']))
	{ 
		echo "Why don't you <a href='login.php'>log in</a>/<a href='register.php'>register</a> and we'll recommend some ideas we think you'll be interested in!"; 
	}
	?>
	</br><?php
	//include 'functions_think.php';
	if(isset($_SESSION['usr']))
	{
		$u = $_SESSION['usr'];
		if(isset($u['interests']))
		{
			echo '<a href="think_output.php"><img src="images/think.png"/></a><br>';
		}
		else
		{
			echo "<p>We've noticed you haven't filled out any interests in your profile yet!
			<br>
			To get the best out of think.do we recommend that you edit your profile to include a few interests!
			<br></p>";
		}
	}
	?>
	</div>
	<div class="mainRight">
            <?php getIdeas(); ?>
    </div>

<?php include 'footer.php'; ?>

<?php
function getIdeas()
{
	//Connect to mysql
	include 'connect.php';
	//Check if start parameter present in URL
	if(array_key_exists("page", $_GET))
	{
		//Set start ID to page number multiplied by 10
		$startID = $_GET["page"] * 10;
		//Add 9 to start ID to get final ID for page
		$endID = $startID + 9;
	}
	else
	{
		//If no page parameter in URL begin from ID = 0
		$startID = 0;
		$endID = 9;
	}
	//Query database for data for all projects to be displayed on this page
	//$ideas = mysql_query("SELECT * FROM idea WHERE ideaID BETWEEN " . $startID . " AND " . $endID);
	$ideas = mysql_query("SELECT * FROM idea WHERE isOpen = 1 ORDER BY dateCreated DESC");
	$ideaAmount = mysql_query("SELECT COUNT(*) FROM idea");
	//If query returns projects
	if($ideas != null)
	{
		outputIdeas($ideas);
	}
	
}
?>

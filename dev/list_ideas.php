<?php
	/**
		Author: Nathan Emery
	*/

include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php getIdeas(); ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

<?php
function outputIdeas(&$ideas)
{
	echo '<table>';
	//Create a table and output the project creator, created date and project name to table. The project name is linked to the project page
	while($ideasArray = mysql_fetch_array($ideas))
	{
		$iName = $ideasArray['ideaName'];
		$createdBy = $ideasArray['createdBy'];
		$dateCreated = $ideasArray['dateCreated'];
		$iID = $ideasArray['ideaID'];
		$iVotes = $ideasArray['upVotes'];
		echo '<tr>';
		echo '<td><h2><a href="./view_ideas.php?pid='.$iID.'">'.$iName.'</a></h2></td>';
		echo '<td>'.$createdBy.'</td>';
		echo '<td>'.$dateCreated.'</td>';
		echo '<td>'.$iVotes.'</td>';
		echo '</tr>';
	}
	echo '</table><br>';
}
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
	$ideas = mysql_query("SELECT * FROM idea WHERE ideaID BETWEEN " . $startID . " AND " . $endID);
	$ideaAmount = mysql_query("SELECT COUNT(*) FROM idea");
	//If query returns projects
	if($ideas != null)
	{
		outputIdeas($ideas);
	}
	
}
?>

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
function outputIdeas($projects)
{

	echo '<table>';
	//Create a table and output the project creator, created date and project name to table. The project name is linked to the project page
	while($projectsArray = mysql_fetch_array($projects))
	{
		$pName = $projectsArray['projectName'];
		$createdBy = $projectsArray['createdBy'];
		$dateCreated = $projectsArray['dateCreated'];
		$pID = $projectsArray['projectID'];
		echo '<tr>';
		echo '<td><h2><a href="./view_ideas.php?pid='.$pID.'">'.$pName.'</a></h2></td>';
		echo '<td>'.$createdBy.'</td>';
		echo '<td>'.$dateCreated.'</td>';
		echo '</tr>';
	}
	echo '</table><br>';
}
function getIdeas()
{
	//Connect to mysql
	include 'connect.php';
	//Select thinkdo database
	mysql_select_db("thinkdo", $con);
	//Check if start parameter present in URL
	if(array_key_exists("page", $_GET))
	{
		//Set start ID to page number multiplied by 10
		$startID = $_GET["page"] * 10;
		//Add 9 to start ID to get final ID for page
		$endID = $startID + 9;
		//Query database for data for all projects to be displayed on this page
		$projects = mysql_query("SELECT createdBy, projectName, dateCreated, projectID FROM project WHERE projectID BETWEEN " . $startID . " AND " . $endID);
		$projectAmount = mysql_query("SELECT COUNT(*) FROM project");
		//If query returns projects
		if($projects!=null)
		{
			outputIdeas($projects);
		}
	}
	else
	{
		//If no page parameter in URL begin from ID = 0
		$startID = 0;
		$endID = 9;
		//Query database for data for all projects to be displayed on this page
		$projects = mysql_query("SELECT createdBy, projectName, dateCreated, projectID FROM project WHERE projectID BETWEEN " . $startID . " AND " . $endID);
		//If query returns projects
		if($projects!=null)
		{
			outputIdeas($projects);
		}
	}
	
}
?>

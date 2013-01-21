<?php include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php getIdeas(); ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

<?php
function getIdeas()
{
	$con = mysql_connect("127.0.0.1:3306","root","");
	
	if (!$con)
	{
		die('Could not connect to mysql: ' . mysql_error());
	}
	mysql_select_db("thinkdo", $con);
	if($_GET["start"]!=null)
	{
		$startID = $_GET["start"] * 10;
		$endID = $startID + 9;
		
		$projects = mysql_query("SELECT createdBy, projectName, dateCreated, projectID FROM project WHERE projectID BETWEEN " . $startID . " AND " . $endID);
		if($projects!=null)
		{
			echo '<table>';
			while($projectsArray = mysql_fetch_array($projects))
			{
				$pName = $projectsArray['projectName'];
				$createdBy = $projectsArray['createdBy'];
				$dateCreated = $projectsArray['dateCreated'];
				$pID = $projectsArray['projectID'];
				echo '<tr>';
				echo '<td><a href="./view_ideas.php?pid='.$pID.'">'.$pName.'</a></td>';
				echo '<td>'.$createdBy.'</td>';
				echo '<td>'.$dateCreated.'</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
}
?>

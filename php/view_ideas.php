<?php include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php getIdea(); ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

<?php
function getIdea(){
	//Connect to mysql
	$con = mysql_connect("127.0.0.1:3306","root","");
	//If connection failed, report error
	if (!$con)
	{
		die('Could not connect to mysql: ' . mysql_error());
	}
	//Check for 'pid' parameter in URL
	if(array_key_exists("pid", $_GET))
	{
		//If present, select thinkdo database
		mysql_select_db("thinkdo", $con);
		$projectID = $_GET["pid"];
		$project = mysql_query("SELECT * FROM project WHERE projectID=" . $projectID);
		//Get project data for the project from the database
		$projectArray = mysql_fetch_array($project);
		//Assign query results to variables
		$pName = $projectArray['projectName'];
		$pDesc = $projectArray['description'];
		$pSkills = $projectArray['skillsRequired'];
		$pTags = $projectArray['tags'];
		//Output project information with appropriate markup
		echo "<h2>".$pName."</h2>";
		echo "<p>".$pDesc."</p>";
	}
}
?>

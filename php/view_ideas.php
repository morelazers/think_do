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
	$con = mysql_connect("127.0.0.1:3306","root","");
	
	if (!$con)
	{
		die('Could not connect to mysql: ' . mysql_error());
	}
	if($_GET["pid"]!=null)
	{
		mysql_select_db("thinkdo", $con);
		
		$projectID = $_GET["pid"];
		$project = mysql_query("SELECT * FROM project WHERE projectID=" . $projectID);
		$projectArray = mysql_fetch_array($project);
		$pName = $projectArray['projectName'];
		$pDesc = $projectArray['description'];
		$pSkills = $projectArray['skillsRequired'];
		$pTags = $projectArray['tags'];
		
		echo "<h2>".$pName."</h2>";
		echo "<p>".$pDesc."</p>";
	}
}
?>

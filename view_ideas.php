<?php
/**
	Author: Nathan Emery
*/
 include 'header.php'; ?>
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
	include 'connect.php';
	//Check for 'pid' parameter in URL
	if(array_key_exists("pid", $_GET))
	{
		$ideaID = $_GET["pid"];
		$idea = mysql_query("SELECT * FROM idea WHERE ideaID =" . $ideaID);
		//Get project data for the project from the database
		$ideaArray = mysql_fetch_array($idea);
		//Assign query results to variables
		$iName = $ideaArray['projectName'];
		$iDesc = $ideaArray['description'];
		$iSkills = $ideaArray['skillsRequired'];
		$iTags = $ideaArray['tags'];
		//Output project information with appropriate markup
		echo '<h2>'.$iName.'</h2><br>';
		echo '<h3>Idea Description:</h3><br>';
		echo '<p>'.$iDesc.'</p><br>';
		echo '<h3>Skills Needed:</h3><br>';
		echo '<p>'.$iSkills.'</p><br>';
		echo '<h3>Idea Tags:</h3><br>';
		echo '<p>'.$iTags.'</p>';
	}
}
?>

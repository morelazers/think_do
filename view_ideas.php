<?php
/**
*	@author: Nathan Emery
*/
 include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php 

            include 'connect.php';

            include 'mysql_functions.php'

            $idea = getIdea();

            showIdea($idea);

            ?>
            </div>
        </div>
    </div>
<?php 

include 'footer.php'; 

/**
 *  Function to output the data from the idea to the page
 *  @param idea $i assosciative array containing the fields fom thr idea table
 */
function showIdea($i)
{
	//Output project information with appropriate markup
	echo '<h2>'.$i['ideaName'].'</h2><br>';
	echo '<h3>Idea Description:</h3><br>';
	echo '<p>'.$i['description'].'</p><br>';
	echo '<h3>Skills Needed:</h3><br>';
	echo '<p>'.$i['skillsRequired'].'</p><br>';
	echo '<h3>Idea Tags:</h3><br>';
	echo '<p>'.$i['tags'].'</p>';
}

?>

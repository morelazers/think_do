<?php
/**
* @author: Nathan Emery
*/
 include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php 

            include 'connect.php';

            include 'mysql_functions.php';

            $idea = getIdea();

            showIdea($idea);
            echo '<br><hr>';
            getComments();
            echo '<br><hr>';
            showCommentForm();

            ?>
            </div>
        </div>
    </div>
<?php 

include 'footer.php'; 

?>
<?php
function showCommentForm()
{
    echo '<form method="post" action="'; echo $PHP_SELF; echo '">
    <label for="comment">Post a comment:</label><br>
    <input type="text" name="content" id="contentInput" value="">
    <br><input type="submit" name="submit" value="Submit"></form>';
}
?>

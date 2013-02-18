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

            if(isset($_POST['submit'])){
                postComment();
            }

            $idea = getIdea();

            showIdea($idea);
            echo '<br><hr>';
            getComments();

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

function postComment()
{
    $u = $_SESSION['usr'];
    $n = $u['username'];
    $now = date("y-m-d H:i:s");
    mysql_query($con, "INSERT INTO comments (ideaID, parentID, username, content, datePosted, upVotes) VALUES (".$_GET["pid"].", 0,".$n.",".$_POST['content'].",".$now.",0");
}
?>

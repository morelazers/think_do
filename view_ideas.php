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

            include 'functions_idea.php';
            include 'functions_comment.php';

            if(isset($_POST['submit'])){
                postComment($con);
            }

            $idea = getIdea();

            showIdea($idea);
            echo '<br><hr>';
            getComments($con);
            if(isset($_SESSION['usr'])){
             showCommentForm();
            }

            if(currentUserIsIdeaMod($idea))
            {
                include 'task_form.php';
            }

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

function postComment($c)
{
    $u = $_SESSION['usr'];
    $n = $u['username'];
    $now = date("Y-m-d H:i:s");
    $content = mysql_real_escape_string($_POST['content']);
    $sql = "INSERT INTO comments (ideaID, parentID, username, content, datePosted, upVotes) VALUES (" . $_GET['pid'] . ", 0, '" .$n. "', '" .$content. "','" .$now. "', 0)";
    mysql_query($sql, $c);
}

function currentUserIsIdeaMod($i)
{
    $u = $_SESSION['usr'];
    $mods = $idea['moderators'];
    $mods = explode(',', $mods);
    foreach ($mods as $uID)
    {
        if ($uID == $u['userID'])
        { 
            return true;
        }
    }
    return false;
}
?>

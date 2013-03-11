<?php
/**
* @author: Nathan Emery
*/
 include 'header.php'; ?>
	<script>
	$(function(){
		$( "#tabs" ).tabs();
	});
	</script>
    <script>
        function echoIncrementIdeaUpvotes(){
           echo' incrementIdeaUpvotes($idea,$_SESSION['usr'],$con); ';
           alert("VOTED!");
    }
    </script>
    <div class="clear"></div>
        <div id="post-container">
         <div class="post">
            <?php 

            include 'connect.php';

            include 'functions_idea.php';
            include 'functions_comment.php';
            include 'functions_task.php';
            include 'functions_input.php';
            include 'functions_gatherings.php';
			
            if(isset($_POST['submitComment']))
            {
                postComment($parent);
            }

            $idea = getIdea();

            echo '
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Description</a></li>
                    <li><a href="#tabs-2">Todo List</a></li>
                    <li><a href="#tabs-3">Gatherings</a></li>
                </ul>
                <div id="tabs-1">
            ';
           // echo '<input type="button" onclick="echoIncrementIdeaUpvotes()" value="UPVOTE" />';
            echo'<input type="button" onclick="'; echo incrementIdeaUpvotes($idea,$_SESSION['usr'],$con); echo'" value="UPVOTE" />';
            showIdea($idea);
            echo '<br><hr>';
            getComments($con);
            if(isset($_SESSION['usr']))
            {
                showCommentForm();
            }
            else
            {
                echo "You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can post a comment!
                   <br>
                   But don't worry, it will take you less than a minute!
                   <br>";
            }
            echo'
                </div>
                <div id="tabs-2">
            ';
                include 'todo_list.php';
                if(currentUserIsIdeaMod($idea))
                {
                    include 'task_form.php';
                }
            echo '
                </div>
                <div id="tabs-3">
            ';
                include 'list_gatherings.php';
                if(currentUserIsIdeaMod($idea))
                {
                    /* JQuery needed here I think, or at the top of the form file */
                    include 'form_gathering.php';
                }
            echo '
                </div>
            </div>
            ';
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
    <br><input type="submit" name="submitComment" value="Submit"></form>';
}

function postComment($p)
{
    if ($p == null)
    {
        $parentID = 0;
    }
    else
    {
        $parentID = $p['commentID'];
    }
    $u = $_SESSION['usr'];
    $n = $u['username'];
    $now = date("Y-m-d H:i:s");
    $content = mysql_real_escape_string($_POST['content']);
    $sql = "INSERT INTO comments (ideaID, parentID, username, content, datePosted, upVotes) VALUES (" . $_GET['pid'] . ", ".$parentID.", '" .$n. "', '" .$content. "','" .$now. "', 0)";
    mysql_query($sql);
}

function currentUserIsIdeaMod($idea)
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

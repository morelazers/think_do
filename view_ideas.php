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
    <div class="clear"></div>
        <div id="post-container">
         <div class="post">
            <?php 

            include 'connect.php';

            include 'functions_idea.php';
            include 'functions_comment.php';
            include 'functions_task.php';
            include 'functions_input.php';
			
            if(isset($_POST['submit']))
            {
                postComment($parent);
            }

            $idea = getIdea();

            

            echo '
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Descriptions</a></li>
                    <li><a href="#tabs-2">To do list</a></li>
                    <li><a href="#tabs-3">Gatherings</a></li>
                </ul>
                <div id="tabs-1">
            ';
                showIdea($idea);
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

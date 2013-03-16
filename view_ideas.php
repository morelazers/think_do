<?php
/**
* @author: Nathan Emery
*/
 include 'header.php';
?>
	<script>
	$(function(){
		$( "#tabs" ).tabs();
	});
	</script>
    <div class="clear"></div>
        <div id="post-container">
            <div class="post">
                <div class="sidebar">   
                    <h1>think.do</h1>
                    Welcome to think.do! We're a site dedicated to the future, but we need your help!
                    <br><br>
                    If you have an idea - be it big or small - we want you to share it here!
                    <br><br>
                    We also believe that what goes around comes around, so if you see an idea that you like and think you can help with, give it a shot! You never know what you might achieve together!</p>
                    <?php
                    //include 'functions_think.php';
                    if(isset($_SESSION['usr']))
                    {
                        $u = $_SESSION['usr'];
                        if(isset($u['interests']))
                        {
                            echo '<a href="think_output.php"><img src="images/think.png"/></a><br>';
                        }
                        else
                        {
                            echo "<p>We've noticed you haven't filled out any interests in your profile yet!
                            <br>
                            To get the best out of think.do we recommend that you edit your profile to include a few interests!
                            <br></p>";
                        }
                    }
                    ?>
                </div>
    
                <div class="mainRight">
                    <?php 

                    include 'connect.php';

                    include 'functions_idea.php';
                    include 'functions_comment.php';
                    include 'functions_task.php';
                    include 'functions_input.php';
                    include 'functions_gatherings.php';
        			$idea = getIdea();
                    $tasks = getIdeaTasks($idea);
                    $gatherings = getIdeaGatherings($idea);
                    if(isset($_POST['submitComment']))
                    {
                        postComment($parent);
                    }
                    elseif(isset($_POST['upvote'])){
                        
                        incrementIdeaUpvotes($idea,$_SESSION['usr'],$con);
                    }
                    elseif(isset($_POST['joinTeam'])){
                        joinIdeaTeam($idea, $_SESSION['usr'], $con);
                        $idea = getIdea();
                    }

                    

                    echo '
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Description</a></li>
                            <li><a href="#tabs-2">Todo List</a></li>
                            <li><a href="#tabs-3">Gatherings</a></li>
                        </ul>
                        <div id="tabs-1">
                    ';
                    
                    if(isset($_SESSION['usr'])){
                        if(userHasVoted($idea, $_SESSION['usr'])==false){
                            echo '<div style="float:right;"><form method="post" action="'; 
                            echo $PHP_SELF; 
                            echo '">
                            <input type="submit" name="upvote" value="Upvote this idea">
                            </form></div>';
                        }
                        else{
                            echo "<p class='upVoted'>You've already upvoted this idea!</p>";
                        }
                        $ideaMember = userMemberStatus($idea, $_SESSION['usr'], $con);
                        if($ideaMember == 0){
                            echo '<form method="post" action="'; 
                            echo $PHP_SELF; 
                            echo '">
                            <input type="submit" name="joinTeam" value="Help Out!">
                            </form>';
                        }
                        elseif($ideaMember == 1){
                            echo "<p class='helperMsg'>You are helping this idea!</p>";
                        }
                        else{
                            echo "<p class='modMsg'>You are an idea moderator</p>";
                        }
                    }
                    showIdea($idea);
                    echo '<br><hr>';
                    getComments($con);
                    if(isset($_SESSION['usr']))
                    {
                        showCommentForm();
                    }
                    else
                    {
                        echo "<h2>Oops!</h2></br>
                            You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can post a comment!
                           <br>
                           But don't worry, it will take you less than a minute!
                           <br>";
                    }
                    echo'
                        </div>
                        <div id="tabs-2">
                    ';
                        displayTasks($tasks);
                        if(currentUserIsIdeaMod($idea))
                        {
                            include 'task_form.php';
                        }
                    echo '
                        </div>
                        <div id="tabs-3">
                    ';
                        displayGatherings($gatherings);
                        if(currentUserIsIdeaMod($idea))
                        {
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
    <label for="comment"><h2>Leave a comment:</h2></label><br>
    <input type="text" name="content" id="contentInput" width="60%" value="">
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
</div>

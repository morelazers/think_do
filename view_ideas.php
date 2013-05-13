<?php
/**
* @author: Nathan Emery
*/
    include 'header.php';
    include 'connect.php';
    include 'functions_idea.php';
    include 'functions_comment.php';
    include 'functions_task.php';
    include 'functions_input.php';
    include 'functions_gatherings.php';
    include 'functions_user.php';
    
	echo '



    <script>
    $(document).ready(function(){  
    
    
    $("#gathForm").hide();
    $("#taskForm").hide();
    
      $(".commentVote").click(function(){
            $(this).toggleClass("voted");
            
            
            commentID = parseInt($(this).parent().parent().parent().attr("id"),10);
            voteNumber = parseInt($(this).parent().parent().text(),10);
            
            if($(this).hasClass("commentVote voted")){
            	newVoteNumber = voteNumber+1;
            }
            else{
            	newVoteNumber = voteNumber-1;
            }
                            
            $("#" + commentID).find(".voteamount").text(""+newVoteNumber);
      });

        $(".ideaVote").click(function(){
            $(this).toggleClass("voted");

            voteNumber = parseInt($("#upvoteNumber").text());

            if($(this).hasClass("ideaVote voted")){
                newVoteNumber = voteNumber+1;
                $(this).val(\'Undo\');
            }
            else{
                newVoteNumber = voteNumber-1;
                $(this).val(\'Upvote\');
            }

            $("#upvoteNumber").text(newVoteNumber);

          });

        $(".showInterest").click(function(){
            $(this).toggleClass("interested");
            if($(this).hasClass("showInterest interested")){
            	$(this).val(\'Remove Interest\');
            }
            else{
            	$(this).val(\'Show Interest\');
            }
          });


        $(".editButton").click(function(){
            $(this).toggleClass("editing");
            if($(this).hasClass("editButton editing")){
                $(this).val(\'Cancel\');
                $("#ideaName").hide();
                $("#ideaDescription").hide();
                $("#ideaForm").show();
            }
            else{
                $(this).val(\'Edit\');
                $("#ideaName").show();
                $("#ideaDescription").show();
                $("#ideaForm").hide();
            }
        });
        
        $(".proposeGatheringButton").click(function(){
        	$(this).toggleClass("editing");
            if($(this).hasClass("proposeGatheringButton editing")){
            	$(this).val(\'Cancel\');
                $("#gathForm").show();
            }
            else{
            	$(this).val(\'Create a Gathering\');
                $("#gathForm").hide();
            }
        });
        
        $(".createTaskButton").click(function(){
        	$(this).toggleClass("editing");
            if($(this).hasClass("createTaskButton editing")){
            	$(this).val(\'Cancel\');
                $("#taskForm").show();
            }
            else{
            	$(this).val(\'Create a Task\');
                $("#taskForm").hide();
            }
        });

    });
    </script>
    ';

    
    $idea = getIdea();
    if(isset($_POST['submit']))
    {
        if (inputIsComplete())
        {
            updateIdeaInfo($_POST, $idea['ideaID']);
            getAllInterests($con);
        }
    }

    $idea = getIdea();
    $tasks = getIdeaTasks($idea);
    $gatherings = getIdeaGatherings($idea);
    if(isset($_POST['submitComment']) && strcmp($_POST['content'], '') != 0)
    {
        postComment($parent);
    }
    elseif(isset($_POST['joinTeam']))
    {
        joinIdeaTeam($idea, $_SESSION['usr'], $con);
        $idea = getIdea();
    }
    
    

    /* This will hide anything with <p1> HTML tag. 
     * Need to change the <h2> and <p> idea HTML tags to something unique
     *  function hideIdea()
     *  {
     *      document.getElementById("p1").style.display="none";
     *  }

    window.onload = function() 
    {
        var a = document.getElementById("editLink");
    }
     *$editing = true;
     */

    echo '<script>
	$(function(){
		$( "#tabs" ).tabs();
	});

    window.onload = function() 
    {
        document.getElementById("ideaForm").style.display="none";
    }

	</script>';

    echo '<script language="javascript" type="text/javascript">
    $(function() {
        var availableInterests = [
        ';
        $count = 0;
        foreach($GLOBALS['interestsArray'] as $val)
        {
            $count++;
            echo '"' . $val . '"';
            if ($count <= $GLOBALS['maxInterestArrayIndex'])
            {
                echo ', ';
            }
        }
        echo '
        ];
        $( "#interests" ).tagit({
            availableTags: availableInterests,
            allowSpaces: true,
            removeConfirmation: true
        });
    });
    
    </script>


    <script language="javascript" type="text/javascript">
    
    function upvoteCommentFunction(id)
    {
        var ajaxRequest;
        try{
            ajaxRequest = new XMLHttpRequest();
        } 
        catch (e){
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } 
            catch (e){
                try{
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } 
                catch (e){
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        ajaxRequest.open("GET", "upvoteComment.php?com="+id, true);
        ajaxRequest.send();
    }

    function upvoteIdeaFunction(id)
    {
        var ajaxRequest;
        try{
            ajaxRequest = new XMLHttpRequest();
        } 
        catch (e){
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } 
            catch (e){
                try{
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } 
                catch (e){
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        ajaxRequest.open("GET", "upvoteIdea.php?id="+id, true);
        ajaxRequest.send();
    }

    function registerInterestFunction(id)
    {
        var ajaxRequest;
        try{
            ajaxRequest = new XMLHttpRequest();
        } 
        catch (e){
            try{
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } 
            catch (e){
                try{
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } 
                catch (e){
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        ajaxRequest.open("GET", "registerInterest.php?id="+id, true);
        ajaxRequest.send();
    }

    </script>

    <div class="clear"></div>
        <div id="post-container">
            <div class="post">
                <div class="sidebar">';
                    getIdeaAvatar($idea);
                    if(isset($_SESSION['usr'])){
                        $_SESSION['usr'] = getUserData($con, $_SESSION['usr']['username']);
                        if(userHasVoted($idea, $_SESSION['usr'])==false){
                            echo '<div class="ideaUpvoteContainer">
                            <input type="button" class="ideaVote" value="Upvote" onclick="upvoteIdeaFunction('.$idea['ideaID'].')">
                            <br>
                            <h1 id="upvoteNumber">'.$idea['upVotes'].'
                            </div>';
                        }
                        else{
                            echo '<div class="ideaUpvoteContainer">
                            <input type="button" class="ideaVote voted" value="Undo" onclick="upvoteIdeaFunction('.$idea['ideaID'].')">
                            <br>
                            <h1 id="upvoteNumber">'.$idea['upVotes'].'
                            </div>';
                        }
                        $ideaMember = userMemberStatus($idea, $_SESSION['usr'], $con);
                        if($ideaMember == 0){
                            echo '
                            <input type="button" class="showInterest" id="showInterestButton" value="Show Interest" onclick="registerInterestFunction('.$idea['ideaID'].')">
                            ';
                        }
                        elseif($ideaMember == 1){
                        	echo '
                            <input type="button" class="showInterest interested" id="showInterestButton" value="Remove Interest" onclick="registerInterestFunction('.$idea['ideaID'].')">
                            ';
                        }
                        else{
                            echo "<p class='modMsg'>You're an idea mod</p>";
                        }
                    }
                    else{
                        echo "<p><br><br><br><br><br><br>You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can show your interest and vote on this idea.
                                Don't worry, it will take you less than a minute!
                             </p><br><br>";
                    }
                    showSidebarContent($idea);
                echo'        <div id="footer">
        	<p><a href="about.php">About</a> &copy; Think.do 2013</p>
        </div></div>
                <div class="mainRight">';
                    echo '
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Description</a></li>
                            <li><a href="#tabs-2">Todo List</a></li>
                            <li><a href="#tabs-3">Gatherings</a></li>
                        </ul>
                        <div id="tabs-1">
                    ';
                    if(currentUserIsIdeaCreator($_SESSION['usr'], $idea))
                    {
                        echo '<br><input type="button" class="editButton" value="Edit" id="editButton">';
                        showIdeaForm($idea);
                    }
                    
                    showIdea($idea);

                    echo '<hr>';
                    getComments($con);
                    if(isset($_SESSION['usr']))
                    {
                        showCommentForm();
                    }
                    else
                    {
                        echo "<h2>Oops!</h2>
                            You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can post or vote on a comment!
                           <br>
                           But don't worry, it will take you less than a minute!
                           <br>";
                    }
                    echo'
                        </div>
                        <div id="tabs-2">
                    ';
                        //$tasks = getIdeaTasks($idea);
                        if(currentUserIsIdeaMod($idea))
                        {
                            include 'task_form.php';
                        }
                        displayTasks($tasks);
                    echo '
                        </div>
                        <div id="tabs-3">
                    ';
                        
                        if(currentUserIsIdeaMod($idea))
                        {
                            include 'form_gathering.php';
                        }
                        displayGatherings($gatherings);

                    echo '
                        </div>
                    </div>            
                </div>
            </div>
        </div>'; 

include 'footer.php'; 

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

echo'</div>';
?>

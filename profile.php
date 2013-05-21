<?php 
	include 'header.php';
	include 'functions_user.php';
	include 'functions_input.php';
    include 'functions_idea.php';
    
    if(array_key_exists("user", $_GET) && strcmp($_SESSION['usr']['username'], $_GET['user'])!=0)
    {
        $thisUser = false;
    	$u = getUserData($con, $_GET["user"]);
    }
    elseif(isset($_SESSION['usr']))
    {
    	$u = $_SESSION['usr'];
        $thisUser = true;
    }
    
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                <div class="ideaAvatar">
                    <?php
                    if(isset($u['avatarLocation'])){
                        echo '<img src="'.$u['avatarLocation'].'"/>';
                    }
                    else{
                        echo '<img src="images/avatar.jpg"/>';
                    }
                    ?>
                </div>
                <h1><?php echo $u['username']; ?></h1>
                <?php
                if(!$thisUser && isset($_SESSION['usr'])){
                    echo '<form method="post" action="message_send.php?user='.$u['username'].'">
                    <br><br><br><br><input type="submit" name="recipient" value="Message">
                    </form>';
                }
                if(!isset($_SESSION['usr'])){
                    echo "<br><br><br><br>You'll have to <a href='login.php'>login</a> or <a href='register.php'>register</a> to send a message to ".$u['username'];
                }
                ?>
                <br><br><br><br><br>

                <?php displaySkillsAndInterests($u) ?>
				<div id="footer">
         			<p><a href="about.php">About</a> &copy; Think.do 2013</p>
        		</div>
            </div>
          <div class="mainRight">
             <?php
                  displayProfile($u, $con);
              ?>

            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>


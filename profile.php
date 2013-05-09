<?php 
	include 'header.php';
	include 'functions_user.php';
	include 'functions_input.php';
    include 'functions_idea.php';
    
    if(array_key_exists("user", $_GET))
    {
    	$u = getUserData($con, $_GET["user"]);
    }
    elseif(isset($_SESSION['usr']))
    {
    	$u = $_SESSION['usr'];
    }
    
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                <?php displaySkillsAndInterests($u) ?>
            </div>
          <div class="mainRight">
             <?php
                  displayProfile($u, $con);
              ?>

            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>


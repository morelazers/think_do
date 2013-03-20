<?php 
	include 'header.php';
	include 'functions_user.php';
	include 'functions_input.php';
    include 'functions_idea.php';
?>
    <div class="clear"></div>
        <div id="post-container">
            <div class="sidebar">
                <?php displaySkillsAndInterests($_SESSION['usr']) ?>
            </div>
          <div class="mainRight">
            <?php include 'view_profile.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>


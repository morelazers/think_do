<?php session_start();
	/**
		Author: Mingkit Wong
	*/
include 'header.php';
include 'functions_idea.php'; ?>
	<div class="clear"></div>
	<div id="post-container">
	<div class="sidebar">	
	<h1>think.do</h1>
	<p>Welcome to think.do! We're a site dedicated to the future, but we need your help!
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
		?><a href="think_output.php"><img src="images/think.png"/></a><br>
		<?php
		}
		else
		{
		?><p>We've noticed you haven't filled out any interests in your profile yet!
			<br>
			To get the best out of think.do we recommend that you edit your profile to include a few interests!
			<br></p>
		<?php 
    }
	}
	?>
      <div id="footer">
        <p><a href="about.php">About</a> &copy; Think.do 2013</p>
      </div>
	</div>
	
		<div class="mainRight">
			<br /><img src="images/top.png" /><br /><br /> 
			<?php getHomepageIdeas($con); ?>
		</div>			
	</div>	
</div>
<?php include 'footer.php'; ?>

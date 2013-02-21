<?php session_start();
	/**
		Author: Mingkit Wong
	*/
include 'header.php'; ?>
	<div class="clear"></div>
	<div id="post-container">
		<div class="post">
			<p>Thinkdo is a website designed to help people get help with their ideas or projects. It is open to all, and shows no discrimination.</p>
			<?php
			//include 'functions_think.php';
			if(isset($_SESSION['usr']))
			{
				$u = $_SESSION['usr'];
				if(isset($u['interests']))
				{
					echo '<a href="think_output.php">Think!</a><br>';
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
	</div>	
</div>
<?php include 'footer.php'; ?>

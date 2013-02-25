<?php session_start();
	/**
		Author: Mingkit Wong
	*/
include 'header.php';
include 'functions_idea.php'; ?>
	<div class="clear"></div>
	<div id="post-container">
	<div class="sidebar">
	
	<h1>Homepage Sidebar</h1>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed id nisl lectus. 
	Donec lacinia justo ut risus viverra mattis. Aliquam sed iaculis lorem. 
	Donec sit amet enim at massa iaculis auctor. Suspendisse posuere iaculis dictum. 
	Nulla in sapien sed diam sodales vehicula. 
	Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
	Etiam dictum mi ac tortor mattis tristique. Cras varius tempor odio ut malesuada. 
	Fusce at ligula velit, ac mollis eros. Quisque in nulla in leo dignissim pulvinar ut quis lacus. 
	Maecenas ornare sollicitudin libero, id molestie mauris iaculis ut. 
	Donec sit amet nulla eu ligula tristique congue. 
	Etiam justo nisl, pharetra id scelerisque in, elementum et magna. 
	Suspendisse potenti.
	
	</div>
	
		<div class="mainRight">
			<p>Welcome to think.do! We're a site dedicated to the future, but we need your help!
			<br>
			If you have an idea - be it big or small - we want you to share it here!
			<br>
			But we also believe that what goes around comes around, so if you see an idea that you like and think you can help with, give it a shot! You never know what you might achieve together!</p>
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
			getHomepageIdeas($con);
			?>
			
		</div>			
	</div>	
</div>
<?php include 'footer.php'; ?>

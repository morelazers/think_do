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
			include 'connect.php';
			include 'functions_think.php';
			if (!isset($GLOBALS['interests']))
			{
				getAllInterests($con);
			}
			?>
		</div>			
	</div>	
</div>
<?php include 'footer.php'; ?>

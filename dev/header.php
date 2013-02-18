<?php session_start();
/**
*	Author: Mingkit Wong
*/
 echo '
<html>
<head>

</head>
<body>
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<div class="header">
	<div class="insideHeader">
		<div class="logo"><img src="images/logo.jpg"/></div>
		<div class="user">
		<div class="userText">';
				
				if (isset($_SESSION['usr']))
				{
					$u = $_SESSION['usr'];
					$n = $u['username'];
					echo '<a href="profile.php">'.$n.'</a></br>
						<a href="modify_profile.php">Modify profile</a></br>
						<a href="logout.php">Logout</a>';
				}
				else
				{
					echo '<a href="login.php">Login</a></br>
                				<a href="register.php">Register</a>';
				}
				
			echo '</div>
			<div class="userImg"><img src="images/avatar.jpg"/></div>
		</div>
	</div>
</div><!--END DIV HEADER-->
<div class="navbar">
	<div class="insideNav">
		<li><a href="#">Home</a></li>
		<li><a href="#">Create Idea</a></li>
		<li><a href="#">My Ideas</a></li>
		<li><a href="#">Discover</a></li>
		<div style="float:right;"><form><input type="text" name="search" value="Search..."></form></div>
	</div>
</div>';
?>

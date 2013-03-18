<?php session_start();
/**
*	Author: Mingkit Wrong
*/
include 'connect.php';
include 'functions_think.php';
getAllInterests($con);
 echo '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon" /> 

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" type="text/css" href="css/jquerycss/jquery-ui-1.10.1.custom.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.tagit.css">
	<link href="modalPopLite.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="modalPopLite.min.js"></script>
<!--
	<script type="text/javascript">
		$(function () {
		    $("#popup-wrapper").modalPopLite({ openButton: "#clicker", closeButton: "#close-btn"});
		});
	</script>
-->
	<script language="javascript" type="text/javascript">
		var dateObject=new Date();
	</script>
	<script type="text/javascript">
		$(function(){
			$("input").tooltip({
				position: "center right",
				offset: [-2, 10],
				effect: "fade",
				opacity: 0.7
			});
		});
  
	</script>
    <title>think.do</title>
    </head>
    <body>

<div class="header">
	<div class="insideHeader">
		<div class="logo"><a href="./"><img src="images/logo.jpg"/></a></div>
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
					echo '<div id="clicker"><a href="login.php">Login</a></div></br>
                				<a href="register.php">Register</a></br>';
				}
				
			echo '</div>';

			if(isset($_SESSION['usr']) && isset($_SESSION['usr']['avatarLocation']))
			{
				echo '<div class="userImg"><img width="70px" height="70px" src="'.$_SESSION['usr']['avatarLocation'].'"/></div>';
			}
			else
			{
				echo '<div class="userImg"><img src="images/avatar.jpg"/></div>';
			}
			echo '
		</div>
	</div>

</div><!--END DIV HEADER-->

<div class="navbar">
	<div class="insideNav">
        	<li><a href="index.php">Home</a></li>
    		<li><a href="submit_idea.php">Share an Idea</a></li>
		<li><a href="list_ideas.php">View a List of Ideas</a></li>';

		//Getting rid of the search bar for now, because it doesn't work
		/* <div style="float:right;" class = "search"><form><input type="text" id="search" name="search" value="Search..."></form></div> */

	echo '</div>
</div>
<div class="main">
<div id="popup-wrapper" style="background-color: #ccc;">I am a popup box. Content can be anything.
<a id="close-btn" href="#">Close</a></div>';
?>

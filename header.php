<?php session_start();
/**
*	Author: Mingkit Wong
*/
include 'connect.php';
include 'functions_think.php';
getAllInterests($con);
 echo '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" href="webfonts/stylesheet.css" type="text/css" charset="utf-8" />
    <link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon" /> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">

<link href="css/jquerycss/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">

	<script language="javascript" type="text/javascript">
		var dateObject=new Date();
	</script>
    <title>think.do</title>
    </head>
    <body>

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
                				<a href="register.php">Register</a></br>';
				}
				
			echo '</div>
			<div class="userImg"><img src="images/avatar.jpg"/></div>
		</div>
	</div>
</div><!--END DIV HEADER-->

<div class="navbar">
	<div class="insideNav">
        	<li><a href="index.php">Home</a></li>
    		<li><a href="submit_idea.php">Submit an Idea</a></li>
		<li><a href="list_ideas.php">View a List of Ideas</a></li>
		<div style="float:right;"><form><input type="text" name="search" value="Search..."></form></div>
	</div>
</div>
<div class="main">';
?>

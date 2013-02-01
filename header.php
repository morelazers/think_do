<?php session_start();
/**
	Author: Mingkit Wong
*/
 echo '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" href="webfonts/stylesheet.css" type="text/css" charset="utf-8" />
    <link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon" /> 
	<script language="javascript" type="text/javascript">
		var dateObject=new Date();
	</script>
    <title>think.do</title>
    </head>
    <body>
    <div id="page-container">
		<div id="header">
			<div id="header-bottom-left">
				<h1><a href="index.php">think.do</a></h1>
				<h2>Think. Share. Do.</h2>
			</div>
            			
		<div id="header-bottom-right">
				<!--Login stuff not really sure what to do here-->
                <h3><a href="login.php">Login</a></h3>
                <h3><a href="register.php">Register</a></h3>
				<h3><a href="modify_profile.php">Modify profile</a></h3>
				<h3><a href="logout.php">Logout</a></h3>';
				
				if (isset($_SESSION['usr'])
				{
					$n = $_SESSION['usr']['username'];
					echo '<h3><a href="profile.php">'.$n.'</a></h3>';
				}
				
			echo '</div>
		</div>
            		
		<div id="navcontainer">
			<ul>
				<li>
                <a href="index.php">Home</a>
    			<a href="submit_idea.php"> | Submit an Idea | </a>
				<a href="list_ideas.php">View a List of Ideas</a>
				</li>			
			</ul>
		</div>';
?>

<?php session_start();
/**
*	Author: Mingkit Wong
*/
include 'connect.php';
include 'matchmaking_functions.php';
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

		$(function() {
		    var availableInterests = [
		    ';
		   	foreach($GLOBALS['interests'] as $val){
		   		echo '"' . $val . '"';
		   		if ($val != "Zoology"){
		   			echo ',';
		   		}
		   	}

		    echo '
    		];

    		$("#interests").tagit({
				availableTags: availableInterests
			});
	 	});





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
            			
		<div id="header-bottom-right">';
				
				if (isset($_SESSION['usr']))
				{
					$u = $_SESSION['usr'];
					$n = $u['username'];
					echo '<h3><a href="profile.php">'.$n.'</a></h3>
						<h3><a href="modify_profile.php">Modify profile</a></h3>
						<h3><a href="logout.php">Logout</a></h3>';
				}
				else
				{
					echo '<h3><a href="login.php">Login</a></h3>
                				<h3><a href="register.php">Register</a></h3>';
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

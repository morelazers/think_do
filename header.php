<?php session_start();
/**
*  Author: Mingkit Wrong
*  Edited by: Thomas Altmann 22.05.2013
*/

if(($_SESSION['justLoggedIn']) == true)
{
  header("Location: index.php");
  $_SESSION['justLoggedIn'] = false;
}

include 'connect.php';
include 'functions_think.php';
include 'functions_messaging.php';
getAllInterests($con);
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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

  <script type="text/JavaScript" src="collapse.js"></script>
  
    <title>think.do</title>
    </head>
    <body>

<div class="header">
  <div class="insideHeader">
    <div class="logo"><a href="./"><img src="images/logo.jpg"/></a></div>
    <div class="user">
      <div class="userText">
        <?php
        if (isset($_SESSION['usr']))
        {
          $u = $_SESSION['usr'];
          $n = $u['username'];
          $newMsgCount = checkForNewMessages();
          echo '<a href="profile.php">'.$n.'</a></br>
            <a href="messages.php">Messages ('.$newMsgCount.')</a></br>
            <a href="modify_profile.php">Modify profile</a></br>
            <a href="logout.php">Logout</a>';
        }
        else
        {
         ?>
         <a href="login.php">Login</a><br /><br />
         <a href="register.php">Register</a><br />
          <?php                      
        }
        ?>
      </div>
      <?php
      if(isset($_SESSION['usr']) && isset($_SESSION['usr']['avatarLocation']))
      {
        //$avLoc = $_SESSION['usr']['avatarLocation'];
        //var_dump($avLoc);
        echo '<div class="userImg"><img src="'.$_SESSION['usr']['avatarLocation'].'"/></div>';
      }
      else
      {
       ?>
       <div class="userImg"><img src="images/avatar.jpg"/></div>
       <?php
      }
      ?>
    </div>
  </div>

</div><!--END DIV HEADER-->

<div class="navbar">
  <div class="insideNav">
          <li><a href="index.php"><b>Home</b><br /><div style="font-size:10px">think.do</div></a></li>
        <li><a href="submit_idea.php"><b>Share</b><br /><div style="font-size:10px">your ideas</div></a></li>
    <li><a href="list_ideas.php"><b>Discover</b><br /><div style="font-size:10px">great ideas</div></a></li>
    <li><a href="think_output.php"><img height="30px" width="60px" src="images/thinknav.png" /></a>

 </div>
</div>
<div class="main">

<?php

include "connect.php";
include "functions_input.php";
//include "functions_messaging.php";


session_start();

if (isset($_SESSION['usr']))
{
	$recipient = mysql_real_escape_string($_POST["recipient"]);
	$msgSubject = mysql_real_escape_string($_POST["msgSubject"]);
	$msgContent = mysql_real_escape_string($_POST["msgContent"]);
	$emptyFields = array();
}
else
{
	header("Location: login.php");
}

if(isset($_POST['submit']))
{
	echo "trying to send your message<br>";
	if(inputIsComplete())
	{
		echo "complete input<br>";
		if(userIsNotTaken($recipient, $con) == false)
		{
			echo "sending message!<br>";
			sendMessage($recipient, $msgSubject, $msgContent);
			echo "message sent!<br>";
		}
	}
}

showForm();

function showForm() 
{
    echo '<form method="post" action="'; echo $PHP_SELF; echo '">
    <label for="recipient"><h2>Recipient:</h2></label>
    <input type="text" name="recipient" id="recipient" value="';
    echo $_POST["recipient"];
    echo '"><br>
    <label for="message_subject"><h2>Subject:</h2></label>
    <input type="text" name="msgSubject" id="message_subject" value="';
	echo $_POST["msgSubject"];
    echo '"><br>
    <label for="msg_content"><h2>Your message:</h2></label>
    <textarea rows="10" cols="30" name="msgContent" id="msg_content" value="';
    echo $_POST["msgContent"]; 
    echo '"></textarea><br>
	<br><input type="submit" name="submit" class="normalButton" value="Send"></form></div>';
}

?>
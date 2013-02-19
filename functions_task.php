<?php


function createTask($i, $n, $d, $u, $c)
{
	$now = date("Y-m-d H:i:s");
	$sql = "INSERT INTO tasks (projectID, taskName, username, taskDescription, complete, dateCreated)
	VALUES ('" . $i['ideaID'] . "', '".$n."', '". $u['username'] ."', '".$d."', '0', '".$now."' )";
	mysql_query($sql, $c)
	or die(mysql_error());
}

?>
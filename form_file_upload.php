<?php 
$u = $_SESSION['usr'];
showUploadForm();

mkdir('directory',0777,true);

if(isset($_POST['submit']))
{
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
	&& ($_FILES["file"]["size"] < 20000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Error: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
			echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			
			$dirToStoreIn = "/upload/".$u['username'];
			
			$dirExists = is_dir($dirToStoreIn);
			var_dump($dirExists);
			
			echo umask(0777);
			
			echo dirname( __FILE__ );
			
			if(!$dirExists)
			{
			   	$success = mkdir($dirToStoreIn, 0777);
			   	var_dump($success);
			}
			
			echo "Stored in: " . $_FILES["file"]["tmp_name"];
	
			if (file_exists($dirToStoreIn . "/" . $_FILES["file"]["name"]))
		      	{
		      		echo $_FILES["file"]["name"] . " already exists. ";
		     	}
		    	else
		      	{
				   move_uploaded_file($_FILES["file"]["tmp_name"],
				   $dirToStoreIn . "/" . $_FILES["file"]["name"]); 
				    //$dirToStoreIn = "upload/".$u['username'];
				    echo "Stored in: " . $dirToStoreIn . "/" . $_FILES["file"]["name"];
		      	}
		}
	}
	else
	{
		echo "Invalid file";
	}
}

function showUploadForm()
{
	echo '<form action="'; echo $PHP_SELF; echo '" method="post"
	enctype="multipart/form-data">
	<label for="file">Filename:</label><br>
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Submit">
	</form>';
}

?>

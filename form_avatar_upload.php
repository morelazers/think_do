<?php 
$u = $_SESSION['usr'];

showUploadForm();

function showUploadForm()
{
	echo '<form action="avatar_upload_handler.php" method="post"
	enctype="multipart/form-data">
	<label for="file">Upload an avatar!: (must be less than 2MB)</label><br>
	<input type="file" name="file" class="normalButton" id="file"><br>
	<input type="submit" name="submit" class="normalButton" value="Submit">
	</form>';
}

?>

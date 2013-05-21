<?php 
//$psn = session_name("thinkdo");
	session_start();
	include 'header.php'; ?>
        <div class="clear"></div>
        <div id="post-container">
    		<div class="post">
		        <?php 
		        echo 'Upload a file!';
		        include 'form_avatar_upload.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

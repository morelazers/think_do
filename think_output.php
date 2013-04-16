<?php

include 'header.php';
include 'functions_idea.php';
//include 'connect.php';

?>
<div class="clear"></div>
        <div id="post-container">
        	<div class="sidebar">
        		<h1>Think</h1></br>
                The think button finds ideas we think you'll like based upon your interests!</br></br>
                Update your interests <a href="modify_profile.php">here</a> to discover more great ideas!
          	</div>
          <div class="mainRight">
             <?php 
                if(isset($_SESSION['usr'])) 
                {
                     think($con);
                }
               else{
                    header("Location: login.php");
               }
               ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

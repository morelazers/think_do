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
                    echo "<h2>Oops!</h2></br>
                            You must first <a href='login.php'>login</a> or <a href='register.php'>register</a> before you can use this!
                           <br>
                           But don't worry, it will take you less than a minute!
                           <br>";
               }
               ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

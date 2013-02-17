<?php
/**
*	@author: Nathan Emery
*/
 include 'header.php'; ?>
    <div class="clear"></div>
        <div id="post-container">
        	<div class="post">
            <?php 

            include 'connect.php';

            include 'mysql_functions.php';

            $idea = getIdea();

            showIdea($idea);

            ?>
            </div>
        </div>
    </div>
<?php 

include 'footer.php'; 

?>

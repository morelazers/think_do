<?php 
    $ideaName = $_POST["ideaName"];
    $ideaDesc = $_POST["ideaDescription"];
    $skills = $_POST["iSkills"];
    $tags = $_POST["iTags"];
    $emptyFields = array();
    if (isset($_POST["submit"]))
    {
        foreach ($_POST as $value)
        {
            if (empty($value))
            { 
                array_push($emptyFields, $value);
            }
        }
        if (empty($emptyFields))
        { 
            //php to add the data into the database        
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
            <link rel="stylesheet" type="text/css" href="https://c9.io/morelazers_1/think_do/workspace/html/css/style.css"/>
        	<link rel="stylesheet" href="webfonts/stylesheet.css" type="text/css" charset="utf-8" />
        	<link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon" /> 
        	<script language="javascript" type="text/javascript">
        		var dateObject=new Date();
        	</script>
        	<title>Think.Do</title>
        </head>
        <body>
        	<div id="page-container">
        		<div id="header">
        			<div id="header-bottom-left">
        				<h1><a href="https://c9.io/morelazers_1/think_do/workspace/html/homepage.html">Think.Do</a></h1>
        				<h2>Think. Share. Do.</h2>
        			</div>
        			
        			<div id="header-bottom-right">
        				<!--Login stuff not really sure what to do here-->
                        <h3><a href="login.html">Login</a></h3>
                        <h3><a href="register.html">Register</a></h3>
        
        			</div>
        		</div>
        		
        		<div id="navcontainer">
        			<ul>
        				<li>
                        <a href="https://c9.io/morelazers_1/think_do/workspace/html/homepage.html">Home</a>
            			<a href="#">Submit an Idea</a>
                        <a href="view_ideas.html">View Ideas</a>
        				</li>			
        			</ul>
        		</div>
        		<div class="clear"></div>
        		<div id="post-container">
        			<div class="post">
        				<p>Idea submitted!</p>
        			</div>			
        		</div>
        		
        	</div>
        	<div id="footer">
        		<div id="copyright">
        		<p> Copyright &copy; Think.Do <script type="text/javascript"> document.write(dateObject.getFullYear());</script></p>
        		</div>
        	</div>
        </body>
        </html>
        <?php }
        else
        { 
            ?>
            
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            
            <head>
                <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
                <link rel="stylesheet" type="text/css" href="https://c9.io/morelazers_1/think_do/workspace/html/css/style.css"/>
                <link rel="stylesheet" href="webfonts/stylesheet.css" type="text/css" charset="utf-8" />
            	<link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon" /> 
            	<script language="javascript" type="text/javascript">
            		var dateObject=new Date();
            	</script>
                <title>Think.Do</title>
            </head>
            <body>
            	<div id="page-container">
            		<div id="header">
            			<div id="header-bottom-left">
            				<h1><a href="https://c9.io/morelazers_1/think_do/workspace/html/homepage.html">Think.Do</a></h1>
            				<h2>Think. Share. Do.</h2>
            			</div>
                        			
            		<div id="header-bottom-right">
            				<!--Login stuff not really sure what to do here-->
                            <h3><a href="login.html">Login</a></h3>
                            <h3><a href="register.html">Register</a></h3>
            			</div>
            		</div>
                        		
            		<div id="navcontainer">
            			<ul>
            				<li>
                            <a href="https://c9.io/morelazers_1/think_do/workspace/html/homepage.html">Home</a>
                			<a href="#">Submit an Idea</a>
                            <a href="view_ideas.html">View Ideas</a>
            				</li>			
            			</ul>
            		</div>
            		<div class="clear"></div>
            		<div id="post-container">
            			<div class="post">
                            <form method="post" action="http://think_do.morelazers_1.c9.io/php/handle_idea.php/php/handle_idea.php">
                            <label for="idea_title">Name your idea:</label><br>
                            <input type="text" name="ideaName" id="idea_title" value="<?php echo htmlspecialchars($_POST['ideaName']); ?>"><br>
                            <label for="idea_desc">Describe your idea:</label><br>
                            <input type="text" name="ideaDescription" id="idea_desc" size="50" value="<?php echo htmlspecialchars($_POST['ideaDecription']); ?>"><br>
                            <label for="skills">Beneficial Skills:</label><br>
                            <input type="text" name="pSkills" id="skills" value="<?php echo htmlspecialchars($_POST['iSkills']); ?>"><br>
                            <label for="tags">Tags:</label><br>
                            <input type="text" name="pTags" id="tags" value="<?php echo htmlspecialchars($_POST['iTags']); ?>"><br>
                            <input type="submit" name="submit" value="Submit">
                            </form>
                        </div>			
                    </div>
            	</div>
            	<div id="footer">
            		<div id="copyright">
            		<p> Copyright &copy; Think.Do <script type="text/javascript"> document.write(dateObject.getFullYear());</script></p>
            		</div>
            	</div>
            </body>
            </html>
        <?php }
    } 
?> 
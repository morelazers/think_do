<?php 
$ideaName = $_POST["ideaName"];
$ideaDesc = $_POST["ideaDescription"];
$skills = $_POST["iSkills"];
$tags = $_POST["iTags"];
foreach ($_POST as $value)
{
    if (!isset($value)) 
    { ?>
    <html>
    <body>
    Please fill in all of the forms
    <?php $formComplete = False; ?>
    </body>
    </html>

    <?php }

}
if ($formComplete)
{ ?>

<html>
<body>

Idea title: <?php echo $_POST["ideaName"]; ?> <br>
Description: <?php echo $_POST["ideaDescription"]; ?>

</body>
</html>

<?php
}
?>
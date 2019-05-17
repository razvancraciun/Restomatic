<?php require_once 'include/config.php';?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Update Restaurant </title>
<link rel="stylesheet" type="text/css" href="/restomatic/include/css/index.css">
<link rel="stylesheet" type="text/css" href="/restomatic/include/css/header.css">

</head>

<body>
<?php require("include/common/header.php"); ?>

<div class='content'>
    <?php  
        $form = new Restomatic\UpdateRestaurantForm();
        echo $form->gestiona();
    ?>
</div>
</body>

</html>

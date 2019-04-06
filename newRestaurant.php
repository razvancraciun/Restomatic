<?php require 'include/config.php' ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Register </title>
    <link rel="stylesheet" type="text/css" href="include/css/index.css">
    <link rel="stylesheet" type="text/css" href="include/css/header.css">
    <link rel="stylesheet" type="text/css" href="include/css/newRestaurant.css">
</head>

<body>
<?php require("include/common/header.php");?>

<div class="content">
  <?php
    $form = new Restomatic\AddRestaurantForm();
    echo $form->gestiona();
  ?>
</div>
</body>

</html>

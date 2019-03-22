<?php require_once 'include/config.php' ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Home </title>
<link rel="stylesheet" type="text/css" href="include/css/index.css">
<link rel="stylesheet" type="text/css" href="include/css/header.css">

</head>

<body>
<?php require("include/common/header.php"); ?>

<div class='content'>
    <h1> Take a look at our restaurants </h1>

    <ul class="restaurantGrid">
    <?php require 'include/fetchAllRestaurants.php' ?>
    </ul>
</div>
</body>

</html>
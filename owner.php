<?php require 'include/config.php'?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Your restaurants </title>
<link rel="stylesheet" type="text/css" href="include/css/index.css">
<link rel="stylesheet" type="text/css" href="include/css/header.css">
</head>

<body>
<?php require(__DIR__."/include/common/header.php"); ?>
<div class="content">
    <h1> Your restaurants </h1>

    <p> List of the restaurants with edit buttons
    <p> + button for adding a new restaurant
    <ul class="restaurantList">
    <?php require "include/fetchMyRestaurants.php" ?>
    <li><a href="newRestaurant.php" class="restaurantListItem">New Restaurant</a></li>
    </ul>
</div>
</body>

</html>
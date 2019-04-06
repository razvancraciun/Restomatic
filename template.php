<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Home </title>
<link rel="stylesheet" type="text/css" href="include/css/index.css">
<link rel="stylesheet" type="text/css" href="include/css/header.css">

</head>

<body>
<?php require("include/common/template_header.php"); ?>

<div class='content'>
    <h1> Welcome to our Sakura's sushi </h1>
    <?= "you are now querying" . $_SERVER['REQUEST_URI'] ?>

    <p> Here we show the opening hours of the restaurant. Maybe add a description(todo add in form). Maybe address with google maps feature.
</div>
</body>

</html>

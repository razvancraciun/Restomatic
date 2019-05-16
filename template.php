<?php require_once 'include/config.php';?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Home </title>
<link rel="stylesheet" type="text/css" href="/restomatic/include/css/index.css">
<link rel="stylesheet" type="text/css" href="/restomatic/include/css/header.css">

</head>

<body>
<?php require("include/common/header.php"); ?>

<div class='content'>
    <?php $page= Restomatic\User::getRestaurantPage($_SERVER['REQUEST_URI']);
        echo $page; ?>
</div>
</body>

</html>

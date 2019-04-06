<?php require_once 'include/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Login </title>
<link rel="stylesheet" type="text/css" href="include/css/index.css">
<link rel="stylesheet" type="text/css" href="include/css/header.css">
</head>

<body>
<?php require("include/common/header.php"); ?>
<div class="content">
    <?php $loginForm  = new Restomatic\LoginForm();
        echo $loginForm->gestiona(); ?>
</div>
</body>

</html>

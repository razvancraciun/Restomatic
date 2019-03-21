<?php require 'include/config.php'; ?>
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
    <form action="processLogin.php" method="POST">
    <fieldset>
    <legend> Login </legend>
    <label for="emailInput">Email:</label><input type="email"  id="emailInput" name="emailInput" placeholder="Your email">
    <label for="passwordInput">Password:</label><input type="password" id="passwordInput" name="passwordInput" placeholder="Your password">
    <input type="submit"> 
    </fieldset>
    </form>
</div>
</body>

</html>
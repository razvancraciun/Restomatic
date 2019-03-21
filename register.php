<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Register </title>
    <link rel="stylesheet" type="text/css" href="include/css/index.css">
    <link rel="stylesheet" type="text/css" href="include/css/header.css">
</head>

<body>
<?php require("include/common/header.php"); ?>

<div class="content">
    <form action="processRegister.php" method="POST">
    <fieldset>
        <legend> Login </legend>
        <label for="emailInput">Email:</label>
        <input type="email"  id="emailInput" name="emailInput" placeholder="Your email">
        <label for="nameInput"> Name: </label>
        <input type="text" id="nameInput" name="nameInput" placeholder="Your name">
        <label for="passwordInput">Password:</label>
        <input type="password" id="passwordInput" name="passwordInput" placeholder="Your password">
        <label for="retypePassword">Repeat password:</label>
        <input type="password" id="retypePassword" name="retypePassword" placeholder="Your password">
        <input type="submit"> 
    </fieldset>
    </form>

</div>
</body>

</html>
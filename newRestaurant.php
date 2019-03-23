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
    <form action="form.php" method="POST">
      <input type="hidden" name="form_kind" value="newRestaurant">
      <div class="info_name">
        <fieldset>
        <legend> New Restaurant Information </legend>
        <legend> What is the name of your new restaurant?</legend>
        <label for="restaurantName">Name:</label>
        <input type="text"  id="restaurantName" name="restaurantName" placeholder="Restaurant Name">
        </fieldset>
      </div>

      <div class="theme">
        <fieldset>
        <legend> Choose a theme </legend>
        <input type="radio" name="theme" value="classic" checked>Classic<br>
        <input type="radio" name="theme" value="modern">Modern<br>
        </fieldset>
      </div>

      <div class="info_time">
        <fieldset>
        <legend> What are the opening hours?</legend>
        <label for="monday"> Monday: </label>
        <input type="text" id="monday" name="monday" placeholder="0:00-12:00">
        <label for="tuesday"> Tuesday: </label>
        <input type="text" id="tuesday" name="tuesday" placeholder="0:00-12:00">
        <label for="wednesday"> Wednesday: </label>
        <input type="text" id="wednesday" name="wednesday" placeholder="0:00-12:00">
        <label for="thursday"> Thursday: </label>
        <input type="text" id="thursday" name="thursday" placeholder="0:00-12:00">
        <label for="friday"> Friday: </label>
        <input type="text" id="friday" name="friday" placeholder="0:00-12:00">
        <label for="saturday"> Saturday: </label>
        <input type="text" id="saturday" name="saturday" placeholder="0:00-12:00">
        <label for="sunday"> Sunday: </label>
        <input type="text" id="sunday" name="sunday" placeholder="0:00-12:00">
        </fieldset>
      </div>

      <div class="info_address">
        <fieldset>
        <legend> What is the address?</legend>
        <textarea id="address" name="address" placeholder="Something Street..." style="height:50px"></textarea>
        <input type="submit">
        </fieldset>
      </div>



    <div class="logo">
      <fieldset>
      <legend>Upload Logo </legend>
      <input type="file" name="logoToUpload" id="logoToUpload">
      <input type="submit" value="Upload Image" name="upload">
      </fieldset>
    </div>

    <div class="menu">
      <fieldset>
      <legend>Upload Menu </legend>
      <input type="file" name="menuToUpload" id="menuToUpload">
      <input type="submit" value="Upload PDF" name="upload">
      </fieldset>
      </div>
      </form>

</div>
</body>

</html>

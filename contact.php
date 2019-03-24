<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Home </title>
<link rel="stylesheet" type="text/css" href="include/css/header.css">
<link rel="stylesheet" type ="text/css" href="include/css/contactrest.css"


</head>

<body>
<?php require("include/common/template_header.php"); ?>

<div class="container">
  <form action="form.php">

    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

    <label for="email">Email </label>
    <input type="email" id="email" name="email" placeholder="Your email..">


    <label for="subject">Subject</label>
    <select id="subject" name="subject">
      <option value="reservation">Reservation</option>
      <option value="catering">Catering</option>
      <option value="book">Book for an event</option>
      <option value = "other"> Other</option>
    </select>

    <label for="Message"> Message</label>
    <textarea id="message" name="message" placeholder="Write us ..." style="height:200px"></textarea>

    <input type="submit" value="Submit">

  </form>
</div>
</body>

</html>

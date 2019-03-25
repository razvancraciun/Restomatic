<?php

 $restaurants=User::fetchMyRestaurants();
 
 while($res=$restaurants->fetch_assoc()) {
     echo "<li><img src='user/".$_SESSION['email']."/"
     .$res['id']."/logo.jpg'>"."<a href='#'>".$res['name']."</a>"."</li>";
 }


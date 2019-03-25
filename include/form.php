<?php

switch ($_POST['form_kind']) {
  case 'login':
    User:login()
    break;
  case 'register'
    User:create()
  case 'newRestaurant'
    User:newRestaurant()
  default:
    // code...
    break;
}

 ?>

<?php
require 'config.php';



if($_REQUEST['passwordInput']==$_REQUEST['retypePassword']) {
    $user= User::create($_REQUEST['emailInput'],$_REQUEST['nameInput'],$_REQUEST['passwordInput'],'owner');
}
else echo 'passwords do not match';

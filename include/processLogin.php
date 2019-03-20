<?php
require 'config.php';

$user=User::login($_REQUEST['emailInput'],$_REQUEST['passwordInput']);
if(! $user) {
    echo 'could not log in';
}
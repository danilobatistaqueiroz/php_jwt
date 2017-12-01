<?php

require_once('../vendor/autoload.php');

use Labs\Service\User;

$action = $_REQUEST['action'];
$login = $_POST['login'];
$pwd = $_POST['pwd'];

if($action=="login"){
    $user = new User();
    $user->action = $action;
    $user->login = $login;
    $user->pwd = $pwd;
    echo $user->doLogin();
}
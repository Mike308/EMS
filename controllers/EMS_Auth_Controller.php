<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 11:13
 */


include "../services/Auth_Gate.php";


$login = $_POST['login'];
$password = md5($_POST['password']);



$auth = new Auth_Gate();
$auth->start_session();

$auth->check_login($login,$password);








<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 11:13
 */


include "../services/Auth_Gate.php";


$login = $_POST['login'];
$password = $_POST['password'];



$auth = new Auth_Gate();
$auth->start_session();
header("Location: http://".localhost."/EMS2/index.php");
$auth->check_login($login,$password);








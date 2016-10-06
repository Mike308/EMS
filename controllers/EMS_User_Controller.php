<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-10-06
 * Time: 19:54
 */


include "../services/Authorisation.php";
include "../config/config.php";

header("Location: http://".localhost."/EMS2/admin_panel.php");

$login = $_POST['login'];
$password = md5($_POST['password']);



$auth_service = new Authorisation(user_db,password,localhost);
$auth_service->open_db();
$auth_service->insert_new_user($login,$password);


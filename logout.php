<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 13:03
 */

include "services/Auth_Gate.php";

$auth = new Auth_Gate();
$auth->start_session();
header("Location: http://".localhost."/EMS2/index.php");
$auth->destroy_session();

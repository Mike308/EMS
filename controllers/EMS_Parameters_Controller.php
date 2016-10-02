<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-10-02
 * Time: 19:14
 */

include "../services/EMS_DB.php";
include "../config/config.php";


$ac_voltage = $_POST['ac_voltage'];
$power_factor = $_POST['power_factor'];


header("Location: http://".localhost."/EMS2/admin_panel.php");
$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();
$ems_db->set_parameter($ac_voltage,$power_factor);

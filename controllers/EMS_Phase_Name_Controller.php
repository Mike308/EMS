<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-10-02
 * Time: 15:52
 */

include "../services/EMS_DB.php";
include "../config/config.php";


$name = $_POST['name'];
$phase_no = $_POST['phase_no'];


header("Location: http://".localhost."/EMS2/admin_panel.php");
$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();
$ems_db->set_phase_name($name,$phase_no);


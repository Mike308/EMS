<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-10-24
 * Time: 18:35
 */

include "../services/EMS_DB.php";
include "../config/config.php";


$id = $_POST['id'];
$value = $_POST['value'];


header("Location: http://".localhost."/EMS2/admin_panel.php");
$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();
$ems_db->update_query_with_bind("update parameters set value = :value where id = :id",array(":value"=>$value,":id"=>$id));

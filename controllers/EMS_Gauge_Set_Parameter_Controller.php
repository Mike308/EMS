<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-10-24
 * Time: 15:53
 */

include "../services/EMS_DB.php";
include "../config/config.php";

$param_id = $_GET['id'];




$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();

//$result = json_encode($ems_db->query_for_json("select value from parameters where id = :id",array(':id'=>$param_id)),JSON_NUMERIC_CHECK);
//echo  "{".'"data"'.":"." ".$result."}";
$result = $ems_db->query("select value from parameters where id = :id",array(':id'=>$param_id));
echo $result[0];



<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 14:20
 */




include "../services/EMS_DB.php";
include "../config/config.php";


$cmd = $_GET['cmd'];
$start = $_GET['start'];
$end = $_GET['end'];




$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();





if($cmd==1){

    $result = json_encode($ems_db->prepare_measurement_of_power_from_range($start,$end),JSON_NUMERIC_CHECK);
     echo $result;

}else if($cmd==2){

    $result = json_encode($ems_db->prepare_measurement_of_current_from_range($start,$end),JSON_NUMERIC_CHECK);
    echo $result;


}



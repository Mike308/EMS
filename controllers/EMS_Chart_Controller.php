<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 20:52
 */

include "../services/EMS_DB.php";
include "../config/config.php";


$cmd = $_GET['cmd'];



$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();



if($cmd==1){

    $result = json_encode($ems_db->prepare_measurement_of_power(),JSON_NUMERIC_CHECK);
    // echo  "{".'"data"'.":"." ".$result."}";
    echo $result;

}else if($cmd==2){

    $result = json_encode($ems_db->prepare_measurement_of_current(),JSON_NUMERIC_CHECK);
    // echo  "{".'"data"'.":"." ".$result."}";
    echo $result;

}


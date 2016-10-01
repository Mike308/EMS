<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 20:51
 */

include "../services/EMS_DB.php";
include "../config/config.php";

$phase_no = $_GET['phase_no'];
$cmd = $_GET['cmd'];



$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();




if($cmd==0){

    $result = json_encode($ems_db->last_measurement_of_power($phase_no),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}else if($cmd==1){

    $result = json_encode($ems_db->last_measurement_of_current($phase_no),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==2){

    $result = json_encode($ems_db->query_for_json("select max(result) from power_measurement where phase_no = :phase_no",array('phase_no'=>$phase_no)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==3){

    $result = json_encode($ems_db->query_for_json("select avg(result) from power_measurement where phase_no = :phase",array('phase_no'=>$phase_no)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";
}
else if($cmd==4){

    $result = json_encode($ems_db->query_for_json("select max(result) from current_measurement where phase_no = :phase_no",array('phase_no'=>$phase_no)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==5){

    $result = json_encode($ems_db->query_for_json("select avg(result) from current_measurement where phase_no = :phase",array('phase_no'=>$phase_no)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";
}







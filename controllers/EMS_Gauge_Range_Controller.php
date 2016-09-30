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
$start = $_GET['start'];
$end = $_GET['end'];


$ems_db = new EMS_DB(user_db,password,localhost);
$ems_db->open_db();




if($cmd==0){

    $result = json_encode($ems_db->query_for_json("select max(result) from power_measurement where phase_no = :phase_no and time between :start and :end",array('phase_no' =>$phase_no,'start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==1){

    $result = json_encode($ems_db->query_for_json("select avg(result) from power_measurement where phase_no = :phase_no and time between :start and :end",array('phase_no' =>$phase_no,'start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==2){

    $result = json_encode($ems_db->query_for_json("select sum(result) from power_measurement where time between :start and :end",array('start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}
else if($cmd==3){

    $result = json_encode($ems_db->query_for_json("select sum(result) from current_measurement where phase_no = :phase_no and time between :start and :end",array('phase_no'=>$phase_no,'start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";
}

else if($cmd==4){

    $result = json_encode($ems_db->query_for_json("select avg(result) from current_measurement where phase_no = :phase_no and time between :start and :end",array('phase_no'=>$phase_no,'start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";
}
else if($cmd==5){

    $result = json_encode($ems_db->query_for_json("select sum(result) from current_measurement where time between :start and :end",array('start'=>$start,'end'=>$end)),JSON_NUMERIC_CHECK);
    echo  "{".'"data"'.":"." ".$result."}";

}









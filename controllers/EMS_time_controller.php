<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 00:59
 */

include "../services/EMS_DB.php";


$cmd = $_GET['cmd'];

$ems_db = new EMS_DB("root","","localhost");
$ems_db->open_db();

if($cmd==2){

    $result = json_encode($ems_db->simple_query("select distinct time from power_measurement order by time asc",null),JSON_NUMERIC_CHECK);
    echo  $result;

}


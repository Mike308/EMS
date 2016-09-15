<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 19:49
 */

class EMS_DB{


    /**
     * @var PDO
     */
    private $cn,$user,$password,$url;


    /**
     * EMS_DB constructor.
     * @param $user
     * @param $password
     * @param $url
     */
    public function EMS_DB($user, $password, $url){

        $this->user = $user;
        $this->password = $password;
        $this->url = $url;


    }

    /**
     *
     */
    public function open_db(){

        try{

            $this->cn = new PDO( "mysql:host=$this->url; dbname=ems2", $this->user, $this->password );
            $this->cn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // seting mode for catching errors

        }catch (PDOException $e){

            echo $e;

        }

    }

    public function last_measurement_of_power($phase_no){

        try{

            $st = $this->cn->prepare("select result from power_measurement where phase_no = :phase_no order by id desc limit 1");
            $st->bindParam(":phase_no",$phase_no);
            $st->execute();
            
            while($row = $st->fetch()){

                $data[] = array('data'=>$row[0]);

                
            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    public function last_measurement_of_current($phase_no){

        try{

            $st = $this->cn->prepare("select result from current_measurement where phase_no = :phase_no order by id desc limit 1");
            $st->bindParam(":phase_no",$phase_no);
            $st->execute();

            while($row = $st->fetch()){

                $data[] = array('data'=>$row[0]);


            }



        }catch (PDOException $e){

            echo $e;

        }


    }









}


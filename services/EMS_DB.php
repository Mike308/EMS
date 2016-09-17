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

    public function simple_query($sql,$id){

        try{

            $st = $this->cn->prepare($sql);
            if($id!=null){

                $st->bindParam(":id",$id);

            }
            $st->execute();

            while ($row = $st->fetch()){



               $result[] =  $row[0];

            }

            return $result;






        }catch (PDOException $e){



        }


    }

    public function prepare_measurement_of_power(){

        try{

            $st = $this->cn->prepare("select distinct  concat('L',phase_no),phase_no from power_measurement");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->simple_query("select distinct time from power_measurement order by time asc",null));

            while($row = $st->fetch()){

             $data[] = array('name'=>$row[0], 'data'=>$this->simple_query("select result from power_measurement where phase_no=:id",$row[1]));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }









}


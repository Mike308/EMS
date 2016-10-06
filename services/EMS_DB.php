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
    private $cn, $user,$password,$url;



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

            return $data;



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

    /**
     * @param $sql
     * @param $params
     * @return array
     */
    public function query($sql, $params){

        try{

            $st = $this->cn->prepare($sql);

            foreach ($params as $parameter=>$bind){



                $st->bindValue($parameter,$bind);

            }

            $st->execute();

            while ($row = $st->fetch()){



                $result[] =  $row[0];

            }

            return $result;






        }catch (PDOException $e){


            echo  "Problem: ".$e;



        }


    }

    public function query_for_json($sql, $params){


        try{

            $st = $this->cn->prepare($sql);




//                if(count($params)>1){

                    foreach ($params as $parameter=>$bind){


                        $st->bindValue($parameter,$bind);


                    }

//                }


//            }else {
//
//                $st->bindValue()
//            }



            $st->execute();

            while ($row = $st->fetch()){



                $data[] = array('data'=>$row[0]);

            }

            return $data;






        }catch (PDOException $e){

            echo  "Problem: ".$e;

        }


    }



    public function prepare_measurement_of_power(){

        try{

            $st = $this->cn->prepare("select distinct  name,phase_no from phase_name");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->simple_query("select * from  (select distinct time from power_measurement order by id DESC limit 8) t_time order by t_time.time ASC ",null));

            while($row = $st->fetch()){

             $data[] = array('name'=>$row[0], 'data'=>$this->simple_query("select * from (select result,time from power_measurement where phase_no=:id order by id desc limit 8) t_val order by t_val.time ASC ",$row[1]));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    public function prepare_measurement_of_current(){

        try{

            $st = $this->cn->prepare("select distinct  name,phase_no from phase_name");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->simple_query("select * from (select distinct time from current_measurement order by id desc limit 8) t_time order by t_time.time ASC ",null));

            while($row = $st->fetch()){

                $data[] = array('name'=>$row[0], 'data'=>$this->simple_query("select * from (select result,time from current_measurement where phase_no=:id order by id desc limit 8) t_val order by t_val.time asc",$row[1]));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function prepare_measurement_of_power_from_range($start, $end){

        try{

            $st = $this->cn->prepare("select distinct  name,phase_no from phase_name");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->query("select distinct time from power_measurement where time between :start and :end  order by time asc",array(':start'=>$start,':end'=>$end)));

            while($row = $st->fetch()){

                $data[] = array('name'=>$row[0], 'data'=>$this->query("select result from power_measurement where phase_no=:id and time between :start and :end",array(':id'=>$row[1], ':start'=>$start,':end'=>$end)));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    public function prepare_measurement_of__real_power_from_range($start, $end){

        try{

            $st = $this->cn->prepare("select distinct name,phase_no from phase_name");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->query("select distinct time from power_measurement where time between :start and :end  order by time asc",array(':start'=>$start,':end'=>$end)));

            while($row = $st->fetch()){

                $data[] = array('name'=>$row[0], 'data'=>$this->query("select (result*parameters.value) result from power_measurement join parameters on parameters.id = 'power_factor' where phase_no=:id and time between :start and :end",array(':id'=>$row[1], ':start'=>$start,':end'=>$end)));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    public function prepare_measurement_of_current_from_range($start, $end){

        try{

            $st = $this->cn->prepare("select distinct  concat('L',phase_no),phase_no from current_measurement");
            $st->execute();


            $data[] = array('name'=>'time', 'data'=>$this->query("select distinct time from current_measurement where time between :start and :end  order by time asc",array(':start'=>$start,':end'=>$end)));

            while($row = $st->fetch()){

                $data[] = array('name'=>$row[0], 'data'=>$this->query("select result from current_measurement where phase_no=:id and time between :start and :end",array(':id'=>$row[1], ':start'=>$start,':end'=>$end)));



            }

            return $data;



        }catch (PDOException $e){

            echo $e;

        }


    }

    public function prepare_measurement_of_power_from_range_for_table($start, $end){


        try{





            $i = 0;
            $st = $this->cn->prepare("select DISTINCT phase_name.name,power_measurement.phase_no,result,round((result*parameters.value),2) real_power,time from power_measurement join phase_name on phase_name.phase_no = power_measurement.phase_no join parameters on parameters.id = 'power_factor' where time between :start and :end order by time asc");
            $st->bindValue(":start",$start);
            $st->bindValue(":end",$end);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);



            return $result;
            
            


        }catch (PDOException $e){



        }


    }

    public function prepare_measurement_of_current_from_range_for_table($start, $end){

        try{





            $i = 0;
            $st = $this->cn->prepare("select DISTINCT concat('L',phase_no) name,phase_no,result,time from current_measurement where time between :start and :end order by time asc");
            $st->bindValue(":start",$start);
            $st->bindValue(":end",$end);
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);



            return $result;




        }catch (PDOException $e){



        }


    }

    public function get_phases_name(){


        try{

            $st = $this->cn->prepare("select name from phase_name order by phase_no ASC");
            $st->execute();
            $result = $st->fetchAll(PDO::FETCH_ASSOC);

            return $result;



        }catch (PDOException $e){



        }

    }

    public function update_query($sql,$parameter,$bind){

        try{

            $st = $this->cn->prepare($sql);
            $st->bindValue($parameter,$bind);
            $st->execute();


        }catch (PDOException $e){


            echo  "Problem: ".$e;



        }

    }


    public function insert_query($sql, $params){

        try{

            $st = $this->cn->prepare($sql);
            foreach ($params as $parameter=>$bind){


                $st->bindValue($parameter,$bind);


            }

            $st->execute();


        }catch (PDOException $e){

            echo "Problem: ".$e;


        }

    }

    public function set_parameter($ac_voltage,$power_factor){

        $this->update_query("update parameters set parameters.value=:value where id = 'ac_voltage'",":value",$ac_voltage);
        $this->update_query("update parameters set parameters.value=:value where id = 'power_factor'",":value",$power_factor);


    }

    public function set_phase_name($name,$phase_no){

        try{

            $st = $this->cn->prepare("update phase_name set name = :name where phase_no = :phase_no");
            $st->bindValue(":name",$name);
            $st->bindValue(":phase_no",$phase_no);
            $st->execute();


        }catch (PDOException $e){


        }

    }




    











}


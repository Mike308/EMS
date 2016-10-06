<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 10:55
 */

include 'EMS_DB.php';



class Authorisation extends EMS_DB {

    /**
     * @var PDO
     */


    public function get_user_id($login, $password){

        $result = $this->query("select id from users where login = :login and password = :password",array(':login'=>$login,':password'=>$password));

        return $result;

    }

    public function get_user_premission($user_id){

        $result = $this->query("select permission from users where id = :id",array(':id'=>$user_id));

        return $result;

    }
    
    public function insert_new_user($login, $password){
        
        $this->insert_query("insert into users (login,password,permission) values (:login,:password,1)",array(":login"=>$login,":password"=>$password));
        
    }
    
    






    
}
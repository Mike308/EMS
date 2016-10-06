<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 11:42
 */

include 'Authorisation.php';
include "$_SERVER[DOCUMENT_ROOT]/EMS2/config/config.php";


class Auth_Gate{

    public function start_session(){

        session_start();


    }

    /**
     *
     */
    public function destroy_session(){

        session_destroy();
    }

    /**
     * @param $login
     * @param $password
     */
    public function check_login($login, $password){



        $auth_service = new Authorisation(user_db,password,localhost);
        $auth_service->open_db();
        $user_id = $auth_service->get_user_id($login, $password);
        $user_permission = $auth_service->get_user_premission($user_id[0]);


        if($user_id != null){

            $_SESSION['success'] = true;
            $_SESSION['user'] = $user_id[0];
            $_SESSION['perm'] = $user_permission[0];
            header("Location: http://".localhost."/EMS2/index.php");

        }else{

            echo "Nie poprawne dane logowania";
            $_SESSION['perm'] = -1;
            header("Location: http://".localhost."/EMS2/login.php");

        }



    }

    public function get_user_prem(){

        return $_SESSION['perm'];

    }
    
    



}
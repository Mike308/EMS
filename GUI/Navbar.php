<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 17:49
 */

class Navbar {

    public function Navbar($item_index,$permission){

        ?>
        <div class="navbar navbar-default">
           <div class="navbar-header">
               <div class="navbar-collapse">

                   <ul class="nav navbar-nav">
                       <?php $this->display_items($item_index,$permission); ?>
                   </ul>

               </div>

           </div>
        </div>




        <?php

    }

    private  function display_item($is_active,$title,$url){

        if($is_active==true){

            ?> <li class="active"><a href=<?php echo $url;?>><?php echo $title;?></a></li> <?php
        }
        else{

            ?>  <li><a href="<?php echo $url;?>"><?php echo $title;?></a></li> <?php
        }

    }

    private function display_login($item,$permission){

        if($permission==0){

            if($item=="login.php"){

                ?> <li class="active"><a href="login.php">Logowanie</a></li> <?php
            }
            else{

                ?> <li><a href="login.php">Logowanie</a> </li><?php
            }

        }else{

            ?> <li><a href="logout.php">Wyloguj się</a></li><?php

        }

    }

    





    private function display_items($item, $permission){


        $titles = array(

            "index.php" => "Strona główna",
            "power_measurement.php"=>"Pomiar mocy"


        );

        foreach ($titles as $url=>$title){

            if($item==$url){

                $this->display_item(true,$title,$url);
            }
            else{

                $this->display_item(false,$title,$url);
            }




        }
        $this->display_login($item,$permission);

    }






}









<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 17:49
 */

class Navbar {

    public function Navbar($permission){

        ?> <ul class="nav navbar-nav">
           <li class="active"><a href="index.php">Strona główna</a></li>
           <li><a href="temp_chart.php">Temperatura w budynku</a></li>
           <li><a href="water_consumption.php">Zużycie wody</a></li>
           <li><a href="air_quality.php">Jakość powietrza</a> </li>
           <li><a href="energy_consumption.php">Zużycie energii elektrycznej</a></li>
           <?php   if(isset($_SESSION['success'])) { if($_SESSION['user'] > 0) { ?> <li><a href="admin_panel.php">Panel Administracyjny</a></li> <?php }}?>
           <?php   if(isset($_SESSION['success'])) { if($_SESSION['user'] > 0) { ?> <li><a href="slot_setup_panel.php">Ustawienia Termometrów</a></li> <?php }}?>
           <?php   if(isset($_SESSION['success'])) { ?> <li><a href="logout.php">Wyloguj</a></li> <?php } else {?> <li><a href="login.php">Logowanie</a></li> <?php }?>
</ul>

    }

}
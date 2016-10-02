<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-25
 * Time: 12:03
 */


include 'GUI\Navbar.php';
include 'services\Auth_Gate.php';
$auth = new Auth_Gate();
$auth->start_session();
$permission = $auth->get_user_prem();


?>

<html>

<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <meta charset="utf-8">
    <title>ISMIE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="darkly/theme/bootstrap.css" media="screen">
    <link rel="stylesheet" href="darkly/theme/usebootstrap.css">
    <script src="bootstrap/html5shiv.js"></script>
    <script src="bootstrap/respond.min.js"></script>
</head>

    <body>


      <h2> Internetowy System Monitorowania Instalacji </h2>
        <?php $nav = new Navbar("admin_panel.php",$permission);?>

      <div class="container">


          <table>
              <tr>
                  <th>
                      <div class="panel-group" align="center">
                          <div class="panel panel-primary" style="width: 300px">
                              <div class="panel-heading" style="width: 300px; color: white" > Logowanie </div>
                              <div class="panel-body">

                                  <form action="controllers/EMS_User_Controller.php" method="post">
                                      <div class="form-group">
                                          <label for="login">Login: </label>
                                          <input type="text" class="form-control" id="login" name="login" style="text-align: center">

                                      </div>
                                      <div class="form-group">
                                          <label for="password">Hasło: </label>
                                          <input type="password" class="form-control" id="password" name="password" style="text-align: center" >

                                      </div>

                                      <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Dodaj użytkownika">
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </th>

                  <th style="padding: 5px">
                      <div class="panel-group" align="center">
                          <div class="panel panel-primary" style="width: 300px">
                              <div class="panel-heading" style="width: 300px; color: white" > Ustawienie napięcia oraz współczynnika mocy </div>
                              <div class="panel-body">

                                  <form action="controllers/EMS_Setup_Controller.php" method="post">
                                      <div class="form-group">
                                          <label for="ac_voltage">Napięcie: </label>
                                          <input type="text" class="form-control" id="ac_voltage" name="ac_voltage" style="text-align: center">

                                      </div>

                                      <div class="form-group">
                                          <label for="power_factor">Współczynnik mocy:  </label>
                                          <input type="text" class="form-control" id="power_factor" name="power_factor" style="text-align: center">
                                      </div>


                                      <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Ustaw stawkę">
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </th>

                  <th style="padding: 5px">
                      <div class="panel-group" align="center">
                          <div class="panel panel-primary" style="width: 300px">
                              <div class="panel-heading" style="width: 300px; color: white" > Ustawienie nazw faz </div>
                              <div class="panel-body">

                                  <form action="controllers/EMS_Phase_Name_Controller.php" method="post">
                                      <div class="form-group">
                                          <label for="phase_name">Nazwa: </label>
                                          <input type="text" class="form-control" id="name" name="name" style="text-align: center">

                                      </div>

                                      <div class="form-group">
                                          <label for="phase_no">Faza:  </label>
                                          <select id = "phase_no" name="phase_no" class="form-control">
                                              <option value="1"> L1  </option>
                                              <option value="2"> L2  </option>
                                              <option value="3"> L3  </option>
                                          </select>

                                      </div>


                                      <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Ustaw nazwę">
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </th>

                  <th style="padding: 5px">
                      <div class="panel-group" align="center">
                          <div class="panel panel-primary" style="width: 350px">
                              <div class="panel-heading" style="width: 350px; color: white" > Analiza poboru mocy  </div>
                              <div class="panel-body">

                                  <form action="power_measurement_of_range.php" method="get">
                                      <div class="form-group">
                                          <label for="start">Początek: </label>
                                          <input type="datetime-local" class="form-control" id="start" name = "start"  style="width: 300px;">

                                      </div>

                                      <div class="form-group">
                                          <label for="start">Koniec: </label>
                                          <input type="datetime-local" class="form-control" id="end" name = "end"  style="width: 300px;">

                                      </div>


                                      <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Pokaż Statystyki">
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </th>

                  <th style="padding: 5px">
                      <div class="panel-group" align="center">
                          <div class="panel panel-danger" style="width: 350px">
                              <div class="panel-heading" style="width: 350px; color: white" > Analiza natężenia prądu  </div>
                              <div class="panel-body">

                                  <form action="current_measurement_of_range.php" method="get">
                                      <div class="form-group">
                                          <label for="start">Początek: </label>
                                          <input type="datetime-local" class="form-control" id="start" name = "start"  style="width: 300px;">

                                      </div>

                                      <div class="form-group">
                                          <label for="start">Koniec: </label>
                                          <input type="datetime-local" class="form-control" id="end" name = "end"  style="width: 300px;">

                                      </div>


                                      <div class="form-group">
                                          <input type="submit" class="btn btn-danger" value="Pokaż statystyki">
                                      </div>
                                  </form>

                              </div>
                          </div>
                      </div>
                  </th>

<!--                  <th style="padding: 5px">-->
<!--                      <div class="panel-group" align="center">-->
<!--                          <div class="panel panel-primary" style="width: 350px">-->
<!--                              <div class="panel-heading" style="width: 350px; color: white" > Zużycie energii elektrycznej </div>-->
<!--                              <div class="panel-body">-->
<!---->
<!--                                  <form action="power_consumption_measurement_of_range.php" method="get">-->
<!--                                      <div class="form-group">-->
<!--                                          <label for="start">Login: </label>-->
<!--                                          <input type="datetime-local" class="form-control" id="start" name = "start"  style="width: 300px;">-->
<!---->
<!--                                      </div>-->
<!---->
<!--                                      <div class="form-group">-->
<!--                                          <label for="start">Login: </label>-->
<!--                                          <input type="datetime-local" class="form-control" id="end" name = "end"  style="width: 300px;">-->
<!---->
<!--                                      </div>-->
<!---->
<!---->
<!--                                      <div class="form-group">-->
<!--                                          <input type="submit" class="btn btn-primary" value="Ustaw stawkę">-->
<!--                                      </div>-->
<!--                                  </form>-->
<!---->
<!--                              </div>-->
<!--                          </div>-->
<!--                      </div>-->
<!--                  </th>-->





              </tr>


          </table>

          </div>












    </body>


</html>

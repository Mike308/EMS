<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-17
 * Time: 11:49
 */



/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 18:07
 */

include 'GUI\Navbar.php';
include 'services\Auth_Gate.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$auth = new Auth_Gate();
$auth->start_session();
$permission = $auth->get_user_perm();
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
<?php $nav = new Navbar("index.php",0);?>

<div class="container">

    <?php if($permission==-1) { ?> <div ng-show = "!names.length" class="alert alert-dismissable alert-danger" style="text-align: center">
        <!--                <button type="button" class="close" data-dismiss="alert">×</button>-->
        <strong>Login lub hasło są błędne</strong>
    </div> <?php } ?>

    <div class="panel-group" align="center">
        <div class="panel panel-primary" style="width: 500px">
            <div class="panel-heading" style="width: 500px; color: white" > Logowanie </div>
            <div class="panel-body">

                <form action="controllers/EMS_Auth_Controller.php" method="post">
                    <div class="form-group">
                        <label for="login">Login: </label>
                        <input type="text" class="form-control" id="login" name="login" style="text-align: center">

                    </div>
                    <div class="form-group">
                        <label for="password">Hasło: </label>
                        <input type="password" class="form-control" id="password" name="password" style="text-align: center" >

                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Zaloguj">
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

</body>

</html>

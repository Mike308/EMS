<?php
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
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["gauge"]});
        google.setOnLoadCallback(function(){

            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=0&phase_no=1","l1_div",2000,15);
            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=3&phase_no=1","l1_avg_div",2000,15);
            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=0&phase_no=2","l2_div",2000,15);
            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=3&phase_no=2","l2_avg_div",2000,15);
            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=0&phase_no=3","l3_div",2000,15);
            drawChart("VA","controllers/EMS_Gauge_Controller.php?cmd=3&phase_no=3","l3_avg_div",2000,15);

            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=1&phase_no=1","l1_current_div",100,5);
            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=1&phase_no=2","l2_current_div",100,5);
            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=1&phase_no=3","l3_current_div",100,5);
            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=4&phase_no=1","l1_avg_current_div",100,5);
            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=4&phase_no=2","l2_avg_current_div",100,5);
            drawChart("A","controllers/EMS_Gauge_Controller.php?cmd=4&phase_no=3","l3_avg_current_div",100,5);


        });


        function drawChart(label,url,div_id,max_value,minor_ticks) {

            var chart_data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                [label, 0],


            ]);


            var options = {
                width: 150, height: 150,

                minorTicks: minor_ticks, max:max_value
            };

            var chart = new google.visualization.Gauge(document.getElementById(div_id));


            chart.draw(chart_data, options);



            setInterval(function() {

                $.getJSON(url,function(data) {



                    $.each(data.data, function(index,value){

                        

                        chart_data.setValue(0,1,value.data);
                        chart.draw(chart_data,options);

                    });

                });
            },1000);

        }


        var app = angular.module('myApp', []);

           app.controller('power2', function($scope, $http) {
                $http.get("controllers/EMS_Table_Controller.php?cmd=3&start=0&end=0")
                    .then(function (response) {$scope.names = response.data.power;});
            });



    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("index.php",$permission);?>

    <div class="container">
        <div ng-app="myApp">
        <table>
            <tr>
                <th>
                    <div class="panel-group" align="center">
                        <div class="panel panel-primary" style="width: 1000px">
                            <div class="panel-heading" style="width: 1000px; color: white" > Pomiar mocy pozornej </div>
                            <div class="panel-body">



                                    <div ng-controller = "power2">
                                        <table>
                                            <tr>
                                                <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Aktualna moc dla: <br>  {{x.name}} </th>
                                                <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Średnia moc dla: <br>  {{x.name}} </th>

                                            </tr>

                                            <tr>
                                                <td style="padding: 5px" align="center"> <div id = "l1_div"> </div> </td>
                                                <td style="padding: 5px" align="center"> <div id = "l2_div"> </div> </td>
                                                <td style="padding: 5px" align="center"> <div id = "l3_div"> </div> </td>
                                                <td style="padding: 5px" align="center"> <div id = "l1_avg_div"> </div> </td>
                                                <td style="padding: 5px" align="center"> <div id = "l2_avg_div"> </div> </td>
                                                <td style="padding: 5px" align="center"> <div id = "l3_avg_div"> </div> </td>

                                            </tr>



                                        </table>



                                    </div>

                            </div>
                        </div>
                    </div>
                </th>

            <tr>

                <th>
                    <div class="panel-group" align="center">
                        <div class="panel panel-danger" style="width: 1000px">
                            <div class="panel-heading" style="width: 1000px; color: white" > Pomiar natężenia prądu</div>
                            <div class="panel-body">



                                <div ng-controller = "power2">
                                    <table>
                                        <tr>
                                            <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Aktualne natężenie prądu dla: <br>  {{x.name}} </th>
                                            <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Średnie nateżenie prądu dla: <br>  {{x.name}} </th>

                                        </tr>

                                        <tr>
                                            <td style="padding: 5px" align="center"> <div id = "l1_current_div"> </div> </td>
                                            <td style="padding: 5px" align="center"> <div id = "l2_current_div"> </div> </td>
                                            <td style="padding: 5px" align="center"> <div id = "l3_current_div"> </div> </td>
                                            <td style="padding: 5px" align="center"> <div id = "l1_avg_current_div"> </div> </td>
                                            <td style="padding: 5px" align="center"> <div id = "l2_avg_current_div"> </div> </td>
                                            <td style="padding: 5px" align="center"> <div id = "l3_avg_current_div"> </div> </td>

                                        </tr>



                                    </table>



                                </div>

                            </div>
                        </div>
                    </div>
                </th>

            </tr>

    </div>

</body>

</html>

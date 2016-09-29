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
$start = $_GET['start'];
$end = $_GET['end'];

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

            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=0&phase_no=1&start=<?php echo $start?>&end=<?php echo $end?>","l1_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=1&phase_no=1&start=<?php echo $start?>&end=<?php echo $end?>","l1_avg_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=0&phase_no=2&start=<?php echo $start?>&end=<?php echo $end?>","l2_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=1&phase_no=2&start=<?php echo $start?>&end=<?php echo $end?>","l2_avg_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=0&phase_no=3&start=<?php echo $start?>&end=<?php echo $end?>","l3_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=1&phase_no=3&start=<?php echo $start?>&end=<?php echo $end?>","l3_avg_div");
            drawChart("VA","controllers/EMS_Gauge_Range_Controller.php?cmd=2&phase_no=3&start=<?php echo $start?>&end=<?php echo $end?>","sum_div");


        });


        function drawChart(label,url,div_id) {

            var chart_data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                [label, 0],


            ]);


            var options = {
                width: 150, height: 150,
                redFrom: 500, redTo: 1000,
                yellowFrom:250, yellowTo: 499,
                minorTicks: 15, max:2000
            };

            var chart = new google.visualization.Gauge(document.getElementById(div_id));


            chart.draw(chart_data, options);





                $.getJSON(url,function(data) {

                    console.log(url);

                    $.each(data.data, function(index,value){



                        chart_data.setValue(0,1,value.data);
                        chart.draw(chart_data,options);

                    });

                });




        }







        $ (function () {
            var options = {
                chart: {
                    type: 'line',
                    marginRight: 130,
                    marginBottom: 25
                },
                title: {
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: []
                },
                yAxis: {
                    title: {
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                            this.x +': '+ this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
                series: []
            };

            var chart1,


            $.getJSON('controllers/EMS_Chart_Range_Controller.php?cmd=1&start=<?php echo $start?>&end=<?php echo $end?>', function(data){

                // chart 1
                options.chart.renderTo = 'power';
                options.title.text = 'Pobór mocy';
                options.yAxis.title.text = 'moc [W]';
                options.xAxis.categories = data[0]['data'];

                options.series.push(data[1]);
                options.series.push(data[2]);
                options.series.push(data[3]);

                chart1 = new Highcharts.Chart(options);




            });
        });

        var app = angular.module('myApp', [])
        .controller('power', function($scope, $http) {
            $http.get("controllers/EMS_Table_Controller.php?cmd=1&start=<?php echo $start?>&end=<?php echo $end?>")
                 .then(function (response) {$scope.names = response.data.power;});
        })
        .controller('power2', function($scope, $http) {
            $http.get("controllers/EMS_Table_Controller.php?cmd=3&start=<?php echo $start?>&end=<?php echo $end?>")
                .then(function (response) {$scope.names = response.data.power;});
        });


    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("power_measurement.php",$permission);?>

<div class="container">








    <div id = "power" style="padding-bottom: 5%">  </div>

    <div ng-app="myApp">

        <div ng-controller = "power2">
            <table>
                <tr>
                    <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Maksymalna moc dla: <br>  {{x.name}} </th>
                    <th style="padding: 5px; text-align: center" align="center" ng-repeat = "x in names"> Średnia moc dla: <br>  {{x.name}} </th>
                    <th style="padding: 5px; text-align: center" align="center"> Całkowita moc pozorna <br> <br></th>
                </tr>

                <tr>
                    <td style="padding: 5px" align="center"> <div id = "l1_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "l2_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "l3_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "l1_avg_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "l2_avg_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "l3_avg_div"> </div> </td>
                    <td style="padding: 5px" align="center"> <div id = "sum_div"> </div> </td>
                </tr>



            </table>



        </div>

        <div ng-controller = "power">

            Szukaj po fazie: <input type="text" class="form-control" ng-model="search.name">


            <table class="table table-striped table-hover ">

                <tr>
                    <th> Faza </th>
                    <th> Pobór mocy </th>
                    <th> Data i czas pomiaru </th>

                </tr>

                <tr ng-repeat="x in names | filter: search">
                    <td>{{ x.name }}</td>
                    <td>{{ x.result }}</td>
                    <td>{{ x.time }}</td>
                </tr>
            </table>

        </div>




    </div>

</div>

</body>

</html>
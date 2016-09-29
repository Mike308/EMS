<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 18:07
 */

include 'GUI\Navbar.php';
include 'services\Auth_Gate.php';
$auth = new Auth_Gate();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$auth->start_session();
$permission = $auth->get_user_prem();

?>


<html>

<head>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <meta charset="utf-8">
    <title>ISMIE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="darkly/theme/bootstrap.css" media="screen">
    <link rel="stylesheet" href="darkly/theme/usebootstrap.css">
    <script src="bootstrap/html5shiv.js"></script>
    <script src="bootstrap/respond.min.js"></script>

    <script type="text/javascript">
        google.load("visualization", "1", {packages:["gauge"]});
        google.setOnLoadCallback(function(){

            drawChart("L1","controllers/EMS_Controller.php?cmd=0&phase_no=1","l1_div");
            drawChart("L2","controllers/EMS_Controller.php?cmd=0&phase_no=2","l2_div");


        });


        function drawChart(label,url,div_id) {

            var chart_data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                [label, 0],


            ]);


            var options = {
                width: 400, height: 400,
                redFrom: 90, redTo: 100,
                yellowFrom:75, yellowTo: 90,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById(div_id));


            chart.draw(chart_data, options);



            setInterval(function() {

                $.getJSON(url,function(data) {

                    //console.log(data);

                    $.each(data.data, function(index,value){



                        chart_data.setValue(0,1,value.data);
                        chart.draw(chart_data,options);

                    });

                });


            },1000);

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
                chart2;

            $.getJSON('controllers/EMS_Chart_Controller.php?cmd=1', function(data){

                // chart 1
                options.chart.renderTo = 'power';
                options.title.text = 'Pobór mocy';
                options.yAxis.title.text = 'moc [W]';
                options.xAxis.categories = data[0]['data'];

                options.series.push(data[1]);
                options.series.push(data[2]);

                chart1 = new Highcharts.Chart(options);




            });
        });


     var app = angular.module('myApp',[]);

            app.controller('tabelController',function ($scope,$http) {

                $http.get('controllers/EMS_Table_Controller.php?cmd=1')
                    .then(function (response) {

                        $scope.phases = response.data.power
                        
                    });

            });




    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("power_measurement.php",$permission);?>

<div class="container">

    <table align="center">
        <tr>
            <th style="text-align: center"> Moc L1 </th>
            <th style="text-align: center"> Moc L2 </th>
        </tr>

        <tr>
            <td align="center"> <div id = "l1_div"> </div> </td>
            <td align="center"> <div id = "l2_div"> </div> </td>
        </tr>
    </table>



    <div id = "power">  </div>

    <div ng-app = "myApp" ng-controller="tableController">

        <table>
            <tr ng-repeat="x in phases" >
                <th> {{x.L1}} </th>
            </tr>
        </table>



    </div>

</div>

</body>

</html>

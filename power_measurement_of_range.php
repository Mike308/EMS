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
                scrollbar: {
                    enabled: true
                },
                series: []
            };

            var chart1,


            $.getJSON('controllers/EMS_Chart_Range_Controller.php?cmd=1&start=<?php echo $start.'&end='.$end?>', function(data){

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

        var app = angular.module('myApp', []);
        app.controller('power', function($scope, $http) {
            $http.get("controllers/EMS_Table_Controller.php?cmd=1")
                .then(function (response) {$scope.names = response.data.power;});
        });

        $scope.names = {};





    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("power_measurement.php",$permission);?>

<div class="container">





    <div id = "power" style="padding-bottom: 5%">  </div>

    <div ng-app="myApp" ng-controller="power">

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
                <td>{{x.time}}</td>
            </tr>
        </table>

    </div>

</div>

</body>

</html>

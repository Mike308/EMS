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
                series: []
            };

            var chart1,
                chart2;

            $.getJSON('controllers/EMS_Chart_Controller.php?cmd=2', function(data){

                // chart 1
                options.chart.renderTo = 'container';
                options.title.text = 'Natężenie prądu';
                options.yAxis.title.text = '[A]';
                options.xAxis.categories = data[0]['data'];

                options.series.push(data[1]);
                options.series.push(data[2]);
                options.series.push(data[3]);

                chart1 = new Highcharts.Chart(options);




            });
        });



    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("current_measurement.php",$permission);?>

<div class="container" id="container" style="width:auto;">

<!--    <table align="center">-->
<!--        <tr>-->
<!--            <th style="text-align: center"> Moc L1 </th>-->
<!--            <th style="text-align: center"> Moc L2 </th>-->
<!--        </tr>-->
<!---->
<!--        <tr>-->
<!--            <td align="center"> <div id = "l1_div"> </div> </td>-->
<!--            <td align="center"> <div id = "l2_div"> </div> </td>-->
<!--        </tr>-->
<!--    </table>-->

    <div id = "current">  </div>

</div>

</body>

</html>

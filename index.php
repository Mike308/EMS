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
        google.load("visualization", "1", {packages:["gauge"]});
        google.setOnLoadCallback(function(){

            drawChart("L1","controllers/EMS_Gauge_Controller.php?cmd=0&phase_no=1","l1_div");
            drawChart("L2","controllers/EMS_Gauge_Controller.php?cmd=0&phase_no=2","l2_div");


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



                    $.each(data.data, function(index,value){

                        

                        chart_data.setValue(0,1,value.data);
                        chart.draw(chart_data,options);

                    });

                });
            },1000);

        }



    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("index.php",$permission);?>

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

    </div>

</body>

</html>

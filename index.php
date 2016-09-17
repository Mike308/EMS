<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 2016-09-15
 * Time: 18:07
 */

include 'GUI\Navbar.php';

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

            drawChart("L1","controllers/EMS_Controller.php?cmd=0&phase_no=1","l1_div");
            


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

        var cnt = 0;

        $(function () {
            $('#container').highcharts({

                title: {
                    text: 'Średnia temperatur',
                    x: -20 //center
                },

                yAxis: {
                    title: {
                        text: 'temperatura (°C)'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },

                tooltip: {
                    valueSuffix: 'kWh'
                },

                legend: {
                    enabled: false
                },



                xAxis: {
                    categories: []

                },
                series:{ []
                }
            });


            // the button action
            cnt = 0;
            setInterval(function() {





                var data_from_json = [];
                var time_from_json = [];
                var urls = ['controllers/EMS_Controller?cmd=2','controllers/EMS_Controller?cmd=2']
                var chart_name = ['Moc','Prąd'];
                var chart_title = ['Moc','Prąd'];

                var chart_type = ['line','line'];
                var chart_y_axis_title = ['W','kWh','m3','ppm','PLN'];

                if(cnt==0 || cnt==1) {


                    // console.log("Adres: "+cnt);

                    $.getJSON(urls[cnt], function (dane) {





                        var chart = $('#container').highcharts();


                        chart.title.text = chart_title[cnt];
                        options.xAxis.categories = dane[0]['data'];
                        for(var i=1; i<3; i++){

                            options.series.push(dane[i]);

                        }






//                        if(cnt==4){
//
//                            chart.series[0].options.colorByPoint = true;
//
//
//                        }else{
//
//                            chart.series[0].options.colorByPoint = false;
//
//                    }
                       // chart.series[0].options.type = chart_type[cnt];

///                        chart.series[0].update(chart.series[0].options);

                        $('#container').highcharts().redraw();
                      //  cnt++;




                    });

                }

















            },2000);

    </script>

</head>


<body>
<h2> Internetowy System Monitorowania Instalacji </h2>
<?php $nav = new Navbar("index.php",0);?>

    <div class="container">

<!--        <table>-->
<!--            <th> Moc L1 </th>-->
<!--            <th> Moc L2 </th>-->
<!--            <tr> <div id = "l1_div"> </div>  </tr>-->
<!--            <tr> <div id = "l2_div"> </div>  </tr>-->
<!--        </table>-->

    </div>

</body>

</html>

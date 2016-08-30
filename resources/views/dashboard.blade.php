@extends('layouts.app')

@section('content')



<div class="contappiner">
    <div class="row">
        <div class="col-md-12">
            The response is {{ $response[0] }}
        </div>
    </div>
    <div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">temp1</div>

                <div class="panel-body" id="temp1" style="height:700px;">
                    
                </div>
            </div>
        </div>
      
    </div>  
                <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">energy2</div>

                <div class="panel-body" id="energy2mm" style="height:700px;">
                    
                </div>
            </div>
        </div>  
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">power2</div>

                <div class="panel-body" id="power2" style="height:700px;">
                    
                </div>
            </div>
        </div>       
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">power3</div>

                <div class="panel-body" id="power3" style="height:700px;">
                    
                </div>
            </div>
        </div>
    </div>

     <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">power4</div>

                <div class="panel-body" id="power4" style="height:700px;">
                    
                </div>
            </div>
        </div>

    </div>  





</div>

    <!-- script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <script type="text/javascript">


    function drawEnergyChart()
    {
        var data1 = new google.visualization.DataTable();
        data1.addColumn('date','Date');
        data1.addColumn('number','Dryer');

        var data2 = new google.visualization.DataTable();
        data2.addColumn('date','Date');
        data2.addColumn('number','Basement Fridge');    

        var data3 = new google.visualization.DataTable();
        data3.addColumn('date','Date');
        data3.addColumn('number','Washer');

    
        @foreach($energy2mm as $energy)



            data1.addRow([new Date('{{ $energy->date }}'), {{ $energy->max - $energy->min }}]);

        @endforeach

        @foreach($energy3mm as $energy)
            data2.addRow([new Date('{{ $energy->date }}'), {{ $energy->max - $energy->min }}]);
        @endforeach

        @foreach($energy4mm as $energy)
            data3.addRow([new Date('{{ $energy->date }}'), {{ $energy->max - $energy->min }}]);
        @endforeach

        var join = google.visualization.data.join(data1, data2, 'full', [[0,0]], [1], [1]);
        var joined4 = google.visualization.data.join(join, data3, 'full', [[0,0]], [1,2], [1]);

          var chart = new google.visualization.ColumnChart(document.getElementById('energy2mm'));
            chart.draw(joined4, { 
          legend: { position: 'bottom' },
          chartArea:{left:50,top:5,width:"90%",height:"80%"},
          vAxis: {
                format: '#.#',
                gridlines: { count: -1 },
            },
            // hAxis: {
            //     minTickInterval: 24 * 3600 * 1000,
            //     format:'MMM d'
            // },    
        }); 
    }

    function drawTempChart()
    {
        var data1 = new google.visualization.DataTable();
        data1.addColumn('date','Date');
        data1.addColumn('number','Front Door');

        var data2 = new google.visualization.DataTable();
        data2.addColumn('date','Date');
        data2.addColumn('number','Side Door');    

        var data3 = new google.visualization.DataTable();
        data3.addColumn('date','Date');
        data3.addColumn('number','Patio Door');

        var data4 = new google.visualization.DataTable();
        data4.addColumn('date','Date');
        data4.addColumn('number','Steps');           

        var data5 = new google.visualization.DataTable();
        data5.addColumn('date','Date');
        data5.addColumn('number','Outside');           

        @foreach($temp1 as $temnp)
            data1.addRow([new Date('{{ $temnp->date }}'), {{ $temnp->avg }}]);
            //data1.addRow(['{{ $temnp->date }}', {{ $temnp->avg }}]);
        @endforeach  

        @foreach($temp4 as $temnp)
            //data2.addRow(['{{ $temnp->date }}', {{ $temnp->avg }}]);
            data2.addRow([new Date('{{ $temnp->date }}'), {{ $temnp->avg }}]);
        @endforeach            

        @foreach($temp6 as $temnp)
            data3.addRow([new Date('{{ $temnp->date }}'), {{ $temnp->avg }}]);
            //data1.addRow(['{{ $temnp->date }}', {{ $temnp->avg }}]);
        @endforeach  

        @foreach($temp7 as $temnp)
            //data2.addRow(['{{ $temnp->date }}', {{ $temnp->avg }}]);
            data4.addRow([new Date('{{ $temnp->date }}'), {{ $temnp->avg }}]);
        @endforeach  

        @foreach($temp8 as $temnp)
            //data2.addRow(['{{ $temnp->date }}', {{ $temnp->avg }}]);
            data5.addRow([new Date('{{ $temnp->date }}'), {{ $temnp->avg }}]);
        @endforeach         

            var joined4 = google.visualization.data.join(google.visualization.data.join(google.visualization.data.join(data1, data2, 'full', [[0,0]], [1], [1]), google.visualization.data.join(data3, data4, 'full', [[0,0]], [1], [1]), 'full', [[0,0]], [1,2], [1,2]), data5, 'full', [[0,0]], [1,2,3,4], [1]);  

            var chart = new google.visualization.LineChart(document.getElementById('temp1'));
            chart.draw(joined4, {
                curveType: 'function',
                legend: { position: 'bottom' },
                chartArea:{left:50,top:5,width:"90%",height:"80%"},
                vAxis: {
                format: '#.#',
                gridlines: { count: -1 },
            },
        });               
        

       // drawLineChartA(joined4, 'temp1', );          
    }

      function drawChart() {
        var power2 = [];
        var energy2 = [];
        var power3 = [];
        var energy3 = [];
        var power4 = [];
        var energy4 = [];

        var temp1 = [];
        var temp4 = [];
        var temp6 = [];
        var temp7 = [];

        var energy2mm = [];
        var energy3mm = [];
        var energy4mm = [];

        var energyday = [];
        var devices = [];

        power2.push(['Date', 'W']);
        energy2.push(['Date', 'kWh']);
        
        power3.push(['Date', 'W']);
        energy3.push(['Date', 'kWh']);
        energy2mm.push(['Date', 'kWh']);
        energy3mm.push(['Date', 'kWh']);
        energy4mm.push(['Date', 'kWh']);

        power4.push(['Date', 'W']);
        energy4.push(['Date', 'kWh']);

        energyday.push(['Date', 'kWh']);

        @foreach($power2 as $power)
            power2.push(['{{ $power->date }}', {{ $power->value }}]);
        @endforeach

        @foreach($power3 as $power)
            power3.push(['{{ $power->date }}', {{ $power->value }}]);
        @endforeach

        @foreach($power4 as $power)
            power4.push(['{{ $power->date }}', {{ $power->value }}]);
        @endforeach

        @foreach($devices as $device)
            devices.push(['{{ $device->uuid }}', '{{ $device->name }}']);
        @endforeach
        
        @foreach($energy3day as $day)
            energyday.push(['{{ $day->date }}', '{{ $day->total }}']);
        @endforeach

        var drawLineChart = function (result, id, options) {
            var data = google.visualization.arrayToDataTable(result);
            var chart = new google.visualization.LineChart(document.getElementById(id));
            chart.draw(data, options);   
        } 

        var drawLineChartA = function (result, id, options) {
            var chart = new google.visualization.LineChart(document.getElementById(id));
            chart.draw(result, options);   
        } 

        var drawBarChart = function(result, id, options) {
            var data = google.visualization.arrayToDataTable(result);
            var chart = new google.visualization.ColumnChart(document.getElementById(id));
            chart.draw(data, options);          
        }

        var bar_options = { 
          legend: { position: 'none' },
          chartArea:{left:50,top:5,width:"90%",height:"80%"},
          colors:['#325024'],
          vAxis: {
                format: '#.#',
                gridlines: { count: -1 },
            },
            // hAxis: {
            //     minTickInterval: 24 * 3600 * 1000,
            //     format:'MMM d'
            // },    
        };        

        var line_array_options = {
          curveType: 'function',
          legend: { position: 'bottom' },
          chartArea:{left:50,top:5,width:"90%",height:"80%"},
          vAxis: {
                viewWindow :{ min: 0 },
                format: '#.#',
                gridlines: { count: -1 },
                minValue: 0
            },
  
        };    


        drawLineChart(power2, 'power2', line_array_options);
        drawLineChart(power3, 'power3', line_array_options);
        drawLineChart(power4, 'power4', line_array_options);

       drawEnergyChart();
         drawTempChart();

      }

      google.load('visualization', '1', {packages:['corechart'], callback: drawChart});

    </script>
@endsection

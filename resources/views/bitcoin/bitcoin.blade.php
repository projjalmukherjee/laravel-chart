@extends('bitcoinlayout')

@section('content')
<div class="row">
    <br>
</div>
<div class="row"> 
    <div class="input-group">
        <input type="text" class="form-control" name="frm_dt" id="frm_dt" placeholder="Start Date" pattern="\d{4}-\d{2}-\d{2}">
        <span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <input type="text" name="to_dt" id="to_dt" class="form-control" placeholder="End Date">
        <span class="input-group-addon">&nbsp;</span>
        <span class="input-group-addon">&nbsp;</span>
        <span class="input-group-addon">&nbsp;</span>
        <button class="btn btn-primary btn-block" type="button" onclick="callchart()">Render</button>
    </div>  
</div>
<div class="row"> 
    <canvas id="myChart"></canvas>
</div>  
@endsection

@section('extrajs')
<script>
    var myChart;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('document').ready(function(e){
        $('#frm_dt').datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd"
                });
         
        $('#to_dt').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });         

    })


    function callchart(){
        
        var start_date = $("#frm_dt").val();
        var end_date = $("#to_dt").val();
        var labels = [];
        var bitcoindata = [];
        $.ajax({
           type:'POST',
           url:"{{ url('/chart-json') }}",
           data:{start_date:start_date, end_date:end_date},
           async:false, 
           success:function(data){
              // console.log(data);
               labels = data.data.yaxis;
               bitcoindata = data.data.xaxis;
               console.log(labels);
               callchartjs(labels,bitcoindata);
              //alert(data.success);
           }
        });

    }

    function callchartjs(labels,bitcoindata){

 
        const chartdata = {
                labels: labels,
                datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: bitcoindata,
                }]
            };

            const config = {
                type: 'line',
                data: chartdata,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    } 
                }
            };
            if (myChart !== undefined) {    myChart.destroy();  }
            myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
            

    }
   
</script>
@endsection
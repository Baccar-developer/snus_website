<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width-device-width initial-scale-1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	@vite('resources/css/app.css')
	@vite('resources/js/app.js')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
	integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" 
	referrerpolicy="no-referrer" />

<title>dashboard</title>
</head>
<body class='bg-dark text-light'>
    <div class="conteiner-fluid p-4 text-center">
    	<p class="fs-4"> current_Admin : {{Auth::guard('admin')->user()->name}}</p>
    	<a href='{{route("dashboard")}}'><button type="button" class='btn btn-danger'> Main</button></a>
    	<a href='{{route("products_dashboard")}}'><button type="button" class='btn btn-danger'> Products</button></a>
    	<a href='{{route("orders_dashboard")}}'><button  type="button" class='btn btn-danger'> Orders</button></a>
    	<a href='{{route("disconnect_admin")}}'><button type="button" class='btn btn-danger'> log out</button></a>
    </div>
    
    <div class="d-flex justify-content-center align-items-center"> 
    	<div class="text-center m-5 p-5" style="background:var(--bs-gray-800)">
    		<h3 class="text-danger ">gains from orders of this month</h3>
    		<p style="font-size:4rem;">{{$this_month_gains}} DTN</p>
    	</div>
    	<div class="text-center m-5 p-5" style="background:var(--bs-gray-800)">
    		<h3 class="text-danger">gains from orders of previous month</h3>
    		<div class="d-flex align-items-center justify-content-center">
    		<p style="font-size:4rem">{{$previous_month_gains}} DTN </p>
    		<?php 
    		if($previous_month_gains !=0){
    		    if($p_previous_month_gains!=0){
    		        $pecentage = ($previous_month_gains-$p_previous_month_gains)/$p_previous_month_gains *100;
    		        
    		        if( $pecentage<0){
    		            echo '<p class="text-danger"><i class="fa-solid fa-arrow-down"></i>'.((int)$pecentage).'%</p>';
    		        }
    		        else if($pecentage>0){
    		            echo '<p class=" text-success"><i class="fa-solid fa-arrow-up"></i>'.((int)$pecentage).'%</p>';
    		        }
    		    }
    		}
    		?>
    		</div>
    	</div>
    </div>
	<div class="d-flex justify-content-center align-items-center"> 
	<div class="text-center m-5">
		<h4>orders this month</h4>
		<h1>{{$this_month_orders}}</h1>
	</div>
	
	<div class="text-center m-5">
		<h4>orders previous month</h4>
		<h1>{{$previous_month_orders}}</h1>
	</div>
	</div>
	<div class="container my-5">
  <canvas id="myChart"></canvas>
</div>

<?php 

    $m = ['01'=>'Jan' ,'02'=>'Feb' ,'03'=>'Mar' ,'04'=>"Apr" ,'05'=>'May' ,'06'=>'Jun' ,'07'=>'Jul' ,'08'=>'Aug' ,'09'=>'Sep' ,'10'=>'Oct' ,'11'=>'Nov' , '12'=>'Dec'];
    use App\Models\orders;
    $date = new DateTime();
    date_modify($date, "-".$date->format("d")." days");
    date_modify($date, "+1 days");
    $date->setTime( 8,0);
    $gain  = orders::where("payed" ,true)->where("created_at",">", $date->format("Y-m-d h:i:s") )->sum("price_per_DT");
    $gains =[ $gain];
    $months = [$m[$date->format("m")]];
    for( $i=0 ;$i<5 ; $i++){
        $p = clone $date;
        date_modify($date, "-1 months");
        array_unshift($months ,$m[$date->format("m")]);
        
        $gain = orders::where("payed" ,true)->where("created_at","<", $p->format("Y-m-d h:i:s") )->where("created_at" ,">" ,$date->format("Y-m-d h:i:s"))->sum("price_per_DT");
        array_unshift($gains ,$gain);
    }
    
    
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
	Chart.defaults.color = "#f8f9fa";
	
const simpleLineConfig = {
  type: 'line',
  data: {
  labels : <?php echo json_encode($months)?>,
    datasets: [{
      label: 'Monthly Sales',
      data: <?php echo json_encode($gains )?> ,
      borderColor: 'rgb(220, 53, 69)',
      backgroundColor: 'rgba(220, 53, 69, 0.2)',
      
      borderWidth: 3,
      fill: true,
      pointRadius: 5,
  pointHoverRadius: 7
      
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
     tooltip: {
      callbacks: {
        label: function(context) {
          return `${context.dataset.label}: ${context.raw} DTN`; // Add dollar sign
          // Alternative formats:
          // return `${context.dataset.label}: ${context.raw}%`; // Percentage
          // return `${context.dataset.label}: ${context.raw} units`; // Generic
        }
      }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        grid:{
        	color :"#6c757d",
        	lineWidth: 2
        },
        ticks: {
        callback: function(value) {
          return  value+"DTN"; // Add dollar sign
          // return value + '%'; // For percentage
          // return value + '°C'; // For temperature
        }
      },
      },
      x:{
      	grid :{
      		color:'#495057',
        	lineWidth: 2,
      	}
      }
    }
  }
};

// Create the chart
new Chart(
  ctx,
  simpleLineConfig
);
	
  
</script>
	
    
    
</body>
</html>
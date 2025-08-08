<?php use App\Models\chart_elements;?>
@foreach($orders as $order)
			<div style="background-color: var(--bs-gray-800); " class="mb-5 p-4">
				<h3>ordered at {{$order["created_at"]}}</h3>
				<h3>status : <label class= 
			<?php 
			

switch ($order->order_status){
			    case "unfulfilled" :echo "'text-warning'";
			    case "canceled" :echo "'text-secondary'";
			    case "delivered" :echo "'text-success'";
			}
			?>>{{$order->order_status}}</label></h3>
				@if($order->order_status=='delivered')
				<h3>delivered at: {{$order->delivered_at}}</h3>
				@endif
				<h3>price: {{$order->price_per_DT}} DTN</h3>
				@if($order->payed)
				<h3 class="text-success">payed</h3>
				@else
				<h3 class="text-danger">not payed</h3>
				@endif
				<?php 
				    
				    $chart_elements =chart_elements::where("chart_id" ,$order->chart_id);
				    $chart_elements= $chart_elements->LeftJoin("products as p" , "p.product_id" ,"=" , "chart_elements.product_id")->paginate(10);
				?>
    			<table class="table table-striped table-dark">
    				<tr>
    					<td>product name</td><td>quantity</td><td>product price</td><td>product image</td>
    				</tr>
    				@foreach($chart_elements as $p)
    				<tr>
    					<td>{{$p->product_name}}</td><td>{{$p->qnt}}</td><td>{{$p->price_per_DT}}DTN</td><td><img height='100px' src="{{asset('storage/product_img/'.$p->product_image)}}"></td>
    				</tr>
    				@endforeach
    			</table>
				{{$chart_elements->links()}}
				@if($order->order_status =='unfulfilled')
				<button type="button" class="btn btn-danger" id="cancel_button_{{$order->order_id}}" target_order={{$order->order_id}}>cancel</button>
				<script>
				$("#cancel_button_{{$order->order_id}}").click(function(){
            		$(".modal").show();
            		$("#order_id").val( $(this).attr("target_order") );
            	});
				</script>
				@endif
			</div>
		
@endforeach

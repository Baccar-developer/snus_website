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
				
    			@include('includes.order_list' ,["chart_id"=>$order->chart_id])
				
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

<?php
use App\Models\chart_elements;
?>
@extends("layouts.layout")
@section('title')
previous orders
@endsection

@section('content')
<!-- modal -->
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-light bg-dark">
      <div class="modal-header">
        <h5 class="modal-title">do you realy want to cancel this order?</h5>
          
      </div>
      <form class="modal-footer" method="post" action="{{route('cancel_order')}}">
      	@method('PATCH')
      	@csrf
      	<input name="order_id" id="order_id" type="hidden">
        <button type="submit" class="btn btn-danger">yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss=".modal" id="no-btn">no</button>
      </form>
    </div>
  </div>
</div>

<script>
	
	$("#no-btn").click(function(){$($(this).attr("data-dismiss")).hide()})
</script>
<!-- orders -->
<div class="container p-5 for-fill" id="scrollable">
<h1 class="text-danger"> your previous orders <i class="fa-solid fa-bag-shopping"></i></h1>
	@if(!isset($orders[0]))
		you didn't order any thing yet
		
	@else
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
				<button type="button" class="btn btn-danger" id="cancel_button_{{$order->order_id}}"  target_order={{$order->order_id}}>cancel</button>
				<script>
				$("#cancel_button_{{$order->order_id}}").click(function(){
            		$(".modal").show();
            		$("#order_id").val( $(this).attr("target_order") );
            	});
				</script>
				@endif
			</div>
			
		@endforeach
	@endif
	
</div>
<script>
var step = 2;
var offset =2;
var loading = false;
var end =false

$(window).on("scroll.once", function() {
	if(end==true){return;}
    if ($(window).scrollTop() >= $(document).height()-$("#scrollable").height()+$("#scrollable").position().top-200 ){
        if(loading === false){
            loading = true;
            $.ajax({
                url: '{{url("profile/orders/scroll")}}',
                method:'POST',
                cache:true,
                data:{start:offset , step:step , _token: '{{ csrf_token() }}'},
                success: function (data) { 
                if (data!=''){
                	offset+=step; $('#scrollable').append(data); loading = false; 
                	}
                else{
                	$('#scrollable').append("<h4 class='text-secondary'>there is no more orders</h4>");
                	end = true
                }},
                error: function(xhr ,ajaxOptions,thrownError){
                	alert(thrownError);
                	alert(xhr.status);
                },
                dataType: 'html'
            });
        }
    }
});
</script>
@endsection
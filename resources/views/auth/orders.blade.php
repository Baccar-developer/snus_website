
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
<h3 class="text-secondary">prices may change with time</h3>
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
				@include("includes.order_list" ,["chart_id"=> $order->chart_id])
				
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
@extends("layouts.layout")
@section('title')
current cart
@endsection

@section('content')
<!-- modal -->
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-light p-4">
      <div class="modal-header">
        <h5 class="modal-title">ORDER</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{route('send_order')}}">
          <div class="modal-body">
            <h3>choose your payment method</h3>
            
            <div class="d-flex g-2">
            	<label class="form-label fs-4 text-danger">at delivery<i class="fa-solid fa-truck"></i></label>
            	<input class="form-check-input" type="radio" name="method" value="at_shipping" checked>
            	
            </div>
             <div class="d-flex g-2">
				<label class="fs-3 text-danger form-label">location</label><input class="form-control" type="text" name="location" value='{{old('location')}}'>
            </div>
            <h4>shipping price: {{getenv("SHIPPING_PRICE")}}DTN</h4>
            <h4>products price: {{$price}}DT</h4>
            <?php $full_price = $price+getenv("SHIPPING_PRICE");?><br>
            <h3>the full price:{{$full_price}}DTN</h3>
            <input type="hidden" name="price_per_DT" value={{$full_price}}>
            <input type="hidden" name="chart_id" value={{$cart->chart_id}}>
            @csrf
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Order</button>
            <button type="button" class="btn btn-secondary" data-dismiss=".modal" id="close_btn">Close</button>
          </div>
      </form>
    </div>
  </div>
</div>
<!-- script -->

<script>
	$(document).ready(function(){
		$('#order_btn').click(function(){$('.modal').show()});
		$('#close_btn').click(function(){$($(this).attr('data-dismiss')).hide()});
	});
</script>
<div class="container-fluid  for-fill" >
<h1 class="text-danger"> your cart <i class="fa-solid fa-cart-shopping"></i></h1>
@if(!$cart_elements[0])
	<div  style="background-color :var(--bs-gray-800); height:70vh ; display:flex ; align-items:center; justify-content:center;padding:20px">
		<h1>your cart is empty for now</h1>
	</div>
@else

		
	<table class="table table-striped table-dark">
	<tr><td>name</td><td>quantity</td><td>price per one</td><td>product image</td> <td>actions</td></tr>
		@foreach($cart_elements as $p)
		<tr>
			<form method='post' action='{{route("modify_cart")}}'>
			@csrf 
			<input type="hidden" name="chart_id" value={{$cart->chart_id}}>
			<input type="hidden" name="product_id" value={{$p->product_id}}>
			<td>{{$p->product_name}}</td>
			<td width='200pxpx' style="padding-right:50px"><input type='number' value='{{$p->qnt}}' name="qnt" min=1 class="form-control" width="50px"></td>
			<td>{{$p->price_per_DT}}DTN</td>
			<td><img height='100px' src="{{asset('storage/product_img/'.$p->product_image)}}"></td>
			<td><button name="modify" class="btn btn-secondary fs-5" type="submit">modify</button>   <button type ="submit" name="delete" class="btn btn-danger fs-5" >delete</button></td>
			</form>
		</tr>
		@endforeach
	</table>
	{{$cart_elements->links()}}
	<h2>total price :{{$price}}DTN</h2>
	<a class="btn btn-danger fs-3" id="order_btn">click to order</a>
@endif
</div>

@endsection
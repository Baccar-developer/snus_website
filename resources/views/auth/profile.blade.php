@extends('layouts.layout')
@section('title')
Dashboard
@endsection

@section("content")
	<div class="container ms-5 mt-5 bg-dark-600 text-center">
		@if(Auth::user()->avatar)
			<img height='300px' width='300px' src='{{asset("storage/profile_img/".Auth::user()->avatar)}}'  style='border-radius:50%'>
		@else
			<img height='300px' width='300px' src="{{asset('assets/img/default.jpg')}}" style='border-radius:50%'>
		@endif
		<script>
			$(document).ready(function(){
				$('#img_change_btn').click(function(){
					$('.modal').show()
					$('#display').attr("src" , 
					@if(Auth::user()->avatar)
						'{{asset("storage/profile_img/".Auth::user()->avatar)}}'
					@else
						'{{asset('assets/img/default.jpg')}}'
					@endif
					)
					$("#image_input").wrap('<form>').closest(
                    'form').get(0).reset();
                   $("#image_input").unwrap(); 
				});
				$('#close').click(function(){
					$('.'+$(this).attr('data-dismiss')).hide();
				});
				$("#image_input").on("change" ,function(){
					
					var file = $(this).get(0).files[0];
					
					var reader = new FileReader();
					reader.readAsDataURL(file);
					
					reader.onload = function(e){
						$('#display').attr("src" , e.target.result);
					}
				});
			});
		</script>
		<!-- modal -->
    		<div class="modal" tabindex="-1" role="dialog">
              <div class="modal-dialog big" role="document">
                <div class="modal-content bg-dark text-light big">
                  <div class="modal-header">
                    <h5 class="modal-title text-danger">change avatar</h5>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method='patch' action='{{route("change_avatar")}}' enctype="multipart/form-data">
                  
                  @csrf
                  <div class="modal-body">
                    <label class="form-label fs-3">select image here:</label>
                     <input type="file" name="image" id='image_input' accept="image/pnj image/jpeg" class="form-control">
                     <br><br>
                     @if(Auth::user()->avatar)
            			<img height='300px' width='300px' style='border-radius:50%' id="display" >
            		@else
            			<img height='300px' width='300px' src="{{asset('assets/img/default.jpg')}}" style='border-radius:50%' id="display">
            		@endif
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
        
		<br>
		<button class="text-danger fs-6 btn" id="img_change_btn">do you want to change you're avatar?</button>
		<br>
		<p class="fs-1">{{Auth::user()->customer_name}}</p>
		
		<hr>
		
		<p class="fs-3">validation gates</p>
		<h4>tel°: {{Auth::user()->tel}}</h4>
		<h4>email:
		@if(Auth::user()->email)
		<label>{{Auth::user()->email}}</label>
		<a class="text-danger fs-6 btn" href='{{route("change_email_form")}}'>do you want to change email?</a>
		@else
		<label class="text-secondary">NULL</label>
		<br>
		<a class="text-danger fs-6 btn" href='{{route("change_email_form")}}'>do you want to add email?</a>
		@endif
		</h4>
		<hr>
		<h2>Last ORDER</h2>
		<div class="p-5 rounded-2 mb-5" style="background-color:var(--bs-gray-800)">
		@if(isset($last_order))
			<h4>ordered at {{$last_order->created_at}}</h4>
			<h4>status: <label
			class= 
			<?php 
			switch ($last_order->order_status){
			    case "unfulfilled" :echo "'text-warning'";
			    case "canceled" :echo "'text-secondary'";
			    case "delivered" :echo "'text-success'";
			}
			?>
			>{{$last_order->order_status}}</label></h4>
			<h4>products:</h4>
			

			<table class="table table-striped table-dark">
				<tr>
					<td>product name</td><td>quantity</td><td>product price</td><td>product image</td>
				</tr>
				@foreach($purchases as $p)
				<tr>
					<td>{{$p->product_name}}</td><td>{{$p->qnt}}</td><td>{{$p->price_per_DT}}DTN</td><td><img height='100px' src="{{asset('storage/product_img/'.$p->product_image)}}"></td>
				</tr>
				@endforeach
			</table>
			
			<h4> full price: {{$last_order->price_per_DT}}DTN</h4>
		@else
			
			<h3 class="text-secondary">you didn't order any thing yet</h3>
			
		@endif
		</div>
	</div>
@endsection


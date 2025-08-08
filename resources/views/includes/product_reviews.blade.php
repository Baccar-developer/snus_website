@foreach($reviews as $r)
    <div class="container p-5 my-4" style='background-color:var(--bs-gray-800)'>
    	<div class="container d-flex mb-2 align-items-center ">
			@include('includes.avatar',["radius"=>'50px' , 'avatar'=>$r->avatar]) 
			<h5 class="m-1">{{$r->customer_name}}</h5>
			<h5 class="m-1">@include('includes.rate' , ["rate" =>$r->rate])</h5>
			<h5 class="ms-auto text-secondary">{{$r->created_at}}</h5>
		</div>
		<div class="container-fluid bg-dark p-4 fs-5 rounded-3">{{$r->comment}}</div>
				
	</div>
    @endforeach
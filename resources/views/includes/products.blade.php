<script>
$(".confirm").click(function(){
	$(".modal").show();
			$("form #id").attr( 'value',Number($(this).parent().attr("product_id")))  ;
			
		});
</script>
<table class="table table-dark table-striped fs-5"> 
    <tr>
    <th>name</th>
    <th>description</th>
    <th width=100px>price per DT</th>
    <th width=100px>full quantity</th>
    <th>wished quntity</th>
    <th>ordered quntity</th>
    <th >sold quantity</th>
    <th >gains per DT</th>
    <th>ratings</th>
    <th width=200px>rate</th>
    <th width=600px>image</th>
    <th>added at</th>
    <th>actions</th>
    </tr>
    @foreach($data as $row)
    
    	
    	<tr >
    	<form enctype="multipart/form-data" method="post" action ="{{route('modify_product')}}">
    		@csrf
    		<input name='product_id' type='hidden' value= {{$row["product_id"]}}>
    		<th ><input type='text' value='{{$row["product_name"]}}' name='product_name' class="form-control"></th>
    		<th ><textarea name='product_desc' class="form-control">{{$row['product_desc']}}</textarea></th>
    		<th ><input type='number' step=0.1  min-value=1 value='{{$row["price_per_DT"]}}' name='price_per_DT' class="form-control"></th>
    		<th ><input type='number'   value='{{$row["full_qnt"]}}' name='full_qnt' class="form-control"></th>
    		<th ><label  class="form-label">{{$row["wished_qnt"]}} </label></th>
    		<th ><label  class="form-label">{{$row["ordered_qnt"]}} </label></th>
    		<th ><label class="form-label">{{ $row['sold_qnt'] }}</label></th>
    		<th ><label  class="form-label">{{$row["gains_per_DT"];}}</label></th>
    		<th ><label class="form-label">{{ $row['ratings'] }}</label></th>
    		<th >
    			@include('includes.rate' ,['rate'=>$row->product_rate])
    		</th>
    	
    		<th class='d-flex'><input type='file' accept="image/png, image/jpeg" name='image' class="form-control mb-auto">
    		@if( isset($row['product_image']))
    		<img height= 150px src="{{asset('storage/product_img/'.$row['product_image'])}}">
    		@else
    		<img height= 150px src="{{asset('assets/img/img.png')}}">
    		@endif
    		</th>
    		<th><label class="form-label">{{$row["created_at"]}}</label></th>
    		<th id='{{$row["product_id"]}}'> <button type="submit" class="btn btn-danger m-2" >modify</button> 
    		<button type="button" class="btn btn-danger m-2 confirm" >delete</button></th>
    	</form>
    	</tr>
    
    @endforeach
   </table>
  {{$data->links()}}
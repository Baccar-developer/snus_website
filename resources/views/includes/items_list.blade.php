 <thead>
 <tr>
 	<td>product name</td>
 	<td>product price</td>
 	<td>quantity</td>
 	<td>image</td>
 </tr>
 </thead>
@foreach($data as $row)
<tbody>
<tr>
 	<td>{{$row->product_name}}</td>
 	<td>{{$row->price_per_DT}}</td>
 	<td>{{$row->qnt}}</td>
 	<td><img height=100px width=100px src="{{asset('storage/product_img/'.$row->product_image)}}"></td>
 </tr>

@endforeach
</tbody>
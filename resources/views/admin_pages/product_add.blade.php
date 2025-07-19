@extends("layouts.admin_layout")
@section('title')
add product
@endsection
@section("content")
<tr>
	<td><label class="form-label">product name</label></td>
	<td><label class="form-label">product description</label></td>
	<td><label class="form-label">product price per DT</label></td>
	<td><label class="form-label">product current quantity</label></td>
	<td><label class="form-label">product display image</label></td>
	<td></td>
</tr>

<tr>
	<form method="post"enctype="multipart/form-data" action="{{route('add_product')}}">
		@csrf
		<td><input type="text" name="name" class="form-control"></td>
		<td> <textarea name="desc" class="form-control"></textarea></td>
		<td><input type="number" min-value=1 value=1 name="price_per_DT" class="form-control"></td>
		<td><input type="number" min-value=0 value=0 name="full_quantity" class="form-control"></td>
		<td><input accept="image/png, image/jpeg"type="file"  name="image" class="form-control"></td>
		<td><button class="btn btn-danger">add</button></td>
</form>
		

</tr>	
@endsection
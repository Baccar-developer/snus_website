<?php
use Carbon\Traits\Date;
?>
@extends("layouts.admin_layout")

@section('content')
<tr>
<th>id</th>
<th>product name</th>
<th>ordered at</th>
<th>time after ordering</th>
<th>order price per DT</th>
<th>governorate</th>
<th>location</th>
<th>state</th>
<th>delivered at</th>
<th>tel</th>
<th>payed</th>
<th>actions</th>
</tr>

@foreach($data as $row)
<tr>
    <th><label class='form-label'>{{$row['id']}}</label><input name='id' type='number' value= {{$row["id"]}}></th>
    <th><label class='form-label'>{{$row['product_name']}}</label></th>
    <?php 
        $order_date = $row['created_at'];
        $date = new DateTime('now');
        $diff = $date->diff($order_date);
    ?>
    <th><label class='form-label'>{{$order_date}}</label></th>
    <th>
    <label class='form-label'>
    <?php
    if($diff->y !=0){echo $diff->y." Years";}
    else if($diff->m !=0){echo $diff->m." Months";}
    else if($diff->d !=0){echo $diff->d." Days";}
    else {echo $diff->h." Hours ".$diff->i." minuts";}
    ?>
    </label>
    </th>
    <th><label class='form-label'>{{$row['order_price']}}</label></th>
    <th><label class='form-label'>{{$row['governorate']}}</label></th>
    <th><label class='form-label'>{{$row['location']}}</label></th>
    <th><label class='form-label text-<?php 
    	$state = $row["state"];
    	if($state =="delivered"){echo "success";}
    	else if($state =="unfulfilled"){echo "danger";}
    	else{echo "light-emphasis";}
    ?>'>{{$state}}</label></th>
    <th>delivered at</th>
    <th>tel</th>
    <th>payed</th>
    <th>
    	@if($state=="unfulfilled"){
    	    <button class='btn btn-danger' type='submit' formaction='route("{{check_order}}")'>check</button>";
    	@endif

    	<button class='btn btn-danger m-2' type="submit" formaction='{{route("delete_order")}}'>delete</button>
    </th>
</tr>

@endforeach
@endsection
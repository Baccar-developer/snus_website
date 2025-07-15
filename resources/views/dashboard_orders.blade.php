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
    <th><label class='form-label'>{{$row['id']}}</label></th>
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
    	<?php
    	if($state=="unfulfilled"){
    	    echo "<a href=".url("chk_order/".$row["id"]).">";
    	    echo "<button class='btn btn-danger'>check</button>";
    	    echo "</a>";
    	}
    	?>
    	<a href='{{url("delete_order/".$row["id"])}}'><button class='btn btn-danger m-2'>delete</button></a>
    </th>
</tr>

@endforeach
@endsection
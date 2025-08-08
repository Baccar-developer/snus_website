@if (!$avatar)
<img height={{$radius}} width={{$radius}} src="{{asset('assets/img/default.jpg')}}" style="border-radius:50%; margin:20px">

@else
<img height={{$radius}} width={{$radius}} src="{{asset('storage/profile_img/'.$avatar)}}" style="border-radius:50% ;margin:20px">

@endif
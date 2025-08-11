<h1>Your Order Has Been Sent!</h1>
<h3>you ordered:</h3>
<table>
@foreach($cart_elements as $c)
<tr><td>{{$c->product_name}}: </td><td>{{$c->qnt}} x {{$c->price_per_DT}} DT</td></tr>
@endforeach
</table>
<h3>your full dept: {{$full_price}} DT</h3>

<p>this email sent by {{env('APP_NAME')}}</p>
<a href='{{env("APP_URL")}}'>{{env('APP_URL')}}</a>

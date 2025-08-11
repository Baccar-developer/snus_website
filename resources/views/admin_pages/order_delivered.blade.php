<h1>Your Order is delivered!</h1>
<h3>we shipped your order to you before minuts</h3>

<?php 
if(!$payed){
    echo "<h3>you didn't pay for our products, hurry and pay!</h3>";
}
?>

<p>this email sent by {{env('APP_NAME')}}</p>
<a href='{{env("APP_URL")}}'>{{env('APP_URL')}}</a>

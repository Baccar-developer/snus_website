@extends('layouts.verification_layout')
@section('title')
email verification code
@endsection

@section("content")
<div class="container form-container p-5 text-center">
	<h1 class="text-danger">Your verification code:</h1>
	<h3>{{$code}}</h3>

</div>
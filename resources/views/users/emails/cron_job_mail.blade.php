@extends('users.emails.email-layout')
@section('content')
<?php 
$html = 'Dear '.$data['poster_name'].'<br>
		<h1>I got email on </h1><p>'.$data['now_date'].'</p>'.$data['message'];
?>
{!! $html !!}
@endsection
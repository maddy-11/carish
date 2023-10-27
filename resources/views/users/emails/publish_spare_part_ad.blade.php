@extends('users.emails.email-layout')
@section('content')
<?php 
	$html = str_replace('[[name]]', '<strong>'.$data['customer_name'].'</strong>', $template->content);
?>
{!! $html !!}
@endsection
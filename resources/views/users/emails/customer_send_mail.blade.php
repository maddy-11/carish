@extends('users.emails.email-layout')
@section('content')
<?php 
	$html = str_replace('[[first_name]]', '<strong>'.$data['firstname'].'</strong>', $template->content);
	$html = str_replace('[[last_name]]', '<strong>'.$data['lastname'].'</strong>', $html);
	$html = str_replace('[[Body]]', '<strong>'.$data['body'].'</strong>', $html);
?>
{!! $html !!}
@endsection
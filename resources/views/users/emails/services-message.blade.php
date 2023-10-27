@extends('users.emails.email-layout')
@section('content')
<?php
	$html = str_replace('[[name]]', '<strong>'.$data['name'].'</strong>', $template->content);
	$html = str_replace('[[ad_title]]', '<strong>'.$data['service_title'].'</strong>', $html);
	$html = str_replace('[[reason]]', '<strong>'.$data['reason'].'</strong>', $html);	
?>
{!! $html !!}
@endsection
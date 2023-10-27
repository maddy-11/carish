@extends('users.emails.email-layout')
@section('title','Account Activation')
@section('content')
<?php 
	$html = str_replace('[[name]]', '<strong>'.$data['fullname'].'</strong>', $template->content);
	$html = str_replace('[[Link]]', url('verify/'.$data['id']), $html);
?>
{!! $html !!}
</br>
@endsection
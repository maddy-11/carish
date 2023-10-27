@extends('users.emails.email-layout')
@section('content')
<?php 
	$html = str_replace('[[name]]', '<strong>'.$data['fullname'].'</strong>', $template->content);
	$html = str_replace('[[Link]]', url('reset_password_form/'.$data['id'].'/'.$data['password_reset_token']), $html);
?>
{!! $html !!}
</br>
@endsection
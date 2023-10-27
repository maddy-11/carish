@extends('users.emails.email-layout')
@section('content')
<?php 
$html = $template->content;
?>
{!! $html !!}
@endsection
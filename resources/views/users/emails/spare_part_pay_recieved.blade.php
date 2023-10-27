@extends('users.emails.email-layout')
@section('content')
<?php
$html = str_replace('[[name]]', '<strong>'.$pay_data['poster_name'].'</strong>', $pay_template->content);
$html = str_replace('[[invoice_number]]', '<strong>'.$pay_data['invoice_id'].'</strong>', $html);
?>
{!! $html !!}
@endsection
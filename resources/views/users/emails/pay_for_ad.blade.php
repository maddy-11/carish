@extends('users.emails.email-layout')
@section('content')
<?php
$html = str_replace('[[name]]', '<strong>'.$pay_data['poster_name'].'</strong>', $pay_template->content);
$html = str_replace('[[ads_title]]', '<strong>'.$pay_data['title'].'</strong>', $html);
$html = str_replace('[[invoice_attachment]]', '<strong>'.$pay_data['invoice_pdf'].'</strong>', $html);
?>
{!! $html !!}
@endsection
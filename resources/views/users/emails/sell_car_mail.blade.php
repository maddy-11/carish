@extends('users.emails.email-layout')
@section('content')
<?php 
$html = str_replace('[[name]]', '<strong>'.$data['poster_name'].'</strong>', $template->content);
$html = str_replace('[[ad_title]]', '<strong>'.$data['title'].'</strong>', $html);
if(@$data['id'] !== null)
{
	$html = str_replace('[[Link]]',url('car-details/'.$data['id']), $html);
}
?>
{!! $html !!}
@endsection
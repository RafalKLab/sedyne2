@extends('templates.main')

@section('title')
    Make reservation
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/space-builder.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/space-preview.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seat-reservation.css') }}">
@endsection

@section('content')
    <livewire:Reservation.seat-reservation />
@endsection

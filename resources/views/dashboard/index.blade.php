@extends('layouts.layout')

@section('content')
    @include('dashboard.accumulations')
    @include('dashboard.revenue')


    @session('success')
        {{ $value }}
    @endsession

@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/index.js') }}"></script>
@endsection


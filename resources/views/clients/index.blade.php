@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Clients'" :createRoute="route('clients.create')" :headerItems="[
        ['width' => '170px', 'title' => 'Reg Date'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Contact No.'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $clients->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/clients/index.js') }}"></script>
@endsection


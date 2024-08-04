@extends('layouts.layout')
   
@section('content')

@include('components.master-data', [
    'dataTitle' => 'Generic Name',
    'createRoute' => route('item-generic-name.create'),
    'headerItems' => [
        ['width' => '80px', 'title' => 'No'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Details'],
        ['width' => '250px', 'title' => 'Action'],
    ]
])

{!! $itemGenericName->links() !!}

@endsection

@section('scripts')
    <script src="{{ asset('js/item-generic-name/index.js') }}"></script>
@endsection

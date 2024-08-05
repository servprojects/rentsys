@extends('layouts.layout')
   
@section('content')

@include('components.master-data', [
    'dataTitle' => 'Item Category',
    'createRoute' => route('item-category.create'),
    'headerItems' => [
        ['width' => '80px', 'title' => 'No'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Details'],
        ['width' => '250px', 'title' => 'Action'],
    ]
])

{!! $itemCategory->links() !!}

@endsection

@section('scripts')
    <script src="{{ asset('js/item-category/index.js') }}"></script>
@endsection

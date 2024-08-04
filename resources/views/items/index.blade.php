@extends('layouts.layout')

@section('content')
    @include('components.master-data', [
        'dataTitle' => 'Items',
        'createRoute' => route('items.create'),
        'headerItems' => [
            ['width' => '80px', 'title' => 'Code'],
            ['width' => '', 'title' => 'Category'],
            ['width' => '', 'title' => 'Description'],
            ['width' => '250px', 'title' => 'Action'],
        ],
    ])

    {!! $items->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/items/index.js') }}"></script>
@endsection

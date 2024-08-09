@extends('layouts.layout')

@section('content')

    <x-master-data :dataTitle="'Items'" :createRoute="route('items.create')" :headerItems="[
        ['width' => '80px', 'title' => 'Code'],
        ['width' => '', 'title' => 'Category'],
        ['width' => '', 'title' => 'Description'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $items->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/items/index.js') }}"></script>
@endsection

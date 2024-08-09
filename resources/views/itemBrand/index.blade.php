@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Item Brand'" :createRoute="route('item-brand.create')" :headerItems="[
        ['width' => '80px', 'title' => 'No'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Details'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $itemBrand->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/item-brand/index.js') }}"></script>
@endsection

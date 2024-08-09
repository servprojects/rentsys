@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Generic Name'" :createRoute="route('item-generic-name.create')" :headerItems="[
        ['width' => '80px', 'title' => 'No'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Details'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $itemGenericName->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/item-generic-name/index.js') }}"></script>
@endsection

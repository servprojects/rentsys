@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Assets'" :createRoute="route('assets.create')" :headerItems="[
        ['width' => '80px', 'title' => 'Code'],
        ['width' => '', 'title' => 'SN'],
        ['width' => '', 'title' => 'Item Desc'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $asset->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/assets/index.js') }}"></script>
@endsection

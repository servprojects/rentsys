@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Lead Sources'" :createRoute="route('lead-source.create')" :headerItems="[
        ['width' => '80px', 'title' => 'No'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Details'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $leadSource->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/lead-source/index.js') }}"></script>
@endsection

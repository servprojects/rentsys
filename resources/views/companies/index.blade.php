@extends('layouts.layout')

@section('content')
    <x-master-data :dataTitle="'Companies'" :createRoute="route('companies.create')" :headerItems="[
        ['width' => '80px', 'title' => 'Code'],
        ['width' => '', 'title' => 'Name'],
        ['width' => '', 'title' => 'Email'],
        ['width' => '250px', 'title' => 'Action'],
    ]" :loadingSpan="4" />

    {!! $company->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/companies/index.js') }}"></script>
@endsection


@extends('layouts.layout')

@section('content')

    <x-master-data :dataTitle="'Rentals'" :createRoute="route('rentals.create')" :headerItems="[
        ['width' => '80px', 'title' => 'Code'],
        ['width' => '', 'title' => 'Pickup'],
        ['width' => '', 'title' => 'Return'],
        ['width' => '', 'title' => 'Asset'],
        ['width' => '', 'title' => 'Client'],
        ['width' => '160px', 'title' => 'Action'],
    ]" :loadingSpan="6">
        @slot('otherActions')
            <select name="asset_id" id="asset_id" class="form-control">
                <option value="0" selected>Filter Asset</option>
                @forelse ($assets as $ic)
                    <option value="{{ $ic->id }}">
                        {{ $ic->item ? $ic->item->description : '' }}</option>
                @empty
                    <option value="">No data</option>
                @endforelse
            </select>
        @endslot

    </x-master-data>
   

    {!! $rentals->links() !!}
@endsection

@section('scripts')
    <script src="{{ asset('js/rentals/index.js') }}"></script>
@endsection

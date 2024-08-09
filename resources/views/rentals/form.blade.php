@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form
                action="{{ $transactionRoute == 'rentals.update' ? route($transactionRoute, $rental->id) : route($transactionRoute) }}"
                method="POST">
                @csrf
                @if ($transactionRoute == 'rentals.update')
                    @method('PUT')
                @endif


                <div class="card-header">
                    RENTAL FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="client" class="form-label">Client</label>
                                <input type="text" value="{{ $rental->client ?? '' }}" name="client"
                                    class="form-control" id="client">
                                @error('client')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label">Asset</label>
                                <select name="asset_id" class="form-control">
                                    <option selected>Select</option>
                                    @forelse ($assets as $ic)
                                        <option value="{{ $ic->id }}"
                                            {{ $rental->asset_id == $ic->id ? 'selected' : '' }}>
                                            {{ $ic->item ? $ic->item->description : '' }}</option>
                                    @empty
                                        <option value="">No data</option>
                                    @endforelse
                                </select>
                                @error('item_category_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- First Row: Expected Pickup and Expected Return -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expected_pickup_datetime" class="form-label">Expected Pickup Date/Time</label>
                                <input type="datetime-local" value="{{ $rental->expected_pickup_datetime ?? '' }}"
                                    name="expected_pickup_datetime" class="form-control" id="expected_pickup_datetime">
                                @error('expected_pickup_datetime')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expected_return_datetime" class="form-label">Expected Return Date/Time</label>
                                <input type="datetime-local" value="{{ $rental->expected_return_datetime ?? '' }}"
                                    name="expected_return_datetime" class="form-control" id="expected_return_datetime">
                                @error('expected_return_datetime')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Second Row: Actual Pickup and Actual Return -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="actual_pickup_datetime" class="form-label">Actual Pickup Date/Time</label>
                                <input type="datetime-local" value="{{ $rental->actual_pickup_datetime ?? '' }}"
                                    name="actual_pickup_datetime" class="form-control" id="actual_pickup_datetime">
                                @error('actual_pickup_datetime')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="actual_return_datetime" class="form-label">Actual Return Date/Time</label>
                                <input type="datetime-local" value="{{ $rental->actual_return_datetime ?? '' }}"
                                    name="actual_return_datetime" class="form-control" id="actual_return_datetime">
                                @error('actual_return_datetime')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_of_inquiry" class="form-label">Date of Inquiry</label>
                                <input type="datetime-local" value="{{ $rental->date_of_inquiry ?? '' }}" name="date_of_inquiry"
                                    class="form-control" id="date_of_inquiry">
                                @error('date_of_inquiry')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="surrendered_id" class="form-label">Surrendered ID and ID Number</label>
                                <input type="text" value="{{ $rental->surrendered_id ?? '' }}" name="surrendered_id"
                                    class="form-control" id="surrendered_id">
                                @error('surrendered_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_from_ads" value="0">
                                <input type="checkbox" {{ $rental->is_from_ads ? 'checked' : '' }} name="is_from_ads"
                                    class="form-check-input" id="is_from_ads" value="1">
                                <label for="is_from_ads" class="form-check-label">Is from ads?</label>
                                @error('is_from_ads')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pickup_remarks" class="form-label">Pickup Remarks</label>
                            <input type="text" value="{{ $rental->pickup_remarks ?? '' }}" name="pickup_remarks"
                                class="form-control" id="pickup_remarks">
                            @error('pickup_remarks')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="return_remarks" class="form-label">Return Remarks</label>
                            <input type="text" value="{{ $rental->return_remarks ?? '' }}" name="return_remarks"
                                class="form-control" id="return_remarks">
                            @error('return_remarks')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>






                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('rentals.index') }}"><button type="button"
                                    class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/rentals/form.js') }}"></script>
@endsection

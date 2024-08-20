@extends('layouts.layout')

@section('content')
    <div class="card mt-5">
        <h2 class="card-header">Rental {{ $rental->id }} - {{ $rental->asset->item->description }}</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('rentals.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>

            {{-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Client:</strong> <br />
                        {{ $rental->client }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Asset:</strong> <br />
                        {{ $rental->asset->item->description }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Expected Pickup Date/Time:</strong> <br />
                        {{ \Carbon\Carbon::parse($rental->expected_pickup_datetime)->format('F j, Y \@ g:i A') }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Expected Return Date/Time:</strong> <br />
                        {{ \Carbon\Carbon::parse($rental->expected_return_datetime)->format('F j, Y \@ g:i A') }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Actual Pickup Date/Time:</strong> <br />
                        @if ($rental->actual_pickup_datetime == null)
                            <span class="text-danger">Not yet picked up</span>
                        @else
                            {{ \Carbon\Carbon::parse($rental->actual_pickup_datetime)->format('F j, Y \@ g:i A') }}
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Actual Return Date/Time:</strong> <br />
                        @if ($rental->actual_return_datetime == null)
                            <span class="text-danger">Not yet returned</span>
                        @else
                             {{ \Carbon\Carbon::parse($rental->actual_return_datetime)->format('F j, Y \@ g:i A') }}
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Pickup Remarks:</strong> <br />
                        {{ $rental->pickup_remarks }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Return Remarks:</strong> <br />
                        {{ $rental->return_remarks }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                    <div class="form-group">
                        <strong>Surrender ID:</strong> <br />
                        {{ $rental->surrendered_id }}
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Client:</strong>
                        <p class="form-control-plaintext">{{ $rental->client }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Date of Inquiry:</strong>
                        <p class="form-control-plaintext">
                            {{ \Carbon\Carbon::parse($rental->date_of_inquiry)->format('F j, Y') }}
                        </p>
                    </div>
                </div>
                {{-- <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Asset:</strong>
                        <p class="form-control-plaintext">{{ $rental->asset->item->description }}</p>
                    </div>
                </div> --}}

                @if ($rental->expected_pickup_datetime)
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Expected Pickup Date/Time:</strong>
                            <p class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($rental->expected_pickup_datetime)->format('F j, Y \@ g:i A') }}
                            </p>
                        </div>
                    </div>
                @endif
                @if ($rental->expected_return_datetime)
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Expected Return Date/Time:</strong>
                            <p class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($rental->expected_return_datetime)->format('F j, Y \@ g:i A') }}
                            </p>
                        </div>
                    </div>
                @endif
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Actual Pickup Date/Time:</strong>
                        <p class="form-control-plaintext">
                            @if ($rental->actual_pickup_datetime == null)
                                <span class="text-danger">Not yet picked up</span>
                            @else
                                {{ \Carbon\Carbon::parse($rental->actual_pickup_datetime)->format('F j, Y \@ g:i A') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Actual Return Date/Time:</strong>
                        <p class="form-control-plaintext">
                            @if ($rental->actual_return_datetime == null)
                                <span class="text-danger">Not yet returned</span>
                            @else
                                {{ \Carbon\Carbon::parse($rental->actual_return_datetime)->format('F j, Y \@ g:i A') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Pickup Remarks:</strong>
                        <p class="form-control-plaintext">{{ $rental->pickup_remarks ?: 'NONE' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Return Remarks:</strong>
                        <p class="form-control-plaintext">{{ $rental->return_remarks ?: 'NONE' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Surrender ID:</strong>
                        <p class="form-control-plaintext">{{ $rental->surrendered_id ?: 'NONE' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <strong>Is From Ads:</strong>
                        <p class="form-control-plaintext">{{ $rental->is_from_ads ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection

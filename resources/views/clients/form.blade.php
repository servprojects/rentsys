@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "clients.update" ? route($transactionRoute, $client->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "clients.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                   CLIENT FORM
                </div>
                <div class="card-body ">
                    <div>
                        
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" value="{{ $client->person->first_name ?? '' }}" name="first_name" class="form-control" id="first_name">
                            @error('first_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" value="{{ $client->person->last_name ?? '' }}" name="last_name" class="form-control" id="last_name">
                            @error('last_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" value="{{ $client->person->contact_number ?? '' }}" name="contact_number" class="form-control" id="contact_number">
                            @error('contact_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" value="{{ $client->person->address ?? '' }}" name="address" class="form-control" id="address">
                            @error('address')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="valid_id_type" class="form-label">Valid ID Type</label>
                            <input type="text" value="{{ $client->person->valid_id_type ?? '' }}" name="valid_id_type" class="form-control" id="valid_id_type">
                            @error('valid_id_type')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="valid_id_no" class="form-label">Valid ID No</label>
                            <input type="text" value="{{ $client->person->valid_id_no ?? '' }}" name="valid_id_no" class="form-control" id="valid_id_no">
                            @error('valid_id_no')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" value="{{ $client->person->email ?? '' }}" name="email" class="form-control" id="email">
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="registration_date" class="form-label">Registration Date</label>
                            <input type="datetime-local" value="{{ $client->registration_date ?? '' }}" name="registration_date" class="form-control" id="registration_date">
                            @error('registration_date')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                           
                        </div>
                        <input type="hidden" value="{{ Auth::user()->company_id }}"  name="company_id">

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('clients.index') }}"><button type="button" class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection



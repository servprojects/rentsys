@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "companies.update" ? route($transactionRoute, $company->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "companies.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                   COMPANY FORM
                </div>
                <div class="card-body ">
                    <div>
                        
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" value="{{ $company->code ?? '' }}" name="code" class="form-control" id="code">
                            @error('code')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="{{ $company->name ?? '' }}" name="name" class="form-control" id="name">
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" value="{{ $company->address ?? '' }}" name="address" class="form-control" id="address">
                            @error('address')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" value="{{ $company->contact_number ?? '' }}" name="contact_number" class="form-control" id="contact_number">
                            @error('contact_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{ $company->email ?? '' }}" name="email" class="form-control" id="email">
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('assets.index') }}"><button type="button" class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

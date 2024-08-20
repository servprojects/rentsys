@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "lead-source.update" ? route($transactionRoute, $leadSource->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "lead-source.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                    LEAD SOURCE FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="{{ $leadSource->name ?? '' }}" name="name" class="form-control" id="model">
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Other Details</label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ $leadSource->details ?? '' }}</textarea>
                            @error('details')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('item-brand.index') }}"><button type="button" class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

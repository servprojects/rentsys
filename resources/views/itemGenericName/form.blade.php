@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "item-generic-name.update" ? route($transactionRoute, $itemGenericName->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "item-generic-name.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                    ITEM GENERIC NAME FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Name</label>
                            <input type="text" value="{{ $itemGenericName->name }}" name="name" class="form-control" id="model">
                            @error('model')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Other Details</label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ $itemGenericName->details }}</textarea>
                            @error('details')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('item-generic-name.index') }}"><button type="button" class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

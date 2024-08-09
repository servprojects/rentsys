@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "assets.update" ? route($transactionRoute, $itemBrand->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "assets.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                   ASSET FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Item</label>
                            <select name="item_id" class="form-control">
                                <option selected>Select</option>
                                @forelse ($items as $ic)
                                    <option value="{{ $ic->id }}" {{ $asset->item_id == $ic->id ? 'selected' : '' }}>{{ $ic->description }}</option>
                                @empty
                                    <option value="">No data</option>
                                @endforelse
                            </select>
                            @error('item_category_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">code</label>
                            <input type="text" value="{{ $asset->code ?? '' }}" name="code" class="form-control" id="code">
                            @error('code')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" value="{{ $asset->serial_number ?? '' }}" name="serial_number" class="form-control" id="serial_number">
                            @error('serial_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" value="{{ $asset->description ?? '' }}" name="description" class="form-control" id="description">
                            @error('description')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_of_purchase" class="form-label">Date of Purchase</label>
                            <input type="date" value="{{ $asset->date_of_purchase ?? '' }}" name="date_of_purchase" class="form-control" id="date_of_purchase">
                            @error('date_of_purchase')
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

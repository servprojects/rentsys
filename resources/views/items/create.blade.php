@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ $transactionRoute == "items.update" ? route($transactionRoute, $item->id) : route($transactionRoute) }}" method="POST">
                @csrf
                @if ($transactionRoute == "items.update")
                   @method('PUT')
                @endif
  
           
                <div class="card-header">
                    ITEM FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Generic Name</label>
                            <select name="item_generic_name_id" class="form-control">
                                <option selected>Select</option>
                                @forelse ($itemGenericNames as $ign)
                                    <option value="{{ $ign->id }}" {{ $item->item_generic_name_id == $ign->id ? 'selected' : '' }}>{{ $ign->name }}</option>
                                @empty
                                    <option value="">No data</option>
                                @endforelse
                            </select>
                            @error('item_generic_name_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select name="item_brand_id" class="form-control">
                                <option selected>Select</option>
                                @forelse ($itemBrands as $ib)
                                    <option value="{{ $ib->id }}" {{ $item->item_brand_id == $ib->id ? 'selected' : '' }}>{{ $ib->name }}</option>
                                @empty
                                    <option value="">No data</option>
                                @endforelse
                            </select>
                            @error('item_generic_name_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Category</label>
                            <select name="item_category_id" class="form-control">
                                <option selected>Select</option>
                                @forelse ($itemCategories as $ic)
                                    <option value="{{ $ic->id }}" {{ $item->item_category_id == $ic->id ? 'selected' : '' }}>{{ $ic->name }}</option>
                                @empty
                                    <option value="">No data</option>
                                @endforelse
                            </select>
                            @error('item_category_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" value="{{ $item->model }}" name="model" class="form-control" id="model">
                            @error('model')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" value="{{ $item->description }}" name="description" class="form-control" id="description">
                            @error('description')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Other Details</label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ $item->details }}</textarea>
                            @error('details')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('items.index') }}"><button type="button" class="btn btn-secondary mr-2">Cancel</button></a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

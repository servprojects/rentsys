@extends('layouts.layout')

@section('content')
    <div class="p-lg-5">
        <div class="card w-100 w-lg-50">
            <form action="{{ route('items.store') }}" method="POST">
                @csrf
                <div class="card-header">
                    ITEM FORM
                </div>
                <div class="card-body ">
                    <div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Generic Name</label>
                            <select name="item_generic_name_id" class="form-control">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            @error('item_generic_name_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select name="item_brand_id" class="form-control">
                                <option selected></option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            @error('item_generic_name_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Category</label>
                            <select name="item_category_id" class="form-control">
                                <option selected></option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            @error('item_category_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="description">
                            @error('description')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" name="model" class="form-control" id="model">
                            @error('model')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Other Details</label>
                            <textarea class="form-control" name="details" id="details" rows="3"></textarea>
                            @error('details')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <footer>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </footer>
                </div>
            </form>
        </div>
    </div>
@endsection

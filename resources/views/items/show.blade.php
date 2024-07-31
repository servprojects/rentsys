@extends('layouts.layout')
  
@section('content')

<div class="card mt-5">
  <h2 class="card-header">{{$item->itemBrand->name}}  {{ $item->model }}</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('items.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Classification:</strong> <br/>
                {{ $item->itemGenericName->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong> <br/>
                {{ $item->itemCategory->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Model:</strong> <br/>
                {{ $item->model }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Description:</strong> <br/>
                {{ $item->description }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Other Details:</strong> <br/>
                {{ $item->details }}
            </div>
        </div>
    </div>
  
  </div>
</div>
@endsection
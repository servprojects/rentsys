@extends('layouts.layout')
  
@section('content')

<div class="card mt-5">
  <h2 class="card-header">Show Asset</h2>
  <div class="card-body">
  
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('item-brand.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Code:</strong> <br/>
                {{ $asset->code }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Serial Number:</strong> <br/>
                {{ $asset->serial_number }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Date of Purchase:</strong> <br/>
                {{ $asset->date_of_purchase }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
            <div class="form-group">
                <strong>Item Description:</strong> <br/>
                {{ $asset->item->description }}
            </div>
        </div>
    </div>
  
  </div>
</div>
@endsection
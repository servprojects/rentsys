@extends('layouts.layout')

@section('content')

    <div class="card mt-5">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h2 class="mb-0">Items</h2>
            <div class="form-inline mt-2 mt-md-0">
                <div class="input-group">
                    <input type="text" class="form-control bg-white border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2" id="search-input">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="search-button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>



        <div class="card-body">

            @session('success')
                <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success btn-sm" href="{{ route('items.create') }}"> <i class="fa fa-plus"></i> Create New
                    Item</a>
            </div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th width="80px">Code</th>
                        <th>Item Name</th>
                        <th>Descroption</th>
                        <th width="250px">Action</th>
                    </tr>
                </thead>

                {{-- <tbody id="items-tbody">
                    @forelse ($items as $ign)
                        <tr>
                            <td>{{ $ign->id }}</td>
                            <td>{{ $ign->itemCategory->name }}</td>
                            <td>{{ $ign->itemGenericName->name }} {{ $ign->itemBrand->name }} {{ $ign->model }}</td>
                            <td></td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">There are no data.</td>
                        </tr>
                    @endforelse
                </tbody> --}}
                <tbody id="items-tbody">
                    <tr>
                        <td colspan="4">Loading...</td>
                    </tr>
                </tbody>

            </table>
            <nav aria-label="...">
                {{-- <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul> --}}
                <ul class="pagination"></ul>
            </nav>

            {!! $items->links() !!}

        </div>
    </div>
@endsection

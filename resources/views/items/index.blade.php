@extends('layouts.layout')

@section('content')

    <div class="card mt-5">
        <h2 class="card-header">Items</h2>
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

                <tbody>
                    @forelse ($items as $ign)
                        <tr>
                            <td>{{ $ign->id }}</td>
                            <td>{{ $ign->itemCategory->name }}</td>
                            <td>{{ $ign->itemGenericName->name }} {{ $ign->itemBrand->name }} {{ $ign->model }}</td>

                            {{-- <td>{{ ++$i }}</td>
                    <td>{{ $ign->name }}</td>
                    <td>{{ $ign->details }}</td> --}}
                            <td>
                                {{-- <form action="{{ route('item-generic-name.destroy',$ign->id) }}" method="POST">
             
                            <a class="btn btn-info btn-sm" href="{{ route('item-generic-name.show',$ign->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                            <a class="btn btn-primary btn-sm" href="{{ route('item-generic-name.edit',$ign->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
             
                            @csrf
                            @method('DELETE')
                
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">There are no data.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            {!! $items->links() !!}

        </div>
    </div>
@endsection

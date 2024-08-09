<div class="card mt-5">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h2 class="mb-0">{{ $dataTitle }}</h2>
        <div class="form-inline mt-2 mt-md-0">

            @isset($otherActions)
              <div class="mr-2" >  {{ $otherActions }}</div>
            @endisset
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


        <div class="d-grid gap-5 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ $createRoute }}"> <i class="fa fa-plus"></i> Create New</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    @foreach ($headerItems as $item)
                        <th width="{{ $item['width'] }}">{{ $item['title'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody id="items-tbody">
                <tr>
                    <td colspan="{{ $loadingSpan ?? '4' }}">Loading...</td>
                </tr>
            </tbody>

        </table>
        <nav aria-label="...">
            <ul class="pagination"></ul>
        </nav>



    </div>
</div>

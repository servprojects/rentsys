<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-11">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <h6 id="available-date" class="m-0 font-weight-bold text-primary">Available Today</h6>
                    </div>
                    <div class="col-auto">
                        <input id="date-picker" class="form-control form-control-sm" type="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" >
                    </div>
                </div>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="list-area">

                    {{-- <a href="#" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">No Available</span>
                    </a> --}}
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

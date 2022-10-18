<div class="col-12 d-flex justify-content-end">
    {{-- <div class="d-flex justify-content-center mb-2 align-items-center">
        <h6 class="mr-1">Project</h6>
        <select class="mb-2 form-control select2" id="select_project_admin">
            <option selected value="">All Projects</option>
            @foreach ($projects as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="d-flex justify-content-center mb-2 align-items-center">
        <h6 >Date Range</h6>
        <input type="text" id="daterange" placeholder="Select Date-Range" name="daterange" class="form-control" />
    </div>

</div>
<div class="row">
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center current-items-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="cpu" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/current-items.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder current-items-heading total_project_count">   </h2>
                <p class="card-text">Current Active Projects</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center cbb-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/ad-pay.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder cbb-heading current_active_customers"></h2>
                <p class="card-text">Current Active Customers</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center current-phase-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="pie-chart" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/current-phase.svg" class="img-fluid">
                    </div>
                </div>
                
                <h2 class="font-weight-bolder current-phase-heading current_active_suppliers"></h2>
                <p class="card-text">Current Active Suppliers</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center current-pay-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/current-payables.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder current-pay-heading current_active_investors"></h2>
                <p class="card-text">Current Active Investors</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center consumed-items-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/consumed-items.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder consumed-items-heading current_active_employee"></h2>
                <p class="card-text">Total Employee's Count</p>
            </div>
        </div>
    </div>
    

    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center current-items-in-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/current-items-in.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder current-items-in-heading total_asset_count"></h2>
                <p class="card-text">Total Asset Count</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center advance-pay-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/cbb.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder advance-pay-heading advance_hr_payment"></h2>
                <p class="card-text">Advanced HR Payment</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card text-center tpc-card main-box-shadow">
            <div class="card-body">
                <div>
                    <div class="avatar-content mb-1">
                        <!-- <i data-feather="dollar-sign" class="font-medium-5"></i> -->
                        <img src="https://dcerp.ropstambpo.com/public/app-assets/images/dashicons/purchase-cost.svg" class="img-fluid">
                    </div>
                </div>
                <h2 class="font-weight-bolder tpc-heading directors_withdraw"></h2>
                <p class="card-text">Director's Withdraw Amount</p>
            </div>
        </div>
    </div>

    {{-- chart js --}}


    <div class="col-12">
        <div class="card text-center main-box-shadow">
            <div class="card-body">
                <h6 class="mb-1">Invoices against Customer's PO'S</h6>
                <canvas id="barChart" width="100" height="25"></canvas>
            </div>
        </div>
    </div>

   
    <div class="col-4">
        <div class="card text-center main-box-shadow">
            <div class="card-body">
                <h6 class="mb-1">Employees Assigned on Projects</h6>
                <canvas id="pieChart" width="100" height="200"></canvas>
            </div>
        </div>
    </div>







</div>
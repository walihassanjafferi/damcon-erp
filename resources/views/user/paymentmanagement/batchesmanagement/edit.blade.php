@extends('layout.main')
@section('batches_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Batches Management Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('batches_management.index')}} @endsection
@section('main_btn_text') All Batches Management @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Batches</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('batches_management.update',encrypt($batche->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Name of Batch<span class="red_asterik"></span></label>
                                        <input type="text"  name="name_of_batch" class="form-control" placeholder="Name of Batch" value="{{ $batche->name_of_batch }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-0">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="bank_id">
                                            @foreach ($bankaccounts as $item)
                                                <option @if($batche->bank_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('sender_bank_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date of Creation<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="date_of_creation" class="form-control date_of_creation" placeholder="Date of Creation" value="{{ $batche->date_of_creation }}" readonly required/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="amount" class="form-control amount" placeholder="Amount" value="{{ $batche->amount }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-12 mb-2">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description_input" rows="5" required>{{ $batche->description_input }}</textarea>
                                </div>

                                 {{-- Salaries management --}}
                                 @if(count($salaries))
                                 <div class="col-12 pl-1 pr-1 mb-2" id="asset_purchase_order">
                                     <p><b>Salaries Management</b></p>
                                     <table class="table table-striped table-bordered asset_purchase_order"
                                         style="width:100%">
                                         <thead>
                                             <tr>
                                                 <th>#</th>
                                                 <th>Payment ID</th>
                                                 <th>Salary Month</th>
                                                 <th>No of Days</th>
                                                 <th>Amount (PKR)</th>
                                                 <th>Date</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($salaries as $val)
                                                 <tr>
                                                     <td>
                                                         <div class="position-relative form-group">
                                                             <input type="checkbox" class="salary_checkbox" data-amount="{{$val->amount}}"  disabled/>
                                                             <input type="text" class="salariesids" name="salariesids[]"  value="{{$val->id}}" disabled hidden/>

                                                         </div> 
                                                     </td>
                                                     <td>{{ $val->payment_id }}</td>
                                                     <td>{{ $val->salary_month }}</td>
                                                     <td>{{ $val->no_of_days }}</td>
                                                     <td>{{ $val->amount }}</td>
                                                     <td>{{ date('d-M-Y', strtotime($val->date)) }}</td>


                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @endif
                             {{-- Salaries management --}}


                             {{-- Advance HR --}}
                                 @if(count($advanceHr))
                                 <div class="col-12 pl-1 pr-1 mb-2" id="asset_purchase_order">
                                     <p><b>Advance HR Payments</b></p>
                                     <table class="table table-striped table-bordered asset_purchase_order"
                                         style="width:100%">
                                         <thead>
                                             <tr>
                                                 <th>#</th>
                                                 <th>Advance HR title</th>
                                                 <th>Emp Name</th>
                                                 <th>Advance Type</th>
                                                 <th>Amount (PKR)</th>
                                                 <th>Date</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($advanceHr as $val)
                                                 <tr>
                                                     <td>
                                                         <div class="position-relative form-group">
                                                             <input type="checkbox" class="advance_checkbox"  data-amount="{{$val->amount}}" disabled />
                                                             <input type="text" class="advancehrids" name="advancehrids[]" value="{{$val->id}}" disabled hidden/>

                                                         </div> 
                                                     </td>
                                                     <td>{{ $val->advance_hr_title }}</td>
                                                     <td>{{ $val->emp_name }}</td>
                                                     <td>{{ $val->advance_type }}</td>
                                                     <td>{{ $val->amount }}</td>
                                                     <td>{{ date('d-M-Y', strtotime($val->date)) }}</td>


                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @endif
                             {{-- Advance HR --}}


                             {{-- supplier payments --}}
                                 @if(count($supplier_payment))
                                 <div class="col-12 pl-1 pr-1 mb-2" id="asset_purchase_order">
                                     <p><b>Supplier Payments</b></p>
                                     <table class="table table-striped table-bordered asset_purchase_order"
                                         style="width:100%">
                                         <thead>
                                             <tr>
                                                 <th>#</th>
                                                 <th>Title</th>
                                                 <th>Supplier</th>
                                                 <th>Supplier Type</th>
                                                 <th>Amount (PKR)</th>
                                                 <th>Date</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($supplier_payment as $val)
                                                 <tr>
                                                     <td>
                                                         <div class="position-relative form-group">
                                                             <input type="checkbox" class="supplier_checkbox" data-amount="{{$val->amount}}" disabled />
                                                             <input type="text" class="supplierpaymentids" name="supplierpaymentids[]"  value="{{$val->id}}" disabled hidden/>
                                                         </div> 
                                                     </td>
                                                     <td>{{ $val->title }}</td>
                                                     <td>{{ $val->supplierName->name }}</td>
                                                     <td>{{ $val->supplier_type }}</td>
                                                     <td>{{ $val->amount }}</td>
                                                     <td>{{ date('d-M-Y', strtotime($val->date)) }}</td>


                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                                 @endif
                             {{-- supplier payments --}}


                            {{-- security payments --}}
                              @if(count($security_payment))
                              <div class="col-12 pl-1 pr-1 mb-2" id="asset_purchase_order">
                                  <p><b>Security Payments</b></p>
                                  <table class="table table-striped table-bordered asset_purchase_order"
                                      style="width:100%">
                                      <thead>
                                          <tr>
                                              <th>#</th>
                                              <th>Title</th>
                                              <th>Project</th>
                                              <th>Customer</th>
                                              <th>Amount (PKR)</th>
                                              <th>Date</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($security_payment as $val)
                                              <tr>
                                                  <td>
                                                      <div class="position-relative form-group">
                                                          <input type="checkbox" class="securitypayment_checkbox" data-amount="{{$val->amount}}" disabled />
                                                          <input type="text" class="securitypaymentids" name="securitypaymentids[]"  value="{{$val->id}}" disabled hidden/>
                                                      </div> 
                                                  </td>
                                                  <td>{{ $val->paymenttype->name }}</td>
                                                  <td>{{ $val->project->name }}</td>
                                                  <td>{{ $val->customer_rel->name }}</td>
                                                  <td>{{ $val->amount }}</td>
                                                  <td>{{ date('d-M-Y', strtotime($val->date)) }}</td>


                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              @endif
                            {{-- security payments --}}



                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1" >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\BatchesManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        var items = "";
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date_of_creation').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            // CKEDITOR.replace('description_input');
        });
    </script>

@endsection

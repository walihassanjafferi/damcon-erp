@extends('layout.main')
@section('supplier_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Supplier</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('suppliers.index') }} @endsection
@section('main_btn_text') All Suppliers @endsection
{{-- back btn --}}

@section('css')
<style>
    .customer_cards label{
        cursor: pointer;
    }
</style>
@endsection
@section('content')

    <div class="col-12">
        <div class="text-right mb-1">
            <h3>Supplier balance : </label><span>PKR {{number_format($supplier->balance)}}</span></h3>
        </div>
        
        <div class="row">
            {{-- <div class="col-8"> --}}
            <div class="col-8">
                <div class="card mb-1" style="min-height: 290px;">
                    <div class="card-body">
                        <div class="customer_status">
                            <h4>Suppliers Details</h4>
                            <span class="customer_status_span"><label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" {{ $supplier->status ? 'checked' : '' }}
                                        onclick="statusChange({{ $supplier->id }});">
                                    <span class="slider round"></span>
                                </label></span>
                        </div>
                        <br />
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ $supplier->name }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Address</label>
                            <span>{{ $supplier->address }} {{ $supplier->street }} {{ $supplier->city }}
                                {{ $supplier->state }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Supplier Type</label>
                            <span>{{ $supplier->supplier_type->name }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Date of creation</label>
                            <span>{{ date('d-M-y',strtotime($supplier->date_of_creation)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-4">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details_no">
                            <h5>NTN #</h5>
                            <h4>{{ $supplier->ntn_number }}</h4>
                            <h5>STRN #</h5>
                            <h4>{{ $supplier->strn_number }}</h4>
                            <h5>Bank</h5>
                            <h4>{{ ucfirst($supplier->bank_name) }}</h4>
                            <h5>Acc no</h5>
                            <h4>{{ $supplier->bank_account_number }}</h4>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <h5 style="text-align: center; padding:10px 0px;">Customer details 1</h5>
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ $supplier->cp1_name }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Cell no</label>
                            <span>{{ $supplier->cp1_cell_no }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Phone no</label>
                            <span>{{ $supplier->cp1_phone_no }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Email</label>
                            <span>{{ $supplier->cp1_email }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Fax</label>
                            <span>{{ $supplier->cp1_fax }} </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <h5 style="text-align: center; padding:10px 0px;">Customer details 2</h5>
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ "Not Found!" }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Cell no</label>
                            <span>{{ "Not Found!" }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Phone no</label>
                            <span>{{ "Not Found!" }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Email</label>
                            <span>{{"Not Found!"}} </span>
                        </div>
                        <div class="customer_details">
                            <label>Fax</label>
                            <span>{{ "Not Found!" }} </span>
                        </div>
                    </div>
                </div>
            </div>



            {{-- <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body customer_cards">
                        <div class="card-text">
                            <h4>Suppliers</h4><br />
                            <div class="customer_projects">
                                <label class="label_heading">Supply name</label>
                                <label class="label_value">Abc1 </label>
                                <br />
                                <label class="label_heading">Supply Code</label>
                                <label class="label_value">1234</label>
                                <hr />
                                <label class="label_heading">Supply name</label>
                                <label class="label_value">Abc1 </label>
                                <br />
                                <label class="label_heading">Supply Code</label>
                                <label class="label_value">1234</label>
                                <hr />
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
           
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-body customer_cards">
                        <div class="card-text">
                            <h4>Purchase Orders</h4><br />
                            @if(count($supplier_pos))
                                @foreach ($supplier_pos as $item)
                                    <div>
                                        <a href="{{ route('supplierspos.show', encrypt($item->id)) }}"
                                            class="customer_projects label_heading w-100 supplier_page_links" target="_blank">
                                            <span class="w-100 d-flex">
                                                <label class="w-50 supplier_text">PO number : </label>
                                                <label class="w-50 supplier_text_label">{{ $item->purchase_od_number ?? '' }}</label>
                                            </span>

                                            <span class="w-100 d-flex">
                                                <label class="w-50 supplier_text">Issue Date : </label>
                                                <label
                                                    class="w-50 supplier_text_label">{{ date('d-M-Y', strtotime($item->issue_date)) }}</label>
                                            </span>
                                        </a>
                                    </div>
                                    <hr />

                                @endforeach
                            @else
                                <p class="text-center">Purchase Orders not found!</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-body customer_cards">
                        <div class="card-text">
                            <h4>Payments</h4><br />

                            @if(count($supplier_payment))
                                @foreach ($supplier_payment as $item)
                                    <div>
                                        <a href="{{ route('supplier_payment_management.show', encrypt($item->id)) }}"
                                            class="customer_projects label_heading w-100 supplier_page_links" target="_blank">
                                            <span class="w-100 d-flex">
                                                <label class="w-50 supplier_text">PO number : </label>
                                                <label class="w-50 supplier_text_label">{{ $item->supplierpo->purchase_od_number ?? '' }}</label>
                                            </span>

                                            <span class="w-100 d-flex">
                                                <label class="w-50 supplier_text">Issue Date : </label>
                                                <label
                                                    class="w-50 supplier_text_label">{{ date('d-M-Y', strtotime($item->created_at)) }}</label>
                                            </span>
                                        </a>
                                    </div>
                                    <hr />
                                @endforeach
                            @else
                            <p class="text-center">Payments not found!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            {{-- supplier payment ledgers --}}
            <div class="col-12">
                <div class="card p-2">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 14px;font-size: 15px; font-weight: 600;">Supplier Payments Ledgers</label>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped supplier_payment_ledger">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th style="display: none;">Date</th>
                                    <th>Date</th>
                                    <th>Purchase Amount (PKR)</th>
                                    <th>Payment Amount (PKR)</th>
                                    <th>Balance (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplier_payables_ledger as $index=>$item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td style="display: none;">{{  $item->transaction_date }}</td>
                                        <td>{{ date('d-M-Y',strtotime($item->transaction_date)) }}</td>
                                        <td>{{ number_format($item->purchase_amount) }}</td>
                                        <td>{{ number_format($item->payment_amount)}}</td>
                                        <td>{{ number_format($item->balance) }}</td>
    
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- Supplier tax Payments ledger --}}

            <div class="col-12">
                <div class="card p-2">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 14px;font-size: 15px; font-weight: 600;">Supplier Tax Ledgers</label>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped supplier_tax_ledger">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Transaction type</th>
                                    <th>Module name</th>
                                    <th>Payment title</th>
                                    <th>Amount (PKR)</th>
                                    <th style="display:none">Transaction Date</th>
                                    <th>Transaction Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplier_tax_ledgers as $index=>$item)
                                    <tr>
                                        {{-- <td>{{$index+1}}</td> --}}
                                        <td>{{ ucfirst($item->transaction_type) }}</td>
                                        <td>{{ ucfirst($item->module_name) }}</td>
                                        <td>{{ $item->payment_title }}</td>
                                        <td>{{ number_format($item->amount)}}</td>
                                        <td>{{ date('d-M-y',strtotime($item->created_at)) }}</td>
                                        <td style="display: none;">{{ date('Y-m-d',strtotime($item->created_at)) }}</td>
  
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            
                  

            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteCustomer({{ $supplier->id }})"
                    style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{ route('suppliers.edit', encrypt($supplier->id)) }}"
                    style="float:right;">Edit</a>
            </div>

        </div>

        {{-- toast --}}

        <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="5000" style="top: 1rem; right: 1rem">
            <div class="toast-header">
                <img src="../../../app-assets/images/logo/logo.png" class="mr-1" alt="Toast image" height="18"
                    width="25" />
                <strong class="mr-auto">Damcon ERP</strong>
                <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
        <button class="btn btn-outline-primary toast-basic-toggler mt-2" id="status_toast" hidden>Toast</button>


    @endsection

    @section('scripts')
        <script>
           $(function(){
           
                $('.supplier_tax_ledger').DataTable({
                    "order": [],
                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Supplier Tax ledger',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ,5 ]
                        },
                        filename:"Supplier tax ledger",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Supplier Tax ledger',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ,5 ]
                        },
                        filename:"Supplier tax ledger",       
                    }
                ]
                });


                $('.supplier_payment_ledger').DataTable({
                    "order": [],
                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Supplier Payment ledger',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 3, 4 ,5 ]
                        },
                        filename:"Supplier Payment ledger",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Suppliers Payment ledger',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 3, 4 ,5 ]
                        },
                        filename:"Suppliers Payment ledger",       
                    }
                ]
                });


           });

            function deleteCustomer(id) {
                var id = id;
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this Supplier",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {

                        if (willDelete) {
                            $.ajax({
                                url: '{{ route('suppliers.destroy', 'id') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": id

                                },
                                method: 'DELETE',
                                success: function(data) {

                                    swal(data.message, {
                                        icon: "success",
                                    });

                                    let url = "{{ route('suppliers.index') }}";

                                    document.location.href = url;


                                },
                                error: function(data) {
                                    alert('Error Failed');

                                }
                            });
                        }
                    });

            }


            function statusChange($id) {

                $.ajax({
                    url: '{{ route('supplier_status_change') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": $id
                    },
                    method: 'post',
                    success: function(data) {

                        $('.toast-body').html(data.message);
                        $('#status_toast').click();

                    },
                    error: function(data) {
                        $('.toast-body').html(data.message);
                        $('#status_toast').click();

                    }
                });

            }
        </script>
    @endsection

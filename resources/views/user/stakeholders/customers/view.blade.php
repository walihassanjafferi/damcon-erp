@extends('layout.main')
@section('customer_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  View Customer</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customers.index')}} @endsection
@section('main_btn_text') All Customers @endsection
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
        
        <div class="row">
           
                <div class="col-8">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="customer_status">
                            <h4>Customer Details</h4>   
                                <span class="customer_status_span"><label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" {{$customer->status ? 'checked' : ''}} onclick="statusChange({{$customer->id}});">
                                    <span class="slider round"></span>
                                </label></span>
                            </div>
                            <br/>
                            <div class="customer_details">
                                <label>Name</label>
                                <span>{{$customer->name}}</span>
                            </div>  
                            <div class="customer_details">
                                <label>Address</label>
                                <span>{{ $customer->address}}</span>
                            </div>  
                            {{-- <div class="customer_details">
                                <label>Zip Code</label>
                                <span>{{ $customer->zip_code}} </span>
                            </div>   --}}
                        </div>
                    </div>
                </div>
          
            <div class="col-4">
                <div class="card mb-1" style="min-height: 176px;">
                    <div class="card-body">
                        <div class="customer_details_no">
                            <h5>NTN #</h5>
                            <h4>{{ $customer->ntn_number}}</h4>
                            <h5>STRN #</h5>
                            <h4>{{ $customer->strn_number}}</h4>
                            
                        </div>  
                    </div>
                </div>
            </div>



            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body"> 
                        <h5 style="text-align: center;padding:10px 0px;">Customer details 1</h5>
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ $customer->cp1_name}} </span>
                        </div>  
                        <div class="customer_details">
                            <label>Cell no</label>
                            <span>{{ $customer->cp1_cell_no}} </span>
                        </div>  
                        <div class="customer_details">
                            <label>Phone no</label>
                            <span>{{ $customer->cp1_phone_no}} </span>
                        </div> 
                        <div class="customer_details">
                            <label>Email</label>
                            <span>{{ $customer->cp1_email}} </span>
                        </div>
                        <div class="customer_details">
                            <label>Designation</label>
                            <span>{{ $customer->cp1_fax}} </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body"> 
                        <h5 style="text-align: center;padding:10px 0px;">Customer details 2</h5>
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ $customer->cp2_name}} </span>
                        </div>  
                        <div class="customer_details">
                            <label>Cell no</label>
                            <span>{{ $customer->cp2_cell_no}} </span>
                        </div>  
                        <div class="customer_details">
                            <label>Phone no</label>
                            <span>{{ $customer->cp2_phone_no}} </span>
                        </div> 
                        <div class="customer_details">
                            <label>Email</label>
                            <span>{{ $customer->cp2_email}} </span>
                        </div>
                        <div class="customer_details">
                            <label>Designation</label>
                            <span>{{ $customer->cp2_fax}} </span>
                        </div>
                    </div>
                </div>
            </div>



           
        
                  <div class="col-4">
                    <div class="card mb-4">
                        <div class="card-body customer_cards">
                            <div class="card-text">
                                <h4>Projects</h4><br/>
                                <div class="customer_projects">
                                    @if(count($customer->Projects))
                                        @foreach ($customer->Projects as $item)
                                        
                                                <a href={{route('projectmanagement.show',encrypt($item->id))}} target="_blank">
                                                    <div style="cursor: pointer;">
                                                        <label class="label_heading">Project name</label>
                                                        <label class="label_value">{{$item->name}}</label>
                                                        <br/>
                                                        <label class="label_heading">Project Code</label>
                                                        <label class="label_value">{{$item->project_code}}</label>
                                                        <hr/>
                                                    </div>
                                                </a>
                                            
                                        @endforeach
                                    @else
                                        <p class="text-center">Customer Project not found!</p>
                                    @endif    
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card mb-4">
                        <div class="card-body customer_cards">
                            <div class="card-text">
                                <h4>Purchase Orders</h4><br/>
                                <div class="customer_projects">
                                    @if(count($purchase_order))
                                        @foreach ($purchase_order as $item)
                                        
                                            <a href={{route('customerpos.show',encrypt($item->id))}} target="_blank">
                                                <div style="cursor: pointer;">
                                                    <label class="label_heading">Customer PO Number</label>
                                                    <label class="label_value">{{$item->customer_po_number}}</label>
                                                    <br/>
                                                    <label class="label_heading">Customer PO Balance</label>
                                                    <label class="label_value">{{number_format($item->customer_po_balance)}}</label>
                                                    <hr/>
                                                </div>
                                            </a>
                                        
                                        @endforeach
                                    @else
                                        <p class="text-center">Purchase Orders not found!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="card mb-4">
                        <div class="card-body customer_cards">
                            <div class="card-text">
                                <h4>Invoices</h4><br/>
                                <div class="customer_projects">
                                    
                                    @if(count($customer->invoices))
                                    @foreach ($customer->invoices as $item)
                                        <a href={{route('customerinvoice.show',encrypt($item->id))}} target="_blank">
                                            <div style="cursor: pointer;">
                                                <label class="label_heading">Customer PO Number</label>
                                                <label class="label_value">{{$item->invoice_number }}</label>
                                                <br/>
                                                <label class="label_heading">Customer PO Balance</label>
                                                <label class="label_value">{{number_format($item->po_balance)}}</label>
                                                <hr/>
                                            </div>
                                        </a>
                                    @endforeach
                                    @else
                                        <p class="text-center">Customer Invoices not Found!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                <div class="col-12">
                    <a class="btn btn-danger mb-1" onclick="deleteCustomer({{$customer->id}})"
                         style="float:right;margin-left:10px;">Delete</i>
                    </a>
                    <a class="btn btn-primary mb-1" href="{{route('customers.edit',encrypt($customer->id))}}" style="float:right;">Edit</a>
                </div>
            
    </div>

    {{-- toast --}}
    
    <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
        <div class="toast-header">
            <img src="../../../app-assets/images/logo/logo.png" class="mr-1" alt="Toast image" height="18" width="25" />
            <strong class="mr-auto">Damcon ERP</strong>
            <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body"></div>
    </div>
    <button class="btn btn-outline-primary toast-basic-toggler mt-2"  id="status_toast" hidden>Toast</button>


@endsection

@section('scripts')
    <script>
         function deleteCustomer(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Customer",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('customers.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });

                                let url = "{{ route('customers.index') }}";
                              
                                document.location.href=url;
                            
                                                    
                        },
                        error: function(data)
                        {
                             alert('Error Failed');
                                
                        }
                    }); 
                }   
            });   
           
        }


        function statusChange($id){
            
            $.ajax({
            url:'{{ route('customer_status_change')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":$id
            },
            method: 'post',
            success: function(data) {

                $('.toast-body').html(data.message);
                $('#status_toast').click();
           
            },
            error: function(data)
            {    
                $('.toast-body').html(data.message);
                $('#status_toast').click();
                
            }
            });

        }
    </script>
@endsection
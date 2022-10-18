@extends('layout.main')
@section('investor_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  View Investor</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('investors.index')}} @endsection
@section('main_btn_text') All Investor @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-8">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="customer_status">
                            <h4>Investor Details</h4>   
                                <span class="customer_status_span"><label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" {{$investor->status ? 'checked' : ''}} onclick="statusChange({{$investor->id}});">
                                    <span class="slider round"></span>
                                </label></span>
                            </div>
                            <br/>
                            <div class="customer_details">
                                <label>Name</label>
                                <span>{{$investor->name}}</span>
                            </div>  
                            <div class="customer_details">
                                <label>Type of Investor</label>
                                <span>{{ $investor->type_of_invester }}</span>
                            </div>  
                            <div class="customer_details">
                                <label>Description</label>
                                <span class="comment more">{{ $investor->description}} </span>
                            </div>  
                            <div class="customer_details">
                                <label>Contact no</label>
                                <span>{{ $investor->contact_no}} </span>
                            </div>  

                            <div class="customer_details">
                                <label>Date of Creation</label>
                                <span>{{ isset($investor->date_of_creation) ? date('d-M-y',strtotime($investor->date_of_creation)) : '' }} </span>
                            </div>  
                            
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-4">
                <div class="card mb-1" style="min-height:226px;">
                    <div class="card-body">
                        <div class="customer_details_no">
                            <h5>Amount</h5>
                            <h4>PKR {{ isset($investor_amount->investor_balance) ? number_format($investor_amount->investor_balance,2) : 0 }}</h4>
                            {{-- <h5>STRN #</h5>
                            <h4>{{ $customer->strn_number}}</h4>
                             --}}
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Investor Ledger</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped investor_ledger">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Invester Type</th>
                                    <th>Amount (PKR)</th>
                                    <th>Balance (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investor->ledgers as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ ucfirst($item->title) }}</td>
                                        <td>{{ strtoupper($item->investment_type) }}</td>
                                        <td>{{ $item->amount_ingoing_outgoing }}</td>
                                        <td>{{ number_format($item->investor_balance,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                  
              
              

                <div class="col-12">
                    <a class="btn btn-danger mb-1" onclick="deleteCustomer({{$investor->id}})"
                         style="float:right;margin-left:10px;">Delete</i>
                    </a>
                    <a class="btn btn-primary mb-1" href="{{route('investors.edit',encrypt($investor->id))}}" style="float:right;">Edit</a>
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
                text: "Once deleted, you will not be able to recover this Investor",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('investors.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });

                                let url = "{{ route('investors.index') }}";
                              
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
            url:'{{ route('investors_status_change')}}',
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


        $(document).ready(function() {
            var showChar = 100;
            var ellipsestext = "...";
            var moretext = "more";
            var lesstext = "less";
            $('.more').each(function() {
                var content = $(this).html();

                if(content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar-1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });

            // investor ledger table
            var table = $('.investor_ledger').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Investor Ledger',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Investors ledgers Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Investor Ledger',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Investors ledgers Data",
                    }
                ]
            });


        });



    </script>
@endsection
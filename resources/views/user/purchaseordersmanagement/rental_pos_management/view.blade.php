@extends('layout.main')
@section('rentalpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Rental POs Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('rentalpos.index')}} @endsection
@section('main_btn_text') All Rental PO Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>PO No. {{ $rental_order->purchase_od_number }}</b></h1>
                    <h1 class="ml-2" style="font-size: 24px;margin-top: 3px;">({{ $rental_order->supplier->name }}) - {{ $rental_order->project->name }}</h1>
                </div>
                <div style="float: right;margin-top: 7px;">
                    <h4>{{ date_format($rental_order->created_at,'d-M-Y')  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-8 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>Agreement Number:</label>
                                    <span>{{ $rental_order->agreement_number }}</span>
                                    <br>
                                    <label>Issue  Date:</label>
                                    <span>{{ $rental_order->issue_date }}</span>
                                    <br>
                                    <label>Purchase Order Number:</label>
                                    <span>{{ $rental_order->purchase_od_number }}</span>
                                    <br>
                                    <label>PO Month:</label>
                                    <span>{{ $rental_order->purchase_order_month }}</span>
                                    <br>
                                    <label>Customer PO Number (optional):</label>
                                    <span>{{ $rental_order->customer_optional_number }}</span>
                                    <br>
                                    <label>Region:</label>
                                    <span>{{ $rental_order->region }}</span>
                                    <br>
                                    <label>Tax Body:</label>
                                    <span>{{ $rental_order->tax_body_id }}</span>
                                    <br>
                                    <label>Tax Body%:</label>
                                    <span>{{ $rental_order->tax_body_percentage }}%</span>
                                    <br>
                                    <label>Taxation Month:</label>
                                    <span>{{ $rental_order->taxation_month }}</span>
                                    <br>
                                    <label>Sales Tax WH%:</label>
                                    <span>{{ $rental_order->sales_tax_wh.'%' }}</span>
                                    <br>
                                    <label>Description:</label>
                                    <span class="comment more">{{ $rental_order->comments}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body">
                                <div class="bank_details">
                                    <label>Subtotal</label>
                                    <span style="float: right;">PKR {{number_format($sub_total_amount)}}</span>
                                </div>

                                <div class="bank_details">
                                    <label>Tax Amount</label>
                                    <span style="float: right;">PKR {{number_format($tax_amount)}}</span>
                                </div>

                                <div class="bank_details">
                                    <label>Total Amount</label>
                                    <span style="float: right;">PKR {{number_format($total_amount)}}</span>
                                </div>

                                <div class="bank_details">
                                    <label>Sales Tax WH</label>
                                    <span style="float: right;">PKR {{number_format($sales_tax_wh_at_src)}}</span>
                                </div>
                                <div class="bank_details">
                                    <label>Supplier WH Tax 1</label>
                                    <span style="float: right;">PKR {{number_format($supplier_wh_tax_1)}}</span>
                                </div>

                                <div class="bank_details">
                                    <label>Supplier WH Tax 2</label>
                                    <span style="float: right;">PKR {{ number_format($supplier_wh_tax_2) }}</span>
                                </div>

                                <div class="bank_details">
                                    <label>Total After Deductions</label>
                                    <span style="float: right;">PKR {{ number_format($total_after_deduction)}}</span>
                                </div>

                

                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;margin-bottom: -10px;">Items Details</label>

                        @php $increment = 1; @endphp
                        <div class="table-responsive p-2">
                            <table class="table table-striped table-bordered custom-data-table" id="items_table_list" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Item Cost</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rental_order_items as $item)
                                    <tr>
                                        <td>{{ $increment }}</td>
                                        <td>{{ $item->items->rental_name ?? '' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rs. {{  $item->cost }} </td>
                                        <td>Rs. {{  $item->cost*$item->qty }} <i>(PKR)</i></td>
                                    </tr>
                                    @php $increment++ @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $files = json_decode($rental_order->document_file);
                   
            @endphp
            @if(isset($files) && count($files) > 0)
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">File Attachments</label>
                        <div class="col-md-12 pl-3 pr-3">
                            <div class="rental bank_details">
                                @php
                                    $files = json_decode($rental_order->document_file);
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12">
                                        Images
                                    </div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  download="download" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/rental_pos/'.$path) }} ><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/rental_pos/'.$path) }}"/>

                                    </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if(isset($pdf))
                                    <div class="col-12 mt-3" >Pdf's</div>
                                    @foreach ($pdf as $item)
                                        <span class="col-12 pip" style="padding: 16px;">
                                        <a  download="download" href={{ asset('/storage/rental_pos/PDF/'.$path) }}><i class="fa fa-download"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/rental_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{ $rental_order->id }})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('rentalpos.edit',encrypt($rental_order->id))}}" style="float:right;">Edit</a>
            </div>
        </div>
    </div>

    <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
        <div class="toast-header">
            <img src="{{ asset('app-assets/images/ico/favicon.png') }}" class="mr-1" alt="Toast image" height="22" width="24" />
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
        function deleteOrder(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Item",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url:'{{route('rentalpos.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('rentalpos.index') }}";

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
        $(document).ready(function() {
            var showChar = 80;
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

            var table =  $('#items_table_list').DataTable({
                "drawCallback": function( settings ) {
                    feather.replace();
                },
            });
        });
    </script>
@endsection

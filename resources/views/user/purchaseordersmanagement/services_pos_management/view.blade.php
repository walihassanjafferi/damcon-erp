@extends('layout.main')
@section('servicespos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Services POs Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('servicespos.index')}} @endsection
@section('main_btn_text') All Maintenance Items & Services POs Management  @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>PO No. {{ $services_order->customer_po_number }}</b></h1><h1 class="ml-2">(CPO No. 2)</h1>
                </div>
                <div style="float: right;margin-top: 10px;">
                    <h4>{{ date_format($services_order->created_at,'d-M-Y')  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-8 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>GRM Number:</label>
                                    <span>{{ $services_order->grm_number }}</span>
                                    <br>
                                    <label>Customer PO Number (optional):</label>
                                    <span>{{ $services_order->customer_po_number }}</span>
                                    <br>
                                    <label>Requesting Person:</label>
                                    <span>{{ $services_order->requesting_person }}</span>
                                    <br>
                                    <label>Delivery Date:</label>
                                    <span>{{ $services_order->delivery_date }}</span>
                                    <br>
                                    <label>PR Number:</label>
                                    <span>{{ $services_order->pr_number }}</span>
                                    <br>
                                    <label>Tax Body%:</label>
                                    <span>{{ $services_order->pr_number }}</span>
                                    <br>
                                    <label>Taxation Month:</label>
                                    <span>{{ $services_order->taxation_month }}</span>
                                    <br>
                                    <label>Sales Tax WH%:</label>
                                    <span>{{ $services_order->sales_tax_wh.'%' }}</span>
                                    <br>
                                    <label>Description:</label>
                                    <br>
                                    <span class="comment more">{{ $services_order->comments}} </span>
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
                                    <span style="float: right;">PKR {{ number_format(doubleval($total_amount)) }}</span>
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
                                    <span style="float: right;">PKR {{ number_format($total_after_deduction) }}</span>
                                </div>
                               


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Items Details</label>

                        @php $increment = 1; @endphp
                        <div class="table-responsive p-2">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Item Cost (PKR)</th>
                                    <th>Total (PKR)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($services_items as $item)
                                    <tr>
                                        <td>{{ $increment }}</td>
                                        <td>{{ $item->item }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ number_format( $item->cost ) }} </td>
                                        <td>{{ number_format($item->cost*$item->qty) }}</td>
                                    </tr>
                                    @php $increment++ @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">File Attachments</label>
                        <div class="col-md-12 pl-3 pr-3">
                            <div class="rental bank_details">
                                @php
                                    $files = json_decode($services_order->document_file);
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12">
                                        Images
                                    </div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  download="download" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/services_pos/'.$path) }} ><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/services_pos/'.$path) }}"/>

                                    </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach

                                    @if(isset($pdf))
                                    <div class="col-12 mt-3" >Pdf's</div>
                                    @foreach ($pdf as $item)
                                        <span class="col-12 pip" style="padding: 16px;">
                                        <a  download="download" href={{ asset('/storage/services_pos/PDF/'.$path) }}><i class="fa fa-download"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/services_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                    @endif
                                @else
                                    <p>No Attachment's Found!</p>    
                                @endif

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder(1)"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('servicespos.edit',encrypt($services_order->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('servicespos.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('servicespos.index') }}";

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
        });
    </script>
@endsection

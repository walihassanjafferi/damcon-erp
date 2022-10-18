@extends('layout.main')
@section('supplier_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Supplier Payments Management View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('supplier_payment_management.index')}} @endsection
@section('main_btn_text') All Supplier Payments Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    {{-- <h1><b>{{ $supplier_payments->supplierpo->purchase_od_number }}</b></h1> --}}
                    <h1 class="ml-2" style="font-size: 24px;margin-top: 3px;">({{ $supplier_payments->supplier_type }}) - {{ $supplier_payments->banks->name ?? ''}}</h1>
                </div>
                <div style="float: right;margin-top: 7px;">
                    <h4>{{ date_format($supplier_payments->created_at,'d-M-Y')  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-8 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>Title:</label>
                                    <span>{{ $supplier_payments->title }}</span>
                                    <br>
                                    <label>Supplier:</label>
                                    {{-- <span>{{ $supplier_payments->supplierpo->purchase_od_number }}</span> --}}
                                    <span>{{ $supplier_payments->supplierName->name ?? ''}}</span>

                                    <br>
                                    <label>Supplier Type:</label>
                                    <span>{{ $supplier_payments->supplier_type_name->name ?? ''}}</span>
                                    <br>
                                    <label>Payment Method:</label>
                                    <span>{{ ($supplier_payments->payment_method == 1) ? 'Direct':'Batch Payment' }}</span>
                                    <br>

                                    @if($supplier_payments->banks)
                                        <label>Bank:</label>
                                        <span>{{ $supplier_payments->banks->name }}</span>
                                        <br>
                                        <label>Cheque Title:</label>
                                        <span>{{ $supplier_payments->cheque_title }}</span>
                                        <br>
                                        <label>Cheque Number:</label>
                                        <span>{{ $supplier_payments->cheque_number }}</span>
                                        <br>
                                     @endif
                                    <label>Payment Details:</label>
                                    <span>{{ $supplier_payments->payment_details }}</span>
                                    <br>
                                    <label>Comments:</label>
                                    <span class="comment more">{{ $supplier_payments->comments}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body">
                                <div class="bank_details">
                                    <label>Date</label>
                                    <span style="float: right;">{{ $supplier_payments->date }}</span>
                                </div>
                                <div class="rental bank_details">
                                    <div class="bank_details_balance" style="display: inline-flex;">
                                        <h2>Amount</h2>
                                        <h3 style="position: absolute;right: 30px;top: 56px;">Rs. {{ $supplier_payments->amount }}</h3>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $files = json_decode($supplier_payments->document_file);

            @endphp
            @if(isset($files) && count($files) > 0)
                <div class="col-12">
                    <div class="card">
                        <div class="row">
                            <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">File Attachments</label>
                            <div class="col-md-12 pl-3 pr-3">
                                <div class="rental bank_details">
                                    @php
                                        $files = json_decode($supplier_payments->document_file);
                                    @endphp
                                    @if(isset($files) && count($files))
                                        <div class="col-12">
                                            Images
                                        </div>
                                        @php $pdf = array(); @endphp
                                        @foreach ($files as $path)
                                            @if(!preg_match("/\.(pdf)$/", $path))
                                                   @if(file_exists(public_path().('/storage/supplier_payments/'.$path)))
                                                        <span class="pip col-3">
                                                                <a  download="{{ $path }}" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/supplier_payments/'.$path) }} ><i class="fa fa-download"></i></a>
                                                                <img class="images_upload" type="file" src="{{ asset('/storage/supplier_payments/'.$path) }}"/>
                                                        </span>
                                                    @endif
                                            @else
                                                @php array_push($pdf,$path) @endphp
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(isset($pdf))
                                        <div class="col-12 mt-3" >Pdf's</div>
                                        @foreach ($pdf as $item)
                                            @if(file_exists(public_path().('/storage/supplier_payments/PDF/'.$item)))
                                                <span class="col-12 pip" style="padding: 16px;">
                                                    <a  download="{{ $item }}" href={{ asset('/storage/supplier_payments/PDF/'.$item) }}><i class="fa fa-download"></i></a>
                                                    <a class="pdf_file" href="{{ asset('/storage/supplier_payments/PDF/'.$item) }}" target="_blank">{{$item}}</a>
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{ $supplier_payments->id }})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('supplier_payment_management.edit',encrypt($supplier_payments->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('supplier_payment_management.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('supplier_payment_management.index') }}";

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

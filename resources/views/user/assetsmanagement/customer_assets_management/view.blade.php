@extends('layout.main')
@section('customerassets_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Customer Assets View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customerassets.index')}} @endsection
@section('main_btn_text') All Customer Assets Management @endsection
{{-- back btn --}}
@section('content')

<style>
    .right-label label{
        display: contents;
    }
    .right-label span{
        float: right;
    }
</style>
<div class="col-12">
    <div class="row">
        <div class="col-12" style="padding-bottom: 5px;">
            <div style="display: inline-flex;">
                <h1><b>{{ $customer_assets->registration_number }}</b></h1><h1 class="ml-2">({{$customer_assets->asset_item_id}}) - {{ $customer_assets->item_condition }}</h1>
            </div>
            <div>
                <h4>Supplied by  <b>{{ $customer_assets->customer->name }}</b> - {{ $customer_assets->asset_Location }}
                    <span style="float: right;">{{ $customer_assets->date_of_handover }}</span>
                </h4>
            </div>
        </div>

        <div class="col-8 card card-updated">
            <div class="">
                <div class="card-body ">
                    <div class="rental bank_details">
                        <div class="row">
                            <div class="col-md-6 right-label">
                                <label>Brand</label>
                                <span>{{$customer_assets->asset_brand}}</span>
                                <br>
                                <label>Asset Incharge</label>
                                <span>{{$customer_assets->employee->name ?? ''}}</span>
                                <br>
                                <label>Model</label>
                                <span>{{$customer_assets->model}}</span>
                                <br>
                                <label>Engine Name</label>
                                <span>{{$customer_assets->engine_name}}</span>
                                <br>
                                <label>Project Name</label>
                                <span>{{$customer_assets->project->name}}</span>
                                <br>
                            </div>
                            <div class="col-md-6 right-label">
                                <label>Chassis</label>
                                <span>{{$customer_assets->chassis_number}}</span>
                                <br>
                                <label>Color</label>
                                <span>{{$customer_assets->color}}</span>
                                <br>
                                <label>Engine Capacity</label>
                                <span>{{$customer_assets->engine_capacity}}</span>
                                <br>
                                <label>Mileage/Hours</label>
                                <span>{{$customer_assets->milage}}</span>
                                <br>
                            </div>
                        </div>


                        @if($customer_assets->specifications_1)
                            <br>
                            <label>Specs 1</label>
                            <br>
                            <span class="addReadMore showlesscontent">@php echo $customer_assets->specifications_1 @endphp </span>
                        @endif

                        @if($customer_assets->specifications_2)
                            <br>
                            <label>Specs 2</label>
                            <br>
                            <span class="addReadMore showlesscontent">@php echo $customer_assets->specifications_2 @endphp </span>
                        @endif

                        <br>
                        <label>Comments</label>
                        <br>
                        <span class="comment more">{{$customer_assets->comments}}</span>
                        <br>
                        <br>
                        <label>Description</label>
                        <br>
                        <span class="addReadMore showlesscontent">@php echo $customer_assets->description_input @endphp </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 card card-updated">
            <div class="" style="min-height: 350px;">
                <div class="card-body">
                    <div class="bank_details">
                        <label>Handover Date</label>
                        <span style="float: right;">{{$customer_assets->date_of_handover}}</span>
                        <br>
                        <label>Market Price</label>
                        <span style="float: right;"><b>Rs. </b> {{$customer_assets->market_price}}</span>

                        <br>
{{--                        <label>Purchase Mode</label>--}}
{{--                        <span style="float: right;"><b>{{ ($customer_assets->mode_of_purchase ==1)? 'Cash':'Bank Lease' }}</b></span>--}}
{{--                        <br>--}}
{{--                        <label>Payment Mode</label>--}}
{{--                        <span style="float: right;"><b>{{ ($customer_assets->mode_of_payment ==1)? 'Cash':'Cheque' }}</b></span>--}}
                    </div>
                </div>
            </div>
        </div>

        @php
            $files = json_decode($customer_assets->document_file);

        @endphp

        @if(isset($files) && count($files) > 0)
            <div class="col-12 card card-updated">
                <div class="">
                    <div class="card-body ">
                        <h2 style="font-size: 17px;">File Attachments</h2>
                        <div>

                            @if(isset($files) && count($files))
                                <div class="col-12 mb-2">
                                    Images
                                </div>
                                @php $pdf = array(); @endphp
                                @foreach ($files as $path)
                                    @if(!preg_match("/\.(pdf)$/", $path))
                                        <span class="pip col-3">
                                        <a  download="download" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/customer_asset_management/'.$path) }} ><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/customer_asset_management/'.$path) }}"/>

                                    </span>
                                    @else
                                        @php array_push($pdf,$path) @endphp
                                    @endif
                                @endforeach
                            @endif

                            @if(isset($pdf))
                                <div class="col-12 mt-3 mb-1" >Pdf's</div>
                                @foreach ($pdf as $item)
                                    <span class="col-12 pip" style="padding: 16px;">
                                        <a  download="download" href={{ asset('/storage/customer_asset_management/PDF/'.$path) }}><i class="fa fa-download"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/customer_asset_management/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12">
            <a class="btn btn-danger mb-1" onclick="deleteRental({{$customer_assets->id}})"
               style="float:right;margin-left:10px;">Delete</i>
            </a>
            <a class="btn btn-primary mb-1" href="{{route('customerassets.edit',encrypt($customer_assets->id))}}" style="float:right;">Edit</a>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        function deleteRental(id){
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
                            url:'{{route('customerassets.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('customerassets.index') }}";

                                document.location.href=url;


                            },
                            error: function(data)
                            {
                                alert('Error Failed');

                            }
                        });
                    }
                });

        };

        $(document).ready(function() {
            var showChar = 70;
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


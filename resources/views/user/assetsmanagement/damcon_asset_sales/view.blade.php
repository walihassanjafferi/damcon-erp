@extends('layout.main')
@section('damconassetsales_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon Assets Sales View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('damconassetsales.index')}} @endsection
@section('main_btn_text') All Damcon Assets Sales @endsection
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
                <h1><b>{{ $damcon_assets_sale->registration_number }}</b></h1><h1 class="ml-2">({{$damcon_assets_sale->damconasset->asset_item_id}})</h1>
            </div>
            <div>
                <h4>
                    <span style="float: right;">{{ date('d-M-Y',strtotime($damcon_assets_sale->date_of_purchase)) }}</span>
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
                                <span>{{$damcon_assets_sale->asset_brand}}</span>
                                <br>
                                <label>Registration Number</label>
                                <span>{{$damcon_assets_sale->registration_number}}</span>
                                <br>
                                <label>Model</label>
                                <span>{{$damcon_assets_sale->model}}</span>
                                <br>
                                <label>Engine Name</label>
                                <span>{{$damcon_assets_sale->engine_name}}</span>
                                <br>
                            </div>
                            <div class="col-md-6 right-label">
                                <label>Chassis</label>
                                <span>{{$damcon_assets_sale->chassis_number}}</span>
                                <br>
                                <label>Color</label>
                                <span>{{$damcon_assets_sale->color}}</span>
                                <br>
                                <label>Engine Capacity</label>
                                <span>{{$damcon_assets_sale->engine_capacity}}</span>
                                <br>
                                <label>Mileage/Hours</label>
                                <span>{{$damcon_assets_sale->milage}}</span>
                                <br>
                                <label>Current Mileage/Hours</label>
                                <span>{{$damcon_assets_sale->current_milage_hours}}</span>
                                <br>
                            </div>
                        </div>


                        @if($damcon_assets_sale->specifications_1)
                            <br>
                            <label>Specs 1</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $damcon_assets_sale->specifications_1 @endphp </span>
                            <br>
                        @endif

                        @if($damcon_assets_sale->specifications_2)
                            <br>
                            <label>Specs 2</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $damcon_assets_sale->specifications_2 @endphp </span>
                            <br>
                        @endif


                        @if($damcon_assets_sale->sold_party_details)
                            <br>
                            <label>Sold Party Details</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $damcon_assets_sale->sold_party_details @endphp </span>
                            <br>
                        @endif


                        <label>Comments</label>
                        <br>
                        <span class="comment more view_details_text">{{$damcon_assets_sale->comments}}</span>
                        <br>
                        <br>
                        <label>Description</label>
                        <br>
                        <span class="addReadMore showlesscontent">@php echo $damcon_assets_sale->description_input @endphp </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 card card-updated">
            <div class="" style="min-height: 350px;">
                <div class="card-body">
                    <div class="bank_details">
{{--                        <label>Depreciation Date</label>--}}
{{--                        <span style="float: right;">{{$damcon_assets_sale->date_of_depreciation}}</span>--}}
{{--                        <br>--}}
                        <label>Purchase Price</label>
                        <span style="float: right;"><b>PKR </b> {{ number_format($damcon_assets_sale->purchase_price) }}</span>
                        <br>
{{--                        <label>Asset New Price</label>--}}
{{--                        <span style="float: right;"><b>Rs. </b> {{$damcon_assets_sale->asset_new_price}}</span>--}}
{{--                        <br>--}}
                        <label>Asset Last Price</label>
                        <span style="float: right;"><b>PKR</b> {{ number_format($damcon_assets_sale->asset_last_price) }}</span>
                        <br>
{{--                        <label>Depreciation Last Date</label>--}}
{{--                        <span style="float: right;"> {{$damcon_assets_sale->last_date_of_depreciation}}</span>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <a class="btn btn-danger mb-1" onclick="deleteRental({{$damcon_assets_sale->id}})"
               style="float:right;margin-left:10px;">Delete</i>
            </a>
            <a class="btn btn-primary mb-1" href="{{route('damconassetsales.edit',encrypt($damcon_assets_sale->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('damconassetsales.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id
                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('damconassetsales.index') }}";

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



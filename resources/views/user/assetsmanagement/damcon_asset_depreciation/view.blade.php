@extends('layout.main')
@section('damconassetsdepreciation_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon Assets Depreciation View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('damconassetsdepreciation.index')}} @endsection
@section('main_btn_text') All Damcon Assets Depreciation @endsection
{{-- back btn --}}
@section('content')
</script>

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
        <div class="col-12" style="padding-bottom: 2px;">
            <div style="display: inline-flex;">
                <h1><b>{{ $assetDep->registration_number }}</b></h1><h1 class="ml-2">({{$assetDep->damconasset->asset_item_id}})</h1>
            </div>
            <div>
                <h4>
                    <span style="float: right;">{{ date('d-M-Y',strtotime($assetDep->date_of_purchase)) }}</span>
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
                                <span>{{$assetDep->asset_brand}}</span>
                                <br>
                                <label>Registration Number</label>
                                <span>{{$assetDep->registration_number}}</span>
                                <br>
                                <label>Model</label>
                                <span>{{$assetDep->model}}</span>
                                <br>
                                <label>Engine Name</label>
                                <span>{{$assetDep->engine_name}}</span>
                                <br>
                            </div>
                            <div class="col-md-6 right-label">
                                <label>Chassis</label>
                                <span>{{$assetDep->chassis_number}}</span>
                                <br>
                                <label>Color</label>
                                <span>{{$assetDep->color}}</span>
                                <br>
                                <label>Engine Capacity</label>
                                <span>{{$assetDep->engine_capacity}}</span>
                                <br>
                                <label>Mileage/Hours</label>
                                <span>{{$assetDep->milage}}</span>
                                <br>
                                <label>Current Mileage/Hours</label>
                                <span>{{$assetDep->current_milage_hours}}</span>
                                <br>
                            </div>
                        </div>


                        @if($assetDep->specifications_1)
                            <br>
                            <label>Specs 1</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $assetDep->specifications_1 @endphp </span>
                            <br>
                        @endif

                        @if($assetDep->specifications_2)
                            <br>
                            <label>Specs 2</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $assetDep->specifications_2 @endphp </span>
                            <br>
                        @endif


                        <label>Comments</label>
                        <br>
                        <span class="comment more view_details_text">{{$assetDep->comments}}</span>
                        <br>
                        <br>
                        <label>Description</label>
                        <br>
                        <span class="addReadMore showlesscontent view_details_text">@php echo $assetDep->description_input @endphp </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 card card-updated">
            <div class="" style="min-height: 350px;">
                <div class="card-body">
                    <div class="bank_details">
                        <label>Depreciation Date</label>
                        <span style="float: right;">{{date('d-M-Y',strtotime($assetDep->date_of_depreciation))}}</span>
                        <br>
                        <label>Purchase Price</label>
                        <span style="float: right;"><b>PKR </b> {{number_format($assetDep->purchase_price)}}</span>
                        <br>
                        <label>Asset New Price</label>
                        <span style="float: right;"><b>PKR </b> {{number_format($assetDep->asset_new_price)}}</span>
                        <br>
                        <label>Asset Last Price</label>
                        <span style="float: right;"><b>PKR </b> {{number_format($assetDep->asset_last_price)}}</span>
                        <br>
                        <label>Depreciation Last Date</label>
                        <span style="float: right;"> {{date('d-M-Y',strtotime($assetDep->last_date_of_depreciation))}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <a class="btn btn-danger mb-1" onclick="deleteRental({{$assetDep->id}})"
               style="float:right;margin-left:10px;">Delete</i>
            </a>
            <a class="btn btn-primary mb-1" href="{{route('damconassetsdepreciation.edit',encrypt($assetDep->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('damconassetsdepreciation.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id
                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('damconassetsdepreciation.index') }}";

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


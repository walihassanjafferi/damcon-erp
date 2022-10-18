@extends('layout.main')
@section('damconassets_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon Assets View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('damconassets.index')}} @endsection
@section('main_btn_text') All Damcon Assets Management @endsection
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
                <h1><b>{{ $assetItem->registration_no }}</b></h1><h1 class="ml-2">({{$assetItem->asset_item_id}}) - {{ $assetItem->item_condition }}</h1>
            </div>
            <div>
                <h4>Supplied by  <b>{{ $assetItem->supplier->name }}</b> - {{ $assetItem->asset_location }}
                    <span style="float: right;">{{ $assetItem->date_of_purchase }}</span>
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
                                <span>{{$assetItem->asset_brand}}</span>
                                <br>
                                <label>Asset Incharge</label>
                                <span>{{$assetItem->employee->name ?? ''}}</span>
                                <br>
                                <label>Model</label>
                                <span>{{$assetItem->model}}</span>
                                <br>
                                <label>Engine Name</label>
                                <span>{{$assetItem->engine_no}}</span>
                                <br>
                                <label>Project Name</label>
                                <span>{{$assetItem->project->name ?? 'N/A'}}</span>
                                <br>
                            </div>
                            <div class="col-md-6 right-label">
                                <label>Chassis</label>
                                <span>{{$assetItem->chasssis_no}}</span>
                                <br>
                                <label>Color</label>
                                <span>{{$assetItem->color}}</span>
                                <br>
                                <label>Engine Capacity</label>
                                <span>{{$assetItem->engine_capacity}}</span>
                                <br>
                                <label>KM on Purchase </label>
                                <span>{{$assetItem->milage_hours}}</span>
                                <br>
                                <label>Asset Maintenance type </label>
                                <span>{{$assetItem->asset_maintenance_type}}</span>
                                <br>
                                <label>Asset Maintenance Duration </label>
                                <span>{{$assetItem->asset_maintenance_duration}}</span>
                                <br>
                            </div>
                        </div>


                        @if($assetItem->technical_specification_1)
                        <br>
                        <label>Specs 1</label>
                        <span class="addReadMore showlesscontent view_details_text">@php echo $assetItem->technical_specification_1 @endphp </span>
                        @endif

                        @if($assetItem->technical_specifications_2)
                        <br>
                        <label>Specs 2</label>
                        <span class="addReadMore showlesscontent view_details_text">@php echo $assetItem->technical_specifications_2 @endphp </span>
                        <br>
                        @endif


                        <label>Comments</label>
                        <br>
                        <span class="comment more view_details_text">{{$assetItem->comments}}</span>
                        <br>
                        <br>
                        <label>Description</label>
                        <br>
                        <span class="addReadMore showlesscontent view_details_text">@php echo $assetItem->description @endphp </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 card card-updated">
            <div class="" style="min-height: 350px;">
                <div class="card-body">
                    <div class="bank_details">
                        <label>Purchase Date</label>
                        <span style="float: right;">{{$assetItem->date_of_purchase}}</span>
                        <br>
                        <label>Purchase Price</label>
                        <span style="float: right;"><b>Rs. </b> {{number_format($assetItem->purchase_price,2)}}</span>

                        <br>
                        <label>Purchase Mode</label>
                        <span style="float: right;"><b>{{ ($assetItem->mode_of_purchase ==1)? 'Cash':'Bank Lease' }}</b></span>
                        <br>
                        <label>Payment Mode</label>
                        <span style="float: right;"><b>{{ ($assetItem->mode_of_payment ==1)? 'Cash':'Cheque' }}</b></span>
                    </div>
                </div>
            </div>
        </div>

        @php
            $files = json_decode($assetItem->file_attachments);

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
                                        <a  download="download" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/demcon_asset_management/'.$path) }} ><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/demcon_asset_management/'.$path) }}"/>

                                    </span>
                                @else
                                    @php array_push($pdf,$path) @endphp
                                @endif
                            @endforeach
                        @endif

                        @if(isset($pdf))
                            <div class="col-4 mt-3 mb-1" >Pdf's</div>
                            @foreach ($pdf as $item)
                                <span class="col-3 pip" style="padding: 16px;">
                                       
                                            <a  download="download" href={{ asset('/storage/demcon_asset_management/PDF/'.$path) }}><i class="fa fa-download"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/demcon_asset_management/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                      
                                    </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-12">
            <a class="btn btn-danger mb-1" onclick="deleteRental({{$assetItem->id}})"
               style="float:right;margin-left:10px;">Delete</i>
            </a>
            <a class="btn btn-primary mb-1" href="{{route('damconassets.edit',encrypt($assetItem->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('damconassets.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('damconassets.index') }}";

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


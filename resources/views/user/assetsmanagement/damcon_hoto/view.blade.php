@extends('layout.main')
@section('damconhoto_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon HOTO</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('damconhoto.index') }} @endsection
@section('main_btn_text') All Damcon HOTO Management @endsection
{{-- back btn --}}
@section('content')


    <style>
        .right-label label {
            display: contents;
        }

        .right-label span {
            float: right;
        }

    </style>
    <div class="col-12">
        <div class="row">
            <div class="col-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>{{ $damconHoto->registration_number }}</b></h1>
                    <h1 class="ml-2">({{$asset_id[0]}})</h1>
                </div>
            </div>

            <div class="col-12 card card-updated">
                <div class="">
                    <div class="card-body ">
                        <div class="rental bank_details">
                            <div class="row">
                                <div class="col-md-6 right-label">
                                    <label>Handover/takeover Supervisor</label>
                                    <span>{{ $damconHoto->hoto_supervisor }}</span>
                                    <br>
                                    <label>Current Possession</label>
                                    <span>{{ $damconHoto->current_possession }}</span>
                                    <br>
                                    <label>Date of Purchase</label>
                                    <span>{{ $damconHoto->date_of_purchase }}</span>
                                    <br>
                                    <label>Brand</label>
                                    <span>{{ $damconHoto->asset_brand }}</span>
                                    <br>
                                    <label>Model</label>
                                    <span>{{ $damconHoto->model }}</span>
                                    <br>
                                    <label>Engine Name</label>
                                    <span>{{ $damconHoto->engine_number }}</span>
                                    <br>
                                    <label>Registration Name</label>
                                    <span>{{ $damconHoto->registration_number }}</span>
                                    <br />
                                </div>
                                <div class="col-md-6 right-label">
                                    <label>Chassis Number</label>
                                    <span>{{ $damconHoto->chassis_number }}</span>
                                    <br>
                                    <label>Color</label>
                                    <span>{{ $damconHoto->color }}</span>
                                    <br>
                                    <label>Engine Capacity</label>
                                    <span>{{ $damconHoto->engine_capacity }}</span>
                                    <br>
                                    <label>Mileage/Hours</label>
                                    <span>{{ $damconHoto->milage_hours }}</span>
                                    <br>
                                    <label>Last Updated Mileage/Hours</label>
                                    <span>{{ $damconHoto->last_updated_milage }}</span>
                                    <br>
                                </div>
                            </div>


                            @if ($damconHoto->specifications_1)
                                <br>
                                <label>Specs 1</label>
                                <span class="addReadMore showlesscontent view_details_text">@php echo $damconHoto->specifications_1 @endphp </span>
                            @endif

                            @if ($damconHoto->specifications_2)
                                <br>
                                <label>Specs 2</label>
                                <span class="addReadMore showlesscontent view_details_text">@php echo $damconHoto->specifications_2 @endphp </span>
                                <br>
                            @endif


                            <label>Comments</label>
                            <br>
                            <span class="comment more view_details_text">{{ $damconHoto->comments }}</span>
                            <br>
                            <br>
                            <label>Description</label>
                            <br>
                            <span class="addReadMore showlesscontent view_details_text">@php echo $damconHoto->description @endphp </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 card card-updated">
                    <div class="card-body">

                        <div class="rental bank_details">
                            <div class="row">
                                <h6 class="pl-1">Current Possession</h6>
                                <div class="col-12"></div>
                                <div class="col-md-6 right-label">
                                    <label>Handover Employee Cnic</label>
                                    <span>{{ $damconHoto->handingover_per_cinc }}</span>
                                    <br>
                                    <label>Handover Employee Name</label>
                                    <span>{{ $damconHoto->handingover_emp_name }}</span>
                                    <br>
                                    <label>Handover Father Name</label>
                                    <span>{{ $damconHoto->handingover_father_name }}</span>
                                    <br>
                                    <label>Handover Date of Join</label>
                                    <span>{{ $damconHoto->handingover_date_join }}</span>
                                    <br>
                                    <label>Handover Designation</label>
                                    <span>{{ $damconHoto->handingover_designation }}</span>
                                    <br>
                                    <label>Handover Location</label>
                                    <span>{{ $damconHoto->handingover_location }}</span>
                                    <br>
                                </div>
                                <div class="col-md-6 right-label">
                                    <h6 class="pl-1">TakeOver Employee</h6>
                                    <label>TakeOver Employee Cnic</label>
                                    <span>{{ $damconHoto->takingover_per_cinc }}</span>
                                    <br>
                                    <label>TakeOver Employee Name</label>
                                    <span>{{ $damconHoto->takingover_emp_name }}</span>
                                    <br>
                                    <label>TakeOver Employee Father Name</label>
                                    <span>{{ $damconHoto->takingover_father_name }}</span>
                                    <br>
                                    <label>TakeOver Employee Date of Join</label>
                                    <span>{{ $damconHoto->takingover_date_join }}</span>
                                    <br>
                                    <label>TakeOver Employee Designation</label>
                                    <span>{{ $damconHoto->takingover_designation }}</span>
                                    <br>
                                    <label>TakeOver Employee Region</label>
                                    <span>{{ $damconHoto->takingover_region }}</span>
                                    <br>
                                    <label>TakeOver Employee Location</label>
                                    <span>{{ $damconHoto->takingover_location }}</span>
                                    <br>
                                </div>
                            </div>
                        </div>
                
                    </div>
            </div>

            @php
                $files = json_decode($damconHoto->document_file);
                
            @endphp

            @if (isset($files) && count($files) > 0)
                <div class="col-12 card card-updated">
                    <div class="">
                        <div class="card-body ">
                            <h2 style="font-size: 17px;">File Attachments</h2>
                            <div>

                                @if (isset($files) && count($files))
                                    <div class="col-12 mb-2">
                                        Images
                                    </div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if (!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                                <a download="download"
                                                    style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c"
                                                    href={{ asset('/storage/damcon_hoto/' . $path) }}><i
                                                        class="fa fa-download"></i></a>
                                                <img class="images_upload" type="file"
                                                    src="{{ asset('/storage/damcon_hoto/' . $path) }}" />

                                            </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if (isset($pdf))
                                    <div class="col-12 mt-3 mb-1">Pdf's</div>
                                    @foreach ($pdf as $item)
                                        <span class="col-12 pip" style="padding: 16px;">
                                            <a download="download"
                                                href={{ asset('/storage/demcon_asset_management/PDF/' . $path) }}><i
                                                    class="fa fa-download"></i></a>
                                            <a class="pdf_file"
                                                href="{{ asset('/storage/demcon_asset_management/PDF/' . $path) }}"
                                                target="_blank">{{ $item }}</a>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteRental({{ $damconHoto->id }})"
                    style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{ route('damconassets.edit', encrypt($damconHoto->id)) }}"
                    style="float:right;">Edit</a>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        function deleteRental(id) {
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
                            url: '{{ route('damconassets.destroy', 'id') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('damconassets.index') }}";

                                document.location.href = url;


                            },
                            error: function(data) {
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

                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar - 1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext +
                        '&nbsp;</span><span class="morecontent"><span>' + h +
                        '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });


            $(".morelink").click(function() {
                if ($(this).hasClass("less")) {
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

@extends('layout.main')
@section('rental_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Rental Items View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('rentalitem.index')}} @endsection
@section('main_btn_text') All Rental Items @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">
        <div class="row">
            <div class="col-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>{{$rentalItem->rental_name}}</b></h1><h1 class="ml-2">({{$rentalItem->rental_id}}) - {{ $rentalItem->item_condition }}</h1>
                </div>
                <div>
                    <h4>Supplied by  <b>{{ $rentalItem->supplier_rental->name }}</b> - {{ $rentalItem->current_localtion }}
                        <span style="float: right;">{{ $rentalItem->date_of_agreement }}</span>
                    </h4>
                </div>
            </div>

            <div class="col-8 card card-updated">
                <div class="mb-4">
                    <div class="card-body ">
                        <div class="rental bank_details">
                            <label>Brand</label>
                            <span>{{$rentalItem->brand}}</span>
                            <br>
                            <label>Model</label>
                            <span>{{$rentalItem->model}}</span>
                            <br>
                            <label>Engine Name</label>
                            <span>{{$rentalItem->engine_name}}</span>
                            <br>
                            <label>Chassis / Alternator No</label>
                            <span>{{$rentalItem->chassis_number}}</span>
                            <br>
                            <label>Color</label>
                            <span>{{$rentalItem->color}}</span>
                            <br>
                            <label>Engine Capacity</label>
                            <span>{{$rentalItem->engine_capacity}}</span>
                            <br>
                            <label>Mileage/Hours at time of agreement</label>
                            <span>{{$rentalItem->current_milage}}</span>
                            <br>
                            <br>
                            <label>Specs 1</label>
                            <br>
                            <span class="addReadMore showlesscontent">@php echo $rentalItem->specifications_1 @endphp </span>
                            <br>
                            <br>
                            <label>Specs 2</label>
                            <br>
                            <span class="addReadMore showlesscontent">@php echo $rentalItem->specifications_2 @endphp </span>
                            <br>
                            <br>
                            <label>Comments</label>
                            <br>
                            <span class="comment more">{{$rentalItem->comments}}</span>
                            <br>
                            <br>
                            <label>Description</label>
                            <br>
                            <span class="addReadMore showlesscontent">@php echo $rentalItem->description_input @endphp </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 card card-updated">
                <div class="mb-4" style="min-height: 350px;">
                    <div class="card-body">
                        <div class="bank_details">
                            <label>Monthly Rent</label>
                            <span style="float: right;"><b>Rs. </b> {{$rentalItem->monthly_rental_amount}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteRental({{$rentalItem->id}})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('rentalitem.edit',encrypt($rentalItem->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('rentalitem.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('rentalitem.index') }}";

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

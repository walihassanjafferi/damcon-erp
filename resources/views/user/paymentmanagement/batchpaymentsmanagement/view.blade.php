@extends('layout.main')
@section('batches_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Batches Payments Management View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('batches_payment_management.index')}} @endsection
@section('main_btn_text') All Batches Payments Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>{{ $batches_payments->title }}</b></h1>
                </div>
                <div style="float: right;margin-top: 10px;">
                    <h4>{{ date('d-M-Y',strtotime($batches_payments->created_at))  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-8 card card-updated">
                        <div class="">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>Name of Batch:</label>
                                    <span>{{ $batches_payments->batches->name_of_batch }}</span>
                                    <br>
                                    <label>Cheque Date:</label>
                                    <span>{{ date('d-M-Y',strtotime($batches_payments->date_of_cheque)) }}</span>
                                    <br>
                                    <label>Bank Account:</label>
                                    <span>{{ $batches_payments->banks->name.'('.$batches_payments->banks->title.')' }}</span>
                                    <br>
                                    <label>Cheque Title:</label>
                                    <span>{{ $batches_payments->cheque_title }}</span>
                                    <br>
                                    <label>Cheque Number:</label>
                                    <span>{{ $batches_payments->cheque_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card card-updated">
                        <div class="">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <div class="bank_details_balance" style="display: inline-flex;">
                                        <h2>Amount</h2>
                                        <h3 style="position: absolute;right: 30px;top: 24px;">PKR {{ number_format($batches_payments->amount) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 card card-updated">
                <div class="">
                    <div class="card-body ">
                        <label style="font-weight:900;font-size:14px;padding-right:10px;" >Batch Description:</label>
                        <span>{{$batches_payments->batch_description}}</span>
                        <br/>
                        <label style="font-weight:900;font-size:14px;padding-right:10px;">Batch Comment:</label>
                        <span>{{$batches_payments->comment_box}}</span>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{$batches_payments->id}})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('batches_payment_management.edit',encrypt($batches_payments->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('batches_payment_management.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('batches_payment_management.index') }}";

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
    </script>
@endsection

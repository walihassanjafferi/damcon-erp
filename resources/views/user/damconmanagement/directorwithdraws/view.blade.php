@extends('layout.main')
@section('director_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Director Withdraws View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('directorwithdraw.index')}} @endsection
@section('main_btn_text') All Director Withdraws @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
           
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-12 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body ">
                                <div class="rental bank_details">
        
                                    <label>Partner Name:</label>
                                    <span>{{ $director->partner_name }}</span>
                                    <br>
                                    <label>Bank:</label>
                                    <span>{{ $director->bank->name }}</span>
                                    <br>
                                    <label>Cheque Title:</label>
                                    <span>{{ $director->cheque_title }}</span>
                                    <br>
                                    <label>Cheque Number:</label>
                                    <span>{{ $director->cheque_number }}</span>
                                    <br>
                                    <label>Amount:</label>
                                    <span>PKR {{ number_format($director->amount) }}</span>
                                    <br>
                                    <label>Cheque Clearing Date:</label>
                                    <span>{{ date('d-M-Y',strtotime($director->cheque_clearing_date)) }}</span>
                                    <br>
                                    <label>Comments:</label>
                                    <span class="comment more">{{ $director->comments}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

    

            <div class="col-12">
                <a class="btn btn-primary mb-1" href="{{route('directorwithdraw.edit',encrypt($director->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('security_payment_management.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('security_payment_management.index') }}";

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

@extends('layout.main')
@section('employees_tax_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Employees Tax View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employees_tax_management.index')}} @endsection
@section('main_btn_text') All Employees Tax Management @endsection
{{-- back btn --}}
@section('content')
    <style>
        .rental label{
            width: 315px;
        }
    </style>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>{{ $employee_tax->title }}</b></h1>
                </div>
                <div style="float: right;margin-top: 7px;">
                    <h4>{{ date_format($employee_tax->created_at,'d-m-Y')  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-12 card card-updated">
                        <div class="">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>Title:</label>
                                    <span>{{ $employee_tax->title }}</span>
                                    <br>

                                    <label>Law of Tax:</label>
                                    <span>{{ $employee_tax->law_of_tax }}</span>
                                    <br>

                                    <label>Income Tax Percentage on salary:</label>
                                    <span>{{ $employee_tax->income_tax_percentage_on_salary.'%' }}</span>
                                    <br>

                                    <label>EOBI Tax Percentage:</label>
                                    <span>{{ $employee_tax->EOBI_tax_percentage.'%' }}</span>
                                    <br>
                                    <label>Law of Tax Update Date:</label>
                                    <span>{{ $employee_tax->law_of_tax_update_date }}</span>
                                    <br>
                                    <label>Description of Tax:</label>
                                    <span class="addReadMore showlesscontent">@php echo $employee_tax->description_input @endphp </span>
                                    <br>
                                    <label>Tax Details:</label>
                                    <span class="addReadMore showlesscontent">@php echo $employee_tax->details_input @endphp </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{ $employee_tax->id }})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('employees_tax_management.edit',encrypt($employee_tax->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('employees_tax_management.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('employees_tax_management.index') }}";

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



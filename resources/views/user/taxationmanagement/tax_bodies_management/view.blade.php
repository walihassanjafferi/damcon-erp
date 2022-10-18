@extends('layout.main')
@section('tax_bodies_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Tax Body Management View</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('tax_bodies.index')}} @endsection
@section('main_btn_text') All Tax Bodies Management @endsection
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
                        <h1><b>{{ $tax_body->name }}</b></h1>
                </div>
                <div style="float: right;margin-top: 7px;">
                    <h4>{{ date_format($tax_body->created_at,'d-m-Y')  }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-12 card card-updated">
                        <div class="">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>Name:</label>
                                    <span>{{ $tax_body->name }}</span>
                                    <br>

                                    <label>Sales Tax Percentage on Items:</label>
                                    <span>{{ $tax_body->sales_tax_percentage_items.'%' }}</span>
                                    <br>

                                    <label>Sales Tax Percentage on Services:</label>
                                    <span>{{ $tax_body->sales_tax_percentage_services.'%' }}</span>
                                    <br>

                                    <label>Sales Tax withheld at source percentage:</label>
                                    <span>{{ $tax_body->sales_tax_withheld_source_percentage.'%' }}</span>
                                    <br>
                                    <label>Modification Date:</label>
                                    <span>{{ $tax_body->rule_creation_date }}</span>
                                    <br>
                                    <label>Comments:</label>
                                    <span class="comment more">{{ $tax_body->comments_about_law}} </span>
                                    <br>
                                    <label>Description:</label>
                                    <span class="addReadMore showlesscontent">@php echo $tax_body->description @endphp </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Inventory Updates</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped tax_body_management">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Transaction type</th>
                                    <th>Module Name</th>
                                    <th>Payment title</th>
                                    <th>Amount (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tax_ledgers as $index=>$item)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{ strtoupper($item->transaction_type) }}</td>
                                        <td>{{ $item->module_name }}</td>
                                        <td>{{ strtoupper($item->payment_title) }}</td>
                                        <td>{{ number_format($item->amount) }}</td>
                                        
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{ $tax_body->id }})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('tax_bodies.edit',encrypt($tax_body->id))}}" style="float:right;">Edit</a>
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
                            url:'{{route('tax_bodies.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('tax_bodies.index') }}";

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


            $('.tax_body_management').DataTable({

            });
        });
    </script>
@endsection



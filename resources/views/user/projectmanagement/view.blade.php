@extends('layout.main')
@section('title')
<title>Damcon ERP -  View Project</title>
@endsection
@section('project_siderbar') active @endsection

{{-- back btn --}}
@section('main_btn_href') {{route('projectmanagement.index')}} @endsection
@section('main_btn_text') All Projects @endsection
{{-- back btn --}}

@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="customer_status">
                            <h4>Project Details</h4>
                                <span class="customer_status_span"><label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" {{$project->status ? 'checked' : ''}} onclick="statusChange({{$project->id}});">
                                    <span class="slider round"></span>
                                </label></span>
                            </div>
                            <br/>
                            <div class="customer_details">
                                <label>Project Code</label>
                                <span>{{$project->name}}</span>
                            </div>
                            <div class="customer_details">
                                <label>Project Name</label>
                                <span>{{ $project->name}} </span>
                            </div>
                            <div class="customer_details">
                                <label>Project Description</label>
                                <span class="comment more">{{ $project->project_description}} </span>
                            </div>
                            <div class="customer_details">
                                <label>Project Customer</label>
                                <span>{{ $project->customer->name}} </span>
                            </div>

                            <div class="customer_details">
                                <label>Project Region Box</label>
                                <span>{{ $project->project_region_box}} </span>
                            </div>
                            

                        </div>
                    </div>
                </div>



            {{-- </div> --}}
            <div class="col-3">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details_no project_cards_height">
                            <h5>Balance PO</h5>
                            <h2>PKR {{number_format($invoices->po_balance)}}</h2>
                            <br/>
                            <h5>Invoices</h5>
                            <h2>PKR {{number_format($invoices->total_after_deductions)}}</h2>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details_no project_cards_height">
                            <h5>Start Date</h5>
                            <h3>{{ date('d-M-Y',strtotime($project->project_start_date)) }}</h3>
                            <br/>
                            <h5>End Date</h5>
                            <h3>{{ date('d-M-Y',strtotime($project->project_end_date))}}</h3>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Customer Project manager / Contact no</label>
                            <span>{{ $project->customer_project_manager_contact_no}} </span>
                        </div>
                        {{-- <div class="customer_details">
                            <label>Customer PM contact</label>
                            <span>{{ $project->customer_project_manager_name}} </span>
                        </div> --}}

                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Damcon Project Manager / Contact no</label>
                            <span>{{ $project->damcon_project_manager_name}} </span>
                        </div>
                        {{-- <div class="customer_details">
                            <label>Damcco PM Contact</label>
                            <span>{{ $project->damcon_project_manager_contact_no}} </span>
                        </div> --}}

                    </div>
                </div>
            </div>


            <div class="col-12 mb-3 mt-2" style="display:flex;flex-wrap:wrap;">

                    <a href="{{ route('damconassets.index',['project_id'=>encrypt($project->id)]) }}" class="col-2 mb-1 project_tiles"  target="_blank" >Project Assets ({{number_format($totalAssets)}}) </a>

                    <a href="{{ route('projectincome.index',['project_id'=>encrypt($project->id)]) }}" class="col-2 mb-1 project_tiles" target="_blank" >Project Income  ({{number_format($totalProjectIncome)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project Payments  ({{number_format($totalProjectPayments)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project Issued Items Expense  ({{number_format($items->total_cost)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project HR Expense  ({{number_format($advancesHrExpense)}})</a>

              {{-- second row --}}

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project Fuel Expense  ({{number_format($fuelConsumption)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project Rental Expense  ({{number_format($totalRentalAmount)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Asset Maintenance Expense ({{number_format($assetMainteanceExpense)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >Project Advances ({{number_format($advancesHrPayment)}})</a>

                    <a href="#" class="col-2 mb-1 project_tiles" target="_blank" >ROI Expense ({{number_format($investorPayment)}})</a>

            </div>




                  <div class="col-6 d-flex">
                    <div class="card mb-4">
                        <div class="card-body ">
                            <div class="card-text">
                                <h4>Recent Invoices</h4><br/>
                                <div class="customer_projects">
                                    <table class="table table-striped table-bordered project_customer_invoice_table" id="project_customer_invoice_table">
                                        <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>Date of Invoicing</th>
                                            <th>Title</th>
                                            <th>invoice number</th>
                                            <th>customer name</th>
                                            <th>region</th>
                                            <th>po balance</th>
                                            <th>status</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-6 d-flex">
                    <div class="card mb-4 ">
                        <div class="card-body ">
                            <div class="card-text">
                                <h4>Recent Payments</h4><br/>
                                <div class="customer_projects">
                                    <table class="table table-striped table-bordered project_customer_payment_table" id="project_customer_payment_table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date of Payment</th>
                                            <th>Title</th>
                                            <th>Receiver Bank</th>
                                            <th>Amount</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                  </div>



                <div class="col-12">
                    <a class="btn btn-danger mb-1" onclick="deleteProject({{$project->id}})"
                         style="float:right;margin-left:10px;">Delete</i>
                    </a>
                    <a class="btn btn-primary mb-1" href="{{route('projectmanagement.edit',encrypt($project->id))}}" style="float:right;">Edit</a>
                </div>

    </div>

    {{-- toast --}}

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
        $(function(){
            var table = $('.project_customer_invoice_table').DataTable({
                "drawCallback": function( settings ) {
                    //Load Icons
                    feather.replace();
                    //Load CheckBoxs
                    $('.item_check').on('change', function(e) {
                        if($(this).is(':checked'))
                        {
                            $(this).prop('checked', true);
                            $(this).parent().parent().addClass('deleted');

                        } else {
                            $(this).prop('checked',false);
                            $(this).parent().parent().removeClass('deleted');
                        }
                    });
                },

                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         title: "Customer Invoice",
                //         className: 'btn btn-primary',
                //         exportOptions: {
                //             columns: [  1, 2, 3, 4,5]
                //         },
                //         filename:"Leaves Data",
                //     },
                //     {
                //         extend: 'pdfHtml5',
                //         title: 'Customer Invoice',
                //         className: 'btn btn-danger',
                //         exportOptions: {
                //             columns: [  1, 2, 3, 4, 5 ]
                //         },
                //         filename:"Leaves Data",
                //     }
                // ],
                scrollX: true,
                // scrollY: "200px",
                processing: true,
                serverSide: true,
                ajax: "{{ route('project_invoices', $project->id) }}",
                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'date_of_invoicing', name: 'date_of_invoicing'},
                    {data: 'title', name: 'title'},
                    {data: 'invoice_number', name: 'invoice_number'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'region', name: 'region'},
                    {data: 'po_balance', name: 'po_balance'},
                    {data: 'status', name: 'status'},
                ],
            });

        });

        $(function(){
            var table = $('.project_customer_payment_table').DataTable({
                "drawCallback": function( settings ) {
                    //Load Icons
                    feather.replace();
                    //Load CheckBoxs
                    $('.item_check').on('change', function(e) {
                        if($(this).is(':checked'))
                        {
                            $(this).prop('checked', true);
                            $(this).parent().parent().addClass('deleted');

                        } else {
                            $(this).prop('checked',false);
                            $(this).parent().parent().removeClass('deleted');
                        }
                    });
                },

                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         title: "Customer Invoice",
                //         className: 'btn btn-primary',
                //         exportOptions: {
                //             columns: [  1, 2, 3, 4,5]
                //         },
                //         filename:"Leaves Data",
                //     },
                //     {
                //         extend: 'pdfHtml5',
                //         title: 'Customer Invoice',
                //         className: 'btn btn-danger',
                //         exportOptions: {
                //             columns: [  1, 2, 3, 4, 5 ]
                //         },
                //         filename:"Leaves Data",
                //     }
                // ],
                scrollX: true,
                scrollY: "300px",

                processing: true,
                serverSide: true,
                ajax: "{{ route('project_incomes', $project->id) }}",
                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'cheque_receving_date', name: 'cheque_receving_date'},
                    {data: 'title', name: 'title'},
                    {data: 'received_cheque_bank', name: 'received_cheque_bank'},
                    {data: 'cheque_amount', name: 'cheque_amount'}]

            });

        });

        function deleteProject(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this project",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {

                if (willDelete) {
                    $.ajax({
                        url:'{{route('projectmanagement.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {

                                swal(data.message, {
                                icon: "success",
                                });

                                let url = "{{ route('projectmanagement.index') }}";

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


        function statusChange($id){

            $.ajax({
            url:'{{ route('project_status_change')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":$id
            },
            method: 'post',
            success: function(data) {

                $('.toast-body').html(data.message);
                $('#status_toast').click();

            },
            error: function(data)
            {
                $('.toast-body').html(data.message);
                $('#status_toast').click();

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

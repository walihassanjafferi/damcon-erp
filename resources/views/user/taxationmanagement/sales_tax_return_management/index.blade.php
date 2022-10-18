@extends('layout.main')
@section('sales_tax_return_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Sales Tax Return Management</title>
@endsection
@section('content')
    @include('alert.alert')

    <style>
        .dt-buttons{
            display: flex;
            height: 38px;
        }
        .dt-buttons button{
            margin: 0px 4px;
        }
    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Sales Tax Return Management</h4>

            <a href="{{ route('sales_tax_return_management.create') }}" class="create-btn"><i data-feather='plus'></i> Add </a>

            <p class="card-text">
            </p>

            <table class="table table-striped table-bordered employees_tax_management_tabel" style="width:100%" id="employees_tax_management_tabel">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Tax Body</th>
                    <th>Taxation Month</th>
                    <th>Payable TaxBody (PKR)</th>
                    <th>Net Payable (PKR)</th>
                    <th>Manual Adjustments (PKR)</th>
                    <th>Amount (PKR)</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready( function () {

            var table = $('.employees_tax_management_tabel').DataTable({
                "drawCallback": function( settings ) {
                    //Load Icons
                    feather.replace();
                    //Load CheckBoxs
                    $('.order_check').on('change', function(e) {
                        if($(this).is(':checked'))
                        {
                            $(this).prop('checked', true);
                            $(this).parent().parent().addClass('deleted');

                        } else {
                            $(this).prop('checked',false);
                            $(this).parent().parent().removeClass('deleted');
                        }
                    });
                    $("#th_check_box").prop('checked',false);
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Sales Tax Return Management',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7]
                        },
                        filename:"Sales Tax Return Management Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Employees Tax Management',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7]
                        },
                        filename:"Sales Tax Return Management Data",
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('getAjaxSalestax') }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'tax_id', name: 'tax_id'},
                    {data: 'taxation_month', name: 'taxation_month'},
                    {data: 'payable_taxbody', name: 'payable_taxbody'},
                    {data: 'net_payable', name: 'net_payable'},
                    {data: 'manual_adjustments', name: 'manual_adjustments'},
                    {data: 'amount', name: 'amount'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ],
            });

            $('#employees_tax_management_tabel tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
            });



            //Add Delete Btn
            // $(".dt-buttons").prepend('<div class="input-group mb-3" style="width: 133px"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" id="th_check_box"></span> </div><a class="btn btn-danger waves-effect waves-float waves-light" onclick="DeleteOrders()">Delete</a></div>');

            //Check All Orders
            $('#th_check_box').on('click', function(e) {
                if($(this).is(':checked'))
                {
                    $(".order_check").prop('checked', true);
                    $(".order_check").parent().parent().addClass('deleted');

                } else {
                    $(".order_check").prop('checked',false);
                    $(".order_check").parent().parent().removeClass('deleted');
                }
            });
        });



        // Delete Single Order
        function deleteOrder(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Tax Body",
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
                                if(data.value == 1)
                                {
                                    $('.status_label_'+data.class+'_d').html('Active');
                                }
                                else{
                                    $('.status_label_'+data.class+'_d').html('Inactive');
                                }
                                $('#employees_tax_management_tabel').DataTable().row('.deleted').remove().draw( false );
                                $("#th_check_box").prop('checked',false);
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



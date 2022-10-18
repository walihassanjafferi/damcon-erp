@extends('layout.main')
@section('rentalpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  View Rental POs Management</title>
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
        #rental_pos_table thead tr th:nth-child(7) {
            display: none;
        }
        #rental_pos_table tbody tr td:nth-child(7) {
            display: none;
        }
    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Rental Purchase Orders Management</h4>

            <a href="{{ route('rentalpos.create') }}" class="create-btn"><i data-feather='plus'></i> Add Purchase Order</a>

            <p class="card-text">
            </p>

            <table class="table table-striped table-bordered rental_pos_table" style="width:100%" id="rental_pos_table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>PO No</th>
                    <th>Supplier Name </th>
                    <th>Project Name </th>
                    <th>Issue Date</th>
                    <th>Issue Date</th>
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

            var table = $('.rental_pos_table').DataTable({
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
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Rental Purchase Orders',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,6]
                        },
                        filename:"Rental Purchase Orders Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Rental Purchase Orders',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,6]
                        },
                        filename:"Rental Purchase Orders Data",
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('rentalpos_get_orders') }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'purchase_od_number', name: 'purchase_od_number'},
                    {data: 'supplier_name', name: 'supplier_name'},
                    {data: 'project_name', name: 'project_name'},
                    {data: 'issue_date', name: 'issue_date'},
                    {data: 'issue_date1', name: 'issue_date1'},

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ],
            });

            $('#rental_pos_table tbody').on( 'click', 'tr', function () {
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
                text: "Once deleted, you will not be able to recover this Rental Purchase Order",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url:'{{route('rentalpos.destroy','id')}}',
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
                                $('#rental_pos_table').DataTable().row('.deleted').remove().draw( false );
                            },
                            error: function(data)
                            {
                                alert('Error Failed');
                            }
                        });
                    }
                });
        }

        // Delete Bulk Orders
        function DeleteOrders(){
            var List_ID = [];

            $(".order_check").each(function( index ) {
                if($(this).is(':checked')){
                    List_ID.push($( this ).val());
                }else{
                }
            });

            if(List_ID.length>0){
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Rental Purchase Order",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'{{route('rentalpos_bulk_remove')}}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "order_list":List_ID
                                },
                                method: 'POST',
                                success: function(data) {
                                    swal(data.message, {
                                        icon: "success",
                                    });

                                    $(".deleted").each(function( index ) {
                                        $('#rental_pos_table').DataTable().row('.deleted').remove().draw(false);
                                    });
                                },
                                error: function(data)
                                {
                                    alert('Error Failed');
                                }
                            });
                        }
                    });
            }else {
                alert('Please select atleast one checkbox');
            }
        }
    </script>
@endsection


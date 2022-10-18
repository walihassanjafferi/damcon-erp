@extends('layout.main')
@section('fuel_consumption_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  View Fuel Consumption</title>
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
        .fuel_consumption thead tr th:nth-child(7) {
            display: none;
        }
        .fuel_consumption tbody tr td:nth-child(7) {
            display: none;
        }
    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Fuel Consumption</h4>

            <a href="{{ route('fuelconsumption.create') }}" class="create-btn"><i data-feather='plus'></i> Add Fuel Consumption</a>

            <p class="card-text">
            </p>

            <table class="table table-striped table-bordered fuel_consumption" style="width:100%" id="fuel_consumption">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Title PO </th>
                    <th>Fueling Item</th>
                    <th>Fuel Item ID</th>
                    <th>Supplier</th>
                    <th style="display:none;">Consumption Month</th>

                    <th>Consumption Month</th>

                    <th>QTY in lites</th>
                    <th>Rate of fuel/liter</th>

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

            var table = $('.fuel_consumption').DataTable({
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
                            title: 'Fuel Consumption',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [  1, 2, 3, 4,5,6,8,9]
                            },
                            filename:"Fuel Consumption Data",
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Fuel Consumption',
                            className: 'btn btn-danger',
                            exportOptions: {
                                columns: [  1, 2, 3, 4,5,6,8,9]
                            },
                            filename:"Fuel Consumption Data",
                        }
                    ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('getFuelConsumption') }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'rowid', name: 'rowid'},
                    {data: 'title_po', name: 'title_po'},
                    {data: 'fueling_item_code', name: 'fueling_item_code'},
                    {data: 'fueling_item_name', name: 'fueling_item_name'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'consumption_month1', name: 'consumption_month1'},
                    {data: 'consumption_month', name: 'consumption_month'},
                    {data: 'qty_in_liter', name: 'qty_in_liter'},
                    {data: 'rate_of_fuel', name: 'rate_of_fuel'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true, 
                        searchable: false
                    },
                    
                ],
            });



            // let column = table.column(6);
            // column.visible(false); 




            $('#fuel_consumption tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
            });



            //Add Delete Btn
            // $(".dt-buttons").prepend('<div class="input-group mb-3" style="width: 133px"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" id="th_check_box"></span> </div><a class="btn btn-danger waves-effect waves-float waves-light" onclick="DeleteFuelConsumption()">Delete</a></div>');

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
        function DeleteFuelConsumption(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Fuel Consumption",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url:'{{route('fuelconsumption.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id
                            },
                            method: 'DELETE',
                            success: function(data) {
                                swal(data.message, {
                                    icon: "success",
                                });
                                $('#fuel_consumption').DataTable().row('.deleted').remove().draw( false );
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
                    text: "Once deleted, you will not be able to recover this Customer Purchase Order",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'{{route('customerpos_bulk_remove')}}',
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
                                        $('#customer_pos_table').DataTable().row('.deleted').remove().draw(false);
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

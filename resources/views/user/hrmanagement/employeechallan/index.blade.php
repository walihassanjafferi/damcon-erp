@extends('layout.main')
@section('hr_emptrafficchalan-sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Employee Challan</title>
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
            <h4 class="card-title">Employee Challan</h4>

            <a href="{{ route('employeechallan.create') }}" class="create-btn"><i data-feather='plus'></i> Add </a>

            <p class="card-text">
            </p>

            <table class="table table-striped table-bordered employee_challan" style="width:100%" id="employee_challan">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Challan ID</th>
                    <th>Employee</th>
                    <th>Challan Date</th>
                    <th>Challan Amount (PKR)</th>
                    <th>Paid Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

       
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready( function () {

            var table = $('.employee_challan').DataTable({
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
                        title: 'Employees Challan',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6]
                        },
                        filename:"Employee Challan",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Employees Challan',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6]
                        },
                        filename:"Employees Challan",
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('employeechallan.index',['emp_id'=>$emp_id]) }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'challan_id', name: 'challan_id'},
                    {data: 'employee', name: 'employee'},
                    {data: 'challan_date', name: 'challan_date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'paid_date', name: 'paid_date'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ],
            });

            $('#employee_challan tbody').on( 'click', 'tr', function () {
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



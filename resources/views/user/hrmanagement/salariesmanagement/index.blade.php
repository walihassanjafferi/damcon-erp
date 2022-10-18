@extends('layout.main')
@section('hr_salary_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  View Employee Salary</title>
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
            <h4 class="card-title">Salaries Management</h4>

            <a href="{{ route('salary_management.create') }}" class="create-btn"><i data-feather='plus'></i> Add Salary</a>

            <p class="card-text">
            <table class="table table-striped table-bordered salary_table" style="width:100%" id="salary_table">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Payment ID</th>
                        <th>Month</th>
                        <th>Project</th>
                        <th>Amount (PKR)</th>
                        <th>Date</th>
                        <th>Bank</th>
                        <th style="width:100px;">Actions </th>
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

            var table = $('.salary_table').DataTable({
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Employee's Data",
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6]
                        },
                        filename:"Employee's Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Rental Items',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6]
                        },
                        filename:"Employee's Data",
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('getAjaxSalaries') }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'payment_id', name: 'payment_id'},
                    {data: 'salary_month', name: 'salary_month'},
                    {data: 'project', name: 'project'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'},
                    {data: 'bank_id', name: 'bank_id'},
                
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ],
            });


            $('#salary_table tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
            });

            //Add Delete Btn
            // $(".dt-buttons").prepend('<div class="input-group mb-3" style="width: 133px"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" id="th_check_box"></span> </div><a class="btn btn-danger waves-effect waves-float waves-light" onclick="DeleteItems()">Delete</a></div>');

            //Check All Orders
            $('#th_check_box').on('click', function(e) {
                if($(this).is(':checked'))
                {
                    $(".item_check").prop('checked', true);
                    $(".item_check").parent().parent().addClass('deleted');

                } else {
                    $(".item_check").prop('checked',false);
                    $(".item_check").parent().parent().removeClass('deleted');
                }
            });
        });

        function deleteItem(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Rental Item",
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
                                $('#employee_table').DataTable().row('.deleted').remove().draw( false );
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
        function DeleteItems(){
            var List_ID = [];

            $(".item_check").each(function( index ) {
                if($(this).is(':checked')){
                    List_ID.push($( this ).val());
                }else{
                }
            });

            if(List_ID.length>0){
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Rental Items",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'{{route('rentalitem_bulk_remove')}}',
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
                                        $('#employee_table').DataTable().row('.deleted').remove().draw(false);
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

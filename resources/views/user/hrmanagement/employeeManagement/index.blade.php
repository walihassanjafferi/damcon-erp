@extends('layout.main')
@section('hr_employee_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  View Employee</title>
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
            <h4 class="card-title">Employee</h4>

            <div class="col-12 d-flex justify-content-end pb-1 pr-0">
               <div class="col-2 text-right pr-0">

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    <i data-feather='upload'></i>
                    &nbsp;
                    Import Employee's
                </button>

                

               </div>
            </div>

            <a href="{{ route('createEmployee') }}" class="create-btn"><i data-feather='plus'></i> Add Employee</a>

            <p class="card-text">
            <table class="table table-striped table-bordered employee_table table-responsive" style="width:100%" id="employee_table">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Project</th>
                    <th>CNIC</th>
                    <th>Joining Date</th>
                    <th>Designation</th>
                    <th>Religion</th>
                    <th>Profile Complition</th>


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



     <!-- Vertical modal -->
     <div class="vertical-modal-ex">
    
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Import Employees</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form  method="post" action='{{ route('import_employees') }}' enctype="multipart/form-data" id="import_emp_form">
                            @csrf
                            <div class="form-group">
                                <input type="file" class="form-control" name="import_file" id="import_employee" accept=".xlsx, .xls" required />
                            </div>
                        </form>
                        <div class="col-6">
                            <a class="btn btn-secondary" href="{{ asset('/storage/sheet_imports/employee_sheet/employee_import.xlsx') }}" download>Download Import template &nbsp; <i data-feather='download'></i></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary import_employee">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical modal end-->





@endsection
@section('scripts')
    <script>
        $(document).ready( function () {

            var table = $('.employee_table').DataTable({
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
                        title: "Employee's",
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7,8,9]
                        },
                        filename:"Employee's Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: "Employee's",
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7,8,9]
                        },
                        filename:"Employee's Data",
                    }
                ],
                processing: true,
                serverSide: true,
                ajax: "{{ route('getAjaxEmployee') }}",
                columns: [
                    {data: 'checkbox', name: '#'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'employee_id', name: 'employee_id'},
                    {data: 'name', name: 'name'},
                    {data: 'project', name: 'project'},
                    {data: 'cnic', name: 'cnic'},
                    {data: 'joining_date', name: 'joining_date'},
                    {data: 'designation', name: 'designation'},
                    {data: 'religion', name: 'religion'},
                    {data: 'profile_complition', name: 'profile_complition'},


                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false
                    },
                ],
            });


            $('#employee_table tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
            });

            //Add Delete Btn
          //  $(".dt-buttons").prepend('<div class="input-group mb-3" style="width: 133px"><div class="input-group-prepend"><span class="input-group-text"><input type="checkbox" id="th_check_box"></span> </div><a class="btn btn-danger waves-effect waves-float waves-light" onclick="DeleteItems()">Delete</a></div>');

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


            // $( "#import_employee" ).change(function() {
            //     $('#import_emp_form').submit();
            // });

            $('.import_employee').click(function(){
                
                var file = $('.import_employee').val();
                
                if(file == null)
                {
                    alert('Please attach file!');
                }

                $('#import_emp_form').submit();

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

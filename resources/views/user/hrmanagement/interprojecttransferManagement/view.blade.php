@extends('layout.main')
@section('hr_interproject_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Inter Project Transfers</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('interproject-management.index') }} @endsection
@section('main_btn_text') All Inter Project Transfer @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h2>{{$interproject->emp_name}}</h2></div>   
            </div> --}}

            <div class="col-12">
                <div class="card mb-1">

                    <div class="card-body project_item_card">
                        <h5 class="mb-2">Employee Details</h5>
                        <div class="customer_status">

                        </div>
                        <div class="customer_details">
                            <label>Employee Cnic</label>
                            <span>{{ $employee->cnic }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Employee Name</label>
                            <span>{{ $employee->name }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Father Name</label>
                            <span>{{ $employee->father_name }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Joining Date</label>
                            <span>{{ $employee->joining_date }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6"
                            style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">All InterProject Transfer
                            Details</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped interproject_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CNIC</th>
                                    <th>Father</th>
                                    <th>Joining Date</th>
                                    <th>Basic Salary</th>
                                    <th>Region</th>
                                    <th>Location</th>
                                    <th>Previous Project</th>
                                    <th>New Project</th>
                                    <th>Reason of Transfer</th>
                                    <th>Actions</th>


                                </tr>
                            </thead>
                            @php $i = 0; @endphp
                            <tbody>
                                @foreach ($interprojects as $inc)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $inc->cnic }}</td>
                                        <td>{{ $inc->father_name }}</td>
                                        <td>{{ date('d-M-Y', strtotime($inc->joining_date)) }}</td>
                                        <td>{{ $inc->basic_salary }}</td>
                                        <td>{{ $inc->region }}</td>
                                        <td>{{ $inc->location }}</td>
                                        <td>{{ $inc->previousProject->name }}</td>
                                        <td>{{ $inc->newProject->name }}</td>
                                        <td>{{ $inc->reason_of_transfer }}</td>
                                        <td> <a href="{{ route('interproject-management.edit', encrypt($inc->id)) }}"><i
                                                    data-feather="edit" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="Edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script>
        function deleteProject(id) {
            var id = id;
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this BankAccount",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url: '{{ route('bankaccounts.destroy', 'id') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('bankaccounts.index') }}";

                                document.location.href = url;


                            },
                            error: function(data) {
                                alert('Error Failed');

                            }
                        });
                    }
                });
        }

        $(function(){
           
           $('.interproject_table').DataTable({
               dom: 'Bfrtip',
               buttons: [
               {
                   extend: 'excelHtml5',
                   title: 'Interproject  ',
                   className: 'btn btn-primary',
                   exportOptions: {
                       columns: [ 1, 2, 3, 4, 5, 6, 7 ,8 ,9 ]
                   },
                   filename:"Interproject Transfer Data",    
               },
               {
                   extend: 'pdfHtml5',
                   title: 'Interproject Transfers',
                   className: 'btn btn-danger',
                   exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7 ,8 ,9 ]
                   },
                   filename:"Interproject Transfer Data",       
               }
           ]
           });

        });

    </script>
@endsection

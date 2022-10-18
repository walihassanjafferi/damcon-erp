@extends('layout.main')
@section('project_siderbar') active @endsection
@section('title')
<title>Damcon ERP -  View Projects</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Projects</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>

        <a href="{{ route('projectmanagement.create') }}" class="create-btn"><i data-feather='plus'></i> Add Project</a>

        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="projects_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Customer</th>
                        <th>Damcon PM</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($projects as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->customer->name}}</td>
                            <td>{{$item->damcon_project_manager_name}}</td>
                            {{-- {{ \Carbon\Carbon::parse($row->posted_at)->diffForHumans() }} --}}

                            <td>{{ date('d-M-Y',strtotime($item->project_start_date)) }}</td>
                            <td>{{ date('d-M-Y',strtotime($item->project_end_date))}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{$item->status ? 'checked' : ''}} onclick="statusChange({{$item->id}});">
                                    <span class="slider round"></span>
                                </label><br/>
                                <label class="status_label_{{$item->id}}_d" style="text-align: center;font-weight:900;">{{$item->status ? 'Active' : 'Inactive'}}</label>

                            </td>


                            <td>
                                <a href="{{route('projectmanagement.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a>
                                &nbsp; &nbsp;
                                <a href="{{route('projectmanagement.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                           &nbsp; &nbsp;

                                <a onclick="deleteProject({{$item->id}})"
                                ><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                                    </a>

                            </td>
                        </tr>
                        <?php $increment++; ?>
                        @endforeach
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
            var table =  $('#projects_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Projects',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"Projects Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Projects',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"Projects Data",
                    }
                ]
            });


            $('#projects_table tbody').on( 'click', 'tr', function () {
                // if ( $(this).hasClass('deleted') ) {
                //     $(this).removeClass('deleted');
                // }
                // else {
                //     table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                //}
            } );


        } );

        function statusChange($id){

            $.ajax({
            url:'{{ route('project_status_change')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":$id
            },
            method: 'post',
            success: function(data) {

                if(data.value == 1)
                {
                  $('.status_label_'+data.class+'_d').html('Active');
                }
                else{
                    $('.status_label_'+data.class+'_d').html('Inactive');
                }

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

        function deleteProject(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Project",
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

                                if(data.value == 1)
                                {
                                    $('.status_label_'+data.class+'_d').html('Active');
                                }
                                else{
                                    $('.status_label_'+data.class+'_d').html('Inactive');
                                }


                            $('#projects_table').DataTable().row('.deleted').remove().draw( false );

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

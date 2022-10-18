@extends('layout.main')
@section('users_sidebar') active @endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Users</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
        <a href="{{ route('users.create') }}" class="create-btn">Create User</a>
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="users_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th> 
                        <th>Role</th>
                        <th>Status</th>
                        <th></th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->role->name}}</td>

                           
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{$item->status ? 'checked' : ''}} onclick="statusChange({{$item->id}});">
                                    <span class="slider round"></span>
                                </label>

                            </td>
                           
                      
                            <td>
                                <a href="{{route('users.edit',encrypt($item->id))}}"><i data-feather="edit"></i> Edit</a>
                         &nbsp; &nbsp; 
                                @if($item->role->name != 'Admin')
                                <a onclick="deleteUser({{$item->id}})"
                                ><i data-feather="delete"></i>
                                    Delete</a>
                                @endif   
                         
                            </td>
                        </tr>  
                        <?php $increment++; ?> 
                        @endforeach
                    </tbody>
              
            </table>
    </div>

    <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
        <div class="toast-header">
            <img src="../../../app-assets/images/logo/logo.png" class="mr-1" alt="Toast image" height="18" width="25" />
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
            var table =  $('#users_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Data export',
                        className: 'btn btn-primary'    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Data export',
                        className: 'btn btn-danger'    
                    }
                ]
            });


            $('#users_table tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
            } );


        } );

        function statusChange($id){
            
            $.ajax({
            url:'{{ route('user_status_change')}}',
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

        function deleteUser(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Customer",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('users.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#users_table').DataTable().row('.deleted').remove().draw( false );
                            
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
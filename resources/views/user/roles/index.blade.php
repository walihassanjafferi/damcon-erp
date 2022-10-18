@extends('layout.main')
@section('role_sidebar') active @endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Roles</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
        @can('manage-roles')
        <a href="{{ route('roles.create') }}" class="create-btn">Create Role</a>
        @endcan
        <p class="card-text">
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="role_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th></th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($roles as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            @can('manage-roles')
                            <td><a href="{{route('roles.edit',encrypt($item->id))}}"><i data-feather="edit"></i> Edit</a></td>
                            @endcan
                        </tr>  
                        @endforeach
                    </tbody>
              
            </table>
    </div>
</div>
            
             
 


@endsection
@section('scripts')
    <script>
        $(document).ready( function () {
            $('#role_table').DataTable({
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
                } );
    </script>
@endsection
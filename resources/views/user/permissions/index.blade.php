@extends('layout.main')
@section('permission_sidebar') active @endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Permission</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
        {{-- @can('create-permissions') --}}
         <a href="{{ route('permissions.create') }}" class="create-btn"> Create Permission</a>
        {{-- @endcan --}}
         <p class="card-text">
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="permission_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>slug</th>
                        <th></th>
                       
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($permissions as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->module->label}}</td>
                            {{-- @can('edit-permissions') --}}
                            <td><a href="{{route('permissions.edit',encrypt($item->id))}}"><i data-feather="edit"></i> Edit</a></td>
                            {{-- @endcan --}}
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
    $('#permission_table').DataTable({
        "drawCallback": function( settings ) {
        feather.replace();
    },
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
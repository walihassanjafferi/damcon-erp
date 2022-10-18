@extends('layout.main')
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Configurations</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
     
        <a href="{{ route('configurations.create') }}" class="create-btn">Create Configuration</a>
    
        <p class="card-text">
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="configuration_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value</th> 
                        <th>label</th> 
                        <th></th>
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($configurations as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->value}}</td>
                            <td>{{$item->label}}</td>
                            @can('manage-configurations')
                            <td><a href="{{route('configurations.edit',encrypt($item->id))}}"><i data-feather="edit"></i> Edit</a></td>
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
            $('#configuration_table').DataTable({
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
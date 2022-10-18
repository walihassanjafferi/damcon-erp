@extends('layout.main')
@section('hr_categories_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  View HR Categories</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">HR Categories</h4>
        
        <a href="{{ route('hrcategories.create') }}" class="create-btn"><i data-feather='plus'></i> Add HR Category</a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="categories_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name </th>
                        <th>Status</th>
                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($categories as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->category_name}}</td>
    
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{$item->status ? 'checked' : ''}} onclick="statusChange({{$item->id}});">
                                    <span class="slider round"></span>
                                </label><br/>
                                <label class="status_label_{{$item->id}}_d" style="text-align: center;font-weight:900;">{{$item->status ? 'Active' : 'Inactive'}}</label>

                            </td>
                           
                        
                            <td>
                                {{-- <a href="{{route('hrcategories.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a> --}}
                                {{-- &nbsp; &nbsp;  --}}
                                <a href="{{route('hrcategories.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                           &nbsp; &nbsp; 
                           
                               
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
            var table =  $('#categories_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'HR Categories',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3]
                        },
                        filename:"HR Categories Data",      
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'HR Categories',
                        className: 'btn btn-danger', 
                        exportOptions: {
                            columns: [ 0, 1, 2, 3]
                        },
                        filename:"HR Categories Data",       
                    }
                ]
            });


            $('#categories_table tbody').on( 'click', 'tr', function () {
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
            url:'{{ route('hrcategory_status_change')}}',
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


    </script>
@endsection
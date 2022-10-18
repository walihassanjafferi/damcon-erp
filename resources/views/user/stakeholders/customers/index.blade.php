@extends('layout.main')
@section('customer_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  Customers</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Customers</h4>
        {{-- <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div> --}}
        @can('manage-customers')
        <a href="{{ route('customers.create') }}" class="create-btn"><i data-feather='plus'></i> Add Customer</a>
        @endcan
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="customer_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>NTN</th> 
                        <th>STRN</th> 
                        <th>Status</th>
                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($customers as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->ntn_number}}</td>
                            <td>{{$item->strn_number}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{$item->status ? 'checked' : ''}} onclick="statusChange({{$item->id}});">
                                    <span class="slider round"></span>
                                </label><br/>
                                <label class="status_label_{{$item->id}}_d" style="text-align: center;font-weight:900;">{{$item->status ? 'Active' : 'Inactive'}}</label>
                            </td>
                           
                            @can('manage-customers')
                            <td>
                                <a href="{{route('customers.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a>
                                &nbsp; &nbsp; 

                                <a href="{{route('customers.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                            @endcan &nbsp; &nbsp; 
                            @can('manage-customers')
                                <a onclick="deleteCustomer({{$item->id}})"
                                ><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                                    </a>
                            @endcan
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
            var table =  $('#customer_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Customers',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Customers Data",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Customers',
                        className: 'btn btn-danger', 
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Customers Data",       
                    }
                ]
            });


            $('#customer_table tbody').on( 'click', 'tr', function () {
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
            url:'{{ route('customer_status_change')}}',
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

        function deleteCustomer(id){
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
                        url:'{{route('customers.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#customer_table').DataTable().row('.deleted').remove().draw( false );
                            
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
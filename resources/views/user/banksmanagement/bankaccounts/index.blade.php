@extends('layout.main')
@section('bank_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Bank Accounts</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Bank Accounts</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
      
        <a href="{{ route('bankaccounts.create') }}" class="create-btn"><i data-feather='plus'></i> Add Account </a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="bankaccounts_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bank Name</th>
                        <th>Account Title</th> 
                        <th>Account Number</th> 
                        <th>Balance (PKR)</th>
                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($bankaccounts as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->account_number}}</td>
                            <td>{{number_format($item->current_balance)}}</td>
                        
                            <td>
                                
                                <a href="{{route('bankaccounts.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a>
                           &nbsp; &nbsp; 
            
                                <a href="{{route('bankaccounts.edit',encrypt($item->id))}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i data-feather="edit"></i> </a>
                           &nbsp; &nbsp; 
                           
                                <a onclick="deleteProject({{$item->id}})"
                                    data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ><i data-feather="delete"></i>
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
            var table =  $('#bankaccounts_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
               
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Bank Accounts',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Accounts Data",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Bank Accounts',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Accounts Data",       
                    },
                    // {
                    //     extend: 'csv',
                    //     title: 'Data export',
                    //     className: 'btn btn-primary'    
                    // },
                ]
            });


            $('#bankaccounts_table tbody').on( 'click', 'tr', function () {
                // if ( $(this).hasClass('deleted') ) {
                //     $(this).removeClass('deleted');
                // }
                // else {
                //     table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                //}
            } );


        } );

      

        function deleteProject(id){
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
                        url:'{{route('bankaccounts.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#bankaccounts_table').DataTable().row('.deleted').remove().draw( false );
                            
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
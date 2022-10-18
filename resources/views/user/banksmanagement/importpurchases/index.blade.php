@extends('layout.main')
@section('import_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Import Purchases</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Import Purchases</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
      
        <a href="{{ route('importpurchases.create') }}" class="create-btn"><i data-feather='plus'></i> Add Import Purchase</a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="importpurchase_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Transaction Date</th> 
                        <th>Payment Sending bank</th>
                        <th>Send Amount (PKR)</th>
                        <th>Payment Receiving Bank</th> 
                        <th>Received Amount (PKR)</th> 
                        <th>Actions</th>
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($purchases as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{ucfirst($item->title)}}</td>
                            <td>{{ date('d-m-Y',strtotime($item->date)) }}</td> 
                            <td>{{$item->senderBank->name}}</td>
                            <td> {{number_format($item->sending_amount,2)}}</td>  
                            <td>{{$item->receiverBank->name}}</td> 
                            <td> {{number_format($item->cash_receiving_amount,2)}}</td>  
                            <td>
                                <a href="{{route('importpurchases.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a>
                                &nbsp; &nbsp; 

                                <a href="{{route('importpurchases.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                                &nbsp; &nbsp; 
                           
                                <a onclick="deleteImport({{$item->id}})"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
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
            var table =  $('#importpurchase_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Import Purchase',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"importpurchase Data",       
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Import Purchase',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"importpurchase Data",       
                    },
                    // {
                    //     extend: 'csv',
                    //     title: 'Data export',
                    //     className: 'btn btn-primary'    
                    // },
                ]
            });


            $('#importpurchase_table tbody').on( 'click', 'tr', function () {
                // if ( $(this).hasClass('deleted') ) {
                //     $(this).removeClass('deleted');
                // }
                // else {
                //     table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                //}
            } );


        } );

      

        function deleteImport(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Import-Purchase",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('importpurchases.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#importpurchase_table').DataTable().row('.deleted').remove().draw( false );
                            
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
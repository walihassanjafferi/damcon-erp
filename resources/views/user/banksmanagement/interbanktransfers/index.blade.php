@extends('layout.main')
@section('interbank_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Interbank transfers</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Inter-Bank Transfer</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
      
        <a href="{{ route('interbanktransfer.create') }}" class="create-btn"><i data-feather='plus'></i> Add transfer</a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="intertransfer_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th style="display: none;">Transaction Date</th>
                        <th>Transaction Date</th> 
                        <th>Cheque no</th> 
                        <th>Sender bank</th>
                        <th>Receiver bank</th> 
                        <th>Amount (PKR)</th> 
                        <th>Actions</th>
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($transfers as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->title_of_transfer}}</td>
                            <td style="display: none;">{{  $item->transaction_date }}</td>
                            <td>{{ isset($item->transaction_date) ?  date('d-M-Y',strtotime($item->transaction_date)) : '' }}</td>
                            <td>{{$item->cheque_no ? $item->cheque_no : 'NULL' }}</td>   
                            <td>{{$item->sender_bankaccount->name}}</td>
                            <td>{{$item->receiver_bankaccount->name}}</td>
                            <td> {{number_format($item->amount)}}</td>   
                        
                            <td>
                                <a href="{{route('interbanktransfer.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i> </a>
                                &nbsp;

                                <a href="{{route('interbanktransfer.edit',encrypt($item->id))}}"><i data-toggle="tooltip" data-placement="top" data-original-title="Edit" data-feather="edit"></i> </a>
                           &nbsp; 
                           
                                <a onclick="deleteTransfer({{$item->id}})"
                                ><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i></a>
                          
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
            var table =  $('#intertransfer_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Inter-Bank Transfers',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4,5,6,7]
                        },
                        filename:"Inter-Bank Transfers",     
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Inter-Bank Transfers',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4,5,6,7]
                        },
                        filename:"Inter-Bank Transfers",      
                    },
                    // {
                    //     extend: 'csv',
                    //     title: 'Data export',
                    //     className: 'btn btn-primary'    
                    // },
                ]
            });


            $('#intertransfer_table tbody').on( 'click', 'tr', function () {
                // if ( $(this).hasClass('deleted') ) {
                //     $(this).removeClass('deleted');
                // }
                // else {
                //     table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                //}
            } );


        } );

      

        function deleteTransfer(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Inter-Transfer",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('interbanktransfer.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#intertransfer_table').DataTable().row('.deleted').remove().draw( false );
                            
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
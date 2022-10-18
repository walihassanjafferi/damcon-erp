@extends('layout.main')
@section('maintenanace_item_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  All Maintenance Items</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Maintenance Item Inventory</h4>
        
        <a href="{{ route('maintenanaceiteminventory.create') }}" class="create-btn"><i data-feather='plus'></i> Add Item</a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="maintenanace_item_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item code</th>
                        <th>Item name</th> 
                        <th>Date</th>
                        <th style="display: none;">Date</th>
                        <th>Brand</th> 
                        <th>Balance QTY</th>
                        <th>Balance Cost</th>
                        <th style="width:100px;">Actions </th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($maintenanace_items as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->item_code}}</td>
                            <td>{{$item->item_name}}</td>
                            <td>{{ isset($item->date_of_addition) ?  date('d-m-Y',strtotime($item->date_of_addition)) : ''}}</td>
                            <td style="display: none;">{{$item->date_of_addition}}</td>
                            <td>{{$item->item_brand}}</td>
                            <td>{{$item->current_balance_item}}</td>
                            <td>{{number_format($item->current_stock_cost)}}</td>
                            <td>
                                <a href="{{route('maintenanaceiteminventory.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>
                                &nbsp; &nbsp; 
                                <a href="{{route('maintenanaceiteminventory.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                                 &nbsp; &nbsp; 
                                    <a  onclick="deleteMaintenanaceitem({{$item->id}})"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
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
            var table =  $('#maintenanace_item_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Maintenanace items Inventory',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4, 5, 6,7]
                        },
                        filename:"Maintenanace Data",      
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Maintenanace items Inventory',
                        className: 'btn btn-danger', 
                        exportOptions: {
                            columns: [ 0, 1, 2, 4, 5, 6,7]
                        },
                        filename:"Maintenanace Items Data",       
                    }
                ]
            });


            $('#maintenanace_item_table tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
               
            } );
        });


        function deleteMaintenanaceitem(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Maintenanace Item",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('maintenanaceiteminventory.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#maintenanace_item_table').DataTable().row('.deleted').remove().draw( false );
                            
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
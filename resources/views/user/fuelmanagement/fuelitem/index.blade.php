@extends('layout.main')
@section('fuel_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Fuel Items</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Fuel items</h4>
        
        <a href="{{ route('fuelitem.create') }}" class="create-btn"><i data-feather='plus'></i> Add Item</a>
    
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="fuel_item_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item code</th>
                        <th>Item name</th> 
                        <th>Fuel Type</th> 
                        <th>Supplier</th> 
                        <th>Balance QTY</th>
                        <th>Balance Cost</th>
                        <th style="width:120px;">Actions </th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($fuel_item as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->item_code}}</td>
                            <td>{{$item->item_name}}</td>
                            <td>{{$item->fuel_type}}</td>
                            <td>
                                {{$item->supplier->name}}
                            </td>
                            <td>{{$item->current_balance_item}}</td>
                            <td>{{number_format($item->current_stock_cost)}}</td>
                            <td>
                                <a href="{{route('fuelitem.show',encrypt($item->id))}}" ><i data-feather="eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i></a>
                                &nbsp; &nbsp; 
                                <a href="{{route('fuelitem.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                                 &nbsp; &nbsp; 
                                <a  onclick="deleteFuel({{$item->id}})"><i data-feather="delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
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
            var table =  $('#fuel_item_table').DataTable({
                "drawCallback": function( settings ) {
                 feather.replace();
                 },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Projects items Inventory',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"Categories Data",      
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Projects items Inventory',
                        className: 'btn btn-danger', 
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6]
                        },
                        filename:"Project Items Data",       
                    }
                ]
            });


            $('#fuel_item_table tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('deleted') ) {
                    $(this).removeClass('deleted');
                }
                else {
                    table.$('tr.deleted').removeClass('deleted');
                    $(this).addClass('deleted');
                }
               
            } );
        });


        function deleteFuel(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Fuel Item",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('fuelitem.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#fuel_item_table').DataTable().row('.deleted').remove().draw( false );
                            
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
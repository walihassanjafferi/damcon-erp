@extends('layout.main')
@section('investor_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  VIIEW Investors</title>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Investors</h4>
        <div class="card-subtitle text-muted mb-1" style="display: inline;">Export options</div>
        @can('manage-investors')
        <a href="{{ route('investors.create') }}" class="create-btn"><i data-feather='plus'></i> Add Investor</a>
        @endcan
        <p class="card-text">
            <?php $increment = 1; ?>
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="investor_table">
                <thead>
                    <tr style="text-align: center"><th colspan="6">Investors</th></tr>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Contact no</th> 
                        <th>Status</th>
                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>
                        @foreach ($investors as $item)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>{{$item->name}}</td>
                            <td><p>{{$item->description}}</td>
                            <td>{{$item->contact_no}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" {{$item->status ? 'checked' : ''}} onclick="statusChange({{$item->id}});">
                                    <span class="slider round"></span>
                                </label>
                                <label class="status_label_{{$item->id}}_d" style="text-align: center;font-weight:900;">{{$item->status ? 'Active' : 'Inactive'}}</label>

                            </td>
                           
                            <td>
                                <a href="{{route('investors.show',encrypt($item->id))}}" data-toggle="tooltip" data-placement="top" data-original-title="View" ><i data-feather="eye"></i> </a>
                                &nbsp; &nbsp; 
                                <a href="{{route('investors.edit',encrypt($item->id))}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i data-feather="edit" ></i> </a>
                            &nbsp; &nbsp; 
                        
                                <a onclick="deleteInvestor({{$item->id}})"
                                    data-toggle="tooltip" data-placement="top" data-original-title="Delete" ><i data-feather="delete"></i></a>
                           
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
            var table = $('#investor_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Investors',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Investors Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Investors',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        },
                        filename:"Investors Data",
                    }
                ]
            });

            $('#investor_table tbody').on( 'click', 'tr', function () {
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
            url:'{{ route('investors_status_change')}}',
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
                $('#status_label').html('Inactive');
                $('.toast-body').html(data.message);
                $('#status_toast').click();
                
            }
            });

        }


        function deleteInvestor(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Investor",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('investors.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            
                            $('#investor_table').DataTable().row('.deleted').remove().draw( false );
                            
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
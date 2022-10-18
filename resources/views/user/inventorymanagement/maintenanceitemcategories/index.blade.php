@extends('layout.main')
@php $category_type = request()->get('category_level'); @endphp
@if($category_type == 'parent-category')
@section('maintenanacecategory_sidebar_parent') active @endsection
@elseif($category_type == 'sub-category')
@section('maintenanacecategory_sidebar_child') active @endsection
@endif
@section('title')
<title>Damcon ERP - View Categories</title>
@endsection
@section('css')
    <style>
        .edit_category{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
@include('alert.alert')
<div class="card mb-4">
    <div class="card-body">
            <h4 class="card-title">Maintenance Categories</h4>
        
        <a href="{{ route('itemscategories.create') }}/?module_name=maintenance_item" class="create-btn"><i data-feather='plus'></i> Add Category</a>

            @php $category_type = request()->get('category_level'); @endphp


            <?php $increment = 1; ?>
            @if($category_type == 'parent-category')
            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="categories_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catgory Type</th>
                        <th>Name (Sub)</th>
                        <th>Main Catgory</th> 
                        <th>Parent Catgory</th>
                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>

                        @foreach ($parent_categories as $val)
                           <tr>
                            <td>{{$increment}}</td>
                            <td>Parent</td>
                            <td>{{$val->category_name}}</td>
                            <td></td>
                            <td><span></span></td>
                            {{-- <td><span></span></td> --}}
                            {{-- <td>
                                <a href="{{route('edit_Child_category',encrypt($val->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                           &nbsp; &nbsp; 
                            </td> --}}
                            <td>
                                <span class="edit_category" data-category_id="{{$val->id}}" data-category_name="{{$val->category_name}}" data-type="parent" data-module_name="{{$val->module_name}}">
                                    <i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                                </span>
                            </td>
                           
                            @php $increment++ @endphp
                            </tr>     
                        @endforeach

                        {{-- main categories --}}

                        @foreach ($main_categories as $val)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>Main</td>
                            <td>{{$val->main_category}}</td>
                            <td><span>{{$val->parent_category}}</span></td>
                            <td><span style="color:red;"></span></td>
                            {{-- <td>
                                <a href="{{route('edit_Child_category',encrypt($val->main_id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                            &nbsp; &nbsp; 
                            </td> --}}
                            <td>
                                <span class="edit_category" data-type="main" data-parent_id="{{$val->parent_id}}" data-category_id="{{$val->main_id}}" data-category_name="{{$val->main_category}}" data-module_name="{{$val->module_name}}">
                                    <i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                                </span>
                            </td>
                            @php $increment++ @endphp
                         </tr>     
                        @endforeach

                        {{-- sub categories --}}


                        @foreach ($sub_categories as $val)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>Sub</td>
                            <td>{{$val->sub_category}}</td>
                            <td><span>{{$val->main_category}}</span></td>
                            <td><span >{{$val->parent_category}}</span></td>
                            {{-- <td><span >{{$val->main_category}}</span></td> --}}

                            {{-- <td>
                                <a href="{{route('edit_Child_category',encrypt($val->main_id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                            &nbsp; &nbsp; 
                            </td> --}}

                            <td>
                                <span class="edit_category" data-type="sub" data-parent_id="{{$val->parent_id}}" data-main_id="{{$val->main_id}}" data-category_name="{{$val->sub_category}}" data-category_id="{{$val->sub_id}}" data-module_name="{{$val->module_name}}">
                                    <i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                                </span>
                            </td>
                            @php $increment++ @endphp
                         </tr>     
                        @endforeach


                        {{-- SUB SUB CATEGORIES --}}

                        {{-- @foreach ($sub_categories as $val)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>Sub Sub</td>
                            <td>{{$val->sub_category}}</td>
                            <td><span>{{$val->main_category}}</span></td>
                            <td><span >{{$val->parent_category}}</span></td>
                            
                            @php $increment++ @endphp
                         </tr>     
                        @endforeach --}}

                        


                
                    </tbody>
            </table>

            @elseif($category_type == 'sub-category')

            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="categories_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catgory Type</th>
                        <th>Name (Sub-Sub)</th>
                        <th>Sub Catgory</th> 
                        <th>Main Catgory</th> 
                        <th>Parent</th> 

                        <th>Actions</th> 
                    </tr>
                </thead>   
                    <tbody>

                        {{-- SUB SUB CATEGORIES --}}

                        @foreach ($sub_sub_categories as $val)
                        <tr>
                            <td>{{$increment}}</td>
                            <td>Sub-Sub</td>
                            <td>{{$val->sub_sub_name}}</td>
                            <td>{{$val->sub_category}}</td>
                            <td><span>{{$val->main_category}}</span></td>
                            <td><span >{{$val->parent_category}}</span></td>

                            <td>
                                &nbsp;&nbsp;
                                <span class="edit_category" data-type="sub_sub" data-parent_id="{{$val->parent_id}}" data-main_id="{{$val->main_id}}" data-category_name="{{$val->sub_sub_name}}" data-category_id="{{$val->sub_sub_id}}" data-module_name="{{$val->module_name}}" data-sub_id={{$val->sub_id}}>
                                    <i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                                </span>
                            </td>


                            @php $increment++ @endphp
                         </tr>     
                        @endforeach

                
                    </tbody>
            </table>
            @endif


    </div>

    {{-- Model for parent edit --}}
    <div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

                <form method="post" action="#">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                         
                            <div class="col-md-6 col-12 parent_categories">
                                <div class="form-group">
                                    <label>Select Parent Category</label>
                                    <select class="form-control select2 parent_Category" name="parent_category_id">
                                        @foreach ($parent_categories as $val)
                                        <option value="{{$val->id}}">{{$val->category_name}}</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>


                            <div class="col-md-6 col-12 main_categories">
                                <div class="form-group">
                                    <label>Select Main Category</label>
                                    <select class="form-control select2 main_category" name="main_category_id">
                                        @foreach ($main_categories as $val)
                                        <option value="{{$val->main_id}}">{{$val->main_category}}</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>


                            <div class="col-md-6 col-12 sub_categories">
                                <div class="form-group">
                                    <label>Select Sub Category</label>
                                    <select class="form-control select2 sub_category" name="sub_category_id">
                                        @foreach ($sub_categories as $val)
                                        <option value="{{$val->sub_id}}">{{$val->sub_category}}</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>


                


                            <input type="hidden" name="category_id" class="category_id" />
                            <div class="col-md-6 col-12 parent_category_value">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="category_name" class="form-control category_name" />  
                                </div>
                            </div>




                        </div>
                      
                        <input type="text" name="category_type" class="category_type" hidden /> 
                        <input type="text" name="module_type" class="module_type" hidden /> 

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            
            
            
        </div>
        </div>
    </div>
    {{-- Model for parent edit --}}






    {{-- <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
        <div class="toast-header">
            <img src="{{ asset('app-assets/images/ico/favicon.png') }}" class="mr-1" alt="Toast image" height="22" width="24" />
            <strong class="mr-auto">Damcon ERP</strong>
            <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body"></div>
    </div>
    <button class="btn btn-outline-primary toast-basic-toggler mt-2"  id="status_toast" hidden>Toast</button> --}}
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
                        title: 'Projects',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Categories Data",      
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Categories',
                        className: 'btn btn-danger', 
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4]
                        },
                        filename:"Categories Data",       
                    }
                ]
            });


            // $('#categories_table tbody').on( 'click', 'tr', function () {
              
            //         $(this).addClass('deleted');
               
            // } );


            // edit parent modal script

            $(document).on("click",".edit_category",function(e){
                var category_id = $(this).data('category_id');
                var category_name = $(this).data('category_name');
                var category_type = $(this).data('type');
                var module_type = $(this).data('module_name');


                if(category_type == "parent")
                {
                    $('.parent_categories').hide().prop('disabled','true')
                    $('.main_categories').hide().prop('disabled','true')
                    $('.sub_categories').hide().prop('disabled','true') 

                }
                else if(category_type == "main")
                {
                    $('.parent_categories').show().prop('disabled','false')
                    $('.main_categories').hide().prop('disabled','true')
                    $('.sub_categories').hide().prop('disabled','true') 

                    $("[name='parent_category_id']").val($(this).data('parent_id')).change();
                }
                else if(category_type == "sub")
                {
                    $('.parent_categories').show().prop('disabled','false')
                    $('.main_categories').show().prop('disabled','false')
                    $('.sub_categories').hide().prop('disabled','true') 
                    
                    $("[name='parent_category_id']").val($(this).data('parent_id')).change();
                    $("[name='main_category_id']").val($(this).data('main_id')).change();

                }
                else if(category_type == "sub_sub")
                {
                    $('.parent_categories').show().prop('disabled','false')
                    $('.main_categories').show().prop('disabled','false')
                    $('.sub_categories').show().prop('disabled','false') 
                    
                    $("[name='parent_category_id']").val($(this).data('parent_id')).change();
                    $("[name='main_category_id']").val($(this).data('main_id')).change();
                    $("[name='sub_category_id']").val($(this).data('sub_id')).change();

                }

                $('.category_name').val(category_name);
                $('.category_type').val(category_type);
                $('.category_id').val(category_id);
                $('.module_type').val(module_type);

                $('#editmodel').modal('show'); 
            });


            // edit parent modal script


        });

        // function statusChange($id){
            
        //     $.ajax({
        //     url:'{{ route('category_status_change')}}',
        //     data: {
        //         "_token": "{{ csrf_token() }}",
        //         "id":$id
        //     },
        //     method: 'post',
        //     success: function(data) {

        //         if(data.value == 1)
        //         {  
        //           $('.status_label_'+data.class+'_d').html('Active');  
        //         }
        //         else{
        //             $('.status_label_'+data.class+'_d').html('Inactive');
        //         }

        //         $('.toast-body').html(data.message);
        //         $('#status_toast').click();
           
        //     },
        //     error: function(data)
        //     {    
        //         $('.toast-body').html(data.message);
        //         $('#status_toast').click();
                
        //     }
        //     });

        // }

        // function deleteProject(id){
        //     var id = id;
        //     swal({
        //         title: "Are you sure?",
        //         text: "Once deleted, you will not be able to recover this Project",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //         })
        //     .then((willDelete) => {
                
        //         if (willDelete) {
        //             $.ajax({
        //                 url:'{{route('categories.destroy','id')}}',
        //                 data: {
        //                     "_token": "{{ csrf_token() }}",
        //                     "id":id

        //                 },
        //                 method: 'DELETE',
        //                 success: function(data) {
                        
        //                         swal(data.message, {
        //                         icon: "success",
        //                         });

        //                         if(data.value == 1)
        //                         {  
        //                             $('.status_label_'+data.class+'_d').html('Active');  
        //                         }
        //                         else{
        //                             $('.status_label_'+data.class+'_d').html('Inactive');
        //                         }    
                            
                            
        //                     $('#categories_table').DataTable().row('.deleted').remove().draw( false );
                            
        //                 },
        //                 error: function(data)
        //                 {
                           
        //                      alert('Error Failed');
                                
        //                 }
        //             }); 
        //         }   
        //     });   
           
        // }

    </script>
@endsection
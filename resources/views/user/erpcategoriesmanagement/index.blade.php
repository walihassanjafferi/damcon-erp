@extends('layout.main')
@section('category_sidebar') active @endsection
@section('title')
<title>View Categories</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('categories.index')}} @endsection
@section('main_btn_text') All Categories @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        @include('alert.alert')
        <div class="row">
            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_status">
                            <h4>Category Details</h4>    
                            <a href="{{ route('categories.create') }}" class="create-btn"><i data-feather='plus'></i> Add Category</a>
                            <br/>
                        </div>
                        <br/>
                            
                            <?php $increment = 1; ?>
                            <table class="table table-striped table-bordered custom-data-table" style="width:100%" id="categories_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Module Name</th>
                                        <th>Catgory Type</th>
                                        <th>Name</th>
                                        <th>Main Category </th>
                                        <th>Parent Catgory</th>

                                        <th>Actions</th> 
                                    </tr>
                                </thead>   
                                    <tbody>
                                        @foreach ($parent_categories as $val)
                                       
                                        <tr>
                                            <td>{{$increment}}</td>
                                            <td>{{ucfirst($val->module_name)}}</td>
                                            <td>Parent</td>
                                            <td>{{$val->category_name}}</td>

                                            <td></td>

                                            <td></td>
                                            <td>
                                                {{-- <a href="{{route('edit_Child_category',encrypt($val->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a> --}}
                                                &nbsp; &nbsp; 
                                                <span class="edit_category"  data-module_name="{{$val->module_name}}" data-category_id="{{$val->id}}" data-category_name="{{$val->category_name}}" data-category_type="parent" >
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
                                            <td>{{ucfirst($val->module_name)}}</td>
                                            <td>Main</td>
                                            <td>{{$val->main_category}}</td>
                                            <td><span>{{$val->parent_category}}</span></td>
                                            {{-- <td><span style="color:red;"></span></td> --}}
                                            {{-- <td>
                                                <a href="{{route('edit_Child_category',encrypt($val->main_id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                                            &nbsp; &nbsp; 
                                            </td> --}}
                                            <td></td>
                                            <td>
                                                &nbsp; &nbsp; 
                                                <span class="edit_maincategory"  data-module_name="{{$val->module_name}}" data-parent_id="{{$val->parent_id}}" data-main_id ="{{$val->main_id}}" data-category_name="{{$val->main_category}}" data-category_type="main" >
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
                                            <td>{{$val->module_name}}</td>
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

                                
                                    </tbody>
                            </table>
                    </div>
                </div>
            </div>




    
          
                    
          
               
               
        </div>


        {{-- edit Parent modal --}}
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                    <form method="post" action="{{ route('updateCatogories')}}">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 col-12 module_type">
                                    <div class="form-group">
                                        <label>Select Module</label>
                                        <select class="form-control select2 module_name" name="module_name">
                                            <option value="bank_payments">Bank Payments</option>
                                            <option value="security_bid_bond">Security/Bid Bond Payments</option>
                                            <option value="mic_income">Misc. Income Management</option>
                                        </select>
                                    
                                    </div>
                                </div>
                                <input type="hidden" name="parent_category_id" class="parent_category_id" />
                                <div class="col-md-6 col-12 parent_category_value">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="parent_category" class="form-control parent_category_name" />  
                                    </div>
                                </div>

                            </div>
                          
                        <input type="text" name="category_type" hidden /> 
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                
                
                
            </div>
            </div>
        </div>
        {{-- edit Parent modal --}}

         {{-- edit Child modal --}}
         <div class="modal fade" id="editmainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            
                    <form method="post" action="{{ route('updateCatogories')}}">

                     
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-12 module_type">
                                    <div class="form-group">
                                        <label>Select Module</label>
                                        <select class="form-control select2 module_name" name="module_name">
                                            <option value="bank_payments">Bank Payments</option>
                                            <option value="security_bid_bond">Security/Bid Bond Payments</option>
                                            <option value="mic_income">Misc. Income Management</option>
                                        </select>
                                    
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 module_type">
                                    <div class="form-group">
                                        <label>Select Parent Category</label>
                                        <select class="form-control select2 parent_Category" name="parent_Category_id">
                                            @foreach ($main_categories as $val)
                                            <option value="{{$val->parent_id}}">{{$val->parent_category}}</option>
                                            @endforeach
                                        </select>
                                    
                                    </div>
                                </div>
                            
                                <input type="hidden" name="sub_category_id" class="sub_category_id" />
                                
                                <div class="col-md-6 col-12 parent_category_value">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="sub_category_name" class="form-control sub_category_name" />  
                                    </div>
                                </div>

                            </div>

                        <input type="text" name="category_type" hidden /> 
                          
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                
             
                
            </div>
            </div>
        </div>
        {{-- edit modal --}}
    </div>


@endsection

@section('scripts')
<script>
    
    $(function(){

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



            $(document).on("click",".edit_category",function(e){

                var module_name = $(this).data('module_name');
                var category_type = $(this).data('category_type');
                var category_id = $(this).data('category_id');
                var category_name = $(this).data('category_name');

                console.log(category_name);


                $('.module_name').val(module_name).change();
                $('.parent_category_id').val(category_id);
                $('.parent_category_name').val(category_name);
                $("input[name=category_type]").val(category_type);

                $('#editModal').modal('show'); 


            })


            $(document).on("click",".edit_maincategory",function(e){
                var module_name = $(this).data('module_name');
                var category_type = $(this).data('category_type');
                var parent_category_id = $(this).data('parent_id');
                var main_category_id = $(this).data('main_id');
                var category_name = $(this).data('category_name');
                $("input[name=category_type]").val(category_type);


               console.log('parent',parent_category_id)
                $('.sub_category_id').val(main_category_id);
                $('.module_name').val(module_name).change();
                $('.parent_Category').val(parent_category_id).change();
                $('.sub_category_name').val(category_name);

                $('#editmainModal').modal('show'); 

            })



    });
    
</script>
@endsection

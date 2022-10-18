@extends('layout.main')
@section('porject_item_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Project Items</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('projectitems.index')}} @endsection
@section('main_btn_text') All Project Inventory Items @endsection
{{-- back btn --}}
@section('css')

@endsection

@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Project Items</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('projectitems.store')}}"  method="post" class="import_purchases">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Item Code<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_code" class="form-control" placeholder="Item Code" value="{{ old('item_code') }}" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Item Name<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_name" class="form-control" placeholder="Item Name"  value="{{ old('item_name') }}" required/>
                                </div>
                            </div>
                    

                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Category<span class="red_asterik"></span></label>
                                    {!! Form::select('category_id',[null=>'Select Category']+$categories,
                                    old('category_id'), ['class' => 'form-control select2','id'=>'select_categories']) !!}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Child Category</label>
                                    {!! Form::select('child_category_id',[null=>'Select Category']+$categories,
                                    old('category_id'), ['class' => 'form-control select2 child_categories','id'=>'child_categories']) !!}
                                </div>
                            </div> --}}


                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="cat_parent_id" class="form-control select2" onchange='getCategoriesByID(this.value,"parent")' required>
                                        <option value="" disabled selected>Select Parent Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Main Category</label>
                                    <select name="cat_main_id" class="form-control select2 main_category" disabled onchange='getCategoriesByID(this.value,"main")'>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select name="cat_sub_id" class="form-control select2 sub_category" disabled onchange='getCategoriesByID(this.value,"sub")'>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Sub Child Category</label>
                                    <select name="cat_sub_sub_id" class="form-control select2 sub_sub_category" disabled>
                                    </select>
                                </div>
                            </div>



                           
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Projects<span class="red_asterik"></span></label>
                                     {!! Form::select('projects[]',$projects,''
                                     , ['class' => 'form-control select2','required'=>'true','multiple'=>'multiple']) !!}
 
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label >Select Suppliers<span class="red_asterik"></span></label>
                                     {!! Form::select('suppliers[]',$suppliers,''
                                     , ['class' => 'form-control select2','required'=>'true','multiple'=>'multiple']) !!}
 
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Balance<span class="red_asterik"></span></label>
                                    <input type="number" name="current_balance_item" class="form-control" placeholder="Current balance item" value="{{ old('current_balance_item') }}" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Stock Cost<span class="red_asterik"></span></label>
                                    <input type="text" name="current_stock_cost" class="form-control amount_format" placeholder="Current stock cost" value="{{ old('current_stock_cost') }}" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Brand Item</label>
                                    <input type="text"  value="{{ old('item_brand') }}" name="item_brand" class="form-control" placeholder="Brand Item"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Unit of Measure</label>
                                    <input type="text"  name="unit_of_measure" class="form-control" placeholder="" value="{{ old('unit_of_measure') }}"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Addition Date</label>
                                    <input type="text" name="date_of_addition" value="{{ old('date_of_addition') }}"  class="form-control date_of_addition"  readonly required/>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description<span class="red_asterik"></span></label>
                                    <textarea name="description"  class="form-control" rows="3"  required>{{ old('description') }}</textarea>
                                </div>
                            </div>   
                            

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Technical Specification 1</label> 
                                    <textarea name="technical_specification_1" class="form-control" rows="4"  required>{{ old('technical_specification_1') }}</textarea>

                                </div>
                            </div>
                            
                            @error('technical_specification_1')
                                <div class="help-block error-help-block">{{ $message }}</div>
                            @enderror


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Technical Specification 2</label> 
                                    <textarea name="technical_specification_2" class="form-control" rows="4"  required>{{ old('technical_specification_2') }}</textarea>

                                </div>
                            </div> 
                            
                            @error('technical_specification_2')
                                <div class="help-block error-help-block">{{ $message }}</div>
                            @enderror

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
                                </div>
                            </div>  
                            

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1" >Submit</button>
                            </div>
  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</section>

@endsection


@section('scripts')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{{-- {!! JsValidator::formRequest('App\Http\Requests\Project_inventory_item'); !!} --}}
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

<script>
   
$(function(){

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('.date_of_addition').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    
    });

    // CKEDITOR.replace( 'technical_specification_1' );
    // CKEDITOR.replace( 'technical_specification_2' );



        // $("#select_categories").change(function(){
            
        // category_id = $('#select_categories').val();
        
        // console.log(category_id);

        // if(category_id!='')
        // {
        //     $.ajax({
        //         url:'{{ route('getchildCategories')}}',
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "category_id":category_id
        //         },
        //         method: 'post',
        //         success: function(data) {
        //             $('.child_categories').html('');
        //             var categories = data.categories;
                
        //             $.each(categories,function(key,value) {
        //             $('.child_categories').append(
        //                 '<option value='+value.id+'>'+value.name+'</option>'
        //             )
        //             })
                
        //         },
        //         error: function(data)
        //         {
                    
        //         }
        //     });

        // }
        // else  $('.child_categories').html('');
      
        // });

});

        function getCategoriesByID(category_id,category_select)
        {
            //var category_id = $(this).val();

            var module_name = "project_item";
           
            $.ajax({
                    url:'{{ route('getajaxcategoryByID')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "module_name":module_name,
                        "category_select":category_select,
                        "category_id":category_id
                    },
                    method: 'post',
                    success: function(data) {

                        var categories = data.categories;

                        if(category_select == 'parent')
                        {
                            // handling parent categories
                            $('.main_category').html('');

                            $('.main_category').html('<option value="" disabled selected>Select Category</option>');
                            
                            $.each(categories,function(key,value) {
                                $('.main_category').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })

                            $('.main_category').removeAttr('disabled');

                        }
                        else if(category_select == 'main')
                        {
                            // handling main categoires
                            $('.sub_category').html('');

                            $('.sub_category').html('<option value="" disabled selected>Select Category</option>');


                            $.each(categories,function(key,value) {
                                $('.sub_category').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })
                            
                            $('.sub_category').removeAttr('disabled');

                            

                        
                        }
                        else if(category_select == 'sub')
                        {
                            // handling main categoires
                            $('.sub_sub_category').html('');

                            $('.sub_sub_category').html('<option value="" disabled selected>Select Category</option>');


                            $.each(categories,function(key,value) {
                                $('.sub_sub_category').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })


                            $('.sub_sub_category').removeAttr('disabled');

                        
                        }

                                
                    },
                    error: function(data)
                    {
                        alert('Error Occured');
                    }
                });
        }


</script>
   
@endsection
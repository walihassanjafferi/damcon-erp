@extends('layout.main')
@section('maintenanace_item_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Maintenance Items</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('maintenanaceiteminventory.index')}} @endsection
@section('main_btn_text') All Maintenance Inventory Items @endsection
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
                    <h4 class="card-title">Edit Maintenanace Items</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('maintenanaceiteminventory.update',encrypt($maintenanace_item->id))}}"  method="post" class="import_purchases">
                        @csrf 
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Item Code<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_code_edit" class="form-control" placeholder="Item Code" value="{{ $maintenanace_item->item_code }}" readonly/>
                                </div>
                                @error('item_code_edit')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Item Name<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_name" class="form-control" placeholder="Item Name"  value="{{  $maintenanace_item->item_name }}" required/>
                                </div>
                            </div>

                          
                    

                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Category<span class="red_asterik"></span></label>
                                    {!! Form::select('category_id',[null=>'Select Category']+$categories,
                                     $maintenanace_item->category_id, ['class' => 'form-control select2','id'=>'select_categories']) !!}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Child Category</label>
                                    {!! Form::select('child_category_id',[null=>'Select Category']+$categories,
                                    $maintenanace_item->chidcategories_id, ['class' => 'form-control select2 child_categories','id'=>'child_categories']) !!}
                                </div>
                            </div> --}}

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="cat_parent_id" class="form-control select2" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($parent_categories as $item)
                                            <option value="{{$item->id}}" {{$maintenanace_item->cat_parent_id ==$item->id ? 'selected':''}}>{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Main Category</label>
                                    <select name="cat_main_id" class="form-control select2 main_category"  >
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($main_categories as $item)
                                            <option value="{{$item->id}}" {{$maintenanace_item->cat_main_id == $item->id ? 'selected':''}}>{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select name="cat_sub_id" class="form-control select2 sub_category" >
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($sub_categories as $item)
                                            <option value="{{$item->id}}" {{$maintenanace_item->cat_sub_id == $item->id ? 'selected':''}}>{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Sub Child Category</label>
                                    <select name="cat_sub_sub_id" class="form-control select2 sub_sub_category" >
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($sub_sub_categories as $item)
                                            <option value="{{$item->id}}" {{$maintenanace_item->cat_sub_sub_id == $item->id ? 'selected':''}}>{{$item->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Service ID</label>
                                    <input type="text"  name="service_id" class="form-control" placeholder="Service ID"  value="{{  $maintenanace_item->service_id }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label >Select Suppliers</label>
                                     {!! Form::select('supplier_id',[null=>'Select Supplier']+$suppliers,$maintenanace_item->supplier_id
                                     , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div>
                    

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Balance<span class="red_asterik"></span></label>
                                    <input type="number" name="current_balance_item" class="form-control" placeholder="Current balance item" value="{{ $maintenanace_item->current_balance_item }}"  readonly required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Stock Cost<span class="red_asterik"></span></label>
                                    <input type="number" name="current_stock_cost" class="form-control" placeholder="Current stock cost" value="{{ $maintenanace_item->current_stock_cost }}" required readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Brand Item</label>
                                    <input type="text"  value="{{ $maintenanace_item->item_brand }}" name="item_brand" class="form-control" placeholder="Brand Item"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Unit of Measure</label>
                                    <input type="text"  name="unit_of_measure" class="form-control" placeholder="" value="{{ $maintenanace_item->unit_of_measure }}"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Addition Date</label>
                                    <input type="text" name="date_of_addition" value="{{ $maintenanace_item->date_of_addition }}"  class="form-control date_of_addition"  readonly required/>
                                </div>
                            </div>



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Item Type<span class="red_asterik"></span></label>
                                    <select class="form-control" name="item_type" required>
                                        <option value="" selected>Select Type</option>
                                        <option value="parts" {{ $maintenanace_item->item_type == 'parts' ? 'selected' : ''}}>Parts</option>
                                        <option value="services" {{ $maintenanace_item->item_type == 'services' ? 'selected' : ''}}>Services</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description"  class="form-control" rows="3"  required>{{ $maintenanace_item->description }}</textarea>
                                </div>
                            </div>   
                            

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Technical Specification 1</label> 
                                    <textarea name="technical_specification_1" class="form-control" rows="4"  required>{{ $maintenanace_item->technical_specification_1 }}</textarea>

                                </div>
                            </div>
                            
                            @error('technical_specification_1')
                                <div class="help-block error-help-block">{{ $message }}</div>
                            @enderror


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Technical Specification 2</label> 
                                    <textarea name="technical_specification_2" class="form-control" rows="4"  required>{{ $maintenanace_item->technical_specifications_2 }}</textarea>
                                </div>
                            </div> 
                            
                            @error('technical_specification_2')
                                <div class="help-block error-help-block">{{ $message }}</div>
                            @enderror

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $maintenanace_item->comments }}</textarea>
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
{!! JsValidator::formRequest('App\Http\Requests\Maintenanace_inventory_item'); !!}
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



        $("#select_categories").change(function(){
            
        category_id = $('#select_categories').val();
        
        console.log(category_id);

        if(category_id!='')
        {
            $.ajax({
                url:'{{ route('getchildCategories')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "category_id":category_id
                },
                method: 'post',
                success: function(data) {
                    $('.child_categories').html('');
                    var categories = data.categories;
                
                    $.each(categories,function(key,value) {
                    $('.child_categories').append(
                        '<option value='+value.id+'>'+value.name+'</option>'
                    )
                    })
                
                },
                error: function(data)
                {
                    
                }
            });

        }
        else  $('.child_categories').html('');
      
        });


});


</script>
   
@endsection
@extends('layout.main')
@section('category_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Categories</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('categories.index')}} @endsection
@section('main_btn_text') All Categories @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store')}}"  method="post">
                        @csrf
                      
                        <div class="row">

                            <div class="col-md-4 col-12 module_type">
                                <div class="form-group">
                                    <label>Select Module</label>
                                    <select class="form-control select2 module_name" name="module_name">
                                        {{-- <option value=""> -- select an option --</option> --}}
                                        <option value="bank_payments">Bank Payments</option>
                                        <option value="security_bid_bond">Security/Bid Bond Payments</option>
                                        <option value="mic_income">Misc. Income Management</option>
                                        <option value="project_cash_payment">Project Cash Payments</option>

                                    </select>
                                   
                                </div>
                            </div>
                          

                            <div class="col-md-4 col-12 categories_select">
                                <div class="form-group">
                                    <label >Select Category Type</label>
                                    <select class="form-control select2" name="category_type" id="category_type">
                                        <option selected="" value=""> -- select an option --</option>
                                        <option value="parent">Parent Category</option>
                                        <option value="main">Main Category</option>
                                        <option value="sub">Sub Category</option>

                            
                                    </select>
                                   
                                </div>
                            </div>

                            <div class="col-md-4 col-12 parent_category" style="display: none;">
                                <div class="form-group">
                                    <label >Parent Category Title</label>
                                    <input type="text" name="parent_category" class="form-control" />
                                   
                                </div>
                            </div>


                            <div class="col-md-4 col-12 parent_categories_1" style="display: none;">
                                <div class="form-group">
                                     <label >Select Parent Category</label>
                                     {!! Form::select('parent_categories',[null=>'Select Parent Catgory'],
                                     "{{ old('parent_categories') }}", ['class' => 'form-control p_categories select2']) !!}
                                </div>
                            </div>


                            <div class="col-md-4 col-12 main_category_value" style="display: none;">
                                <div class="form-group">
                                    <label>Main Category</label>
                                    <input type="text" name="main_category" class="form-control" />  
                                </div>
                            </div>


                            <div class="col-md-4 col-12 main_categories" style="display: none;">
                                <div class="form-group">
                                     <label >Select Main Category</label>
                                     {!! Form::select('main_categories',[null=>'Select Main Category'],
                                     "{{ old('main_categoriess') }}", ['class' => 'form-control main_categories_1 select2']) !!}
                                </div>
                            </div>

                           <div class="col-md-4 col-12 sub_category_value" style="display: none;">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <input type="text" name="sub_category" class="form-control" />  
                                </div>
                            </div>


                            {{-- <div class="col-md-4 col-12 sub_categories" style="display: none;">
                                <div class="form-group">
                                     <label >Select Sub Category</label>
                                     {!! Form::select('sub_categories',[null=>'Select Sub Category'],
                                     "{{ old('sub_categories') }}", ['class' => 'form-control sub_categories_1 select2','required'=>'true']) !!}
                                </div>
                            </div> --}}

                           
                            
                            
                            <br/>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')


{{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script> --}}
{{-- {!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!} --}}

<script>
   
    $(function(){

    
        $('.categories_select').change(function(){
            
            var category_select = $('.categories_select').find(":selected").val();
            var module_name = $('.module_name').find(":selected").val();
            if(category_select == 'parent')
            {
               
                $('.parent_category').css('display','block');

                $('.parent_categories_1').css('display','none');
                $(".parent_categories_1:selected").removeAttr("selected");

                $('.main_category_value').css('display','none');
                $("[name='main_category']").val('');


                $('.sub_category_value').css('display','none');
                $("[name='sub_category']").val('');


                $('.main_categories').css('display','none');
                $(".main_categories:selected").removeAttr("selected");


                // // hiding sub sub category
                // $('.sub_categories').css('display','none');
                // $(".sub_categories_1:selected").removeAttr("selected");
                // $('.sub_sub_category_value').css('display','none');
                // $("[name='sub_sub_category']").val('');

                
            }
            else if(category_select == 'main')
            {
                $('.main_category_value').css('display','block');
                $("[name='main_category']").val('');



                $('.parent_category').css('display','none');
                $("[name='parent_category']").val('');
                


                $('.sub_category_value').css('display','none');
                $("[name='sub_category']").val('');

                $('.main_categories').css('display','none');
                $(".main_categories:selected").removeAttr("selected");


                   // hiding sub sub category
                $('.sub_categories').css('display','none');
                $(".sub_categories_1:selected").removeAttr("selected");
                $('.sub_sub_category_value').css('display','none');
                $("[name='sub_sub_category']").val('');


                getAjaxCategories(module_name,category_select);


            }
            else if(category_select == 'sub')
            {
                
                $('.parent_category').css('display','none');
                $("[name='parent_category']").val('');


                $('.parent_categories_1').css('display','none');
                $(".parent_categories_1:selected").removeAttr("selected");

                $('.main_category_value').css('display','none');
                $("[name='main_category']").val('');


                // hiding sub sub category
                $('.sub_categories').css('display','none');
                $(".sub_categories_1:selected").removeAttr("selected");
                $('.sub_sub_category_value').css('display','none');
                $("[name='sub_sub_category']").val('');


                getAjaxCategories(module_name,category_select);
            }
            

            function getAjaxCategories(module_name,category_select) {
                $.ajax({
                    url:'{{ route('ajaxgeterpcategorybymodule')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "module_name":module_name,
                        "category_select":category_select
                    },
                    method: 'post',
                    success: function(data) {

                        var categories = data.categories;

                        if(category_select == 'main')
                        {
                            // handling parent categories
                            $('.p_categories').html('');

                            $('.p_categories').html('<option value="">Select Parent Category</option>');
                            
                            $.each(categories,function(key,value) {
                                $('.p_categories').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })

                            $('.parent_categories_1').css('display','block');
                        }
                        else if(category_select == 'sub')
                        {
                            // handling main categoires
                            $('.main_categories_1').html('');

                            $('.main_categories_1').html('<option value="">Select Main Category</option>');


                            $.each(categories,function(key,value) {
                                $('.main_categories_1').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })
                            
                            
                            $('.main_categories').css('display','block');

                            $('.sub_category_value').css('display','block');


                        
                        }
                        else if(category_select == 'sub_sub')
                        {
                            // handling main categoires
                            $('.sub_categories_1').html('');

                            $('.sub_categories_1').html('<option value="">Select Sub Category</option>');


                            $.each(categories,function(key,value) {
                                $('.sub_categories_1').append(
                                    '<option value='+value.id+'>'+value.category_name+'</option>'
                                )
                            })
                            
                            
                            $('.sub_categories').css('display','block');

                            $('.sub_sub_category_value').css('display','block');


                        
                        }

                       
            
                    },
                    error: function(data)
                    {
                        
                    }
                });
            }

        })


    });
</script>
@endsection


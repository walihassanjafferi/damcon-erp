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
                        <div class="form_status">
                            <label>Status</label> &nbsp;
                            <label class="switch">
                                <input type="checkbox" checked name = 'status'>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label >Select Module</label>
                                    {!! Form::select('module_id',[null=>'Select Module']+$configurations,
                                    "{{ old('module_id') }}", ['class' => 'form-control select2 getCategories','id'=>'module','required'=>'true']) !!}
                                </div>
                            </div>
                            <div class="col-md-4 col-12 categories_select">
                                <div class="form-group">
                                     <label >Select Parent Category</label>
                                     {!! Form::select('parent_categories[]',[null=>'Select Module'],
                                     "{{ old('parent_categories') }}", ['class' => 'form-control select2 p_category','required'=>'true','multiple'=>'multiple']) !!}
 
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Category Name</label>
                                    <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" placeholder="Value" required/>
                                </div>
                            </div>
                           
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


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!}

<script>
   
    $(function(){

        $(".getCategories").change(function(){
            
           module_id = $('.getCategories').val();
           $.ajax({
                url:'{{ route('getCategories')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "module_id":module_id
                },
                method: 'post',
                success: function(data) {
                    $('.p_category').html('');
                    var categories = data.categories;
                  
                    $.each(categories,function(key,value) {
                      $('.p_category').append(
                          '<option value='+value.id+'>'+value.name+'</option>'
                      )
                    })
                
                },
                error: function(data)
                {
                    
                }
            });
        });


    });
</script>
@endsection


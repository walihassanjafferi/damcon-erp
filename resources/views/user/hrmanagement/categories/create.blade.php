@extends('layout.main')
@section('hr_categories_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add HR-Categories</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('hrcategories.index')}} @endsection
@section('main_btn_text') All HR Categories @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add HR Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrcategories.store')}}"  method="post">
                        @csrf
                        <div class="form_status" style="position: absolute; right:25px;">
                            <label>Status</label> &nbsp;
                            <label class="switch">
                                <input type="checkbox" checked name = 'status'>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Category Name</label>
                                    <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" placeholder="Category" required/>
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
@endsection


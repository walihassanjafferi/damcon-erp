@extends('layout.main')
@section('bank_sidebar') active @endsection
@section('title')
<title>View Categories</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('categories.index')}} @endsection
@section('main_btn_text') All Categories @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_status">
                            <h4>Category Details</h4>   
                                <span class="customer_status_span"><label>Status</label>
                                <label class="switch">
                                    <input type="checkbox" {{$category->status ? 'checked' : ''}} onclick="statusChange({{$category->id}});">
                                    <span class="slider round"></span>
                                </label></span>
                            </div>
                            <br/>
                        <div class="bank_details">
                            <label>Name</label>
                            <span>{{$category->name}}</span>
                        </div>  
                        <div class="bank_details">
                            <label>Module</label>
                            <span>{{$category->module->label}}</span>
                        </div>  
                       
                    </div>
                </div>
            </div>


             {{-- toast --}}
    
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
                    
            @if($category->parentCatgories && count($category->parentCatgories))
                <div class="col-12">
                    <div class="card">
                        <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Parent Categories</label>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Category Module</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @foreach ($category->parentCatgories as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->module->label }}</td>
                                        <td>
                                            <a href="{{route('categories.edit',encrypt($item->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            {{-- {{-- @else
                <label class="pl-1 pt-1"><b>Child Ccategory Not Found!</b></label> --}}
            @endif
               
               
        </div>
    </div>


@endsection

@section('scripts')
<script>
    function statusChange($id){
            
            $.ajax({
            url:'{{ route('category_status_change')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":$id
            },
            method: 'post',
            success: function(data) {

                $('.toast-body').html(data.message);
                $('#status_toast').click();
           
            },
            error: function(data)
            {    
                $('.toast-body').html(data.message);
                $('#status_toast').click();
                
            }
            });

        }
</script>
@endsection

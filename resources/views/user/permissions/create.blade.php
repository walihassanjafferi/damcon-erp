@extends('layout.main')
@section('permission_sidebar') active @endsection
@section('content')
<center><div id="js-alert"></div></center>    
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Permission</h4>
                </div>
                <div class="card-body">
                    <form id="permission_form">
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="name">Permission Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="slug">Permission Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control" placeholder="slug"  required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="status">Select Modules<span class="red_asterik"></span></label>
                                   <select name="module_id" class="form-control" id="select_module">
                                        <option value="#" selected>-- --</option>
                                       @foreach ($modules as $item)
                                         <option value="{{$item->id}}">{{ $item->label }}</option>
                                       @endforeach
                                       
                                   </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="button" class="btn btn-primary mr-1" onclick="addPermission(event)">Submit</button>

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
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\RoleRequest', '#permission_form'); !!}
<script>
     function addPermission(event){
        event.preventDefault();
        var name = $('#name').val();
        var slug = $('#slug').val();
        var module1 = $('#select_module').val();

    
        if(name && slug && module1!='#'){
                $.ajax({
                url:'{{ route('permissions.store')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "name":name,
                    "slug":slug,
                    "module_id":module1
                },
                method: 'post',
                success: function(data) {
                
                    if(data.success)
                    {
                        $('#js-alert').html('<div class="alert alert-success col-6">' + data.message + '</div>').delay(3000).fadeIn('slow');

                        $('#js-alert').delay(3000).fadeOut('slow');

                        $('#name').val(''); $('#slug').val('');
                    }
                
                },
                error: function(data)
                {
                    
                    var errors = data.responseJSON;
    
                    $('#js-alert').html('<div class="alert alert-warning col-6">' + errors.message + '</div>');
                    
                }
            });
        }
        else{
            alert('Fields are required');
        }
        
    }

</script>




@endsection

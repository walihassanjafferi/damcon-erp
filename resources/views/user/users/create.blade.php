@extends('layout.main')
@section('users_sidebar') active @endsection
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store')}}"  method="post" id="users_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="first-name-column">User Name</label>
                                    <input type="text" id="first-name-column" name="name" class="form-control" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >User Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email"  required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"  required/>
                                  
                                    <div class="custom-control custom-checkbox" style="margin-top: 2%;">
                                        <input type="checkbox" class="custom-control-input" id="pass">
                                        <label class="custom-control-label" for="pass" onclick="showPassword()"><small>Show Password</small></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label>Select Role</label>
                                <select class="select2 form-control form-control-lg" name="role_id">
                                    <option value="" selected>Select Role</option>
                                    @foreach ($roles as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                   
                                </select>
                                
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status<span class="red_asterik"></span></label>
                                   <select name="status" class="form-control" id="status">
                                       <option name="active" selected value=1>Active</option>
                                       <option name="inactive" value=0>Inactive</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-12"><h6>Permissions</h6></div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox permission-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_all_label">
                                    <label class="custom-control-label"  name="check_all" for="check_all_label" id="check-all">Select All</label>
                                </div>
                            </div>
                            <?php $heading = ""; ?>
                            <div class="col-12 permissions">
                                <div class="row" style="margin-left:unset;margin-right:unset;">
                                {{-- <ul class="permission_custom_list"> --}}
                                    @foreach ($permissions as $item)
                                        @if($heading!=$item->module->label)
                                            <?php $heading = $item->module->label ?>
                                              <div class="w-100"><h6><b>{{$heading}}</b></h6> </div>
                                        @endif
                                      
                                        {{-- <li> --}}
                                           
                                            <div class="col-md-3 col-12 custom-control custom-checkbox permission-checkbox">
                                                <input type="checkbox" class="custom-control-input" value={{$item->id}} name="permissions[]" id="{{$item->name.$item->id}}">
                                                <label class="custom-control-label"   for="{{$item->name.$item->id}}" style="box-sizing: border-box; display:block;">{{ ucfirst($item->name) }}</label>
                                            </div>
                                        {{-- </li> --}}
                                    @endforeach
                                </div>
                                {{-- </ul> --}}
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
</section>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\UserRequest') !!}


<script>
      $("#check_all_label").click(function () {
            $('.permissions input:checkbox').not(this).prop('checked', this.checked);
        });
        function showPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }       
</script>
    
@endsection

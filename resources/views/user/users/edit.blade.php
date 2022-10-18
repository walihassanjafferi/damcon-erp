@extends('layout.main')
@section('users_sidebar') active @endsection
@section('css')
<style>
    .label_permission{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }
</style>
@endsection
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update',encrypt($user->id)) }}"  method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label >User Name</label>
                                    <input type="text" name="name" class="form-control" value={{$user->name}} placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >User Email</label>
                                    <input type="email" name="email" class="form-control" value="{{$user->email}}" placeholder="Email"  readonly required/>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" value="" class="form-control" placeholder="Password"  required/>
                                  
                                    <div class="custom-control custom-checkbox" style="margin-top: 2%;">
                                        <input type="checkbox" class="custom-control-input" id="pass">
                                        <label class="custom-control-label" for="pass" onclick="showPassword()"><small>Show Password</small></label>
                                    </div>
                                </div>
                            </div> --}}
                            
                            <div class="col-md-6 mb-1">
                                <label>Select Role</label>
                                <select class="select2 form-control form-control-lg" name="role_id">
                                    <option value="" >Select Role</option>
                                   
                                    @foreach ($roles as $item)
                                    <option value="{{$item->id}}" {{$user->role->id == $item->id ? 'selected' : '' }} >{{$item->name}}</option>
                                    @endforeach
                                   
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="status">Status<span class="red_asterik"></span></label>
                                   <select name="status" class="form-control" id="status">
                                       <option name="active"  value=1 {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                       <option name="inactive" value=0 {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
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
                            <div class="col-12">
                                <div class="row" style="margin-left:unset;margin-right:unset;">
                                {{-- <ul class="permission_custom_list"> --}}
                                    @foreach ($permissions as $item)
                                        @if($heading!=$item->module->label)
                                            <?php $heading = $item->module->label ?>
                                              <div style="width:100%;"><h6><b>{{$heading}}</b></h6> </div>
                                        @endif
                                      
                                        {{-- <li> --}}

                                            @if(in_array($item->id,$user_permissions))

                                                <div class="col-md-4 col-12 custom-control custom-checkbox permission-checkbox">
                                                    <input type="checkbox" class="custom-control-input" value={{$item->id}} name="permissions[]" id="{{$item->name.$item->id}}" checked>
                                                    <label class="custom-control-label label_permission"   for="{{$item->name.$item->id}}">{{ $item->name }}</label>
                                                </div>

                                            @else
                                           
                                                <div class="col-md-4 col-12 custom-control custom-checkbox permission-checkbox">
                                                    <input type="checkbox" class="custom-control-input" value={{$item->id}} name="permissions[]" id="{{$item->name.$item->id}}">
                                                    <label class="custom-control-label label_permission"   for="{{$item->name.$item->id}}">{{ $item->name }}</label>
                                                </div>
                                           
                                            @endif
                                            
                                        {{-- </li> --}}
                                    @endforeach
                                </div>
                                {{-- </ul> --}}
                            </div>


                         
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Update</button>
                               
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
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    //     function showPassword() {
    //         var x = document.getElementById("password");
    //         if (x.type === "password") {
    //             x.type = "text";
    //         } else {
    //             x.type = "password";
    //         }
    //     }       
</script>
    
@endsection

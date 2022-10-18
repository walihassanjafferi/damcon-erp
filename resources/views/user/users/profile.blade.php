@extends('layout.main')
@section('content')
@include('alert.alert')

@section('css')
<style>
.field-icon {
    position: absolute;
    top: 34px;
    right: 24px;
    z-index: 2;
}
#profile_preview{
    width: 100px;
}
.profile_preview_div{
    margin: 10px;
}
</style>
@endsection
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Profile</h4>
                </div>
                <div class="card-body">

                    <section id="vertical-tabs">
                        <div class="row match-height">
                            <!-- Vertical Left Tabs start -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="nav-vertical">
                                    <ul class="nav nav-tabs nav-left flex-column" role="tablist" style="height: 98px;">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab" aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" role="tab" aria-selected="false">General Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2" href="#tabVerticalLeft2" role="tab" aria-selected="true">Password Settings</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabVerticalLeft1" role="tabpanel" aria-labelledby="baseVerticalLeft-tab1">
                                            <form action="{{ route('user.profileUpdate',encrypt($user->id)) }}" method="post" id="users_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row ml-0 mr-0">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Name</label>
                                                            <input type="text" id="first-name-column" name="name" class="form-control"
                                                                placeholder="Name" value="{{$user->name}}" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label>User Email</label>
                                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                              value="{{$user->email}}"  readonly />
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-md-6 mb-1">
                                                        <label>Select Role</label>
                                                        <input type="text" class="form-control"
                                                        placeholder="Name" value="{{$user->role->name}}" readonly />
                        
                                                    </div>
                        
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="status">Status<span class="red_asterik"></span></label>
                                                            <select name="status" class="form-control" id="status" disabled>
                                                                <option name="active" value=1 {{$user->status == 1 ? 'selected' : ''}}>Active</option>
                                                                <option name="inactive" value=0 {{$user->status == 0 ? 'selected' : ''}}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Upload Profile Pic</label>
                                                            <input type="file" name="document_file" class="form-control" required id="profile_upload"/>
                                                        </div>
                                                        <div class="profile_preview_div">
                                                            <img id="profile_preview"
                                                            @if($user->document_file)
                                                             src="{{asset('/storage/user_profile_images/'.json_decode($user->document_file))}}" 
                                                            @else
                                                            src="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/portrait/small/avatar-s-11.jpg"
                                                            @endif
                                                             alt="Profile Image" />
                                                        </div>
                                                    </div>

                                                
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="tabVerticalLeft2" role="tabpanel" aria-labelledby="baseVerticalLeft-tab2">
                                            <form action="{{ route('user.profileUpdate',encrypt($user->id)) }}" method="post" id="users_form">
                                                @csrf
                                               
                                                <div class="row ml-0 mr-0">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label >Old Password</label>
                                                            <input type="password"  name="old_pass" class="form-control old-password"
                                                                required />
                                                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon old-password-eye"></span>
                                                            @error('old_pass')
                                                            <div class="error-help-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="col-12"></div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label >New Password</label>
                                                            <input type="password" name="new_password" class="form-control new-password"
                                                             required />
                                                             <span toggle="#password-field" class="fa fa-fw fa-eye field-icon new-password-eye"></span>
                                                             @error('new_password')
                                                                <div class="error-help-block">{{ $message }}</div>
                                                             @enderror
                                                        </div>
                                                       
                                                    </div>


                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label >Confirm Password</label>
                                                            <input type="password" name="confirm_password" class="form-control confirm-password"
                                                             required />
                                                             <span toggle="#password-field" class="fa fa-fw fa-eye field-icon confirm-password-eye"></span>
                                                             @error('confirm_password')
                                                                <div class="error-help-block">{{ $message }}</div>
                                                             @enderror
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
                            <!-- Vertical Left Tabs ends -->
    
                           
                        </div>
                    </section>

                   
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<script>
    $(".old-password-eye").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $('.old-password')

        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
       
    });

    $(".new-password-eye").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $('.new-password')

        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
       
    });

    $(".confirm-password-eye").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $('.confirm-password')

        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
       
    });


    profile_upload.onchange = evt => {
        const [file] = profile_upload.files
        if (file) {
            profile_preview.src = URL.createObjectURL(file)
        }
    }
</script>

@endsection

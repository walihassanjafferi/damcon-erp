@extends('layout.main')
@section('role_sidebar') active @endsection
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Role</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store')}}"  method="post" id="role_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="first-name-column">Role Name</label>
                                    <input type="text" id="first-name-column" name="name" class="form-control" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="last-name-column">Role Slug</label>
                                    <input type="text" id="last-name-column" name="slug" class="form-control" placeholder="slug"  required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
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
{!! JsValidator::formRequest('App\Http\Requests\RoleRequest', '#role_form'); !!}
    
@endsection

@extends('layout.main')
@section('permission_sidebar') active @endsection
@section('content')
  
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Permission</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('permissions.update',encrypt($permission->id))}}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="name">Permission Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" value={{$permission->name}} required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="slug">Permission Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control" placeholder="slug" value={{$permission->slug}}  required/>
                                </div>
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

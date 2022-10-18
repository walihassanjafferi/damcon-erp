@extends('layout.main')

@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Configurations</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('configurations.store')}}"  method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label >Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Value</label>
                                    <input type="text"  name="value" class="form-control" placeholder="Value"  required/>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Label</label>
                                    <input type="text"  name="label" class="form-control" placeholder="Label"  required/>
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
</section>

@endsection


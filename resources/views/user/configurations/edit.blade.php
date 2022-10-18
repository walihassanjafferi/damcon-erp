@extends('layout.main')

@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Configuration</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($configuration, ['route' => ['configurations.update', encrypt($configuration->id)],'method' => 'PATCH']) !!}
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label > Name<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="state">Value<span class="red_asterik"></span></label>
                                    {!! Form::text('value', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Label<span class="red_asterik"></span></label>
                                    {!! Form::text('label', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            
                            
                             
                         
                
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Update</button>
                            </div>
  
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@extends('layout.main')
@section('customer_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  Create Customer</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customers.index')}} @endsection
@section('main_btn_text') All Customers @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Customers</h4>
                </div>
                <div class="card-body">
                        {!! Form::model($customer, ['route' => ['customers.update', encrypt($customer->id)],'method' => 'PATCH']) !!}
                        
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label for="first-name-column">Customer Name<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control','required','id'=>'first-name-column']) !!}
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label >Address<span class="red_asterik"></span></label>
                                    {!! Form::text('address', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="state">State<span class="red_asterik"></span></label>
                                    {!! Form::text('state', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Street<span class="red_asterik"></span></label>
                                    {!! Form::text('street', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city">City<span class="red_asterik"></span></label>
                                    {!! Form::text('city', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="country">Country<span class="red_asterik"></span></label>
                                    {!! Form::text('country', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code<span class="red_asterik"></span></label>
                                    {!! Form::text('zip_code', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div> --}}
                            {{-- contact person 1  --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 1 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1">Contact Person name<span class="red_asterik"></span></label>
                                    {!! Form::text('cp1_name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_phone">Contact Person Phone <span class="red_asterik"></span></label>
                                    {!! Form::text('cp1_phone_no', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_cell">Contact Person Cell no <span class="red_asterik"></span></label>
                                    {!! Form::text('cp1_cell_no', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_email">Contact Person Email <span class="red_asterik"></span></label>
                                    {!! Form::email('cp1_email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_fax">Contact Person Designation <span class="red_asterik"></span></label>
                                    {!! Form::text('cp1_fax', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            {{-- contact person 1  --}}


                            {{-- contact person 2  --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 2 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2">Contact Person name <span class="red_asterik"></span></label>
                                    {!! Form::text('cp2_name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_phone">Contact Person Phone <span class="red_asterik"></span></label>
                                    {!! Form::text('cp2_phone_no', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_cell">Contact Person Cell no <span class="red_asterik"></span></label>
                                    {!! Form::text('cp2_cell_no', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_email">Contact Person Email <span class="red_asterik"></span></label>
                                    {!! Form::email('cp2_email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_fax">Contact Person Designation <span class="red_asterik"></span></label>
                                    {!! Form::text('cp2_fax', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                              {{-- contact person 2  --}}
                            <div class="col-12"></div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">NTN Number<span class="red_asterik"></span></label>
                                     {!! Form::text('ntn_number', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">STRN Number<span class="red_asterik"></span></label>
                                    {!! Form::text('strn_number', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status<span class="red_asterik"></span></label>
                                    {!! Form::select('status', ['0' => 'In active', '1' => 'Active'],
                                    null, ['class' => 'form-control', 'id' => 'is_active']) !!}
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

@section('scripts')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerRequest'); !!}
    
@endsection
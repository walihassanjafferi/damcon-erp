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
                    <h4 class="card-title">Create Customers</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store')}}"  method="post" >
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label for="first-name-column">Customer Name<span class="red_asterik"></span></label>
                                    <input type="text" id="first-name-column" name="name" class="form-control" placeholder="Name" />
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label for="last-name-column">Address<span class="red_asterik"></span></label>
                                    <input type="text" id="last-name-column" name="address" class="form-control" placeholder="Address"  required/>
                                </div>
                            </div>

                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city">City<span class="red_asterik"></span></label>
                                    <input type="text" id="city" name="city" class="form-control" placeholder="City"  required/>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="state">State<span class="red_asterik"></span></label>
                                    <input type="text" id="state" name="state" class="form-control" placeholder="Steet"  required/>
                                </div>
                            </div> --}}
                            
                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="street">Street<span class="red_asterik"></span></label>
                                    <input type="text" id="street" name="street" class="form-control" placeholder="Steet"  required/>
                                </div>
                            </div> --}}
{{--                          
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="country">Country<span class="red_asterik"></span></label>
                                    <input type="text" id="country" name="Country" class="form-control" placeholder="Country"  required/>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code<span class="red_asterik"></span></label>
                                    <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="ZipCode"  required/>
                                </div>
                            </div> --}}
                            {{-- contact person 1  --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 1 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1">Contact Person name </label>
                                    <input type="text" id="cp1" name="cp1_name" class="form-control" placeholder=" name"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_phone">Contact Person Phone </label>
                                    <input type="text" id="cp1_phone" name="cp1_phone" class="form-control" placeholder="Phone"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_cell">Contact Person Cell no </label>
                                    <input type="text" id="cp1_cell" name="cp1_cell" class="form-control" placeholder="Cell"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_email">Contact Person Email </label>
                                    <input type="email" id="cp1_email" name="cp1_email" class="form-control" placeholder="Email"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_fax">Contact Person Designation </label>
                                    <input type="text" id="cp1_fax" name="cp1_fax" class="form-control" placeholder="Designation"  required/>
                                </div>
                            </div>
                            {{-- contact person 1 end --}}


                            {{-- contact person 2  --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 2 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2">Contact Person name </label>
                                    <input type="text" id="cp2" name="cp2_name" class="form-control" placeholder=" name"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_phone">Contact Person Phone  </label>
                                    <input type="text" id="cp2_phone" name="cp2_phone" class="form-control" placeholder="Phone"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_cell">Contact Person Cell no  </label>
                                    <input type="text" id="cp2_cell" name="cp2_cell" class="form-control" placeholder="Cell"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_email">Contact Person Email  </label>
                                    <input type="email" id="cp2_email" name="cp2_email" class="form-control" placeholder="Email"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp2_fax">Contact Person Designation  </label>
                                    <input type="text" id="cp2_fax" name="cp2_fax" class="form-control" placeholder="Designation"  required/>
                                </div>
                            </div>
                              {{-- contact person 2 end --}}
                            <div class="col-12"></div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">NTN Number </label>
                                    <input type="text" id="ntn_no" name="ntn_no" class="form-control" placeholder="Ntn Number"  required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">STRN Number </label>
                                    <input type="text" id="strn_no" name="strn_no" class="form-control" placeholder="Strn Number"  required/>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status </label>
                                   <select name="status" class="form-control" id="status">
                                       <option name="active" selected value=1>Active</option>
                                       <option name="inactive" value=0>Inactive</option>
                                   </select>
                                </div>
                            </div>

                          

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                {{-- <button type="reset" class="btn btn-outline-secondary">Reset</button> --}}
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
{!! JsValidator::formRequest('App\Http\Requests\CustomerRequest'); !!}
    
@endsection
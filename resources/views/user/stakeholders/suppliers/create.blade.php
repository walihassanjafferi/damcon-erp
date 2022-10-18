@extends('layout.main')
@section('supplier_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  Create Supplier</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('suppliers.index')}} @endsection
@section('main_btn_text') All Suppliers @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Suppliers</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.store')}}"  method="post" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label for="first-name-column">Name<span class="red_asterik"></span></label>
                                    <input type="text" id="first-name-column" name="name" class="form-control" placeholder="Name" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="status">Suppliers Type<span class="red_asterik"></span></label>
                                   <select name="suppliers_types_id" class="form-control" id="status">
                                    {{-- <option value="" selected>----</option> --}}
                                        @foreach ($supplier_type as $item)
                                            <option value="{{ $item->id}}">{{$item->name}}</option>
                                        @endforeach
                                   </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="last-name-column">Address<span class="red_asterik"></span></label>
                                    <input type="text" id="last-name-column" name="address" class="form-control" placeholder="Address"  required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label>Date of Creation</label>
                                    {!! Form::text('date_of_creation', null, ['class' => 'form-control date_of_creation','required']) !!}

                                </div>
                            </div>
                            {{-- <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" class="form-control" placeholder="State"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" id="street" name="street" class="form-control" placeholder="Street"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="form-control" placeholder="City"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" class="form-control" placeholder="Country"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control" placeholder="ZipCode"  required/>
                                </div>
                            </div> --}}
                            {{-- contact person 1  --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 1 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1">Contact Person name</label>
                                    <input type="text" id="cp1" name="cp1_name" class="form-control" placeholder=" name"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_phone">Contact Person Phone</label>
                                    <input type="text" id="cp1_phone" name="cp1_phone_no" class="form-control" placeholder="0300784501"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_cell">Contact Person Cell no</label>
                                    <input type="texts" id="cp1_cell" name="cp1_cell_no" class="form-control" placeholder="Cell"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_email">Contact Person Email</label>
                                    <input type="email" id="cp1_email" name="cp1_email" class="form-control" placeholder="Email"  required/>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_fax">Contact Person Fax</label>
                                    <input type="text" id="cp1_fax" name="cp1_fax" class="form-control" placeholder="Fax"  required/>
                                </div>
                            </div>
                            {{-- contact person 1 end --}}


                           
                            <div class="col-12"></div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">NTN Number</label>
                                    <input type="text" id="ntn_no" name="ntn_number" class="form-control" placeholder="Ntn Number"  required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">STRN Number</label>
                                    <input type="text" id="strn_no" name="strn_number" class="form-control" placeholder="Strn Number"  required/>
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank Name</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Bank Name"  required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank title</label>
                                    <input type="text" name="bank_account_title" class="form-control" placeholder="Bank title"  required/>
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank Account No</label>
                                    <input type="text" name="bank_account_number" class="form-control" placeholder="Bank Account no"  required/>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                   <select name="status" class="form-control" id="status">
                                       <option name="active" selected value=1>Active</option>
                                       <option name="inactive" value=0>Inactive</option>
                                   </select>
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


@section('scripts')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\SupplierRequest'); !!}


<script>
    
    $(function(){

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

        $('.date_of_creation').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });


    });

</script>
    
@endsection
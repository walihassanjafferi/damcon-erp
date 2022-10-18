@extends('layout.main')
@section('supplier_sidebar')
    active
@endsection
@section('title')
    <title>Damcon ERP - Edit Supplier</title>
@endsection
{{-- back btn --}}
@section('main_btn_href')
    {{ route('suppliers.index') }}
@endsection
@section('main_btn_text')
    All Suppliers
@endsection
{{-- back btn --}}
@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Supplier</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($supplier, ['route' => ['suppliers.update', encrypt($supplier->id)], 'method' => 'PATCH']) !!}

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="first-name-column">Supplier Name<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'id' => 'first-name-column']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="is_active">Supplier Nature<span class="red_asterik"></span></label>
                                    {!! Form::select('suppliers_types_id', $supplier_type, $supplier->suppliers_types_id, ['class' => 'form-control', 'id' => 'is_active']) !!}
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label>Address<span class="red_asterik"></span></label>
                                    {!! Form::text('address', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Date of Creation</label>
                                    {!! Form::text('date_of_creation', null, ['class' => 'form-control date_of_creation', 'required']) !!}

                                </div>
                            </div>
{{-- 
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    {!! Form::text('state', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Street</label>
                                    {!! Form::text('street', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    {!! Form::text('city', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    {!! Form::text('country', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="zipcode">Zip Code</label>
                                    {!! Form::text('zip_code', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div> --}}
                            {{-- contact person 1 --}}
                            <div class="col-12">
                                <h6 class="pt-1 pb-1">Contact Person 1 details</h6>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1">Contact Person name</label>
                                    {!! Form::text('cp1_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_phone">Contact Person Phone </label>
                                    {!! Form::text('cp1_phone_no', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_cell">Contact Person Cell no <span
                                            class="red_asterik"></span></label>
                                    {!! Form::text('cp1_cell_no', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_email">Contact Person Email </label>
                                    {!! Form::email('cp1_email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="cp1_fax">Contact Person Fax </label>
                                    {!! Form::text('cp1_fax', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            {{-- contact person 1 --}}
                            <div class="col-12"></div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Ntn Number</label>
                                    {!! Form::text('ntn_number', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Strn Number</label>
                                    {!! Form::text('strn_number', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank name</label>
                                    {!! Form::text('bank_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank title</label>
                                    {!! Form::text('bank_account_title', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="ntn_no">Bank Account Number</label>
                                    {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    {!! Form::select('status', ['0' => 'In active', '1' => 'Active'], null, ['class' => 'form-control', 'id' => 'is_active']) !!}
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SupplierRequest') !!}

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

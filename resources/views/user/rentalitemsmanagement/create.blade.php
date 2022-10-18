@extends('layout.main')
@section('rental_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Rental Items Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('rentalitem.index')}} @endsection
@section('main_btn_text') All Rental Items @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
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
                        <h4 class="card-title">Add Rental Items</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('rentalitem.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Rental ID<span class="red_asterik"></span></label>
                                        <input type="text"  name="rental_id" class="form-control" placeholder="Rental ID" value="{{ old('rental_id') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Rental Item Name<span class="red_asterik"></span></label>
                                        <input type="text"  name="rental_name" class="form-control" placeholder="Rental Item Name" value="{{ old('rental_name') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Date of Agreement</label>
                                        <input type="text"  name="date_of_agreement" class="form-control date_of_agreement" placeholder="Date of Agreement" value="{{ old('date_of_agreement') }}" required readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Monthly Rental Amount</label>
                                        <input type="text"  name="monthly_rental_amount" class="form-control amount_format" placeholder="Monthly Rental Amount"   value="{{ old('monthly_rental_amount') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Item Condition</label>
                                        <input type="text"  name="item_condition" class="form-control"  placeholder="Item Condition"  value="{{ old('item_condition') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input type="text"  name="brand" class="form-control"  placeholder="Brand"  value="{{ old('brand') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Supplier<span class="red_asterik"></span></label>
                                        {!! Form::select('supplier_id',$rental_supplies+[NULL=>'Select Supplier'],
                                        NULL, ['class' => 'form-control select2 select_supplier','required'=>'true']) !!}
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <input type="text" name="model" class="form-control" placeholder="Model" value="{{ old('model') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Name</label>
                                        <input type="text" name="engine_name" class="form-control" placeholder="Engine Name" value="{{ old('engine_name') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Chassis Number</label>
                                        <input type="text" name="chassis_number" class="form-control" placeholder="Chassis Number" value="{{ old('chassis_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <input type="text" name="color" class="form-control" placeholder="Color" value="{{ old('color') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Capacity</label>
                                        <input type="text" name="engine_capacity" class="form-control" placeholder="Engine Capacity" value="{{ old('engine_capacity') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Current Milage/Hours</label>
                                        <input type="text" name="current_milage" class="form-control" placeholder="Current Milage/Hours" value="{{ old('current_milage') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Current Location</label>
                                        <input type="text" name="current_localtion" class="form-control" placeholder="Current Location" value="{{ old('current_localtion') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-12 col-12">
                                    @error('specifications_1')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Specifications 1</label>
                                        <textarea name="specifications_1" class="form-control" rows="4"  required>{{ old('specifications_1') }}</textarea>
                                        <span id="specifications_1_error" class="custome_error" style="display: block;"></span>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    @error('specifications_2')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Specifications 2</label>
                                        <textarea name="specifications_2" class="form-control" rows="4"  required>{{ old('specifications_2') }}</textarea>
                                        <span id="specifications_2_error" class="custome_error" style="display: block;"></span>
                                    </div>
                                </div>

                                @error('description_input')
                                <div class="help-block error-help-block">{{ $message }}</div>
                                @enderror

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description_input" class="form-control" rows="4"  required>{{ old('description_input') }}</textarea>
                                        <span id="description_input_error" class="custome_error" style="display: block;"></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1" >Submit</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\RentalItemsRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>

        var items = "";
        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date_of_agreement').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
        });

        CKEDITOR.replace('description_input');
        CKEDITOR.replace('specifications_1');
        CKEDITOR.replace('specifications_2');

        $(".import_purchases").submit( function(e) {
            var specifications_1 = CKEDITOR.instances['specifications_1'].getData().replace(/<[^>]*>/gi, '').length;
            // if( !specifications_1 ) {
            //     $("#specifications_1_error").html("The Specifications 1 field is required.");
            //     e.preventDefault();
            // }

            var specifications_2 = CKEDITOR.instances['specifications_2'].getData().replace(/<[^>]*>/gi, '').length;
            // if( !specifications_2 ) {
            //     $("#specifications_2_error").html("The Specifications 2 field is required.");
            //     e.preventDefault();
            // }

            var description_input = CKEDITOR.instances['description_input'].getData().replace(/<[^>]*>/gi, '').length;
            // if( !description_input ) {
            //     $("#description_input_error").html("Description is required!");
            //     e.preventDefault();
            // }
        });

    </script>

@endsection

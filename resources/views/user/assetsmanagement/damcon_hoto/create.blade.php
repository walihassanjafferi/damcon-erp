@extends('layout.main')
@section('damconhoto_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon HOTO</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('damconhoto.index') }} @endsection
@section('main_btn_text') All Damcon HOTO @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th,
        .table td {
            padding: 0.72rem 0.98rem;
        }

        #file_input {
            opacity: 0;
            position: absolute;
            pointer-events: none;
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
                        <h4 class="card-title">Add Damcon HOTO</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('damconhoto.store') }}" method="post" class="import_purchases"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Type<span class="red_asterik"></span></label>
                                        <select class="form-control select2 asset_type" name="asset_type">
                                            <option value="">Select Asset type</option>
                                            <option value="damcon" {{ old('asset_type') == 'damcon' ? 'selected' : '' }}>
                                                Damcon</option>
                                            <option value="customer"
                                                {{ old('asset_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 damcon_asset" style="display: none;">
                                    <div class="form-group">
                                        <label>Damcon Asset Item ID<span class="red_asterik"></span></label>
                                        <select class="form-control select2 select_damcon_asset" name="asset_item_id">
                                            <option value="">Select Asset</option>
                                            @foreach ($damcon_assets as $item)
                                                <option value="{{ $item->id }}" data-value="{{ $item }}">
                                                    {{ $item->asset_item_id }} ( {{ $item->registration_no }} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 customer_asset" style="display: none;">
                                    <div class="form-group">
                                        <label>Customer Asset Item ID<span class="red_asterik"></span></label>
                                        <select class="form-control select2 select_customer_asset" name="customer_asset_item_id">
                                            <option value="">Select Asset</option>
                                            @foreach ($customer_assets as $item)
                                                <option value="{{ $item->id }}" data-value="{{ $item }}">
                                                    {{ $item->asset_item_id }} ( {{ $item->registration_number }} )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>




                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>HOTO Date<span class="red_asterik"></span></label>
                                        <input type="text" name="hoto_date" class="form-control hoto_date"
                                            placeholder="Date of Handover" value="{{ old('date_of_handover') }}" readonly
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>HOTO Supervisor<span class="red_asterik"></span></label>
                                        <input type="text" name="hoto_supervisor" class="form-control"
                                            placeholder="HOTO supervisor" value="{{ old('hoto_supervisor') }}"
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Current Possession<span class="red_asterik"></span></label>
                                        <input type="text" name="current_possession" class="form-control current_possession"
                                            placeholder="Current Possession" value="{{ old('current_possion') }}"
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Date of Purchase<span class="red_asterik"></span></label>
                                        <input type="text" name="date_of_purchase" class="form-control date_of_purchase"
                                            placeholder="Date of Purchase" value="{{ old('date_of_purchase') }}" readonly
                                            required />
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Item Condition<span class="red_asterik"></span></label>
                                        <input type="text"  name="item_condition" class="form-control item_condition"  placeholder="Item Condition"  value="{{ old('item_condition') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Incharge<span class="red_asterik"></span></label>
                                        <input type="text"  name="asset_incharge" class="form-control"  placeholder="Asset Incharge"  value="{{ old('asset_incharge') }}"/>
                                    </div>
                                </div> --}}


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Brand<span class="red_asterik"></span></label>
                                        <input type="text" name="asset_brand" class="form-control asset_brand"
                                            placeholder="Asset Brand" value="{{ old('asset_brand') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Model<span class="red_asterik"></span></label>
                                        <input type="text" name="model" class="form-control model" placeholder="Model"
                                            value="{{ old('model') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Registration Number<span class="red_asterik"></span></label>
                                        <input type="text" name="registration_number"
                                            class="form-control registration_number" placeholder="Registration Number"
                                            value="{{ old('registration_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Number<span class="red_asterik"></span></label>
                                        <input type="text" name="engine_number" class="form-control engine_number"
                                            placeholder="Engine Name" value="{{ old('engine_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Chassis Number<span class="red_asterik"></span></label>
                                        <input type="text" name="chassis_number" class="form-control chassis_number"
                                            placeholder="Chassis Number" value="{{ old('chassis_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Color<span class="red_asterik"></span></label>
                                        <input type="text" name="color" class="form-control color" placeholder="Color"
                                            value="{{ old('color') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Capacity<span class="red_asterik"></span></label>
                                        <input type="text" name="engine_capacity" class="form-control engine_capacity"
                                            placeholder="Engine Capacity" value="{{ old('engine_capacity') }}"
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Mileage/Hours on Purchase<span class="red_asterik"></span></label>
                                        <input type="text" name="milage" class="form-control milage_pur"
                                            placeholder="Mileage/Hours on Purchase" value="{{ old('milage') }}"
                                            required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Updated Mileage/Hours<span class="red_asterik"></span></label>
                                        <input type="text" name="last_updated_milage" class="form-control pre_milage"
                                            placeholder="Last Updated Mileage/Hours" value="{{ old('milage') }}"
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Purchase Price<span class="red_asterik"></span></label>
                                        <input type="text" name="purchase_price" class="form-control purchase_price amount_format"
                                        placeholder="Purchase Price" value="{{ old('purchase_price') }}" required />
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}"
                                                style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label>
                                        <input id="file_input" type="file" class="form-control" name="document_file[]"
                                            multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    @error('specifications_1')
                                        <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 1<span class="red_asterik"></span></label>
                                        <textarea name="specifications_1" class="form-control specifications_1" rows="4"
                                            required>{{ old('specifications_1') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    @error('specifications_2')
                                        <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 2<span class="red_asterik"></span></label>
                                        <textarea name="specifications_2" class="form-control specifications_2" rows="4"
                                            required>{{ old('specifications_2') }}</textarea>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control description" rows="4"
                                            required>{{ old('description_input') }}</textarea>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea name="comments" class="form-control comments" rows="3"
                                            required>{{ old('comments') }}</textarea>
                                    </div>
                                </div>

                                <h6 class="pl-1">Asset Current Possession</h4>
                                    <div class="col-12"></div>

                                    <input type="text" name="handover_emp_id" class="handover_emp_id" hidden />

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Handing over person CNIC<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_per_cinc"
                                                class="form-control handing_over_per_cinc" placeholder=""
                                                value="{{ old('handing_over_per_cinc') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Employee Name<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_emp_name"
                                                class="form-control handing_over_emp_name"
                                                value="{{ old('handing_over_emp_name') }}" required />
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Employee ID<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_emp_damcon_id"
                                                class="form-control handingover_emp_damcon_id"
                                                value="{{ old('handing_over_emp_id') }}" required />
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Father Name<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_father_name"
                                                class="form-control handingover_father_name"
                                                value="{{ old('father_name') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Date of Joining<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_date_join"
                                                class="form-control handingover_date_join"
                                                value="{{ old('handingover_date_join') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Designation<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_designation"
                                                class="form-control handingover_designation"
                                                value="{{ old('handingover_designation') }}" required />
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Region<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_region"
                                                class="form-control handingover_region"
                                                value="{{ old('handingover_region') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Location<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_location"
                                                class="form-control handingover_location"
                                                value="{{ old('handingover_location') }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Project<span class="red_asterik"></span></label>
                                            <input type="text" name="handingover_project_id"
                                                class="form-control handingover_project_id"
                                                value="{{ old('handingover_project_id') }}" required />
                                        </div>
                                    </div>


                                    <div class="col-12"></div>
                                    <h6 class="pl-1">Asset Next Possession</h4>
                                        <div class="col-12"></div>

                                        <input type="text" name="takeover_emp_id" class="takeover_emp_id" hidden />


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Taking Over person CNIC<span class="red_asterik"></span></label>
                                                <select class="form-control select2 takingover_per_cinc"
                                                    name="takingover_per_cinc">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($employee as $item)
                                                        <option value="{{ $item->cnic }}"> {{ $item->cnic }} ({{$item->name}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Employee Name<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_emp_name"
                                                    class="form-control takingover_emp_name"
                                                    value="{{ old('takingover_emp_name') }}" required />
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Employee ID<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_emp_damcon_id"
                                                    class="form-control takingover_emp_damcon_id"
                                                    value="{{ old('takingover_emp_id') }}" required />
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Father Name<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_father_name"
                                                    class="form-control takingover_father_name"
                                                    value="{{ old('takingover_father_name') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Date of Joining<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_date_join"
                                                    class="form-control takingover_date_join"
                                                    value="{{ old('takingover_date_join') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Designation<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_designation"
                                                    class="form-control takingover_designation"
                                                    value="{{ old('takingover_designation') }}" required />
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Region<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_region"
                                                    class="form-control takingover_region"
                                                    value="{{ old('takingover_region') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Location<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_location"
                                                    class="form-control takingover_location"
                                                    value="{{ old('takingover_location') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Project<span class="red_asterik"></span></label>
                                                <input type="text" name="takingover_project_id"
                                                    class="form-control takingover_project_id"
                                                    value="{{ old('takingover_project_id') }}" required />
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script> --}}


    <script>
        var items = "";
        $(function() {

            $('.asset_type').change(function() {

                var type = $(".asset_type option:selected");

                if (type.val() == 'customer') {
                    $('.damcon_asset').hide();
                    $('.customer_asset').show();
                } else {
                    $('.customer_asset').hide();
                    $('.damcon_asset').show();
                }

            });

            // get employees details

            $('.select_damcon_asset').change(function() {

                // $.ajax({
                // url:'{{ route('gethotoEmployeeDetails') }}',
                // data: {
                //     "_token": "{{ csrf_token() }}",
                //     "id":$id,
                // },
                // method: 'post',
                // success: function(data) {

                //     $('#tax_body_percentage').val(data.message);

                // },
                // error: function(data)
                // {    


                // }
                // });
            });





            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

            $('.hoto_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.select_damcon_asset').change(function() {
                var asset = $(".select_damcon_asset option:selected");
                var values = asset.data('value');
                console.log(values);
                // autofetching values
                $('.date_of_purchase').val(values.date_of_purchase);
                $('.description').html(values.description.replace(/(<([^>]+)>)/gi, ""));
                $('.asset_brand').val(values.asset_brand);
                // $('.item_condition').val(values.item_condition)
                $('.model').val(values.model);
                $('.registration_number').val(values.registration_no)
                $('.engine_number').val(values.engine_no)
                $('.chassis_number').val(values.chasssis_no)
                $('.color').val(values.color)
                $('.engine_capacity').val(values.engine_capacity)
                values.technical_specification_1 != null ?
                    $('.specifications_1').val(values.technical_specification_1.replace(/(<([^>]+)>)/gi,
                        "")) : '';
                values.technical_specifications_2 != null ?
                    $('.specifications_2').val(values.technical_specifications_2.replace(/(<([^>]+)>)/gi,
                        "")) : '';
                $('.comments').val(values.comments)
                $('.milage_pur').val(values.milage_hours)
                $('.purchase_price').val(values.market_price)

                // getting employee details

                var asset_id = $(".select_damcon_asset option:selected").val();
                var asset_type = $(".asset_type option:selected").val();

                $.ajax({
                    url: '{{ route('gethotoEmployeeDetails') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "asset_id": asset_id,
                        "asset_type": asset_type
                    },
                    method: 'post',
                    success: function(data) {

                        // handover employee details
                        var handover_employee = data.emp_details;

                        var fuel_consumption = data.fuel_consumption;
                        console.log(fuel_consumption);
                        $('.pre_milage').val(fuel_consumption.milage_hours)

                        $('.handing_over_per_cinc').val(handover_employee.cnic);
                        $('.handing_over_emp_name').val(handover_employee.name);
                        $('.handingover_emp_damcon_id').val(handover_employee
                            .employee_damcon_id);
                        $('.handingover_father_name').val(handover_employee.father_name);
                        $('.handingover_date_join').val(handover_employee.joining_date);
                        $('.handingover_designation').val(handover_employee.designation);
                        $('.handingover_region').val(handover_employee.region);
                        $('.handingover_region').val(handover_employee.region);
                        $('.handingover_location').val(handover_employee.assigned_locations);
                        $('.handingover_project_id').val(handover_employee.project.name);
                        $('.handover_emp_id').val(handover_employee.id);

                        $('.current_possession').val(handover_employee.name);
                    },
                    error: function(data) {


                    }
                });
            });

            // taking over employee 

            $('.takingover_per_cinc').change(function() {
                var taking_over = {!! $employee !!}

                var asset = $(".takingover_per_cinc option:selected").val();

                $.each(taking_over, function(key, value) {
                    if (value.cnic == asset) {
                        console.log(value)
                        $('.takeover_emp_id').val(value.id);
                        $('.takingover_emp_name').val(value.name)
                        $('.takingover_emp_damcon_id').val(value.employee_damcon_id)
                        $('.takingover_father_name').val(value.father_name)
                        $('.takingover_date_join').val(value.joining_date);
                        $('.takingover_designation').val(value.designation);
                        $('.takingover_region').val(value.region);
                        // $('.takingover_location').val(value.region);
                        $('.takingover_project_id').val(value.project.name)



                    }
                });

        
            });

            $('.select_customer_asset').change(function() {
        
                var asset = $(".select_customer_asset option:selected");
                var values = asset.data('value');
                // autofetching values
                $('.date_of_purchase').val(values.date_of_purchase);
                $('.description').html(values.description_input.replace(/(<([^>]+)>)/gi, ""));
                $('.asset_brand').val(values.asset_brand);
                // $('.item_condition').val(values.item_condition)
                $('.model').val(values.model);
                $('.registration_number').val(values.registration_number)
                $('.engine_number').val(values.engine_name)
                $('.chassis_number').val(values.chassis_number)
                $('.color').val(values.color)
                $('.engine_capacity').val(values.engine_capacity)
                values.specifications_1 != null ?
                    $('.specifications_1').val(values.specifications_1.replace(/(<([^>]+)>)/gi, "")) : '';
                values.specifications_2 != null ?
                    $('.specifications_2').val(values.specifications_2.replace(/(<([^>]+)>)/gi, "")) : '';
                values.comments != null ? $('.comments').val(values.comments) : '';
                $('.milage_pur').val(values.milage)
                $('.purchase_price').val(values.market_price)

                var asset_id = $(".select_customer_asset option:selected").val();
                var asset_type = $(".asset_type option:selected").val();

                $.ajax({
                    url: '{{ route('gethotoEmployeeDetails') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "asset_id": asset_id,
                        "asset_type": asset_type
                    },
                    method: 'post',
                    success: function(data) {
                       
                        // handover employee details
                        var handover_employee = data.emp_details;
                        console.log(handover_employee);

                        var fuel_consumption = data.fuel_consumption;
                        
                        
                        (fuel_consumption!=null && fuel_consumption.milage_hours!=null) ?  $('.pre_milage').val(fuel_consumption.milage_hours) : '';

                        $('.handing_over_per_cinc').val(handover_employee.cnic);
                        $('.handing_over_emp_name').val(handover_employee.name);
                        $('.handingover_emp_damcon_id').val(handover_employee
                            .employee_damcon_id);
                        $('.handingover_father_name').val(handover_employee.father_name);
                        $('.handingover_date_join').val(handover_employee.joining_date);
                        $('.handingover_designation').val(handover_employee.designation);
                        $('.handingover_region').val(handover_employee.region);
                        $('.handingover_region').val(handover_employee.region);
                        $('.handingover_location').val(handover_employee.assigned_locations);
                        $('.handingover_project_id').val(handover_employee.project.name);
                        $('.handover_emp_id').val(handover_employee.id);

                        $('.current_possession').val(handover_employee.name);
                    },
                    error: function(data) {


                    }
                });



            });
        });

        // CKEDITOR.replace('description_input');
        // CKEDITOR.replace('specifications_1');
        // CKEDITOR.replace('specifications_2');

        function previewImages() {

            var preview = document.querySelector('#preview');

            if (this.files) {
                [].forEach.call(this.files, readAndPreview);
            }

            function readAndPreview(file) {

                // Make sure `file.name` matches our extensions criteria
                var filename = file.name;
                var file_extension = filename.split('.').pop();

                if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                    return alert(file.name + " is not an image");
                } // else...

                var reader = new FileReader();

                reader.addEventListener("load", function() {

                    if (file_extension != 'pdf') {
                        $("<span class=\"pip col-3\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name +
                            "\"/>" +
                            "</span>").insertAfter("#preview");
                    } else {

                        $("<span class=\"pip col-4\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>" + file.name +
                            "</span>" +
                            "</span>").insertAfter("#preview_pdf");
                    }

                    $(".remove").click(function() {
                        $(this).parent(".pip").delay(200).fadeOut();
                    });
                });
                reader.readAsDataURL(file);
            }
        }

        document.querySelector('#file_input').addEventListener("change", previewImages);
    </script>

@endsection

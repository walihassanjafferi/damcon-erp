@extends('layout.main')
@section('hr_employee_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Employess</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('hrcategories.index')}} @endsection
@section('main_btn_text') All Employees @endsection
@section('css')
 <!-- BEGIN: Page Vendor JS-->


 <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
 {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-wizard.css') }}">
@endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    
    @if (Session::has('step'))
        @php $step = Session::get('step'); echo $step; @endphp
    @endif
   

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h4 class="card-title">Add Employee</h4>
                </div>
                {{-- <div class="card-body"> --}}
                     <!-- Horizontal Wizard -->
                <div style="padding:13px;">
                <section class="horizontal-wizard">
                    <div class="bs-stepper horizontal-wizard-example">
                        <div class="bs-stepper-header" >
                            <div class="step" data-target="#account-details {{$step == 1 ? 'active' : ''}}">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">1</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Employee Details</span>
                                        {{-- <span class="bs-stepper-subtitle">Enter Employee Details</span> --}}
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>
                            <div class="step" data-target="#personal-info {{$step == 2 ? 'active' : ''}}">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">2</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Bank Details</span>
                                        {{-- <span class="bs-stepper-subtitle">Add Personal Info</span> --}}
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>
                            <div class="step" data-target="#salary-step">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">3</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Salary break down</span>
                                        {{-- <span class="bs-stepper-subtitle">Add Address</span> --}}
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i data-feather="chevron-right" class="font-medium-2"></i>
                            </div>
                            <div class="step" data-target="#social-links">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">4</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Social Links</span>
                                        <span class="bs-stepper-subtitle">Add Social Links</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            {{-- first section --}}
                            <div id="account-details" class="content {{$step == 1 ? 'active dstepper-block' : ''}}">
                                <div class="content-header">
                                    {{-- <h5 class="mb-0">Account Details123</h5> --}}
                                    <small class="text-muted">Enter Employee details.</small>
                                </div>
                                <form id="employee_basic_details" method="POST" action={{route('saveEmployee')}}>
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="username">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{old('name')}}" />
                                            @error('name')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="email">Father name</label>
                                            <input type="text" name="father_name" id="father_name" class="form-control" placeholder="father name" value="{{old('father_name')}}"  />
                                            @error('father_name')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" for="employee_damcon_id">CNIC
                                            </label>
                                            <input type="text" name="cnic" id="cnic" class="form-control" value="{{old('cnic')}}" placeholder="CNIC" />
                                            @error('cnic_error')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" for="employee_damcon_id">Employee Damcon ID
                                            </label>
                                            <input type="text" name="employee_damcon_id" id="employee_damcon_id" value="{{old('employee_damcon_id')}}" class="form-control" placeholder="Employee Damcon ID" />
                                            @error('employee_damcon_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>
                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >EOBI Member</label>  &nbsp;
                                            <input type="checkbox" name="eobi_member_checkbox" id="eobi_member" placeholder="Eobi Member" value="{{old('eobi_member_checkbox')}}" />
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6" id="eobi_number_check" style="display: none">
                                            <label class="form-label" >Member EOBI Number</label> &nbsp;
                                            <input type="text" class="form-control" name="eobi_number" value="{{old('eobi_number')}}" id="eobi_number" placeholder="Eobi Number" />
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Social Security Member</label>  &nbsp;
                                            <input type="checkbox" name="social_security_member_checkbox" value="{{old('social_security_member_checkbox')}}" id="social_security_member_checkbox" placeholder="Social Security Member" />
                                        </div>


                                        <div class="form-group form-password-toggle col-md-6" id="social_secuity_check" style="display: none">
                                            <label class="form-label" >Social Security Number</label>
                                            <input type="text" class="form-control" name="social_security_number" value="{{old('social_security_number')}}" id="social_decurity_number" placeholder="Social security number" />
                                        </div>


                                                    
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Select Project</label>
                                                {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                                old('project_id'), ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                                @error('project_id')
                                                <div class="error-help-block">{{ $message }}</div>
                                                @enderror  
                                            </div>
                                        </div>


                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Joining Date</label>
                                            <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{old('joining_date')}}" placeholder="joining date" readonly/>
                                            @error('joining_date')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Designation</label>
                                            <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="{{old('designation')}}" />
                                            @error('designation_error')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Line Manager</label>
                                            <input type="text" class="form-control" name="line_manager_employee_id" id="line_manager_id"  value="{{old('line_manager_employee_id')}}" />
                                            @error('line_manager_employee_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label">Subordinates (multiple selected)</label>
                                            <input type="text" class="form-control" name="subordinates_id" id="subordinates_id" value="{{old('subordinates_id')}}" />
                                            @error('subordinates_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Date of Birth</label>
                                            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Date of Birth" value="{{old('date_of_birth')}}" readonly/>
                                            @error('date_of_birth')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Contact number 1</label>
                                            <input type="text" class="form-control" name="contact_no_1" id="contact_no_1"  placeholder="Contact number 1"  value="{{old('contact_no_1')}}"/>
                                            @error('contact_no_1')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Contact number 2</label>
                                            <input type="text" class="form-control" name="contact_no_2" id="contact_no_2" placeholder="Contact number 2"  value="{{old('contact_no_2')}}"/>
                                            <span id="contact_no_2" class="error-help-block"></span>
                                            @error('contact_no_2')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Email Address 1</label>
                                            <input type="text" class="form-control" name="email_address_1" id="email_address_1" value="{{old('email_address_1')}}" placeholder="Email Address 1" />
                                            @error('email_address_1')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Email Address 2</label>
                                            <input type="text" class="form-control" name="email_address_2" id="email_address_2" placeholder="Email Address 2" value="{{old('email_address_2')}}" />
                                            @error('email_address_2')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>


                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Gender</label>
                                            <select name="gender" class="select2 form-control">
                                                <option value="" selected>Select Gender</option>
                                                <option value="male" {{old('gender') == 'male' ? 'selected' : ''}} >Male</option>
                                                <option value="women"  {{old('gender') == 'women' ? 'selected' : ''}}>Women</option>
                                                <option value="shemale" {{old('gender') == 'shemale' ? 'selected' : ''}}>Shemale</option>
                                            </select>
                                            @error('gender')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror 
                                        </div>


                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label">Marital Status</label>
                                            <select name="marital_status" class="select2 form-control">
                                                <option value="" selected>Select Marital Status</option>
                                                <option value="married" {{old('marital_status') == 'married' ? 'selected' : ''}}>Married</option>
                                                <option value="single" {{old('marital_status') == 'single' ? 'selected' : ''}}>single</option>
                                            </select>
                                            @error('marital_status')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror 
                                        </div>

                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label">Religion</label>
                                            <select name="religion" class="select2 form-control">
                                                <option value="" selected>Select Religion</option>
                                                <option value="islam" {{old('religion') == 'islam' ? 'selected' : ''}} >Islam</option>
                                                <option value="christianity"  {{old('religion') == 'christianity' ? 'selected' : ''}}>Christianity</option>
                                                <option value="hinduism" {{old('religion') == 'hinduism' ? 'selected' : ''}}>Hinduism</option>
                                            </select>
                                            @error('religion')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                      


                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Region</label>
                                            <input type="text" class="form-control" name="region" id="region" placeholder="Region" value="{{old('region')}}" />
                                            @error('region')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror 
                                        
                                        </div>
                                        


                                        <div class="form-group form-password-toggle col-md-12">
                                            <label class="form-label">Current Address</label>
                                            <input type="text" class="form-control" name="current_address" id="current_address" placeholder="Current Address" value="{{old('current_address')}}" />
                                            <input type="text" class="form-control" name="current_address_lat" hidden />
                                            <input type="text" class="form-control" name="current_address_long" hidden />
                                            @error('current_address')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                       

                                        <div class="form-group form-password-toggle col-md-12">
                                            <label class="form-label">Permanent Address</label>
                                            <input type="text" class="form-control" name="permanent_address" id="current_address" placeholder="Permanent Address" value="{{old('permanent_address')}}" />
                                            <input type="text" class="form-control" name="current_address_lat" hidden />
                                            <input type="text" class="form-control" name="current_address_long" hidden />
                                            @error('permanent_address')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                      


                                        <div class="form-group form-password-toggle col-md-6">
                                            <label class="form-label" >Assigned Locations</label>
                                            <input type="text" class="form-control" name="assigned_locations" id="region" placeholder="Assigned locations" value="{{old('assigned_locations')}}" />
                                            @error('assigned_locations')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                       

                                        <input type="text" value="1" name="form_step" hidden/>
                                        
                                        <div class="col-12 mb-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>


                                        
                                    </div>
                                </form>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" {{ $step == 1 ? 'disabled' : 'abc' }} >
                                        <span class="align-middle d-sm-inline-block d-none" >Next</span>
                                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- first section end --}}

                            <div id="personal-info" class="content {{$step == 2 ? 'active dstepper-block' : ''}}">
                                <div class="content-header">
                                    <h5 class="mb-0">Bank Details</h5>
                                    {{-- <small>Enter Your Personal Info.</small> --}}
                                </div>
                                <form method="POST" action={{route('saveEmployee')}}>
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" >Bank Name <span class="red_asterik"></span></label>
                                            <input type="text" name="bank_name"  class="form-control" placeholder="Bank Name" />
                                            @error('bank_name')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" >Account title <span class="red_asterik"></span></label>
                                            <input type="text" name="account_title"  class="form-control" placeholder="Account title" />
                                            @error('account_title')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" >Account Number <span class="red_asterik"></span></label>
                                            <input type="text" name="account_number"  class="form-control" placeholder="Account Number" />
                                            @error('account_number')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <input type="text" value="2" name="form_step" hidden/>

                                    <div class="col-12 mb-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                
                                </form>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="salary-step" class="content {{$step == 3 ? 'active dstepper-block' : ''}}">
                                <div class="content-header">
                                    <h5 class="mb-0">Salary Breakdown</h5>
                                    {{-- <small>Enter Your Address.</small> --}}
                                </div>
                                <form method="POST" action={{route('saveEmployee')}}>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="basic_salary">Basic Salary</label>
                                            <input type="text" id="basic_salary" name="basic_salary" class="form-control" placeholder="Basic Salary" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="medical_allowance">Medical Allowance</label>
                                            <input type="number" name="medical_allowance" id="medical_allowance" class="form-control" placeholder="Medical Allowance" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="pincode1">Mobile Allowance</label>
                                            <input type="number" id="mobile_allowance" name="mobile_allowance" class="form-control" placeholder="Mobile Allowance" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="laptop_bonus">Laptop Bonus</label>
                                            <input type="text" id="laptop_bonus" name="laptop_bonus" class="form-control" placeholder="Birmingham" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="conveyance_allowance">Conveyance Allowance</label>
                                            <input type="number" id="conveyance_allowance" name="conveyance_allowance" class="form-control" placeholder="Conveyance Allowance" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="laptop_bonus">Other Allowance</label>
                                            <input type="text" id="other_allowance" name="other_allowance" class="form-control" placeholder="Other Allowance" />
                                        </div>
                                    </div>
                                    <input type="text" value="3" name="form_step" hidden/>
                                    <div class="col-12 mb-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="social-links" class="content">
                                <div class="content-header">
                                    <h5 class="mb-0">Social Links</h5>
                                    <small>Enter Your Social Links.</small>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="twitter">Twitter</label>
                                            <input type="text" id="twitter" name="twitter" class="form-control" placeholder="https://twitter.com/abc" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="facebook">Facebook</label>
                                            <input type="text" id="facebook" name="facebook" class="form-control" placeholder="https://facebook.com/abc" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="google">Google+</label>
                                            <input type="text" id="google" name="google" class="form-control" placeholder="https://plus.google.com/abc" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="linkedin">Linkedin</label>
                                            <input type="text" id="linkedin" name="linkedin" class="form-control" placeholder="https://linkedin.com/abc" />
                                        </div>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev">
                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-success btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                </div>
                <!-- /Horizontal Wizard -->
                {{-- </div> --}}
            </div>
        </div>
    </div>


@endsection


@section('scripts')

{{-- <script src="{{asset('app-assets/js/scripts/forms/form-wizard.js')}}"></script> --}}
<script src="{{asset('app-assets/vendors/js/ui/jquery.sticky.js')}}"></script>
{{-- <script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>  --}}
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!}

<script>

    $(function() {
        $('#name_error').hide();
    });


    $('#eobi_member').click(function(){
        if($(this).val() == 'on')
        {
            $('#eobi_number_check').show() 
        }
    })  

    $('#social_decurity_member_checkbox').click(function(){
        if($(this).val() == 'on')
        {
            $('#social_secuity_check').show() 
        }
    });


    $( "#employee_basic_details" ).submit(function( event ) {

    });


    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#date_of_birth').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: today,
        
    });

    $('#joining_date').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    });



  
    // $('#step1_submit').click(function() {
       
    //     var name = $('#name').val(); 
    //     var fathername = $('#father_name').val();
    //     var cnic = $('cnic').val();
    //     var employee_damcon_id = $('#employee_damcon_id').val();
    //     var eobi_member_checkbox = $('#eobi_member_checkbox').val();
    //     var eobi_number = $('#eobi_number').val();
    //     var social_security_member_checkbox = $('#social_decurity_member_checkbox').val();
    //     var social_security_number = $('#social_security_number').val();
    //     var project_id = $('#project_id').val();
    //     var joining_date = $('#joining_date').val();
    //     var designation = $('#designation').val();
    //     var employee_id = $('#employee_id').val();
    //     var date_of_birth = $('#date_of_birth').val();
    //     var contact_no_1 = $('#contact_no_1').val();
    //     var email_address_1 = $('#email_address_1').val();
    //     var email_address_2 = $('#email_address_2').val();
    //     var gender = $('#gender').val();
    //     var marital_status = $('#marital_status').val();
    //     var religion = $('#religion').val();
    //     var region = $('#region').val();
    //     var current_address = $('#current_address').val();
    //     var permanent_address = $('#permanent_address').val();
    //     var assigned_locations = $('#assigned_locations').val();
    //     var form_step = $('#form_step').val();

        
    //     if(name == '')
    //     {  
    //         $('#name_error').html('Name is required');
    //         $('#name_error').show();
    //         $('#name_error').focus();
    //     }
    //     else{
    //         $('#name_error').hide();
    //     }

    //     event.preventDefault();
    //     // $.ajax({
    //     //         url:'{{ route('createEmployee')}}',
    //     //         data: {
    //     //             "_token": "{{ csrf_token() }}",
    //     //         },
    //     //         method: 'post',
    //     //         success: function(data) {
                   
                
    //     //         },
    //     //         error: function(data)
    //     //         {
                    
    //     //         }
    //     //     });


    //     });
 
  
</script>

@endsection


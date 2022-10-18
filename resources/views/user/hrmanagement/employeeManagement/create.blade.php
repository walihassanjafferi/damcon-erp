
@extends('layout.main')
@section('hr_employee_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Employess</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employees')}} @endsection
@section('main_btn_text') All Employees @endsection
@section('content')
@include('alert.alert')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Employee</h4>
            </div>
            @php $form_step= 0; @endphp
            

            <div class="card-body">
                <div class="nav-vertical">
                    <ul class="nav nav-tabs nav-left flex-column" role="tablist" style="height: 140px;">
                        <li class="nav-item">
                            <a class="nav-link {{ ($form_step == 1 || $form_step == 0) ? 'active' : ''  }}" id="baseVerticalLeft-tab1" data-toggle="tab" aria-controls="employeedetails" href="#employeedetails" role="tab" aria-selected="true">Employee Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2" href="#tabVerticalLeft2" role="tab" aria-selected="false">Employee Bank Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab3" data-toggle="tab" aria-controls="tabVerticalLeft3" href="#tabVerticalLeft3" role="tab" aria-selected="false">Salary Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab4" data-toggle="tab" aria-controls="tabVerticalLeft4" href="#tabVerticalLeft4" role="tab" aria-selected="false">Pre-Allowed Leaves
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab5" data-toggle="tab" aria-controls="tabVerticalLeft5" href="#tabVerticalLeft5" role="tab" aria-selected="false">Reference Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab6" data-toggle="tab" aria-controls="tabVerticalLeft6" href="#tabVerticalLeft6" role="tab" aria-selected="false">Police Verification
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab7" data-toggle="tab" aria-controls="tabVerticalLeft7" href="#tabVerticalLeft7" role="tab" aria-selected="false">Emergency Contact Number
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab8" data-toggle="tab" aria-controls="tabVerticalLeft8" href="#tabVerticalLeft8" role="tab" aria-selected="false">Landline Contact Number
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab9" data-toggle="tab" aria-controls="tabVerticalLeft9" href="#tabVerticalLeft9" role="tab" aria-selected="false">Next of Kin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab10" data-toggle="tab" aria-controls="tabVerticalLeft10" href="#tabVerticalLeft10" role="tab" aria-selected="false">Dependents
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link disabled" id="baseVerticalLeft-tab11" data-toggle="tab" aria-controls="tabVerticalLeft11" href="#tabVerticalLeft11" role="tab" aria-selected="false">Qualifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  disabled" id="baseVerticalLeft-tab12" data-toggle="tab" aria-controls="tabVerticalLeft12" href="#tabVerticalLeft12" role="tab" aria-selected="false">Work Experience
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="employee_details_form" >
                        <div class="tab-pane {{ ($form_step == 1 || $form_step == 0) ? 'active' : ''  }}" id="employeedetails" role="tabpanel" aria-labelledby="baseVerticalLeft-tab1">
                            <h4>Employee Details</h4>
                            <form id="employee_basic_details" method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="username">Name <span class="red_asterik"></span></label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{old('name') ?? (isset($employee->name) ? $employee->name : '' )}}" />
                                        @error('name')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="email">Father name<span class="red_asterik"></span></label>
                                        <input type="text" name="father_name" id="father_name" class="form-control" placeholder="father name" value="{{old('father_name')}}"  />
                                        @error('father_name')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror  
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" for="employee_damcon_id">CNIC
                                        <span class="red_asterik"></span></label>
                                        <input type="text"  data-inputmask="'mask': '99999-9999999-9'"   name="cnic" id="cnic" class="form-control cnic" value="{{old('cnic')}}" placeholder="XXXXX-XXXXXXX-X" />
                                        @error('cnic')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror  
                                    </div>

                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" for="employee_damcon_id">Employee Damcon ID
                                            <span class="red_asterik"></span></label>
                                        <input type="text" name="employee_damcon_id" id="employee_damcon_id" value="{{old('employee_damcon_id')}}" class="form-control" placeholder="Employee Damcon ID" />
                                        @error('employee_damcon_id')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror  
                                    </div>
                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" >EOBI Member</label>  &nbsp;
                                        <input type="checkbox" name="eobi_member_checkbox" id="eobi_member" placeholder="Eobi Member" value="{{old('eobi_member_checkbox')}}"  {{ !empty(old('social_security_number')) ? 'checked' : ''}}/>
                                    </div>

                                    <div class="form-group form-password-toggle col-md-6 abc" id="eobi_number_check" {{ !empty(old('eobi_number')) ? '' : 'style=display:none' }}>
                                        <label class="form-label" >Member EOBI Number</label> &nbsp;
                                        <input type="text" class="form-control" name="eobi_number" value="{{old('eobi_number')}}" id="eobi_number" placeholder="Eobi Number" />
                                    </div>

                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" >Social Security Member</label>  &nbsp;
                                        <input type="checkbox" name="social_security_member_checkbox"  id="social_security_member_checkbox" placeholder="Social Security Member" {{ !empty(old('social_security_member_checkbox')) ? 'checked' : ''}} />
                                    </div>


                                    <div class="form-group form-password-toggle col-md-6" id="social_secuity_check" {{ !empty(old('social_security_number')) ? '' : 'style=display:none' }}>
                                        <label class="form-label" >Social Security Number</label>
                                        <input type="text" class="form-control" name="social_security_number" value="{{old('social_security_number')}}" id="social_decurity_number" placeholder="Social security number" />
                                    </div>


                                                
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Select Project<span class="red_asterik"></span></label>
                                            {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                            old('project_id'), ['class' => 'form-control select2 select_project','required'=>'true','id'=>'project_id']) !!}
                                            @error('project_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                            @enderror  
                                        </div>
                                    </div>


                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" >Joining Date<span class="red_asterik"></span></label>
                                        <input type="text" class="form-control" name="joining_date" id="joining_date" value="{{old('joining_date')}}" placeholder="joining date" readonly/>
                                        @error('joining_date')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" >Designation<span class="red_asterik"></span></label>
                                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="{{old('designation')}}" />
                                        @error('designation')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label" >Line Manager</label>
                                        {{-- <input type="text" class="form-control" name="line_manager_employee_id" id="line_manager_id"  value="{{old('line_manager_employee_id')}}" /> --}}
                                        <select class="select2 check-emp" name="line_manager_employee_id" id="line_manager_employee_id">
                                         
                                        </select>
                                       
                                        @error('line_manager_employee_id')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                   


                                    <div class="form-group form-password-toggle col-md-6">
                                        <label class="form-label">Subordinates (multiple selected)</label>
                                        {{-- <input type="text" class="form-control" name="subordinates_id" id="subordinates_id" value="{{old('subordinates_id')}}" /> --}}
                                        
                                        <select class="select2 check-emp" multiple="multiple"  name="subordinates_id[]" id="subordinates_id">
        
                                        </select>
                                        
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
                                        <label class="form-label" >Gender<span class="red_asterik"></span></label>
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


                                    <br/>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                   


                                    
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane {{ ($form_step == 2) ? 'active' : ''  }}" id="tabVerticalLeft2" role="tabpanel" aria-labelledby="baseVerticalLeft-tab2">
                          <h4>Employee Bank Details</h4>
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

                          
                            <button type="submit" class="btn btn-primary">Save</button>
                           
                        
                        </form>
                        </div>
                        <div class="tab-pane {{ ($form_step == 3) ? 'active' : ''  }}" id="tabVerticalLeft3" role="tabpanel" aria-labelledby="baseVerticalLeft-tab3">
                            <h4>Salary details</h4>
                            <form method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="basic_salary">Basic Salary</label>
                                        <input type="text" id="basic_salary" name="basic_salary" class="form-control amount_format" placeholder="Basic Salary" value="{{ old('basic_salary') }}"/>
                                        @error('basic_salary')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="medical_allowance">Medical Allowance</label>
                                        <input type="text" name="medical_allowance" id="medical_allowance" class="form-control amount_format" placeholder="Medical Allowance" value="{{old('medical_allowance')}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="pincode1">Mobile Allowance</label>
                                        <input type="text" id="mobile_allowance" name="mobile_allowance" class="form-control amount_format" placeholder="Mobile Allowance" value="{{old('mobile_allowance')}}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="laptop_bonus">Laptop Bonus</label>
                                        <input type="text" id="laptop_bonus" name="laptop_bonus" class="form-control amount_format" placeholder="Laptop Bonus" value="{{old('laptop_bonus')}}" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="conveyance_allowance">Conveyance Allowance</label>
                                        <input type="text" id="conveyance_allowance" name="conveyance_allowance" class="form-control amount_format" placeholder="Conveyance Allowance" value="{{old('conveyance_allowance')}}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="laptop_bonus">Other Allowance</label>
                                        <input type="text" id="other_allowance" name="other_allowance" class="form-control amount_format" placeholder="Other Allowance"  value="{{old('other_allowance')}}"/>
                                    </div>
                                </div>
                                <input type="text" value="3" name="form_step" hidden/>
                              
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                            </form>
                        </div>
                        <div class="tab-pane {{ ($form_step == 4) ? 'active' : ''  }}" id="tabVerticalLeft4" role="tabpanel" aria-labelledby="baseVerticalLeft-tab4">
                            <h4>Pre-Allowed Leaves</h4>
                            <form method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="annual_leaves">Annual Leaves</label>
                                        <input type="number" id="annual_leaves" name="annual_leaves" class="form-control" placeholder="Annual leaves" value="{{ old('annual_leaves') }}"/>
                                        @error('annual_leaves')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="annual_leaves">Casual Leaves</label>
                                        <input type="number" id="casual_leaves" name="casual_leaves" class="form-control" placeholder="Casual leaves" value="{{ old('casual_leaves') }}"/>
                                        @error('casual_leaves')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="sick_leaves">Sick Leaves</label>
                                        <input type="number" id="sick_leaves" name="sick_leaves" class="form-control" placeholder="Sick leaves" value="{{ old('sick_leaves') }}"/>
                                        @error('sick_leaves')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="off_leaves">Off Leaves</label>
                                        <input type="number" id="off_leaves" name="off_leaves" class="form-control" placeholder="off leaves" value="{{ old('off_leaves') }}"/>
                                        @error('off_leaves')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                </div>
                               
                                
                                <input type="text" value="4" name="form_step" hidden/>
                              
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                            </form>
                        </div>  

                        <div class="tab-pane {{ ($form_step == 5) ? 'active' : ''  }}" id="tabVerticalLeft5" role="tabpanel" aria-labelledby="baseVerticalLeft-tab5">
                            <h4>Reference</h4>
                            <h5>Details 1</h5>
                            <form method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_name">Name</label>
                                        <input type="text" id="reference_name" name="reference_name_one" class="form-control" placeholder="Name" value="{{ old('reference_name_one') }}"/>
                                        @error('reference_name_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_contactno_one">Contact Number</label>
                                        <input type="number" name="reference_contactno_one" id="reference_contactno_one" class="form-control" placeholder="Contact Number" value="{{old('reference_contactno_one')}}" />
                                        @error('reference_contactno_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_occupation_one">Occupation</label>
                                        <input type="text" id="reference_occupation_one" name="reference_occupation_one" class="form-control" placeholder="Occupation" value="{{old('reference_occupation_one')}}" />
                                        @error('reference_occupation_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_email_one">Email</label>
                                        <input type="email" id="reference_email_one" name="reference_email_one" class="form-control" placeholder="Email" value="{{old('reference_email_one')}}" />
                                        @error('reference_email_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                </div>

                                <h5>Details 2</h5>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_name">Name</label>
                                        <input type="text" id="reference_name_two" name="reference_name_two" class="form-control" placeholder="Name" value="{{ old('reference_name_two') }}"/>
                                        @error('reference_name')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_contactno_two">Contact Number</label>
                                        <input type="number" name="reference_contactno_two" id="reference_contactno_two" class="form-control" placeholder="Contact Number" value="{{old('reference_contactno_two')}}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_occupation_two">Occupation</label>
                                        <input type="text" id="reference_occupation_two" name="reference_occupation_two" class="form-control" placeholder="Occupation" value="{{old('reference_occupation_two')}}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_email_two">Email</label>
                                        <input type="email" id="reference_email_two" name="reference_email_two" class="form-control" placeholder="Email" value="{{old('reference_email_two')}}" />
                                    </div>
                                </div>

                            
                                <input type="text" value="6" name="form_step" hidden/>
                              
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                            </form>


                        </div>  

                        <div class="tab-pane {{ ($form_step == 6) ? 'active' : ''  }}" id="tabVerticalLeft6" role="tabpanel" aria-labelledby="baseVerticalLeft-tab6">
                            <h4>Police Verification</h4>
                            <form method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_date">Verification Date</label>
                                        <input type="text" id="verification_date" name="verification_date" class="form-control" placeholder="Verification Date" value="{{ old('verification_date') }}"/>
                                        @error('verification_date')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_contactno_one">Status</label>
                                        {{-- <input type="text" name="status" id="status" class="form-control" placeholder="Status" value="{{old('status')}}" /> --}}
                                        <select class="form-control" name="status" id="verification_status_one">
                                            <option value="" selected>Select Status</option>
                                            <option value=1>Active</option>
                                            <option value=0>Inactive</option>
                                        </select>
                                       
                                        @error('status')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="reference_contactno_one">Station</label>
                                        <input type="text" name="station" id="station" class="form-control" placeholder="station" value="{{old('station')}}" />
                                        @error('station')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  
                                </div>
                                <div class="col-12">
                                    <input type="text" value="6" name="form_step" hidden/>
                              
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>  

                        <div class="tab-pane {{ ($form_step == 7) ? 'active' : ''  }}" id="tabVerticalLeft7" role="tabpanel" aria-labelledby="baseVerticalLeft-tab7">
                            <h4>Emergency</h4>
                            <h5>Contact no 1</h5>
                            <form method="POST" action={{route('saveEmployee')}}>
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_one">Name</label>
                                        <input type="text" id="name_one" name="name_one" class="form-control" placeholder="Name" value="{{ old('name_one') }}"/>
                                        @error('name_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_one">Relationship</label>
                                        <input type="text" name="relationship_one" id="relationship_one" class="form-control" placeholder="Relationship" value="{{old('relationship_one')}}" />
                                        @error('relationship_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_one">Verification Status</label>
                                        <input type="text" name="verification_status_one" id="verification_status_one" class="form-control" placeholder="Verification" value="{{old('verification_status_one')}}" />
                                        @error('verification_status_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                                <h5>Contact no 2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_two">Name</label>
                                        <input type="text" id="name_one" name="name_two" class="form-control" placeholder="Name" value="{{ old('name_two') }}"/>
                                        @error('name_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_two">Relationship</label>
                                        <input type="text" name="relationship_two" id="relationship_two" class="form-control" placeholder="Relationship" value="{{old('relationship_two')}}" />
                                    </div>
                                    @error('relationship_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_two">Verification Status</label>
                                        <input type="text" name="verification_status_two" id="verification_status_two" class="form-control" placeholder="Verification" value="{{old('verification_status_two')}}" />
                                    </div>
                                    @error('verification_status_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <h5>Contact no 3</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_three">Name</label>
                                        <input type="text" id="name_three" name="name_three" class="form-control" placeholder="Name" value="{{ old('name_three') }}"/>
                                        @error('name_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_three">Relationship</label>
                                        <input type="text" name="relationship_three" id="relationship_three" class="form-control" placeholder="Relationship" value="{{old('relationship_three')}}" />
                                        @error('relationship_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_three">Verification Status</label>
                                        <input type="text" name="verification_status_three" id="verification_status_three" class="form-control" placeholder="Verification" value="{{old('verification_status_three')}}" />
                                        @error('verification_status_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-12 pl-0">
                                    <input type="text" value="7" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div> 
                        <div class="tab-pane {{ ($form_step == 8) ? 'active' : ''  }}" id="tabVerticalLeft8" role="tabpanel" aria-labelledby="baseVerticalLeft-tab8">
                            <h4>Landline Contact Number</h4>
                            <h5>Contact no 1</h5>
                            <form method="POST" action={{route('saveEmployee')}} >
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_one">Name</label>
                                        <input type="text" id="name_one" name="name_one" class="form-control" placeholder="Name" value="{{ old('name_one') }}"/>
                                        @error('name_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_one">Relationship</label>
                                        <input type="text" name="relationship_one" id="relationship_one" class="form-control" placeholder="Relationship" value="{{old('relationship_one')}}" />
                                        @error('relationship_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_one">Verification Status</label>
                                        <input type="text" name="verification_status_one" id="verification_status_one" class="form-control" placeholder="Verification" value="{{old('verification_status_one')}}" />
                                        @error('verification_status_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h5>Contact no 2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_two">Name</label>
                                        <input type="text" id="name_one" name="name_two" class="form-control" placeholder="Name" value="{{ old('name_two') }}"/>
                                        @error('name_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_two">Relationship</label>
                                        <input type="text" name="relationship_two" id="relationship_two" class="form-control" placeholder="Relationship" value="{{old('relationship_two')}}" />
                                        @error('relationship_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_two">Verification Status</label>
                                        <input type="text" name="verification_status_two" id="verification_status_two" class="form-control" placeholder="Verification" value="{{old('verification_status_two')}}" />
                                    </div>
                                    @error('verification_status_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 pl-0">
                                    <input type="text" value="8" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </form>
                        </div> 
                        <div class="tab-pane {{ ($form_step == 9) ? 'active' : ''  }}" id="tabVerticalLeft9" role="tabpanel" aria-labelledby="baseVerticalLeft-tab9">
                            <h4>Next of Kins</h4>
                            <h5>1</h5>
                            <form method="POST" action={{route('saveEmployee')}} >
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_one">Name</label>
                                        <input type="text" id="name_one" name="name_one" class="form-control" placeholder="Name" value="{{ old('name_one') }}"/>
                                        @error('name_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="cnic_one">Cnic</label>
                                        <input type="text" name="cnic_one" id="cnic_one" class="form-control" placeholder="Cnic" value="{{old('cnic_one')}}" />
                                        @error('cnic_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_one">Relationship</label>
                                        <input type="text" id="relationship_one" name="relationship_one" class="form-control" placeholder="Relationship" value="{{ old('relationship_one') }}"/>
                                        @error('relationship_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_one">Verification Status</label>
                                        <input type="text" name="verification_status_one" id="verification_status_one" class="form-control" placeholder="verification_status_one" value="{{old('verification_status_one')}}" />
                                        @error('verification_status_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h5>2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_two">Name</label>
                                        <input type="text" id="name_two" name="name_two" class="form-control" placeholder="Name" value="{{ old('name_two') }}"/>
                                        @error('name_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="cnic_two">Cnic</label>
                                        <input type="text" name="cnic_two" id="cnic_two" class="form-control" placeholder="Cnic" value="{{old('cnic_two')}}" />
                                    </div>
                                    @error('cnic_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_two">Relationship</label>
                                        <input type="text" id="relationship_two" name="relationship_two" class="form-control" placeholder="Relationship" value="{{ old('relationship_two') }}"/>
                                        @error('relationship_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_two">Verification Status</label>
                                        <input type="text" name="verification_status_two" id="verification_status_two" class="form-control" placeholder="verification_status_two" value="{{old('verification_status_two')}}" />
                                    </div>
                                    @error('verification_status_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 pl-0">
                                    <input type="text" value="9" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </form>
                        </div>  
                        <div class="tab-pane {{ ($form_step == 10) ? 'active' : ''  }}" id="tabVerticalLeft10" role="tabpanel" aria-labelledby="baseVerticalLeft-tab10">
                            <h4>Dependents</h4>
                            <h5>1</h5>
                            <form method="POST" action={{route('saveEmployee')}} >
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_one">Name</label>
                                        <input type="text" id="name_one" name="name_one" class="form-control" placeholder="Name" value="{{ old('name_one') }}"/>
                                        @error('name_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="cnic_one">Cnic</label>
                                        <input type="text" name="cnic_one" id="cnic_one" class="form-control" placeholder="Cnic" value="{{old('cnic_one')}}" />
                                        @error('cnic_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_one">Relationship</label>
                                        <input type="text" id="relationship_one" name="relationship_one" class="form-control" placeholder="Relationship" value="{{ old('relationship_one') }}"/>
                                        @error('relationship_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="cnic_one">Verification Status</label>
                                        <input type="text" name="verification_status_one" id="verification_status_one" class="form-control" placeholder="Veritication Status" value="{{old('verification_status_one')}}" />
                                        @error('verification_status_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <h5>2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="name_two">Name</label>
                                        <input type="text" id="name_two" name="name_two" class="form-control" placeholder="Name" value="{{ old('name_two') }}"/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="cnic_two">Cnic</label>
                                        <input type="text" name="cnic_two" id="cnic_two" class="form-control" placeholder="Cnic" value="{{old('cnic_two')}}" />
                                    </div>
                                  
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="relationship_two">Relationship</label>
                                        <input type="text" id="relationship_two" name="relationship_two" class="form-control" placeholder="Relationship" value="{{ old('relationship_two') }}"/>
                                        @error('relationship_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="verification_status_two">Verification Status</label>
                                        <input type="text" name="verification_status_two" id="verification_status_one" class="form-control" placeholder="Veritication Status" value="{{old('verification_status_two')}}" />
                                    </div>
                                    @error('verification_status_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 pl-0">
                                    <input type="text" value="10" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                                
                            </form>
                            
                        </div>
                        <div class="tab-pane {{ ($form_step == 11) ? 'active' : ''  }}" id="tabVerticalLeft11" role="tabpanel" aria-labelledby="baseVerticalLeft-tab11">
                            <h4>Qualifications</h4>
                            <h5>Details 1</h5>
                            <form method="POST" action={{route('saveEmployee')}} >
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="program_one">Program</label>
                                        <input type="text" id="program_one" name="program_one" class="form-control" placeholder="Program" value="{{ old('program_one') }}"/>
                                        @error('program_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="passing_year_one">Passing Year</label>
                                        <input type="text" name="passing_year_one" id="passing_year_one" class="form-control" placeholder="Passing Year" value="{{old('passing_year_one')}}" />
                                        @error('passing_year_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="marks_percentage_one">Marks Percentage</label>
                                        <input type="text" id="marks_percentage_one" name="marks_percentage_one" class="form-control" placeholder="Program" value="{{ old('program_one') }}"/>
                                        @error('marks_percentage_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h5>Details 2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="program_two">Program</label>
                                        <input type="text" id="program_two" name="program_two" class="form-control" placeholder="Program" value="{{ old('program_two') }}"/>
                                        @error('program_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="passing_year_two">Passing Year</label>
                                        <input type="text" name="passing_year_two" id="passing_year_two" class="form-control" placeholder="Passing Year" value="{{old('passing_year_two')}}" />
                                    </div>
                                    @error('passing_year_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="marks_percentage_two">Marks Percentage</label>
                                        <input type="text" id="marks_percentage_two" name="marks_percentage_two" class="form-control" placeholder="Marks Percentage" value="{{ old('marks_percentage_two') }}"/>
                                        @error('marks_percentage_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h5>Details 3</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="program_three">Program</label>
                                        <input type="text" id="program_three" name="program_three" class="form-control" placeholder="Program" value="{{ old('program_three') }}"/>
                                        @error('program_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="passing_year_three">Passing Year</label>
                                        <input type="text" name="passing_year_three" id="passing_year_three" class="form-control" placeholder="Passing Year" value="{{old('passing_year_three')}}" />
                                    </div>
                                    @error('passing_year_three')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="marks_percentage_three">Marks Percentage</label>
                                        <input type="text" id="marks_percentage_three" name="marks_percentage_three" class="form-control" placeholder="Marks Percentage" value="{{ old('marks_percentage_three') }}"/>
                                        @error('marks_percentage_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <h5>Details 4</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="program_four">Program</label>
                                        <input type="text" id="program_four" name="program_four" class="form-control" placeholder="Program" value="{{ old('program_four') }}"/>
                                        @error('program_four')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="passing_year_four">Passing Year</label>
                                        <input type="text" name="passing_year_four" id="passing_year_four" class="form-control" placeholder="Passing Year" value="{{old('passing_year_four')}}" />
                                    </div>
                                    @error('passing_year_four')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="marks_percentage_four">Marks Percentage</label>
                                        <input type="text" id="marks_percentage_four" name="marks_percentage_four" class="form-control" placeholder="Marks Percentage" value="{{ old('marks_percentage_four') }}"/>
                                        @error('marks_percentage_four')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 pl-0">
                                    <input type="text" value="11" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </form>
                        </div>  
                        <div class="tab-pane {{ ($form_step == 12) ? 'active' : ''  }}" id="tabVerticalLeft12" role="tabpanel" aria-labelledby="baseVerticalLeft-tab12">
                            <h4>Work Experience</h4>
                            <h5>1</h5>
                            <form method="POST" action={{route('saveEmployee')}} >
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="jobtitle_one">Job title</label>
                                        <input type="text" id="jobtitle_one" name="jobtitle_one" class="form-control" placeholder="Job title" value="{{ old('jobtitle_one') }}"/>
                                        @error('jobtitle_one')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="organization_one">Organization</label>
                                        <input type="text" name="organization_one" id="organization_one" class="form-control" placeholder="Organization" value="{{old('organization_one')}}" />
                                    </div>
                                    @error('organization_one')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="duration_one">Duration</label>
                                        <input type="text" name="duration_one" id="duration_one" class="form-control" placeholder="Duration" value="{{old('duration_one')}}" />
                                    </div>
                                    @error('duration_one')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <h5>2</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="jobtitle_two">Job title</label>
                                        <input type="text" id="jobtitle_two" name="jobtitle_two" class="form-control" placeholder="Job title" value="{{ old('jobtitle_two') }}"/>
                                        @error('jobtitle_two')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="organization_two">Organization</label>
                                        <input type="text" name="organization_two" id="organization_two" class="form-control" placeholder="Organization" value="{{old('organization_two')}}" />
                                    </div>
                                    @error('organization_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="duration_two">Duration</label>
                                        <input type="text" name="duration_two" id="duration_two" class="form-control" placeholder="Duration" value="{{old('duration_two')}}" />
                                    </div>
                                    @error('duration_two')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <h5>3</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="jobtitle_three">Job title</label>
                                        <input type="text" id="jobtitle_three" name="jobtitle_three" class="form-control" placeholder="Job title" value="{{ old('jobtitle_three') }}"/>
                                        @error('jobtitle_three')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="organization_three">Organization</label>
                                        <input type="text" name="organization_three" id="organization_three" class="form-control" placeholder="Organization" value="{{old('organization_three')}}" />
                                    </div>
                                    @error('organization_three')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="duration_three">Duration</label>
                                        <input type="text" name="duration_three" id="duration_three" class="form-control" placeholder="Duration" value="{{old('duration_three')}}" />
                                    </div>
                                    @error('duration_three')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <h5>4</h5>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="jobtitle_four">Job title</label>
                                        <input type="text" id="jobtitle_four" name="jobtitle_four" class="form-control" placeholder="Job title" value="{{ old('jobtitle_four') }}"/>
                                        @error('jobtitle_four')
                                        <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="organization_four">Organization</label>
                                        <input type="text" name="organization_four" id="organization_four" class="form-control" placeholder="Organization" value="{{old('organization_four')}}" />
                                    </div>
                                    @error('organization_four')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="duration_four">Duration</label>
                                        <input type="text" name="duration_four" id="duration_four" class="form-control" placeholder="Duration" value="{{old('duration_four')}}" />
                                    </div>
                                    @error('duration_four')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 pl-0">
                                    <input type="text" value="12" name="form_step" hidden/>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>


                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> 
<script>
     $(function() {
        $('#name_error').hide();

        $('.cnic').inputmask();
    });


    $('#eobi_member').click(function(){
        

        var eobi_check = $(this).is(':checked');
        if(eobi_check)
        {  
            $('#eobi_number_check').show() 
            $('#eobi_number_check #eobi_number').css('border-color','#281570');
        }
        else{
            $('#eobi_number_check').hide() 
        }
    })  

    $('#social_security_member_checkbox').click(function(){
      
        var social_security = $(this).is(':checked');

        if(social_security)
        {
            $('#social_secuity_check').show();
            $('#social_secuity_check #social_decurity_number').css('border-color','#281570');

        }
        else{
            $('#social_secuity_check').hide() 
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

    $('#verification_date').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    });

    $('.select_project').change(function(){

            var project_id = $(this).val();

            $.ajax({
                url:'{{ route('getProjectEmp')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "project_id":project_id
                },
                method: 'post',
                success: function(data) {
                   
                   
                    $('#subordinates_id').html('');
                    var employess = data.employees;
                
                    $.each(employess,function(key,value) {
                        $('#subordinates_id').append(
                            '<option value='+value.id+'>'+value.name+'('+value.designation+')'+'</option>'
                        )
                    });

                    $('#line_manager_employee_id').html('');
                    $('#line_manager_employee_id').append(
                        '<option value="">Select Line Manager</option>'
                    );
                    $.each(employess,function(key,value) {
                        $('#line_manager_employee_id').append(
                            '<option value='+value.id+'>'+value.name+' ('+value.designation+')'+'</option>'
                        )
                    });
                
                },
                error: function(data)
                {
                    alert('Opps! Error Occured');
                }
            });


    });


    $('#subordinates_id').change(function(){
            var linemanager = $('#line_manager_employee_id :selected').val();
            var subordinate = $('#subordinates_id :selected').val();

            if(linemanager == subordinate)
            {
                alert("Error, \nLine manager & Subordinate can't be the same!");
                $('#line_manager_employee_id').css('border-color','red');
                $('#subordinates_id').val('').change();
                $('#line_manager_employee_id').val('').change();
                return;
            }
    });


        // $('#line_manager_employee_id').change(function(){
        //         var linemanager = $('#line_manager_employee_id :selected').val();
        //         var subordinate = $('#subordinates_id :selected').val();

        //         if(linemanager == subordinate)
        //         {
        //             alert("Error, \nLine manager & Subordinate can't be the same!");
        //             $('#line_manager_employee_id').css('border-color','red');
        //             $('#subordinates_id').val('').change();
        //             $('#line_manager_employee_id').val('').change();
        //             return;
        //         }
        // });
    





</script>

@endsection
@extends('layout.main')
@section('hr_increment_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Edit Increment Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('increment-management.show',encrypt($increment->employeemanagement_id))}} @endsection
@section('main_btn_text') Back @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Increment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('increment-management.update',encrypt($increment->id))}}"  method="post">
                        @csrf
                        @method('patch')
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Employee CNIC</label>
                                    <select name="employee_cnic" class="form-control select2" id="employee_cnic" >
                                        <option value="" selected>Select CNIC</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->cnic}}"  {{$increment->employee_cnic == $emp->cnic ? 'selected' : '' }} data-cnicid = {{$emp->id}}>{{$emp->cnic}} </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Employee Name </label>
                                        <select name="emp_name" class="form-control select2" id="employee_name">
                                            <option value="" selected>Select Employee</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{$emp->name}}" {{$increment->emp_name == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
                                            @endforeach
                                        </select>
                                    @error('employee_name')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Employee ID</label> 
                                    <select name="employee_id" class="form-control select2" id="employee_id">
                                        <option value="" selected>Select Employee ID</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->id}}" {{$increment->employeemanagement_id  == $emp->id ? 'selected' : '' }}>{{$emp->employee_damcon_id}} </option>
                                        @endforeach
                                    </select>
                                    @error('employee_name')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Father Name</label>
                                    <input type="text" name="father_name" class="form-control father_name" value="{{ $increment->father_name }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="text" name="joining_date" class="form-control joining_date" value="{{ $increment->joining_date }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Basic Salary</label>
                                    <input type="number" name="current_basic_salary" class="form-control current_basic_salary" value="{{ $increment->current_basic_salary }}" placeholder="Basic Salary" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Medical Allowance</label>
                                    <input type="number" name="current_medical_allowance" class="form-control current_medical_allowance" value="{{ $increment->current_medical_allowance }}" placeholder="Current Medical Allowance" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Mobile Allowance</label>
                                    <input type="number" name="current_mobile_allowance" class="form-control current_mobile_allowance" value="{{ $increment->current_mobile_allowance }}" placeholder="Current Mobile Allowance" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Laptop Bonus</label>
                                    <input type="number" name="current_laptop_bonus" class="form-control current_laptop_bonus" value="{{ $increment->current_laptop_bonus }}" placeholder="Current Laptop Bonus" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Conveyance Allowance</label>
                                    <input type="number" name="current_conveyance_allowance" class="form-control current_conveyance_allowance" value="{{ $increment->current_conveyance_allowance }}" placeholder="Current Conveyance Allowance" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Other Allowance</label>
                                    <input type="number" name="current_other_allowance" class="form-control current_other_allowance" value="{{ $increment->current_other_allowance }}" placeholder="Current Other Allowance" readonly/>
                                </div>
                            </div>
                        </div>

                        {{-- new row --}}
                        <h5>New Salaries & Allowances</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Basic Salary</label>
                                    <input type="number" name="new_basic_salary" class="form-control new_basic_salary" value="{{ $increment->new_basic_salary }}" placeholder="New Basic Salary" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Medical Allowance</label>
                                    <input type="number" name="new_medical_allowance" class="form-control new_medical_allowance" value="{{ $increment->new_medical_allowance }}" placeholder="New Medical Allowance" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Mobile Allowance</label>
                                    <input type="number" name="new_mobile_allowance" class="form-control new_mobile_allowance" value="{{ $increment->new_mobile_allowance }}" placeholder="New Mobile Allowance" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Laptop Bonus</label>
                                    <input type="number" name="new_laptop_bonus" class="form-control new_laptop_bonus" value="{{ $increment->new_laptop_bonus }}" placeholder="New Laptop Bonus" />
                                </div>
                            </div>
                            



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Conveyance Allowance</label>
                                    <input type="number" name="new_conveyance_Allowance" class="form-control new_conveyance_Allowance" value="{{ $increment->new_conveyance_Allowance }}" placeholder="New Conveyance Allowance" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Other Allowance</label>
                                    <input type="number" name="new_other_allowance" class="form-control new_other_allowance" value="{{ $increment->new_other_allowance }}" placeholder="New Other Allowance" />
                                </div>
                            </div>

                        </div>
                        <h5>New Salaries & Allowances Increments</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Basic Salary</label>
                                    <input type="number" name="inc_basic_salary" class="form-control inc_basic_salary" value="{{ $increment->inc_basic_salary }}" placeholder="New Basic Salary" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Medical Allowance</label>
                                    <input type="number" name="inc_medical_allowance" class="form-control inc_medical_allowance" value="{{ $increment->inc_medical_allowance }}" placeholder="New Medical Allowance" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Mobile Allowance</label>
                                    <input type="number" name="inc_mobile_allowance" class="form-control inc_mobile_allowance" value="{{ $increment->inc_mobile_allowance }}" placeholder="New Mobile Allowance" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Laptop Bonus</label>
                                    <input type="number" name="inc_laptop_bonus" class="form-control inc_laptop_bonus" value="{{ $increment->inc_laptop_bonus }}" placeholder="New Laptop Bonus" readonly/>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Conveyance Allowance</label>
                                    <input type="number" name="inc_conveyance_Allowance" class="form-control inc_conveyance_Allowance" value="{{ $increment->inc_conveyance_Allowance }}" placeholder="New Conveyance Allowance" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Other Allowance</label>
                                    <input type="number" name="inc_other_allowance" class="form-control inc_other_allowance" value="{{ $increment->inc_other_allowance }}" placeholder="New Other Allowance" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Total Increment</label>
                                    <input type="number" name="total_increment" class="form-control total_increment" value={{$increment->total_increment}} placeholder="Total Increment" readonly/>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments" class="form-control comments" rows="3"
                                        required>{{ $increment->comments }}</textarea>
                                </div>
                            </div>

                        </div>


                    


                        
                
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            </div>
                        </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!}

<script>
   
    $(function(){

        var data = {!! json_encode($employees) !!};

        $('#employee_cnic').change(function(){

            // empty values
            $('#employee_name').val('').change();
            $('#employee_id').val('').change();
            $('.father_name').val('');
            $('.joining_date').val('');
            $('.current_basic_salary').val('');
            $('.current_project').val('').change();
            $('.current_medical_allowance').val('');
            $('.current_mobile_allowance').val('');
            $('.current_laptop_bonus').val('');
            $('.current_conveyance_allowance').val('');
            $('.current_other_allowance').val('');


            var id = $(this).find(":selected").data('cnicid');
            
            $.each( data, function( key, value ) {
               if(id === value.id)
               {    
                    $('#employee_name').val(value.name).change();
                    $('#employee_id').val(value.id).change();
                    $('.father_name').val(value.father_name);
                    $('.joining_date').val(value.joining_date);
                    
                    if(value.salarybreakdown != null)
                    {
                        $('.current_basic_salary').val(value.salarybreakdown.basic_salary);
                      
                    }
                  
                    if(value.salarybreakdown.medical_allowance != null)
                    {
                        $('.current_medical_allowance').val(value.salarybreakdown.medical_allowance);

                    }
                    if(value.salarybreakdown.mobile_allowance != null)
                    {
                        $('.current_mobile_allowance').val(value.salarybreakdown.mobile_allowance);

                    }
                    if(value.salarybreakdown.conveyance_allowance != null)
                    {
                        $('.current_conveyance_allowance').val(value.salarybreakdown.conveyance_allowance);
                    }
                    if(value.salarybreakdown.laptop_bonus != null)
                    {
                        $('.current_laptop_bonus').val(value.salarybreakdown.laptop_bonus);
                    }
                    if(value.salarybreakdown.other_allowance != null)
                    {
                        $('.current_other_allowance').val(value.salarybreakdown.other_allowance);
                    }
                    if(value.project != null)
                    {
                        $('.current_project').val(value.project.id).change();
                    }

                
               }
            });
            

        });

        //  calculation new salaries
        $('.new_basic_salary').keyup(function(){
            var new_salary = $(this).val();
            var basic_salary = $('.current_basic_salary').val();

            var inc_salary = parseFloat( new_salary) - parseFloat(basic_salary);

            $('.inc_basic_salary').val(inc_salary.toFixed(2));

            calulateTotal();
        
        });

        $('.new_medical_allowance').keyup(function(){
            var new_allowance = $(this).val();
            var current_allowance = $('.current_medical_allowance').val();

            var inc_allowance = parseFloat( new_allowance) - parseFloat(current_allowance);

            $('.inc_medical_allowance').val(inc_allowance.toFixed(2));

        
            calulateTotal();

            
        });


        $('.new_mobile_allowance').keyup(function(){
            var new_allowance = $(this).val();
            var current_allowance = $('.current_mobile_allowance').val();

            var inc_allowance = parseFloat( new_allowance) - parseFloat(current_allowance);

            $('.inc_mobile_allowance').val(inc_allowance.toFixed(2));

            calulateTotal()
            
        });

        $('.new_laptop_bonus').keyup(function(){
            var new_allowance = $(this).val();
            var current_allowance = $('.current_laptop_bonus').val();

            var inc_allowance = parseFloat( new_allowance) - parseFloat(current_allowance);

            $('.inc_laptop_bonus').val(inc_allowance.toFixed(2));

            calulateTotal()
         
        });


        $('.new_conveyance_Allowance').keyup(function(){
            var new_allowance = $(this).val();
            var current_allowance = $('.current_conveyance_allowance').val();

            var inc_allowance = parseFloat( new_allowance) - parseFloat(current_allowance);

            $('.inc_conveyance_Allowance').val(inc_allowance.toFixed(2));

            calulateTotal()
           
        });


        $('.new_other_allowance').keyup(function(){
            var new_allowance = $(this).val();
            var current_allowance = $('.current_other_allowance').val();

            var inc_allowance = parseFloat( new_allowance) - parseFloat(current_allowance);

            $('.inc_other_allowance').val(inc_allowance.toFixed(2));
           
           
            calulateTotal();

           
        });


        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_transfer').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
      


    });


    
    function calulateTotal() {
            var inc_salary = Number($('.inc_basic_salary').val());
            var inc_medical_allowance = Number($('.inc_medical_allowance').val());
            var inc_mobile_allowance = Number($('.inc_mobile_allowance').val());
            var inc_laptop_bonus = Number($('.inc_mobile_allowance').val());
            var inc_conveyance_Allowance = Number($('.inc_conveyance_Allowance').val());
            var inc_other_allowance = Number($('.inc_other_allowance').val());
            var total = inc_salary+inc_medical_allowance+inc_mobile_allowance+inc_laptop_bonus+inc_conveyance_Allowance+inc_other_allowance;
          
            $('.total_increment').val(total);
        }
</script>
@endsection


@extends('layout.main')
@section('hr_interproject_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Inter Project Transfers</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('interproject-management.index')}} @endsection
@section('main_btn_text') All Inter Project Transfer @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Inter Project Transfers</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('interproject-management.store')}}"  method="post">
                        @csrf
                    
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Employee CNIC</label>
                                    <select name="employee_cnic" class="form-control select2" id="employee_cnic">
                                        <option value="" selected>Select CNIC</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->cnic}}"  {{old('employee_cnic') == $emp->cnic ? 'selected' : '' }} data-cnicid = {{$emp->id}}>{{$emp->cnic}} ({{$emp->name}})</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                        <select name="name" class="form-control select2" id="employee_name">
                                            <option value="" selected>Select Employee</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{$emp->name}}" {{old('employee_name') == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
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
                                            <option value="{{$emp->id}}" {{old('employee_id') == $emp->id ? 'selected' : '' }}>{{$emp->employee_damcon_id}} </option>
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
                                    <input type="text" name="father_name" class="form-control father_name" value="{{ old('father_name') }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="text" name="joining_date" class="form-control joining_date" value="{{ old('joining_date') }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Basic Salary</label>
                                    <input type="text" name="basic_salary" class="form-control basic_salary" value="{{ old('basic_salary') }}" placeholder="Basic Salary" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" name="region" class="form-control" value="{{ old('region') }}" placeholder="Region"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Location"/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Project</label>
                                    {!! Form::select('current_project',[''=>'Select Project']+$projects,
                                    old('current_project'), ['class' => 'form-control select2 current_project','required'=>'true']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                         
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>New Project</label>
                                    {!! Form::select('new_project',[''=>'Select Project']+$projects,
                                     old('new_project'), ['class' => 'form-control select2 new_project','required'=>'true']) !!}
                                    @error('new_project')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                            

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of Transfer</label>
                                    <input type="text" name="date_of_transfer" class="form-control date_of_transfer" value="{{ old('date_of_transfer') }}" placeholder="Date of Transfer"/>
                                </div>
                            </div>
                            

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Reason of Transfer</label>
                                    <input type="text" name="reason_of_transfer" class="form-control reason_of_transfer" value="{{ old('reason_of_transfer') }}" placeholder="Location"/>
                                </div>
                            </div>
                            
                        
                           
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
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
            $('.basic_salary').val('').change();
            $('.current_project').val('').change();

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
                        $('.basic_salary').val(value.salarybreakdown.basic_salary);
                      
                    }
                    if(value.project != null)
                    {
                        $('.current_project').val(value.project.id).change();
                    }
               }
            });
            

        });





        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_transfer').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
      


    });
</script>
@endsection


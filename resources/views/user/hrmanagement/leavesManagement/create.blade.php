@extends('layout.main')
@section('hr_leaves_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Leaves Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('leave-management.index')}} @endsection
@section('main_btn_text') All Leaves Management @endsection
{{-- back btn --}}
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">

@endsection
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Leaves Management</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('leave-management.store')}}"  method="post">
                        @csrf
                    
                        <div class="row">


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label> Projects</label>
                                    {!! Form::select('project_id',[''=>'Select Project']+$projects,
                                    old('project_id'), ['class' => 'form-control select2 current_project','required'=>'true']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control today_date" value="{{ old('date') }}" placeholder="Select Date" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control title" value="{{ old('title') }}" placeholder="Title"/>
                                </div>
                            </div>



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
                                        <select name="emp_name" class="form-control select2" id="employee_name">
                                            <option value="" selected>Select Employee</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{$emp->name}}" {{old('emp_name') == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
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
                                    <label>Leave Start Date</label>
                                    <input type="text" name="start_date" class="form-control leave_start" value="{{ old('start_date') }}" placeholder="Start Date" readonly/>

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Leave End Date</label>
                                    <input type="text" name="end_date" class="form-control leave_end" value="{{ old('end_date') }}" placeholder="End Date" readonly/>

                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Number of off Days</label>
                                    <input type="number" class="form-control off_days" name="no_off_Days" value="{{ old('no_off_Days') }}" placeholder="Number of off Days" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Leave type</label>
                                    <select class="form-control select2" name="leave_type">
                                        
                                        <option value="annual" {{old('leave_type') == 'annual' ? 'selected' : ''}}>Annual</option>
                                        <option value="casual" {{old('leave_type') == 'casual' ? 'selected' : ''}}>Casual</option>
                                        <option value="sick" {{old('leave_type') == 'sick' ? 'selected' : ''}}>Sick</option>
                                        <option value="off" {{old('leave_type') == 'off' ? 'selected' : ''}}>Off</option>

                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Balance Leaves (Comments)</label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
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
{!! JsValidator::formRequest('App\Http\Requests\LeaveManagementRequest'); !!}

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

            var emp_id = $("#employee_cnic").select2().find(":selected").data("cnicid");
            
            if(emp_id!=null)
            {
                $.ajax({
                    url:'{{ route('getleftleaves')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":emp_id
                    },
                    method: 'post',
                    success: function(data) {

                        var annual= data.annual_leaves ;
                        var sick = data.sick_leaves;
                        var off = data.off_leaves;
                        var casual = data.casual_leave;
                    

                        swal("Leaves Left", `Annual : ${annual} \n\n Sick : ${sick} \n\n Off : ${off} \n\n Casual : ${casual}`);

                    },
                    error: function(data)
                    {    
                        alert("Network Error!, Connection Failed");
                    }
                });
            }

           

            

        });







        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_transfer').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });


        $('.today_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
      

        // leaves days difference

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.leave_start').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'yyyy-mm-dd',
            minDate: today,
            maxDate: function () {
                return $('.leave_end').val();
            }
        });
        $('.leave_end').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'yyyy-mm-dd',
            minDate: function () {
                return $('.leave_start').val();
            }
        });

        var start_date = ''; var end_date = '';
        $('.leave_start').change(function(){
            start_date = $(this).val();
            var end_date_semi = $('.leave_end').val();
            start_date = new Date(start_date);
            if(end_date!= '')
            {
                end_date_semi = new Date(end_date_semi);
                dateDiff(start_date,end_date_semi);
            }
           
        });

        $('.leave_end').change(function(){
            end_date = $(this).val();
            end_date = new Date(end_date);
            dateDiff(start_date,end_date);
        });

        function dateDiff(start_d,end_d){
            var diffDays = parseInt((end_d - start_d) / (1000 * 60 * 60 * 24), 10); 
            if(diffDays == 0)
            {
                $('.off_days').val(1);
            }
            else{
                $('.off_days').val(diffDays+1);
            }
           
        }

    });
</script>
@endsection


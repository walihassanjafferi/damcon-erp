@extends('layout.main')
@section('hr_salary_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Salaries</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('salary_management.index')}} @endsection
@section('main_btn_text') All Salaries Management @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Month Salary</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('salary_management.store')}}"  method="post">
                        @csrf
                        {{-- <div class="form_status">
                            <label>Status</label> &nbsp;
                            <label class="switch">
                                <input type="checkbox" checked name = 'status'>
                                <span class="slider round"></span>
                            </label>
                        </div> --}}
                        <div class="row">

                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Employee</label>
                                    <select name="employee_id" class="form-control">
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->id}}"  {{old('employee_id') == $emp->id ? 'selected' : '' }}>{{$emp->name . ' ('.$emp->employee_damcon_id.')'}} </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  

                                </div>
                            </div> --}}


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >Payment ID</label>
                                    <input type="text" name="payment_id" class="form-control" value="{{ old('payment_id') }}" placeholder="Payment ID" required/>
                                    @error('payment_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Project</label>
                                    {!! Form::select('project_id[]',$projects,
                                    '', ['class' => 'form-control select2 select_project','required'=>'true','multiple'=>'multiple']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>
                        
                            

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >Select Month</label>
                                    <input type="month" name="salary_month" class="form-control" value="{{ old('salary_month') }}" placeholder="Salary Month" required/>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >No of Days (In selected Month)</label>
                                    <input type="number" name="no_of_days" class="form-control" value="{{ old('no_of_days') }}" placeholder="No of days" required/>
                                </div>
                            </div>

                               

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select class=  "form-control payment_method" name="payment_method">
                                        <option value="">Select Payment method</option>
                                        <option value="direct" {{old('payment_method') == 'direct' ? 'selected' : ''}}>Direct Payment</option>
                                        <option value="batch" {{old('payment_method') == 'batch' ? 'selected' : ''}}>Batch Payment</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6 col-12 debited_bank">
                                <div class="form-group">
                                    <label>Debited Bank</label>

                                    <select name="debited_bank_id" class="select2">
                                        <option value=" ">Select Bank</option>
                                        @foreach ($banks as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 debited_cheque_no">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_number" class="form-control" value="{{ old('cheque_number') }}" placeholder="Cheque Number" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 debited_cheque_title">
                                <div class="form-group">
                                    <label>Cheque Title</label>
                                    <input type="text" name="cheque_title" class="form-control" value="{{ old('cheque_title') }}" placeholder="Cheque Title" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control" value="{{ old('date') }}" id="date" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control" value="{{ old('amount') }}" id="date" required/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Payment details</label>
                                    <textarea name="payment_details"  class="form-control" rows="3"  required>{{ old('payment_details') }}</textarea>
                                </div>
                            </div>   


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments</label>
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
{{-- {!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!} --}}

<script>
   
    $(function(){

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
      

        $('.payment_method').change(function(){

            if($(this).val() == "batch")
            {
                $('.debited_bank').fadeOut(300);
                $('.debited_cheque_title').fadeOut(300);
                $('.debited_cheque_no').fadeOut(300);

                $("[name='debited_bank_id']").prop('disabled', true);
                $("[name='cheque_number']").prop('disabled', true);
                $("[name='cheque_title']").prop('disabled', true);



            }
            else{
                $('.debited_bank').fadeIn(300);
                $('.debited_cheque_title').fadeIn(300);
                $('.debited_cheque_no').fadeIn(300);

                $("[name='debited_bank_id']").prop('disabled', false);
                $("[name='cheque_number']").prop('disabled', false);
                $("[name='cheque_title']").prop('disabled', false);
            }

        })  

    });
</script>
@endsection


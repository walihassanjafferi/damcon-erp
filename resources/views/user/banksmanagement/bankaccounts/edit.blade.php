@extends('layout.main')
@section('bank_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Edit Accounts</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('bankaccounts.index')}} @endsection
@section('main_btn_text') All Bank Accounts @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Bank Account</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($bankaccount, ['route' => ['bankaccounts.update', encrypt($bankaccount->id)],'method' => 'PATCH']) !!}
                        <div class="row">
                            <div class="col-md-3 col-12" >
                                <div class="form-group">
                                    <label>Name of Bank<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Bank Account Title<span class="red_asterik"></span></label>
                                    {!! Form::text('title', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Bank Account Number</label>
                                    {!! Form::text('account_number', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Opening Balance<span class="red_asterik"></span></label>
                                    {!! Form::number('current_balance', null, ['class' => 'form-control avaliable_balance','required','id'=>'current_balance','readonly']) !!}

                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="is_active">Overdraft facility<span class="red_asterik"></span></label>
                                    {!! Form::select('overdraft_facility', ['1' => 'Yes', '0' => 'No'],
                                    null, ['class' => 'form-control','id'=>'overdraft_facility']) !!}
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-12" id="overdraft_limit_fields" style="display:none;">
                                <div class="form-group">
                                    <label>Overdraft limit<span class="red_asterik"></span></label>
                                    @if (Auth::user()->role->name == 'Admin')
                                    {!! Form::number('overdraft_limit', null, ['class' => 'form-control avaliable_balance','required','id'=>'overdraft_limit']) !!}
                                    @else
                                    {!! Form::number('overdraft_limit', null, ['class' => 'form-control','required','readonly']) !!}
                                    @endif

                                </div>
                            </div>
                          
                         

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Avaliable funds<span class="red_asterik"></span></label>
                                    {!! Form::text('avaliable_funds', null, ['class' => 'form-control','required','readonly','id'=>'avaliable_funds']) !!}
                                </div>
                            </div>

                            
                            <div class="col-md-3 col-12" >
                                <div class="form-group">
                                    <label>Opening Date<span class="red_asterik"></span></label>
                                    {!! Form::text('opening_date', null, ['class' => 'form-control opening_date','required']) !!}

                                </div>
                            </div>
                           
                            <div class="col-md-3 col-12 overdraft_used" style="display: none;">
                                <div class="form-group">
                                    <label >Overdraft used<span class="red_asterik"></span></label>
                                    {!! Form::number('overdraft_used', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            
                            {{-- <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status<span class="red_asterik"></span></label>
                                    {!! Form::select('status', ['0' => 'In active', '1' => 'Active'],
                                    1, ['class' => 'form-control', 'id' => 'is_active']) !!}
                                </div>
                            </div> --}}

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
{!! JsValidator::formRequest('App\Http\Requests\BankaccountRequest'); !!}

<script>
            var overdraft_facility = {!! $bankaccount->overdraft_facility !!}
            
           $(function(){
               
                var val = $('#overdraft_facility').val();
                
                if(val == 1)
                {
                    $('#overdraft_limit_fields').css('display','block');

                    $('.overdraft_used').css('display','block');
                }

                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                $('.opening_date').datepicker({
                    format: 'yyyy-mm-dd',
                    uiLibrary: 'bootstrap4',
                    iconsLibrary: 'fontawesome',
                });
                
           });

            $('#overdraft_facility').change(function(e) {
                var val = $('#overdraft_facility').val();
               // alert(val);
                if(val == 1)
                {
                    $('#overdraft_limit_fields').css('display','block');
                }
                else{
                    $('#overdraft_limit_fields').css('display','none');
                }
            });

            $('.avaliable_balance').bind("keyup", function() {
                var curr_balance = parseFloat($('#current_balance').val());
                var overdraft_limit = parseFloat($('#overdraft_limit').val());

                if(isNaN(curr_balance))
                {
                    curr_balance = 0;
                }
                if(isNaN(overdraft_limit))
                {
                    overdraft_limit = 0;
                }

              
               // console.log(parseFloat(curr_balance));
                var total = curr_balance + overdraft_limit;
                $('#avaliable_funds').val(total);
            });
           
        
</script>
    
@endsection
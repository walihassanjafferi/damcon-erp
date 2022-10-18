@extends('layout.main')
@section('interbank_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Edit Interbank transfers</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('interbanktransfer.index')}} @endsection
@section('main_btn_text') All Inter-Banks Transfer @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Inter-Bank transfer</h4>
                </div>
                <div class="card-body">
                {!! Form::model($transfer, ['route' => ['interbanktransfer.update', encrypt($transfer->id)],'method' => 'PATCH']) !!}
                        <div class="row">
                            <div class="col-md-3 col-12" >
                                <div class="form-group">
                                    <label>Title of transfer<span class="red_asterik"></span></label>
                                    {!! Form::text('title_of_transfer', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Transaction Date<span class="red_asterik"></span></label>
                                    {!! Form::text('transaction_date', null, ['class' => 'form-control','required','id'=>'transaction_date']) !!}

                                </div>
                            </div>
                            
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Transaction Type<span class="red_asterik"></span></label>
                                    {!! Form::select('transaction_type', [null=>'Select type','cheque' => 'Cheque', 'cash' => 'Cash'],
                                    null, ['class' => 'form-control','id'=>'transaction_type','disabled']) !!}
                                </div>
                            </div>

                            <div class="col-md-3 col-12" id="cheque_no_field">
                                <div class="form-group">
                                    <label >Cheque no<span class="red_asterik"></span></label>
                                    {!! Form::text('cheque_no', null, ['class' => 'form-control avaliable_balance','required','id'=>'cheque_no']) !!}

                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Sender Bank<span class="red_asterik"></span></label>
                                    {!! Form::select('sender_bank_id',[null=>'Select Sender bank']+$banks,
                                    null, ['class' => 'form-control select2 banks','id'=>'sender_Bank','disabled']) !!}
                                    <span class="error-help-block"></span>    
                            </div>
                            </div>
                            
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Amount<span class="red_asterik"></span></label>
                                  
                                    {!! Form::number('amount', null, ['class' => 'form-control avaliable_balance','required','disabled']) !!}
                                 

                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Receiver Bank<span class="red_asterik"></span></label>
                                    {!! Form::select('receiver_bank_id',[null=>'Select Receiver bank']+$banks,
                                    null, ['class' => 'form-control select2 banks','id'=>'receiver_bank','disabled']) !!}
                                    <span class="error-help-block"></span>    

                                </div>
                            </div>
                          
                         

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    {!! Form::textarea('comments', null, ['class' => 'form-control','required','rows'=>'3']) !!}
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
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\InterBankTransferRequest'); !!}

<script>

           $(function(){
                var val = $('#transaction_type').val();
            
                if(val == 'cheque')
                {
                    $('#cheque_no_field').show();
                }
                else{
                    $('#cheque_no_field').hide();

                }
           });



           $('#transaction_type').change(function(e) {
             
                var val = $('#transaction_type').val();
            
                if(val == 'cheque')
                {
                    $('#cheque_no_field').show();
                }
                else{
                    $('#cheque_no_field').hide();

                }
            });

        //     $('.banks').change(function(e) {
             
        //      var sender = $('#sender_Bank').val();
        //      var receiver = $('#receiver_bank').val();
            
        //      if(sender == receiver)
        //      { 
        //         $('.error-help-block').html("Sender & Receiver Banks can't be same");
        //      }
        //      else{
        //         $('.error-help-block').html("");

        //      }
        //  });

          
            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('#transaction_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                minDate: today,
                maxDate: function () {
                    return $('#project_end_date').val();
                }
            });
        
</script>
    
@endsection
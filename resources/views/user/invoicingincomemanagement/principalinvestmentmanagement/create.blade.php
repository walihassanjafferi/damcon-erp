@extends('layout.main')
@section('principal_investment_sidebar') active @endsection
@section('title')
    <title>Damcon Principal Investments Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('principalinvestment.index') }} @endsection
@section('main_btn_text') All Profit on Investment @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th,
        .table td {
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
                        <h4 class="card-title">Add Profit on Investments</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('principalinvestment.store') }}" method="post" class="import_purchases"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            value="{{ old('title') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Type<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment" name="payment">
                                            <option value="">Select Payment</option>
                                            <option value="in" {{ old('payment') == 'in' ? "selected" : "" }}>In</option>
                                            <option value="out" {{ old('payment') == 'out' ? "selected" : "" }}>Out</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Project<span></span></label>
                                        <select class="form-control select2 project" name="project_id">
                                            <option value="">Select Project</option>
                                            @foreach ($projects as $item)
                                                <option value="{{$item->id}}" {{ old('po_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Investor<span class="red_asterik"></span></label>
                                        <select class='form-control select2 investors' name="investor_id">
                                            <option value=''>Select Investor</option>
                                            @foreach ($investors as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('investor_id') == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                


                                <div class="col-md-6 col-12 investor_balance" style="display: none;">
                                    <div class="form-group">
                                        <label>Current Balance (PKR)<span class="red_asterik"></span></label>
                                        <input type="text" name="current_balance_investor"
                                            class="form-control current_balance_investor"
                                            placeholder="Current Balance Investor"
                                            value="{{ old('current_balance_investor') }}" readonly/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Deposit Bank Account<span class="red_asterik"></span></label>
                                        <select class='form-control select2' name="cash_deposit_bank_id">
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('cash_deposit_bank_id') == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control cheque_number"
                                            placeholder="Cheque Number" value="{{ old('cheque_number') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Clearing Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_clearing_date"
                                            class="form-control cheque_clearing_date" placeholder="Cheque Clearing Date"
                                            value="{{ old('cheque_clearing_date') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Amount (PKR)<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_amount" class="form-control cheque_amount amount_format"
                                            placeholder="Cheque Amount" value="{{ old('cheque_amount') }}" required />
                                    </div>
                                </div>


                                <div class="col-12 mt-1">
                                    <div class="form-group">
                                        <label>Payment Details<span class="red_asterik"></span></label>
                                        <textarea name="payment_details" class="form-control" rows="3"
                                            required>{{ old('payment_details') }}</textarea>
                                    </div>
                                </div>


                                <div class="col-12 mt-1">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea name="comments" class="form-control" rows="3"
                                            required>{{ old('comments') }}</textarea>
                                    </div>
                                </div>



                                <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                    <small>**multiple items can be selected</small><br />
                                    <label for="formFileMultiple" class="form-label">File Attachment</label>
                                    <input class="form-control" type="file" name="document_file[]" id="file-input"
                                        multiple>
                                    <small>files supported jpg | jpeg | png | pdf</small><br />
                                </div>

                                <div class="col-12" style="margin-bottom: 20px;">
                                    <div id="preview" class="gallery col-12"></div>
                                    <div id="preview_pdf" class="gallery col-12"></div>
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
    <script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\MiscIncomeRequest') !!}


    <script>
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
           

            $('.cheque_receving_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.cheque_clearing_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

           
            $('.investors').change(function(){
               
                if($('.investors').val() != '')
                {
                    $id = $(".investors option:selected").val();
            
                    $.ajax({
                        url:'{{ route('getInvestorBalance')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":$id
                        },
                        method: 'post',
                        success: function(data) {

                            $('.current_balance_investor').val(data.message);
                            
                        },
                        error: function(data)
                        {    
                        
                            
                        }
                    });
                    $('.investor_balance').show();
                }
                else{
                    $('.investor_balance').hide();
                }
                
            });

    


           





        });



        
    </script>

@endsection

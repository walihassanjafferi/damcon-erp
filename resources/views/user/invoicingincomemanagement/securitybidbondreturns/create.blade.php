@extends('layout.main')
@section('security_bid_sidebar') active @endsection
@section('title')
    <title>Damcon ERP Security/Bid Bond Returns</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('securitybondreturns.index') }} @endsection
@section('main_btn_text') All Security/Bid Bond Returns @endsection
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
                        <h4 class="card-title">Add Security/Bid Bond Returns</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('securitybondreturns.store') }}" method="post" class="import_purchases"
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
                                    <div class="form-group">
                                        <label>Select Security/Bid Returns title</label>
                                        <select name="security_payment_id" class="form-control select2 security_payment_id">
                                            <option value="">Select Security/Bid</option>
                                            @foreach ($security_payments as $item)
                                                <option value="{{ $item->id }}"
                                                    data-customer="{{ $item->customer_rel }}" data-security_payment="{{$item}}">
                                                    {{-- {{ $item->customer_rel->name }} ({{ $item->paymenttype->name }}) --}}
                                                    {{$item->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Customer<span class="red_asterik"></span></label>
                                        <input type="text" name="customer_name" class="form-control customer_name"
                                            placeholder="Customer Name" value="{{ old('customer_name') }}" readonly />
                                        <input type="text" name="customer_id" class="form-control customer_id"
                                            value="{{ old('customer_id') }}" hidden />
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
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control cheque_number"
                                            placeholder="Cheque Number" value="{{ old('cheque_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Amount<span class="red_asterik"></span></label>
                                        <input type="number" name="amount" class="form-control amount"
                                            placeholder="Amount" value="{{ old('amount') }}" readonly />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Deposit Bank Account<span class="red_asterik"></span></label>
                                        <select class='form-control select2' name="cash_deposit_bank_id">
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('cash_deposit_bank_id') == $val->id ?? 'selected' }}>
                                                    {{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Payment Details<span class="red_asterik"></span></label>
                                        <textarea name="payment_details" class="form-control" rows="3"
                                            required>{{ old('payment_details') }}</textarea>
                                    </div>
                                </div>



                                <div class="col-12">
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

    {!! JsValidator::formRequest('App\Http\Requests\ProjectIncomeRequest') !!}


    <script>
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
          
            
            $('.cheque_clearing_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
         

            $('.security_payment_id').change(function() {
                var customer = $(this).find(':selected').data('customer');
                var security_payment = $(this).find(':selected').data('security_payment');
                
                $('.customer_id').val(customer.id);
                $('.customer_name').val(customer.name);
                $('.amount').val(security_payment.amount);


            });
        });
    </script>

@endsection

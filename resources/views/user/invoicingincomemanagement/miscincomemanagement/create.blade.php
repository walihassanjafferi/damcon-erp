@extends('layout.main')
@section('misc_income_sidebar') active @endsection
@section('title')
    <title>Damcon ERP Misc Income Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('miscincome.index') }} @endsection
@section('main_btn_text') All Misc Income Management @endsection
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
                        <h4 class="card-title">Add Misc Income</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('miscincome.store') }}" method="post" class="import_purchases"
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
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" name="misc_date" class="form-control misc_date"
                                            placeholder="Date" value="{{ old('misc_date') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Income Type<span class="red_asterik"></span></label>
                                        {{-- <select class="form-control income_type select2" name="income_type">
                                            <option value="">Select Income type</option>
                                            <option value="project_income">Project Income</option>
                                            <option value="advance_hr">Advance HR</option>
                                        </select> --}}

                                        <select class="form-control income_type select2" name="income_type">
                                            <option value="">Select Income type</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}" {{old('income_type') == $item->id ? "selected": ''}}>{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 advance_HR_payment" style="display: none;">
                                    <div class="form-group">
                                        <label>Advanced HR Payments<span class="red_asterik"></span></label>
                                        <select class='form-control select2' name="advance_hr_payment_id">
                                            <option value="">Select advance HR Payment</option>
                                            @foreach ($advance_hr as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ old('advance_hr_payment_id') == $val->id ?? 'selected' }}>
                                                    Payment ID : {{ $val->payment_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Project (optional)</label>
                                        {!! Form::select('project_id', $projects + [null => 'Select Project'], old('project_id'), ['class' => 'form-control select2 select_project', 'required' => 'true', 'id' => 'project_id']) !!}
                                        @error('project_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Mode of Payment<span class="red_asterik"></span></label>
                                        <select class="form-control select2 mode_of_payment" name="mode_of_payment">
                                            <option value="">Select mode of payment</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 cheque_receving_date_div">
                                    <div class="form-group">
                                        <label>Cheque Receiving Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_receving_date"
                                            class="form-control cheque_receving_date" placeholder="Cheque Receiving Date"
                                            value="{{ old('cheque_receving_date') }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 received_cheque_bank_div">
                                    <div class="form-group">
                                        <label>Received Cheque Bank<span class="red_asterik"></span></label>
                                        <input type="text" name="received_cheque_bank" class="form-control"
                                            placeholder="Received Cheque Bank" value="{{ old('received_cheque_bank') }}"
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 cheque_clearing_date_div">
                                    <div class="form-group">
                                        <label>Cheque Clearing Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_clearing_date"
                                            class="form-control cheque_clearing_date" placeholder="Cheque Clearing Date"
                                            value="{{ old('cheque_clearing_date') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 cheque_number_div">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control cheque_number"
                                            placeholder="Cheque Number" value="{{ old('cheque_number') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_amount" class="form-control cheque_amount amount_format"
                                            placeholder="Amount" value="{{ old('cheque_amount') }}" required />
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
                                                    {{ $val->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Associated Outward Payment ID (Optional)</label>
                                        <input type="text" name="outward_payment_id" class="form-control Associated Outward Payment ID" placeholder="Associated Outward Payment ID"  value="{{ old('outward_payment_id') }}"/>
                                    </div>
                                </div>


                                <div class="col-12 mt-1">
                                    <div class="form-group">
                                        <label>Miscellaneous Income Details<span class="red_asterik"></span></label>
                                        <textarea name="misc_income_detail" class="form-control" rows="3"
                                            required>{{ old('misc_income_detail') }}</textarea>
                                    </div>
                                </div>


                                <div class="col-12 mt-1">
                                    <div class="form-group">
                                        <label>Outward Payment ID Comments<span class="red_asterik"></span></label>
                                        <textarea name="outward_payment_comments" class="form-control" rows="3"
                                            required>{{ old('outward_payment_comments') }}</textarea>
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

    {!! JsValidator::formRequest('App\Http\Requests\MiscIncomeRequest'); !!}


    <script>
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.misc_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',

            });
            


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

            $('.cheque_receving_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.income_type').change(function(){
                var type = $('.income_type').val();
                if(type == 'advance_hr')
                {
                    $('.advance_HR_payment').show();
                }
                else{
                    $('.advance_HR_payment').hide();
                }
            });


            $('.mode_of_payment').change(function(){
               
                if($('.mode_of_payment').val() == 'cash')
                {  
                    $('.cheque_receving_date_div, .cheque_receving_date_div, .cheque_clearing_date_div, .cheque_number_div, .received_cheque_bank_div').hide();
                }
                else{
                    $('.cheque_receving_date_div, .cheque_receving_date_div, .cheque_clearing_date_div, .cheque_number_div, .received_cheque_bank_div').show();
                }
            });





        });


     
        function fetch_tax__body_percentage() {
            $id = $(".tax_id option:selected").val();

            $.ajax({
                url: '{{ route('get_tax_boby') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $id
                },
                method: 'post',
                success: function(data) {

                    $('#tax_body_percentage').val(data.message);

                },
                error: function(data) {


                }
            });

        }
    </script>

@endsection

@extends('layout.main')
@section('project_income_sidebar') active @endsection
@section('title')
    <title>Damcon ERP Project Income Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('projectincome.index') }} @endsection
@section('main_btn_text') All Project Income Management @endsection
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
                        <h4 class="card-title">Add Project Income Management</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('projectincome.store') }}" method="post" class="import_purchases"
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
                                        <label>Select Project</label>
                                        {!! Form::select('project_id', $projects + [null => 'Select Project'], old('project_id'), ['class' => 'form-control select2 select_project', 'required' => 'true', 'id' => 'project_id']) !!}
                                        @error('project_id')
                                            <div class="error-help-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 pl-1 pr-1 mb-2">
                                    <table class="table table-striped table-bordered invoices" style="width:100%"
                                        id="invoices">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice No</th>
                                                <th>Invoice Status</th>
                                                <th>Original Invoice</th>
                                                <th>Paid Amount</th>
                                                <th>Pending Balance</th>
                                                {{-- <th>Remaining Balance</th> --}}

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Receiving Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_receving_date"
                                            class="form-control cheque_receving_date" placeholder="Cheque Receiving Date"
                                            value="{{ old('cheque_receving_date') }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Received Cheque Bank<span class="red_asterik"></span></label>
                                        <input type="text" name="received_cheque_bank" class="form-control"
                                            placeholder="Received Cheque Bank" value="{{ old('received_cheque_bank') }}"
                                            required />
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
                                        <input type="text" name="cheque_amount" class="form-control cheque_amount amount_format"
                                            placeholder="Cheque Amount" value="{{ old('cheque_amount') }}" required />
                                    </div>
                                </div>


                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Deposit Bank Account<span class="red_asterik"></span></label>
                                        {!! Form::select('cash_deposit_bank_id', [null => 'Select Bank'] + $banks, old('cash_deposit_bank_id'), ['class' => 'form-control select2']) !!}
                                    </div>
                                </div> --}}

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
                                        <label>Bad Debt Amount<span class="red_asterik"></span></label>
                                        <input type="number" name="bad_debt_amount" class="form-control bad_debt_amount"
                                            placeholder="Bad debt amount" value=0 readonly />
                                    </div>
                                </div>




                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Difference Comments<span class="red_asterik"></span></label>
                                        <textarea name="difference_comments" class="form-control" rows="3"
                                            required>{{ old('difference_comments') }}</textarea>
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
            $('.date').datepicker({
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


            $('.invoices').hide();
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


        $('.select_project').change(function() {

            $id = $(".select_project option:selected").val();

            $.ajax({
                url: '{{ route('getProjectInvoices') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $id
                },
                method: 'post',
                success: function(data) {

                    var content = '';
                    var tableBody = '';

                    if (data.message.length == 0) {
                        alert('No Invoices Found!');
                        return;
                    }

                    $.each(data.message, function(key, item) {

                        content += '<tr>';
                        content += '<td><div class="position-relative form-group">';
                        content +=
                            '<input type="checkbox" class="invoice_check" name="invoice_check[]" /></div>';
                        content += '</td>';
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Invoice Number</label>';
                        content +=
                            '<input class="form-control invoice_ids" name="invoice_id[]" type="text" value=' +
                            item
                            .invoice_number + ' disabled /></div>';
                        content += '</div></td>';
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Invoice Status</label>';
                        content +=
                            '<input class="form-control invoice_status" type="text" value=' +
                            item
                            .invoice_status + ' disabled /></div>';
                        content += '</div></td>';


                        
                        content += '</div></td>';
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Original Invoice</label>';
                        content +=
                            '<input class="form-control original_invoice" type="integer" name="original_invoice[]" value='+item.total_after_deductions+' disabled/></div>';
                        content += '</div></td>';


                        if(item.invoice_status == 'pending' && item.status == 'pending')
                        {
                            pending_balance = item.pending_balance;
                            total_after_deductions = item.pending_balance;
                        }
                        else{
                            pending_balance = 0;
                            total_after_deductions = item.total_after_deductions;
                        }



                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Paid Amount</label>';
                        content +=
                            '<input class="form-control invoice_amounts" type="integer" value=' +
                            total_after_deductions +
                            ' name="invoice_amount[]" disabled /></div>';

                      
                        content += '</div></td>';
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Pending Balance</label>';
                        content +=
                            '<input class="form-control pending_balances" type="integer" name="pending_balance[]" value='+pending_balance+' disabled/></div>';
                        content += '</div></td>';

                        // remaining balance

                        // content += '</div></td>';
                        // content += '<td><div class="position-relative form-group">';
                        // content += '<label class="required">Remaining Balance</label>';
                        // content +=
                        //     '<input class="form-control remaining_balances" type="integer" name="remaining_balance[]" value="0" disabled/></div>';
                        // content += '</div></td>';

                            
                        content += '</tr>';

                    });

                    tableBody = $(".invoices tbody");
                    // tableBody.html(content);
                    tableBody.html(content);
                    //  console.log(tableBody);
                    // $('.invoices').tbody.append(content);
                    $('.invoices').show();


                    // $('.pending_balances').keyup(function(){
                    //     var amount = $(this).closest('tr').find('.invoice_amounts').val();
                    //     console.log('Amount',amount);
                    //     var balance = amount - $(this).val();
                    //     console.log('Remaingi  Amount',balance);

                    //     $(this).closest('tr').find('.remaining_balances').val(balance);

                    // });


                },
                error: function(data) {


                }
            });

        });
        var invoices = [];
        var bad_amount = 0;

        $(document).on('change', '.invoice_check', function() {

            $(this).closest('tr').find('.invoice_ids, .invoice_amounts, .pending_balances , .remaining_balances').prop('disabled', !this
                .checked);
            invoices.push(parseFloat($(this).closest('tr').find('.invoice_amounts').val()));

            //console.log(invoices)
            var total = 0;
            for (var i = 0; i < invoices.length; i++) {
                total += invoices[i];
            }


            $('.bad_debt_amount').val(total);
            bad_amount = $('.bad_debt_amount').val();

        });


       



        $('.cheque_amount').keyup(function() {

            var amount = $('.cheque_amount').val().replace(',','');

            console.log('amount',amount)

            var result = bad_amount - amount;

            console.log('R',result);


            $('.bad_debt_amount').val(result.toFixed(2));
        });
        
    </script>

@endsection

@extends('layout.main')
@section('sales_tax_return_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Sales Tax return Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('employees_tax_management.index') }} @endsection
@section('main_btn_text') All Sales Tax return Management @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th,
        .table td {
            padding: 0.72rem 0.98rem;
        }

        #file_input {
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }

        .align_checkbox_input {
            position: absolute;
            top: 33px;
            z-index: 10000;
            right: 29px;
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
                        <h4 class="card-title">Add Sales Tax Return</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('sales_tax_return_management.store') }}" method="post"
                            class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tax Body<span class="red_asterik"></span></label>
                                        {!! Form::select('tax_id', [null => 'Select Tax body'] + $tax_bodies, old('tax_id'), ['class' => 'tax_id form-control select2 select_taxbody', 'id' => 'tax_body','required']) !!}
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Taxation Month<span class="red_asterik"></span></label>
                                        <input type="month" name="taxation_month" class="form-control select_taxation_month"
                                            placeholder="Taxation Month" value="{{ old('taxation_month') }}" />
                                    </div>
                                </div>


                                <div class="col-12 pl-1 pr-1 mb-2" id="invoices">
                                    <p>Invoices</p>
                                    <table class="table table-striped table-bordered invoices" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice No</th>
                                                <th>Customer Name</th>
                                                <th>Date of Invoicing</th>
                                                <th>Amount</th>
                                                <th>Tax Amount (Ledger)</th>
                                                <th>Avaliable Outputs</th>
                                                <th>Adjusted Output</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>



                                <div class="col-12 pl-1 pr-1 mb-2" id="supplier_purchase_order">
                                    <p>Supplier Purchase Orders</p>
                                    <table class="table table-striped table-bordered supplier_purchase_order"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Purchase Order Name</th>
                                                <th>Amount</th>
                                                <th>Tax Amount (Ledger)</th>
                                                <th>Avaliable Inputs</th>
                                                <th>Adjusted Inputs</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12 pl-1 pr-1 mb-2" id="rental_purchase_order">
                                    <p>Rental Purchase Orders</p>
                                    <table class="table table-striped table-bordered rental_purchase_order"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Purchase Order Name</th>
                                                <th>Amount</th>
                                                <th>Tax Amount (Ledger)</th>
                                                <th>Avaliable Inputs</th>
                                                <th>Adjusted Inputs</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-12 pl-1 pr-1 mb-2" id="asset_purchase_order">
                                    <p>Assets Purchase Orders</p>
                                    <table class="table table-striped table-bordered asset_purchase_order"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Purchase Order Name</th>
                                                <th>Amount</th>
                                                <th>Tax Amount (Ledger)</th>
                                                <th>Avaliable Inputs</th>
                                                <th>Adjusted Inputs</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-12 pl-1 pr-1 mb-2" id="service_purchase_order">
                                    <p>Service Purchase Orders</p>
                                    <table class="table table-striped table-bordered service_purchase_order"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Purchase Order Name</th>
                                                <th>Amount</th>
                                                <th>Tax Amount (Ledger)</th>
                                                <th>Avaliable Inputs</th>
                                                <th>Adjusted Inputs</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="input-group-append pl-2 align_checkbox_input">
                                        <label class="mb-0">Calculate Payable</label>
                                        <input type="checkbox" class="calcualte_payables form-check-input">
                                    </div>
                                    <label>Payable to Taxbody<span class="red_asterik"></span></label>
                                    <div class="input-group">

                                        <input type="text" name="payable_taxbody" class="form-control payable_taxbody"
                                        placeholder="Payable tax body" value="{{ old('payable_taxbody') }}" readonly/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Manual Adjustments<span class="red_asterik"></span></label>
                                        <input type="number" name="manual_adjustments"
                                            class="form-control manual_adjustments" placeholder="Manual Adjustments"
                                            value="{{ old('manual_adjustments') }}" />
                                    </div>
                                </div>



                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Manual Adjustment Comments</label>
                                    <textarea class="form-control" name="manual_adjustment_comments" rows="5"
                                        >{{ old('manual_adjustment_comments') }}</textarea>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <div class="input-group-append pl-2 align_checkbox_input">
                                            <label class="mb-0">Calculate Net Payable to Tax Body</label>
                                            <input type="checkbox" class="calcualte_netpayables form-check-input">
                                        </div>
                                        <label>Net Payable to TaxBody<span class="red_asterik"></span></label>
                                        <input type="number" name="net_payable" class="form-control net_payable"
                                            placeholder="Net Payable" value="{{ old('net_payable') }}" readonly required/>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Payment Method<span class="red_asterik"></span></label>
                                        <select name="payment_method" class="form-control select2 payment_method">
                                            <option value="" selected>Select Payment Method</option>
                                            <option value="direct">Direct Payment</option>
                                            <option value="batch">Batch Payment</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 debited_bank">
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


                                <div class="col-md-6 col-12 debited_cheque_title">
                                    <div class="form-group">
                                        <label>Cheque Title<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_title" class="form-control"
                                            placeholder="Cheque Title" value="{{ old('cheque_title') }}"  />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 debited_cheque_no">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control"
                                            placeholder="Cheque Number" value="{{ old('cheque_number') }}"  />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" name="date" class="form-control date" placeholder="Date"
                                            value="{{ old('date') }}"  />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" name="amount" class="form-control" placeholder="Amount"
                                            value="{{ old('amount') }}"  />
                                    </div>
                                </div>


                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Payment Details</label>
                                    <textarea class="form-control" name="payment_details" rows="5"
                                        >{{ old('payment_details') }}</textarea>
                                </div>


                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5"
                                        >{{ old('comments') }}</textarea>
                                </div>

                                <input type="text" class="invoice_data" name="invoice_data" hidden />
                                <input type="text" class="supplier_po_data" name="supplier_po_data" hidden />
                                <input type="text" class="rental_po_data" name="rental_po_data" hidden />
                                <input type="text" class="assets_po_data" name="assets_po_data" hidden />
                                <input type="text" class="services_po_data" name="services_po_data" hidden />



                                <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                    <small>**multiple items can be selected</small><br />
                                    <label for="formFileMultiple" class="form-label">File Attachments</label>
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
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script>


    <script>
        $(function() {

            $('#invoices').hide();
            $('#supplier_purchase_order').hide();
            $('#rental_purchase_order').hide();
            $('#asset_purchase_order').hide();
            $('#service_purchase_order').hide();




            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });


            $('.payment_method').change(function()
            {

                if($(this).val() == "batch")
                {
                    $('.debited_bank').fadeOut(300);
                    $('.debited_cheque_title').fadeOut(300);
                    $('.debited_cheque_no').fadeOut(300);

                    $("[name='cash_deposit_bank_id']").prop('disabled', true);
                    $("[name='cheque_number']").prop('disabled', true);
                    $("[name='cheque_title']").prop('disabled', true);



                }
                else{
                    $('.debited_bank').fadeIn(300);
                    $('.debited_cheque_title').fadeIn(300);
                    $('.debited_cheque_no').fadeIn(300);

                    $("[name='cash_deposit_bank_id']").prop('disabled', false);
                    $("[name='cheque_number']").prop('disabled', false);
                    $("[name='cheque_title']").prop('disabled', false);
                }

            });




            var total_adjusted_input = 0, total_adjusted_output = 0;




            $('.select_taxation_month').change(function() {

                var tax_body_id = $('.select_taxbody :selected').val();

                if (tax_body_id != '') {
                    var tax_month = $('.select_taxation_month').val();

                    $.ajax({
                        url: '{{ route('getTaxMonthData') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "tax_month": tax_month,
                            "tax_body_id": tax_body_id,
                        },
                        method: 'post',
                        success: function(data) {

                            var content = '',
                                content_po = '',
                                content_rpo = '',
                                content_apo = '',
                                content_spo = '';
                            var tableBody = '',
                                rental_purchase_tbody = '',
                                asset_purchase_tbody = '',
                                service_purchase_tbody = '';


                            if (data.customer_invoices.length == 0) {
                                alert('No Invoices Found!');
                            }

                            if (data.customer_invoices.length != 0) {
                                $.each(data.customer_invoices, function(key, item) {

                                    content += '<tr>';
                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<input type="checkbox" class="invoice_check" /></div>';
                                    content += '</td>';

                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Invoice Number</label>';
                                    content +=
                                        '<input class="form-control invoice_ids" type="text" value=' +
                                        item
                                        .invoice_number + ' disabled /></div>';
                                    content += '</div></td>';


                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Customer Name</label>';
                                    content +=
                                        '<input class="form-control customer_name" type="text" value=' +
                                        item
                                        .customer_name + ' disabled /></div>';
                                    content += '</div></td>';



                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Customer Name</label>';
                                    content +=
                                        '<input class="form-control date_of_invoicing" type="text" value=' +
                                        item
                                        .date_of_invoicing + ' disabled /></div>';
                                    content += '</div></td>';




                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content += '<label class="required">Amount</label>';
                                    content +=
                                        '<input class="form-control invoice_amounts" type="integer" value=' +
                                        item.total_after_deductions +
                                        ' disabled /></div>';
                                    content += '</div></td>';
                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Tax Body Ledger</label>';
                                    content +=
                                        '<input class="form-control invoice_tax" type="integer"  value=' +
                                        item.tax_amount + ' disabled/></div>';
                                    content += '</div></td>';

                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Avaliable Output</label>';
                                    content +=
                                        '<input class="form-control invoice_avaliable_output" type="integer" value="0" /></div>';
                                    content += '</div></td>';


                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Adjusted Output</label>';
                                    content +=
                                        '<input class="form-control invoice_adjusted_output" type="number"  value="0" disabled/></div>';
                                    content += '</div></td>';

                                    content += '</tr>';

                                });
                                tableBody = $(".invoices tbody");
                                tableBody.html(content);
                                $('#invoices').show();
                            }


                            //supplier purchase order
                            if (data.supplier_purchase_order.length != 0) {
                                $.each(data.supplier_purchase_order, function(key, item) {

                                    content_po += '<tr>';
                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<input type="checkbox" class="supplier_po_check"  /></div>';
                                    content_po += '</td>';
                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">Title PO #</label>';
                                    content_po +=
                                        '<input class="form-control supplier_po_title_no" type="text" value=' +
                                        item
                                        .purchase_od_number + ' disabled /></div>';
                                    content_po += '</div></td>';

                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">Purchase Order Name</label>';
                                    content_po +=
                                        '<input class="form-control" type="integer"  value="Supplier Purchase Order" readonly/></div>';
                                    content_po += '</div></td>';



                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">PO Amount</label>';
                                    content_po +=
                                        '<input class="form-control supplier_po_amount" type="text"  value=' +
                                        item
                                        .total_after_deduction + ' disabled /></div>';
                                    content_po += '</div></td>';


                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">Tax Body Amount</label>';
                                    content_po +=
                                        '<input class="form-control supplier_tax_body" type="integer" value=' +
                                        item.tax_amount + ' /></div>';
                                    content_po += '</div></td>';



                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">Avaliable Inputs</label>';
                                    content_po +=
                                        '<input class="form-control supplier_po_inputs" type="integer" value="0" /></div>';
                                    content_po += '</div></td>';


                                    content_po +=
                                        '<td><div class="position-relative form-group">';
                                    content_po +=
                                        '<label class="required">Adjusted Inputs</label>';
                                    content_po +=
                                        '<input class="form-control supplier_adjusted_input" type="integer" value="0" disabled/></div>';
                                    content_po += '</div></td>';
                                    content_po += '</tr>';

                                });
                                purchase_tbody = $(".supplier_purchase_order tbody");
                                purchase_tbody.html(content_po);
                                $('#supplier_purchase_order').show();


                            }

                            //rental purchase order

                            if (data.rental_purchase_order.length != 0) {
                                $.each(data.rental_purchase_order, function(key, item) {

                                    content_rpo += '<tr>';
                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<input type="checkbox" class="rental_po_check" /></div>';
                                    content_rpo += '</td>';
                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Title PO #</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_po_title_no" type="text" value=' +
                                        item
                                        .purchase_od_number + ' disabled /></div>';
                                    content_rpo += '</div></td>';

                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Purchase Order Name</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_po_name" type="integer"  value="Rental Purchase Order" readonly/></div>';
                                    content_rpo += '</div></td>';


                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Amount (PKR)</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_po_amount" type="text" value=' +
                                        item
                                        .total_after_deduction + ' disabled /></div>';
                                    content_rpo += '</div></td>';


                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Tax Body Amount</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_tax_body" type="integer" value=' +
                                        item.tax_amount + ' /></div>';
                                    content_rpo += '</div></td>';



                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Avaliable Inputs</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_avaliable_input" type="integer value="0" /></div>';
                                    content_rpo += '</div></td>';


                                    content_rpo +=
                                        '<td><div class="position-relative form-group">';
                                    content_rpo +=
                                        '<label class="required">Adjusted Inputs</label>';
                                    content_rpo +=
                                        '<input class="form-control rental_adjusted_input" type="integer"  value="0" disabled/></div>';
                                    content_rpo += '</div></td>';



                                    content_rpo += '</tr>';

                                });

                                rental_purchase_tbody = $(".rental_purchase_order tbody");
                                rental_purchase_tbody.html(content_rpo);
                                $('#rental_purchase_order').show();
                            }

                            // asset purchase order

                            if (data.asset_purchase_order.length != 0) {

                                $.each(data.asset_purchase_order, function(key, item) {

                                    content_apo += '<tr>';
                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<input type="checkbox" class="asset_po_check"  /></div>';
                                    content_apo += '</td>';
                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Title PO #</label>';
                                    content_apo +=
                                        '<input class="form-control asset_po_title_no" type="text" value=' +
                                        item
                                        .purchase_title + ' disabled /></div>';
                                    content_apo += '</div></td>';

                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Purchase Order Name</label>';
                                    content_apo +=
                                        '<input class="form-control" type="integer" value="Assets Purchase Order" readonly/></div>';
                                    content_apo += '</div></td>';



                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Amount (PKR)</label>';
                                    content_apo +=
                                        '<input class="form-control asset_po_amount" type="text" value=' +
                                        item
                                        .total_after_deduction + ' disabled /></div>';
                                    content_apo += '</div></td>';


                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Tax Body Amount</label>';
                                    content_apo +=
                                        '<input class="form-control asset_tax_body" type="integer" value=' +
                                        item.tax_amount + ' /></div>';
                                    content_apo += '</div></td>';


                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Avaliable Inputs</label>';
                                    content_apo +=
                                        '<input class="form-control asset_avaliable_input" type="integer" value="0" /></div>';
                                    content_apo += '</div></td>';


                                    content_apo +=
                                        '<td><div class="position-relative form-group">';
                                    content_apo +=
                                        '<label class="required">Adjusted Inputs</label>';
                                    content_apo +=
                                        '<input class="form-control assets_adjusted_input" type="integer" value="0" disabled/></div>';
                                    content_apo += '</div></td>';

                                    content_apo += '</tr>';

                                });

                                asset_purchase_tbody = $(".asset_purchase_order tbody");

                                asset_purchase_tbody.html(content_apo);
                                $('#asset_purchase_order').show();
                            }


                            //service purchase order

                            if (data.services_purchase_order.length != 0) {

                                $.each(data.services_purchase_order, function(key, item) {

                                    content_spo += '<tr>';
                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<input type="checkbox" class="services_po_check" /></div>';
                                    content_spo += '</td>';
                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Title PO #</label>';
                                    content_spo +=
                                        '<input class="form-control service_po_title_no" type="text" value=' +
                                        item
                                        .title_po_number + ' disabled /></div>';
                                    content_spo += '</div></td>';

                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Purchase Order Name</label>';
                                    content_spo +=
                                        '<input class="form-control service_po_names" type="integer" value="Service Purchase Order" readonly/></div>';
                                    content_spo += '</div></td>';



                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Amount (PKR)</label>';
                                    content_spo +=
                                        '<input class="form-control service_po_amount" type="text" value=' +
                                        item
                                        .total_after_deduction + ' disabled /></div>';
                                    content_spo += '</div></td>';


                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Tax Body Amount</label>';
                                    content_spo +=
                                        '<input class="form-control service_tax_body" type="integer" value=' +
                                        item.tax_amount + ' /></div>';
                                    content_spo += '</div></td>';


                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Avaliable Inputs</label>';
                                    content_spo +=
                                        '<input class="form-control service_avaliable_input"  value="0" /></div>';
                                    content_spo += '</div></td>';


                                    content_spo +=
                                        '<td><div class="position-relative form-group">';
                                    content_spo +=
                                        '<label class="required">Adjusted Inputs</label>';
                                    content_spo +=
                                        '<input class="form-control services_adjusted_input" type="integer" value="0" disabled/></div>';
                                    content_spo += '</div></td>';

                                    content_spo += '</tr>';

                                });

                                service_purchase_tbody = $(".service_purchase_order tbody");

                                service_purchase_tbody.html(content_spo);
                                $('#service_purchase_order').show();
                            }




                        },
                        error: function(data) {

                            alert('Error Occured!');

                        }
                    });
                } else {
                    alert('Kindly select Tax Body first!');
                    $('.select_taxation_month').val('');
                }


            });

            var invoices = [],
                total_amount = 0;

            $(document).on('change', '.invoice_check', function() {
                $('.invoice_data').val('');
                $(this).closest('tr').find(
                    '.invoice_ids, .invoice_amounts, .invoice_tax, .invoice_adjusted_output').prop(
                    'disabled', !this.checked);
                // invoices.push(parseFloat($(this).closest('tr').find('.invoice_amounts').val()));
                var invoice_id = $(this).closest('tr').find('.invoice_ids').val();
                var invoice_amount = $(this).closest('tr').find('.invoice_amounts').val();
                var tax_ledger = $(this).closest('tr').find('.invoice_tax').val();
                var adjusted_out = parseFloat($(this).closest('tr').find('.invoice_adjusted_output').val());
                var total = (parseFloat(invoice_amount) + parseFloat(tax_ledger)) - adjusted_out;
                $(this).closest('tr').find('.invoice_avaliable_output').val(total);

                //total+=number(invoice_amount);

                var invoice_Data = {
                    'invoice_id': invoice_id,
                    'amount': total
                };

                invoices.push(invoice_Data);
                $('.invoice_data').val(JSON.stringify(invoices));

               // console.log('invoice data',JSON.stringify(invoices));


                //    adjusted outputs js
                $(this).closest('tr').find('.invoice_adjusted_output').change(function() {

                    var adjusted_output = $(this).closest('tr').find('.invoice_adjusted_output')
                        .val();
                    var total_amount = invoices.find(someobject => someobject.invoice_id ==
                        invoice_id).amount;
                    if (Number(adjusted_output) <= Number(total_amount)) {
                        invoice_id = $(this).closest('tr').find('.invoice_ids').val();
                        var find_invoice = invoices.find(someobject => someobject.invoice_id ==
                            invoice_id);
                        find_invoice.adjusted_output = Number(adjusted_output);
                        find_invoice.amount = Number(total_amount) - Number(adjusted_output);
                        $(this).closest('tr').find('.invoice_avaliable_output').val(find_invoice
                            .amount);

                        $('.invoice_data').val(JSON.stringify(invoices));
                        //console.log('Latest',invoices);

                        total_adjusted_output += Number(adjusted_output);
                        console.log('invoice data1',JSON.stringify(invoices));


                    } else {
                        alert('Adjusted Output value has to be less then avaliable output!');
                        $(this).closest('tr').find('.invoice_adjusted_output').val(0);
                    }

                });

            });

            var supplier_po = [];

            $(document).on('change', '.supplier_po_check', function() {
                $('.supplier_po_data').val('');
                $(this).closest('tr').find(
                    '.supplier_po_check, .supplier_po_title_no, .supplier_po_amount, .supplier_adjusted_input'
                ).prop(
                    'disabled', !this.checked);

                var supplier_po_title = $(this).closest('tr').find('.supplier_po_title_no').val();
                var supplier_po_amount = $(this).closest('tr').find('.supplier_po_amount').val();
                var supplier_tax_ledger = $(this).closest('tr').find('.supplier_tax_body').val();
                var supplier_total = parseFloat(supplier_po_amount) + parseFloat(supplier_tax_ledger);
                $(this).closest('tr').find('.supplier_po_inputs').val(supplier_total);

                var supplier_data = {
                    'po_number': supplier_po_title,
                    'po_type': 'supplier_po',
                    'amount': supplier_total
                };

                supplier_po.push(supplier_data);
                $('.supplier_po_data').val(JSON.stringify(supplier_po));

                ////    adjusted outputs js
                $(this).closest('tr').find('.supplier_adjusted_input').change(function() {
                    var po_number = $(this).closest('tr').find('.supplier_po_title_no').val();
                    var adjusted_input = $(this).closest('tr').find('.supplier_adjusted_input')
                        .val();
                    var total_amount = supplier_po.find(someobject => someobject.po_number ==
                        po_number).amount;
                    if (Number(adjusted_input) <= Number(total_amount)) {
                        var find_po = supplier_po.find(someobject => someobject.po_number ==
                            po_number);
                        find_po.adjusted_input = Number(adjusted_input);
                        find_po.amount = Number(total_amount) - Number(adjusted_input);
                        $(this).closest('tr').find('.supplier_po_inputs').val(find_po.amount);

                        total_adjusted_input += Number(adjusted_input);

                        $('.supplier_po_data').val(JSON.stringify(supplier_po));
                        console.log('Latest', supplier_po);

                    } else {
                        alert('Adjusted Input value has to be less then avaliable input!');
                        //$(this).closest('tr').find('.invoice_adjusted_output').val(0);
                    }

                });



            });


            var rental_po = [];

            $(document).on('change', '.rental_po_check', function() {

                $('.rental_po_data').val();
                $(this).closest('tr').find(
                        '.rental_po_check, .rental_po_title_no, .rental_po_amount, .rental_adjusted_input')
                    .prop(
                        'disabled', !this.checked);
                var rental_po_title = $(this).closest('tr').find('.rental_po_title_no').val();
                var rental_po_amount = $(this).closest('tr').find('.rental_po_amount').val();
                var rental_tax_ledger = $(this).closest('tr').find('.rental_tax_body').val();
                var rental_total = parseFloat(rental_po_amount) + parseFloat(rental_tax_ledger);
                $(this).closest('tr').find('.rental_avaliable_input').val(rental_total);

                var rental_data = {
                    'po_number': rental_po_title,
                    'po_type': 'rental_po',
                    'amount': rental_total
                };

                rental_po.push(rental_data);
                $('.rental_po_data').val(JSON.stringify(rental_po));

                ////    adjusted outputs js
                $(this).closest('tr').find('.rental_adjusted_input').change(function() {
                    var po_number = $(this).closest('tr').find('.rental_po_title_no').val();
                    var adjusted_input = $(this).closest('tr').find('.rental_adjusted_input')
                        .val();
                    var total_amount = rental_po.find(someobject => someobject.po_number ==
                        po_number).amount;
                    if (Number(adjusted_input) <= Number(total_amount)) {
                        var find_po = rental_po.find(someobject => someobject.po_number ==
                            po_number);
                        find_po.adjusted_input = Number(adjusted_input);
                        find_po.amount = Number(total_amount) - Number(adjusted_input);
                        $(this).closest('tr').find('.rental_avaliable_input').val(find_po.amount);
                        total_adjusted_input += Number(adjusted_input);
                        $('.rental_po_data').val(JSON.stringify(rental_po));
                        console.log('Latest', rental_po);

                    } else {
                        alert('Adjusted Input value has to be less then avaliable input!');
                        // $(this).closest('tr').find('.invoice_adjusted_output').val(0);
                    }

                });




            });

            // Assets PO

            var assets_po = [];

            $(document).on('change', '.asset_po_check', function() {
                $('.assets_po_data').val('');
                $(this).closest('tr').find('.asset_po_check, .asset_po_title_no, .asset_po_amount , .assets_adjusted_input').prop(
                    'disabled', !this.checked);

                var asset_po_title = $(this).closest('tr').find('.asset_po_title_no').val();
                var asset_po_amount = $(this).closest('tr').find('.asset_po_amount').val();
                var asset_tax_ledger = $(this).closest('tr').find('.asset_tax_body').val();
                var asset_total = parseFloat(asset_po_amount) + parseFloat(asset_tax_ledger);
                $(this).closest('tr').find('.asset_avaliable_input').val(asset_total);

                var asset_data = {
                    'po_number': asset_po_title,
                    'po_type': 'asset_po',
                    'amount': asset_total
                };

                assets_po.push(asset_data);
                $('.assets_po_data').val(JSON.stringify(assets_po));


                ////    adjusted outputs js
                $(this).closest('tr').find('.assets_adjusted_input').change(function() {
                   
                    var po_number = $(this).closest('tr').find('.asset_po_title_no').val();
                    var adjusted_input = $(this).closest('tr').find('.assets_adjusted_input')
                        .val();
                    var total_amount = assets_po.find(someobject => someobject.po_number ==
                        po_number).amount;
                    if (Number(adjusted_input) <= Number(total_amount)) {
                        var find_po = assets_po.find(someobject => someobject.po_number ==
                            po_number);
                        find_po.adjusted_input = Number(adjusted_input);
                        find_po.amount = Number(total_amount) - Number(adjusted_input);
                        total_adjusted_input += Number(adjusted_input);
                        console.log(find_po);
                        $(this).closest('tr').find('.asset_avaliable_input').val(find_po.amount);

                        $('.assets_po_data').val(JSON.stringify(assets_po));
                        console.log('Latest', assets_po);

                    } else {
                        alert('Adjusted Input value has to be less then avaliable input!');
                        // $(this).closest('tr').find('.invoice_adjusted_output').val(0);
                    }

                });




            });


            var services_po = [];

            $(document).on('change', '.services_po_check', function() {
                $('.services_po_data').val('');
                $(this).closest('tr').find('.service_po_title_no, .service_po_amount, .services_adjusted_input').prop(
                    'disabled', !this.checked);

                var services_po_title = $(this).closest('tr').find('.service_po_title_no').val();
                var services_po_amount = $(this).closest('tr').find('.service_po_amount').val();
                var services_tax_ledger = $(this).closest('tr').find('.service_tax_body').val();
                var services_total = parseFloat(services_po_amount) + parseFloat(services_tax_ledger);
                $(this).closest('tr').find('.service_avaliable_input').val(services_total);

                var services_data = {
                    'po_number': services_po_title,
                    'po_type': 'service_po',
                    'amount': services_total
                };

                services_po.push(services_data);
                $('.services_po_data').val(JSON.stringify(services_po));


                 ////    adjusted outputs js
                 $(this).closest('tr').find('.services_adjusted_input').change(function() {
                    var po_number = $(this).closest('tr').find('.service_po_title_no').val();
                    var adjusted_input = $(this).closest('tr').find('.services_adjusted_input')
                        .val();
                    var total_amount = services_po.find(someobject => someobject.po_number ==
                        po_number).amount;
                    if (Number(adjusted_input) <= Number(total_amount)) {
                        var find_po = services_po.find(someobject => someobject.po_number ==
                            po_number);
                        find_po.adjusted_input = Number(adjusted_input);
                        find_po.amount = Number(total_amount) - Number(adjusted_input);
                        total_adjusted_input += Number(adjusted_input);
                        $(this).closest('tr').find('.service_avaliable_input').val(find_po.amount);

                        $('.services_po_data').val(JSON.stringify(services_po));
                        console.log('Latest', services_po);

                    } else {
                        alert('Adjusted Input value has to be less then avaliable input!');
                        // $(this).closest('tr').find('.invoice_adjusted_output').val(0);
                    }

                });



            });


            $('.calcualte_payables').click(function(){
                var payable = Number(total_adjusted_input) - Number(total_adjusted_output);
                $('.payable_taxbody').val(payable);
            });


            
            $('.calcualte_netpayables').click(function(){
               
                var payable = Number($('.payable_taxbody').val());
                var manual_adjustments = Number($('.manual_adjustments').val());
                var netpayable = payable - manual_adjustments;
                $('.net_payable').val(netpayable);
            });










        });

        // CKEDITOR.replace('details_input');
        // CKEDITOR.replace('description_input');
    </script>

@endsection

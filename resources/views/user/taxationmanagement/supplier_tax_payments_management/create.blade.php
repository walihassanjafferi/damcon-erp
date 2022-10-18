@extends('layout.main')
@section('supplier_tax_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Supplier Tax Payments Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('suppliertaxpayment.index')}} @endsection
@section('main_btn_text') All Supplier Tax Payments Management @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }
        .align_checkbox_input {
            position: absolute;
            top: 33px;
            /* z-index: 10000; */
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
                        <h4 class="card-title">Add Supplier Tax Payments</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('suppliertaxpayment.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="title" class="form-control" placeholder="Title" value="{{ old('title') }}"/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-0" >
                                        <label>Select Supplier<span class="red_asterik"></span></label>
                                        <select class="form-control select2 supplier_select" name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @foreach ($supplies as $item)
                                                <option value="{{$item->id}}" {{ old('supplier_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Payable Tax<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="payable_tax" id="payable_tax" class="form-control" placeholder="Payable Tax" value="{{ old('payable_tax') }}" readonly/>
                                    </div>
                                </div>



                                <div class="col-12 pl-1 pr-1 mb-2" id="supplier_ledger" style="display: none">
                                    <p>Supplier Tax ledger</p>
                                    <table class="table table-striped table-bordered supplier_ledger" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Payment Title</th>
                                                <th>Transaction Type</th>
                                                <th>Module </th>
                                                <th>Tax Amount (Ledger)</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Manual Adjustments<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="manual_adjustments" id="manual_adjustments" class="form-control" placeholder="Manual Adjustments" value="{{ old('manual_adjustments') }}"/>
                                    </div>
                                </div>

                                
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <div class="input-group-append pl-2 align_checkbox_input">
                                            <label class="mb-0">Calculate Fianl Amount</label>
                                            <input type="checkbox" class="calcualte_finalAmount form-check-input">
                                        </div>
                                        <label>Final Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="final_amount" id="final_amount" class="form-control" placeholder="Final Amount" value="{{ old('final_amount') }}" readonly/>
                                    </div>
                                </div>


                            

                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-0">
                                        <label>Payment Method<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment_method" name="payment_method">
                                           <option disabled selected value="">Select Payment Method</option>
                                           <option value="direct">Direct</option>
                                           <option value="batch">Batch </option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12 debited_bank">
                                    <div class="form-group mb-0">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="bank_id">
                                            @foreach ($bankaccounts as $item)
                                                <option value="{{$item->id}}" {{ old('sender_bank_id') == $item->id ? "selected" : "" }}>{{$item->name}} ({{$item->title}})</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12 debited_cheque_title">
                                    <div class="form-group">
                                        <label>Cheque Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="cheque_title" class="form-control" placeholder="Cheque Title" value="{{ old('cheque_title') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12 debited_cheque_no">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ old('cheque_number') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="date" class="form-control date form-date" placeholder="Date" value="{{ old('date') }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-12 mt-2">
                                    <label>Payment Details</label>
                                    <textarea class="form-control" name="payment_details" rows="5" required >{{ old('payment_details') }}</textarea>
                                </div>


                                <div class="col-md-12 mt-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ old('description_input') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Manual Adjustment comments</label>
                                    <textarea class="form-control" name="manual_adjustment_comments" rows="5" required>{{ old('manual_adjustment_comments') }}</textarea>
                                </div>

                                <input type="text" class="ledger_data" name="ledger_data"  hidden />


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
                                    <button type="submit" class="btn btn-primary mr-1" >Submit</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\EmployeesTaxManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script>

    <script>


        $(function(){
            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            // $('#supplier_ledger').hide();

            $('.supplier_select').change(function(){
                
                var supplier_id = $('.supplier_select :selected').val();

                $.ajax({
                        url: '{{ route('getSuppliertaxledgers') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "supplier_id": supplier_id,
                        },
                        method: 'post',
                        success: function(data) {

                            var content = '',tableBody = '';
                              

                            if (data.supplier_ledgers.length == 0) {
                                alert('No tax ledgers Found!');
                                return;
                            }

                            if (data.supplier_ledgers.length != 0) {
                                $.each(data.supplier_ledgers, function(key, item) {

                                    content += '<tr>';
                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<input type="checkbox"  class="ledger_check" /></div>';
                                    content += '</td>';


                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<input type="integer" class="form-control ledger_id" value=' +
                                        item.id +' readonly /></div>';
                                    content += '</td>';



                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Payment title</label>';
                                    content +=
                                        '<input class="form-control payment_title" type="text" value=' +
                                        item
                                        .payment_title + ' disabled /></div>';
                                    content += '</div></td>';


                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Transaction type</label>';
                                    content +=
                                        '<input class="form-control transaction_type" type="text" value=' +
                                        item
                                        .transaction_type + ' disabled /></div>';
                                    content += '</div></td>';



                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content +=
                                        '<label class="required">Module</label>';
                                    content +=
                                        '<input class="form-control module_name" type="text" value=' +
                                        item
                                        .module_name + ' disabled /></div>';
                                    content += '</div></td>';




                                    content +=
                                        '<td><div class="position-relative form-group">';
                                    content += '<label class="required">Amount</label>';
                                    content +=
                                        '<input class="form-control amount" type="integer" value=' +
                                        item.amount +
                                        ' readonly /></div>';
                                    content += '</div></td>';
                                            
                                
                                    content += '</tr>';

                                });
                                tableBody = $(".supplier_ledger tbody");

                                tableBody.html(content);

                                $('#supplier_ledger').css('display','block');
                            }

                        
                        },
                        error: function(data) {

                            alert('Error Occured!');

                        }
                    });


            });


            var ids = [], ledger_total_amount = 0; supplier_tax_ledger =[];

            $(document).on('change', '.ledger_check', function() {
                $(this).closest('tr').find(
                    '.transaction_type, .payment_title, .module_name').prop(
                    'disabled', !this.checked);

                var ledger_id = $(this).closest('tr').find('.ledger_id').val();
                var tax_ledger_amount = $(this).closest('tr').find('.amount').val();
                var payment_title = $(this).closest('tr').find('.payment_title').val();


                ledger_total_amount+=Number(tax_ledger_amount);
                $('#payable_tax').val(Number(ledger_total_amount));

                var ledger_Data = {
                    'ledger_id': ledger_id,
                    'payment_title': payment_title,
                    'tax_ledger_amount':tax_ledger_amount
                };

                supplier_tax_ledger.push(ledger_Data);
                $('.ledger_data').val(JSON.stringify(supplier_tax_ledger));

        
            });

            $('.calcualte_finalAmount').click(function(){
                var manual_adjustments = Number($('#manual_adjustments').val());

                var final_amount = Number($('#payable_tax').val())-manual_adjustments;

                $('#final_amount').val(final_amount);
            });


            $('.payment_method').change(function(){

                if($(this).val() == "batch")
                {
                    $('.debited_bank').fadeOut(300);
                    $('.debited_cheque_title').fadeOut(300);
                    $('.debited_cheque_no').fadeOut(300);

                    $("[name='bank_id']").prop('disabled', true);
                    $("[name='cheque_number']").prop('disabled', true);
                    $("[name='cheque_title']").prop('disabled', true);



                }
                else{
                    $('.debited_bank').fadeIn(300);
                    $('.debited_cheque_title').fadeIn(300);
                    $('.debited_cheque_no').fadeIn(300);

                    $("[name='bank_account']").prop('disabled', false);
                    $("[name='cheque_number']").prop('disabled', false);
                    $("[name='cheque_title']").prop('disabled', false);
                }

            })  



        });


    </script>

@endsection

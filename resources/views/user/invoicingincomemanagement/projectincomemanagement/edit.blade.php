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
                        <h4 class="card-title">Edit Project Income Management</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('projectincome.update', encrypt($project_income->id)) }}" method="post"
                            class="import_purchases" enctype="multipart/form-data">
                            @csrf @method('patch')
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            value="{{ $project_income->title }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Project</label>
                                        {!! Form::select('project_id', $projects + [null => 'Select Project'], $project_income->project_id, ['class' => 'form-control select2 select_project', 'required' => 'true', 'id' => 'project_id','disabled'=>'disabled']) !!}
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
                                                <th>Amount</th>
                                                <th>Pending Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $item)
                                            <tr>
                                                <td>
                                                    <div class="position-relative form-group">
                                                    <input type="checkbox" class="invoice_check" name="invoice_check[]" checked  disabled/></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group">
                                                    <label class="required">Invoice Number</label>
                                                    <input class="form-control invoice_ids" name="invoice_id[]" type="text" value='{{$item->invoice_number}}' disabled />
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group">
                                                    <label class="required">Invoice Status</label>
                                                    <input class="form-control invoice_status" type="text" value='{{$item->invoice_status}}' disabled /></div>
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group">
                                                    <label class="required">Amount</label>
                                                    <input class="form-control invoice_amounts" type="integer" value='{{$item->total_after_deductions}}' name="invoice_amount[]" disabled /></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group">
                                                        <label class="required">Pending Balance</label>
                                                        <input class="form-control pending_balances" type="integer" name="pending_balance[]" value="0" disabled/></div>
                                                    </div>
                                                </td>

                                            </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Receiving Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_receving_date"
                                            class="form-control cheque_receving_date" placeholder="Cheque Receiving Date"
                                            value="{{ $project_income->cheque_receving_date }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Received Cheque Bank<span class="red_asterik"></span></label>
                                        <input type="text" name="received_cheque_bank" class="form-control"
                                            placeholder="Received Cheque Bank"
                                            value="{{ $project_income->received_cheque_bank }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Clearing Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_clearing_date"
                                            class="form-control cheque_clearing_date" placeholder="Cheque Clearing Date"
                                            value="{{ $project_income->cheque_clearing_date }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control cheque_number"
                                            placeholder="Cheque Number" value="{{ $project_income->cheque_number }}"
                                            required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Amount<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_amount" class="form-control cheque_amount"
                                            placeholder="Cheque Amount" value="{{ $project_income->cheque_amount }}"
                                            required readonly />
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
                                        <select class='form-control select2' name="cash_deposit_bank_id" disabled>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ $project_income->cash_deposit_bank_id == $val->id ? 'selected': '' }}>
                                                    {{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Bad Debt Amount<span class="red_asterik"></span></label>
                                        <input type="text" name="bad_debt_amount" class="form-control bad_debt_amount"
                                            placeholder="Bad debt amount" value="{{ $project_income->bad_debt_amount }}" readonly/>
                                    </div>
                                </div>




                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Difference Comments<span class="red_asterik"></span></label>
                                        <textarea name="difference_comments" class="form-control" rows="3"
                                            required>{{ $project_income->difference_comments }}</textarea>
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



                                {{-- remove picture code --}}

                                @php
                                    $files = json_decode($project_income->document_file);
                                @endphp
                                @if (isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if (!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                                <a class="remove" href={{ $path }}><i
                                                        class="fa fa-times"></i></a>
                                                <img class="images_upload" type="file"
                                                    src="{{ asset('/storage/projectIncome/' . $path) }}" />

                                            </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if (isset($pdf))
                                    <div class="col-12 mt-3"></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-4 pip">
                                            <a class="remove" href={{ $item }}><i
                                                    class="fa fa-times"></i></a>
                                            <a class="pdf_file"
                                                href="{{ asset('/storage/projectIncome/PDF/' . $item) }}"
                                                target="_blank">{{ $item }}</a>
                                        </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images" name="remove_images" hidden>

                                {{-- remove picture code --}}




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

    {!! JsValidator::formRequest('App\Http\Requests\ProjectIncomeRequest'); !!}


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


           // $('.invoices').hide();
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
                        content += '</div></td>';
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
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Amount</label>';
                        content +=
                            '<input class="form-control invoice_amounts" type="integer" value=' +
                            item.total_after_deductions +
                            ' name="invoice_amount[]" disabled /></div>';
                        content += '</div></td>';
                        content += '<td><div class="position-relative form-group">';
                        content += '<label class="required">Pending Balance</label>';
                        content +=
                            '<input class="form-control pending_balances" type="integer" name="pending_balance[]" value="0" disabled/></div>';
                        content += '</div></td>';
                        content += '</tr>';

                    });

                    tableBody = $(".invoices tbody");
                    // tableBody.html(content);
                    tableBody.html(content);
                    //  console.log(tableBody);
                    // $('.invoices').tbody.append(content);
                    $('.invoices').show();

                },
                error: function(data) {


                }
            });

        });

        $(document).on('change', '.invoice_check', function() {
            $(this).closest('tr').find('.invoice_ids, .invoice_amounts, .pending_balances').prop('disabled', !this
                .checked);
        });
    </script>

@endsection

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
                        <h4 class="card-title">Edit Security/Bid Bond Returns</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('securitybondreturns.update',encrypt($security_bond_return->id)) }}" method="post" class="import_purchases"
                            enctype="multipart/form-data">
                            @csrf @method('patch')
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            value="{{ $security_bond_return->title }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Security/Bid Returns title</label>
                                        <select name="security_payment_id" class="form-control select2 security_payment_id" disabled>
                                            <option value="">Select Security/Bid</option>
                                            @foreach ($security_payments as $item)
                                                <option value="{{ $item->id }}"
                                                    data-customer="{{ $item->customer_rel }}" data-security_payment="{{$item}}"
                                                    {{ $security_bond_return->pre_security_bid_id == $item->id ? 'selected' : '' }}>
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
                                            placeholder="Customer Name" value="{{ $security_bond_return->customer->name }}" readonly />
                                        <input type="text" name="customer_id" class="form-control customer_id"
                                            value="{{ $security_bond_return->customer_id }}" hidden />
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Clearing Date<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_clearing_date"
                                            class="form-control cheque_clearing_date" placeholder="Cheque Clearing Date"
                                            value="{{ $security_bond_return->cheque_clearing_date }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" name="cheque_number" class="form-control cheque_number"
                                            placeholder="Cheque Number" value="{{ $security_bond_return->cheque_number }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Amount<span class="red_asterik"></span></label>
                                        <input type="number" name="amount" class="form-control amount"
                                            placeholder="Amount" value="{{ $security_bond_return->amount }}" readonly />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Cheque Deposit Bank Account<span class="red_asterik"></span></label>
                                        <select class='form-control select2' name="cash_deposit_bank_id" disabled>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $val)
                                                <option value="{{ $val->id }}"
                                                    {{ $security_bond_return->cash_deposit_bank_id == $val->id ? 'selected' : '' }}>
                                                    {{ $val->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Payment Details<span class="red_asterik"></span></label>
                                        <textarea name="payment_details" class="form-control" rows="3"
                                            required>{{ $security_bond_return->payment_details }}</textarea>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea name="comments" class="form-control" rows="3"
                                            required>{{ $security_bond_return->comments }}</textarea>
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
                                  $files = json_decode($security_bond_return->document_file);
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
                                                    src="{{ asset('/storage/SecurityBond/' . $path) }}" />

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
                                                href="{{ asset('/storage/SecurityBond/PDF/' . $item) }}"
                                                target="_blank">
                                                {{ $item }}</a>
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

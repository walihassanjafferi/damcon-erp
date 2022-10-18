@extends('layout.main')
@section('supplier_payment_management_sidebar')
    active
@endsection
@section('title')
    <title>Damcon ERP - Supplier Payments Management Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href')
    {{ route('supplier_payment_management.index') }}
@endsection
@section('main_btn_text')
    All Supplier Payments Management
@endsection
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

    </style>
@endsection

@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Supplier Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('supplier_payment_management.update', encrypt($supplier_payments->id)) }}"
                            method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            value="{{ $supplier_payments->title }}" required />
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Supplier<span class="red_asterik"></span></label>
                                        <select id="supplier_id" class="form-control select2" name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $supplier_payments->supplier_id == $item->id ? 'selected' : '' }}
                                                    data-supplierid="{{ $item->id }}" data-supplierbalance="{{$item->balance}}" data-suppliertype="{{$item->type}}">
                                                    {{ $item->supplier_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>



                                {{-- <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Purchase Order<span class="red_asterik"></span></label>
                                        <select class="form-control select2 batch" name="po_id">
                                            @foreach ($supplier_pos as $item)
                                                <option @if ($supplier_payments->po_id == $item->id) {{ 'selected' }} @endif
                                                    value="{{ $item->id }}"
                                                    {{ old('po_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->purchase_od_number }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div> --}}

                                <input type="text" class="supplier_id" name="supplier_id" hidden />


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Supplier Type<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="supplier_type" id="supplier_type"
                                            class="form-control" placeholder="Supplier Type"
                                            value="{{ $supplier_payments->supplier_type_name->name ?? '' }}" readonly required />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment Method<span class="red_asterik"></span></label>
                                        <select class="form-control select2" name="payment_method">
                                            <option @if ($supplier_payments->payment_method == 'direct') {{ 'selected' }} @endif value="direct">
                                                Direct</option>
                                            <option @if ($supplier_payments->payment_method == "batch") {{ 'selected' }} @endif value="batch">
                                                Batch Payment</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>
                                @if($supplier_payments->banks)

                                    <div class="col-md-4 col-12">
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <label>Select Bank<span class="red_asterik"></span></label>
                                            <select class="form-control select2 banks" name="bank_id">
                                                @foreach ($bank_accounts as $item)
                                                    <option @if ($supplier_payments->bank_id == $item->id) {{ 'selected' }} @endif
                                                        value="{{ $item->id }}"
                                                        {{ old('sender_bank_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                            <span class="error-help-block"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Cheque Title<span class="red_asterik"></span></label>
                                            <input type="text" autocomplete="off" name="cheque_title" class="form-control"
                                                placeholder="Cheque Title" value="{{ $supplier_payments->cheque_title }}"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Cheque Number<span class="red_asterik"></span></label>
                                            <input type="text" autocomplete="off" name="cheque_number" class="form-control"
                                                placeholder="Cheque Number" value="{{ $supplier_payments->cheque_number }}"
                                                required />
                                        </div>
                                    </div>

                                @endif

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="date" class="form-control date"
                                            placeholder="Date" value="{{ $supplier_payments->date }}" readonly
                                            required />
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="amount" class="form-control"
                                            placeholder="Amount" value="{{ $supplier_payments->amount }}" required />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Payment Details<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="payment_details" class="form-control"
                                            placeholder="Payment Details"
                                            value="{{ $supplier_payments->payment_details }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}"
                                                style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label>
                                        <input id="file_input" type="file" class="form-control" name="document_file[]"
                                            multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                @php
                                    $files = json_decode($supplier_payments->document_file);
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
                                                    src="{{ asset('/storage/supplier_payments/' . $path) }}" />

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
                                                href="{{ asset('/storage/supplier_payments/PDF/' . $path) }}"
                                                target="_blank">{{ $item }}</a>
                                        </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images" name="remove_images" hidden>

                                <div class="col-md-12 col-12 mt-2">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea class="form-control" rows="4" name="comments"
                                            required>{{ $supplier_payments->comments }}</textarea>
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SupplierPaymentRequest') !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        var items = "";
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });


            var supplier_type =  $('#supplier_id option:selected').data('suppliertype');

            $('#supplier_type').val(supplier_type);

            $('.supplier_id').val($('#supplier_id option:selected').data('supplierid'));


           
        });

        function previewImages() {

            var preview = document.querySelector('#preview');

            if (this.files) {
                [].forEach.call(this.files, readAndPreview);
            }

            function readAndPreview(file) {

                // Make sure `file.name` matches our extensions criteria
                var filename = file.name;
                var file_extension = filename.split('.').pop();

                if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                    return alert(file.name + " is not an image");
                } // else...

                var reader = new FileReader();

                reader.addEventListener("load", function() {

                    if (file_extension != 'pdf') {
                        $("<span class=\"pip col-3\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name +
                            "\"/>" +
                            "</span>").insertAfter("#preview");
                    } else {

                        $("<span class=\"pip col-4\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>" + file.name +
                            "</span>" +
                            "</span>").insertAfter("#preview_pdf");
                    }

                    $(".remove").click(function() {
                        $(this).parent(".pip").delay(200).fadeOut();
                    });
                });
                reader.readAsDataURL(file);
            }
        }

        document.querySelector('#file_input').addEventListener("change", previewImages);

        // $(".batch").change(function() {
        //     $id = $(this).val();
        //     if ($id) {
        //         $.ajax({
        //             url: '{{ route('get_supplier_po') }}',
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "id": $id
        //             },
        //             method: 'post',
        //             success: function(data) {
        //                 $('#supplier_type').val(data.name);
        //                 $('.supplier_id').val($('.batch').find(":selected").data('supplierid'));

        //             },
        //             error: function(data) {
        //                 $('#supplier_type').val("");
        //             }
        //         });
        //     } else {
        //         alert("Select Tax Body");
        //         $('#bank_of_batch').val("");
        //     }
        // });


        $("#supplier_id").change(function() {
            //$id = $(this).val();
          /// .attr('data-id')
            
            var supplier_type =  $('#supplier_id option:selected').data('suppliertype');
            var balance = $('#supplier_id option:selected').data('supplierbalance');
            
            $('.supplier_id').val($('#supplier_id option:selected').data('supplierid'));

            $('#supplier_type').val(supplier_type);

           // alert(supplier_type);
           
           swal("Supplier Balance",`PKR ${balance}`);


        });

        var remove_images = [];
        $(".remove").click(function() {
            event.preventDefault();
            let img_val = $(this).attr('href');
            remove_images.push(img_val);
            $('#remove_images').val(remove_images);
            $(this).parent(".pip").remove();
        });
    </script>
@endsection

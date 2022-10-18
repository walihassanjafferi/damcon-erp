@extends('layout.main')
@section('security_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Security Payments Management Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('security_payment_management.index')}} @endsection
@section('main_btn_text') All Security Payments Management @endsection
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
    </style>
@endsection

@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Security Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('security_payment_management.update',encrypt($securityPayments->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">

                                <div class="col-md-4 col-12 debited_cheque_title">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="title" class="form-control" placeholder="Title" value="{{ $securityPayments->title }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Project<span class="red_asterik"></span></label>
                                        <select class="form-control select2 project" name="project_id">
                                            @foreach ($projects as $item)
                                                <option @if($securityPayments->project_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('po_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment Type<span class="red_asterik"></span></label>
                                        {{-- <select class="form-control select2 Payment" name="payment_type">
                                            @foreach ($category as $item)
                                                <option @if($securityPayments->payment_type == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('payment_type') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select> --}}
                                        <select class='form-control select2 select_expense' name="payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            @foreach ($categories as $item)
                                                <option @if($securityPayments->payment_type == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('payment_type') == $item->id ? "selected" : "" }}>{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment Method<span class="red_asterik"></span></label>
                                        <select class="form-control select2" name="payment_method">
                                            <option @if($securityPayments->payment_method == 'direct'){{ 'selected' }}@endif value="direct" {{ old('payment_method') == 1 ? "selected" : "" }}>Direct</option>
                                            <option @if($securityPayments->payment_method == 'batch'){{ 'selected' }}@endif value="batch" {{ old('payment_method') == 2 ? "selected" : "" }}>Batch Payment</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                @if($securityPayments->banks)
                                    <div class="col-md-4 col-12">
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <label>Select Bank<span class="red_asterik"></span></label>
                                            <select class="form-control select2 banks" name="bank_id" disabled>
                                                @foreach ($bank_accounts as $item)
                                                    <option @if($securityPayments->bank_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}} </option>
                                                @endforeach
                                            </select>
                                            <span class="error-help-block"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12" >
                                        <div class="form-group">
                                            <label>Cheque Title<span class="red_asterik"></span></label>
                                            <input type="text" autocomplete="off"  name="cheque_title" class="form-control" placeholder="Cheque Title" value="{{ $securityPayments->cheque_title }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12" >
                                        <div class="form-group">
                                            <label>Cheque Number<span class="red_asterik"></span></label>
                                            <input type="text" autocomplete="off"  name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ $securityPayments->cheque_number }}" readonly/>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="date" class="form-control date" placeholder="Date" value="{{ $securityPayments->date }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="amount" class="form-control" placeholder="Amount" value="{{ $securityPayments->amount }}" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Payment Details</label>
                                        <input type="text" autocomplete="off"  name="payment_details" class="form-control" placeholder="Payment Details" value="{{ $securityPayments->payment_details }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Select Customer<span class="red_asterik"></span></label>
                                        <select name="customer_id" class="form-control select2">
                                        @foreach ($customer as $item)
                                            <option value="{{$item->id}}" {{old('customer_id') == $item->id ? 'selected' : '' }}  >{{ucfirst($item->name)}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Submitted to Customer</label>
                                        <input type="text" autocomplete="off"  name="customer" class="form-control" placeholder="Submitted to Customer" value="{{ $securityPayments->customer }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}" style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label>
                                        <input id="file_input" type="file" class="form-control" name="document_file[]" multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                @php
                                    $files = json_decode($securityPayments->document_file)
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/security_payments/'.$path) }}"/>

                                    </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if(isset($pdf))
                                    <div class="col-12 mt-3" ></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-4 pip">
                                        <a  class="remove" href={{$item}}><i class="fa fa-times"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/security_payments/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>


                                <div class="col-md-12 col-12 mt-2" >
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea class="form-control" rows="4" name="comments" required>{{ $securityPayments->comments }}</textarea>
                                    </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\SecurityPaymentRequest'); !!}
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

            CKEDITOR.replace('description_input');
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

                    if(file_extension!='pdf')
                    {
                        $("<span class=\"pip col-3\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name + "\"/>" +
                            "</span>").insertAfter("#preview");
                    }
                    else{

                        $("<span class=\"pip col-4\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>"+file.name+"</span>" +
                            "</span>").insertAfter("#preview_pdf");
                    }

                    $(".remove").click(function(){
                        $(this).parent(".pip").delay(200).fadeOut();
                    });
                });
                reader.readAsDataURL(file);
            }
        }

        document.querySelector('#file_input').addEventListener("change", previewImages);

        var remove_images = [];
        $(".remove").click(function(){
            event.preventDefault();
            let img_val =  $(this).attr('href');
            remove_images.push(img_val);
            $('#remove_images').val(remove_images);
            $(this).parent(".pip").remove();
        });
    </script>

@endsection

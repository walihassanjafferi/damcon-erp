@extends('layout.main')
@section('security_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Supplier Payments Management Create</title>
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
                        <h4 class="card-title">Add Security/Bid Bond Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('security_payment_management.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-md-4 col-12 debited_cheque_title">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" required/>
                                    </div>
                                </div>

                                
                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Project<span class="red_asterik"></span></label>
                                        <select class="form-control select2 project" name="project_id">
                                            @foreach ($projects as $item)
                                                <option value="{{$item->id}}" {{ old('po_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
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
                                                <option value="{{$item->id}}" {{ old('payment_type') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select> --}}
                                        <select class='form-control select2 select_expense' name="payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}" {{ old('payment_type') == $item->id ? "selected" : "" }}>{{$item->category_name}}</option>
                                            @endforeach

                                        </select>
                                
                                        
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment Method<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment_method" name="payment_method">
                                            <option value="">Select Payment method</option>
                                            <option value="direct" {{ old('payment_method') == "direct" ? "selected" : "" }}>Direct</option>
                                            <option value="batch" {{ old('payment_method') == "batch" ? "selected" : "" }}>Batch Payment</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-12" id="batchs">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select batch<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks select_batch" name="batch_id">
                                            <option value="">Select batch</option>
                                            @foreach ($batches_payment as $item)
                                                <option value="{{$item->id}}" {{ old('batch_id') == $item->id ? "selected" : "" }}>{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div> --}}

                                <div class="col-md-4 col-12 debited_bank">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks select_bank" name="bank_id">
                                            @foreach ($bank_accounts as $item)
                                                <option value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12 debited_cheque_title">
                                    <div class="form-group">
                                        <label>Cheque Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="cheque_title" class="form-control" placeholder="Cheque Title" value="{{ old('cheque_title') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12 debited_cheque_no">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ old('cheque_number') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="date" class="form-control date" placeholder="Date" value="{{ old('date') }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="amount" class="form-control amount amount_format" placeholder="Amount" value="{{ old('amount') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Payment Details</label>
                                        <input type="text" autocomplete="off"  name="payment_details" class="form-control" placeholder="Payment Details" value="{{ old('payment_details') }}" required/>
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
                                        <input type="text" autocomplete="off"  name="customer" class="form-control" placeholder="Submitted to Customer" value="{{ old('customer') }}" required/>
                                    </div>
                                </div>


                                {{-- <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment type<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment_type" name="payment_type">
                                            <option value="in" {{ old('payment_type') == 'in' ? "selected" : "" }}>Payment IN</option>
                                            <option value="out" {{ old('payment_type') == 'out' ? "selected" : "" }}>Payment OUT</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div> --}}



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

                                <div class="col-md-12 col-12" >
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea class="form-control" rows="4" name="comments" required>{{ old('comments') }}</textarea>
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

            // $("#batchs").hide();

            // var batches = {!! json_encode($batches_payment) !!}


            // $('.select_batch').change(function(){
            //     var id = $('.select_batch').find(":selected").val();

            //     for(var i=0; i<batches.length ;i++)
            //     {
            //         if(batches[i].id == id)
            //         {
            //                 $('.amount').val(batches[i].amount);
            //                 $('.select_bank').val(batches[i].bank_of_batch).change();
            //         }
            //     }
            // });

            // $('.payment_method').change(function(){
            //     var payment_method = $('.payment_method').find(":selected").val();
            //     if(payment_method == 2)
            //     {
            //         $("#batchs").show();
            //     }
            //     else{
            //         $("#batchs").hide();
            //     }
            // });

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
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

                    $("[name='bank_id']").prop('disabled', false);
                    $("[name='cheque_number']").prop('disabled', false);
                    $("[name='cheque_title']").prop('disabled', false);
                }

            }) 

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
    </script>

@endsection

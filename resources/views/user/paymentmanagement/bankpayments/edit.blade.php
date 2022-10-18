@extends('layout.main')
@section('bank_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Bank Payments Management Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('bank_payment_management.index')}} @endsection
@section('main_btn_text') All Bank Payments Management @endsection
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
                        <h4 class="card-title">Edit Bank Payments</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('bank_payment_management.update',encrypt($bank_payments->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Select Project</label>
                                        {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                        $bank_payments->project_id, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                    </div>
                                </div>



                                {{-- <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Expense Type</label>
                                        {!! Form::select('expense_type',$categories+[NULL=>'Select Type'],
                                        $bank_payments->expense_type, ['class' => 'form-control select2 select_expense','required'=>'true']) !!}
                                    </div>
                                </div> --}}


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Expense Type</label>
                                      
                                
                                        <select class='form-control select2 select_expense' name="expense_type" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}" {{($bank_payments->expense_type == $item->id) ? "selected": ''}}>{{$item->category_name}}</option>
                                            @endforeach

                                        </select>
                                
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select class="form-control select2" name="payment_type" onchange="selectPayment(this.value)">
                                            <option>Select Payment Type</option>
                                            <option @if($bank_payments->payment_type == "bank"){{ 'selected' }}@endif value="bank">Bank</option>
                                            <option @if($bank_payments->payment_type == "advance"){{ 'selected' }}@endif value="advance">Advanced Project Payment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" id="banks">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="bank_id">
                                            @foreach ($bankaccounts as $item)
                                                <option @if($bank_payments->bank_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" id="banks_cheque">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ $bank_payments->cheque_number }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" id="batchs">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select batch<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="batch_id">
                                            <option></option>
                                            @foreach ($batches_payment as $item)
                                                <option @if($bank_payments->batch_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('batch_id') == $item->id ? "selected" : "" }}>{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>





                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date of payment<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="payment_date" class="form-control payment_date form-date" placeholder="Date of payment" value="{{ $bank_payments->payment_date }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Region</label>
                                        <input type="text" autocomplete="off"   name="region" class="form-control" placeholder="Region" value="{{ $bank_payments->region }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="amount" class="form-control" placeholder="Amount" value="{{ $bank_payments->amount }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Paid to Person</label>
                                        <input type="text" autocomplete="off"   name="paid_to_person" class="form-control" placeholder="Paid to Person" value="{{ $bank_payments->paid_to_person }}" required/>
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
                                    $files = json_decode($bank_payments->document_file)
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/bankpayments/'.$path) }}"/>

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
                                        <a class="pdf_file" href="{{ asset('/storage/bankpayments/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>


                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ $bank_payments->comments }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\BankPaymentsManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>


        $(function(){
            @if($bank_payments->payment_type == "advance")
                $("#banks").hide();
                $("#banks_cheque").hide();
                $("#batchs").show();
            @elseif ($bank_payments->payment_type =="bank")
                $("#banks").show();
                $("#banks_cheque").show();
                $("#batchs").hide();
            @endif



            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.payment_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.expense_month').datepicker({
                format: 'yyyy-mm',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

        });



        function selectPayment(type){
            if(type == "bank"){
                $("#banks").show();
                $("#banks_cheque").show();
                $("#batchs").hide();
            }else if(type == "advance"){
                $("#banks").hide();
                $("#banks_cheque").hide();
                $("#batchs").show();
            }else {
                $("#banks").hide();
                $("#banks_cheque").hide();
                $("#batchs").hide();
            }
        }

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


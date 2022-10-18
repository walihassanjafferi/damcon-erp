@extends('layout.main')
@section('bank_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Bank Payments Management Create</title>
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
                        <h4 class="card-title">Add Bank Payments</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('bank_payment_management.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Select Project</label>
                                        {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                        NULL, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                    </div>
                                </div>



                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Expense Type</label>
                                        {{-- {!! Form::select('expense_type',$categories+[NULL=>'Select Type'],
                                        NULL, ['class' => 'form-control select2 select_expense','required'=>'true']) !!} --}}
                                        
                                        <select class='form-control select2 select_expense' name="expense_type" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->category_name}}</option>
                                            @endforeach

                                        </select>
                                
                                    </div>
                                </div>

                                <input type="text" name="expense_type_name" class="expense_type_name" hidden />

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select class="form-control select2" name="payment_type" onchange="selectPayment(this.value)">
                                            <option value="bank">Bank</option>
                                            <option value="advance">Advanced Project Payment</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" id="batchs">
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
                                </div>

                                <div class="col-md-4 col-12" id="banks">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks select_bank" name="bank_id">
                                            @foreach ($bankaccounts as $item)
                                                <option value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}} </option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                               

                                <div class="col-md-4 col-12" id="banks_cheque">
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ old('cheque_number') }}"/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date of payment<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="payment_date" class="form-control payment_date form-date" placeholder="Date of payment" value="{{ old('payment_date') }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Region</label>
                                        <input type="text" autocomplete="off"   name="region" class="form-control" placeholder="Region" value="{{ old('region') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="amount" class="form-control amount_format amount" placeholder="Amount" value="{{ old('amount') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Paid to Person</label>
                                        <input type="text" autocomplete="off"   name="paid_to_person" class="form-control" placeholder="Paid to Person" value="{{ old('paid_to_person') }}" required/>
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


                                <div class="col-md-12 mb-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ old('comments') }}</textarea>
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
            $("#batchs").hide();

            var batches = {!! json_encode($batches_payment) !!}
            
            
            $('.select_batch').change(function(){
                var id = $('.select_batch').find(":selected").val();

                for(var i=0; i<batches.length ;i++)
                {
                   if(batches[i].id == id)
                   {
                        $('.amount').val(batches[i].amount);
                        $('.select_bank').val(batches[i].bank_of_batch).change();
                   }
                }

            });

            $('.select_expense').change(function(){

                
                var expense_type_name = $('.select_expense').find(":selected").text();
                $('.expense_type_name').val(expense_type_name);


            });


    


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

            $('.taxation_month_date').datepicker({
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
               // $("#banks").hide();
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

    </script>

@endsection

@extends('layout.main')
@section('loan_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Investor Payments Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('loan_payment_management.index')}} @endsection
@section('main_btn_text') All Investor Principal Payments Management @endsection
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
                        <h4 class="card-title">Add Investor Principal Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('loan_payment_management.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Investor<span class="red_asterik"></span></label>
                                        <select class="form-control select2 investor" name="investor_id">
                                            <option value="">Select Investor</option>
                                            @foreach ($investors as $item)
                                                <option value="{{$item->id}}" data-balance = "" {{ old('investor_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Type<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment" name="payment">
                                            <option value="">Select Payment</option>
                                            <option value="in" {{ old('payment') == 'in' ? "selected" : "" }}>In</option>
                                            <option value="out" {{ old('payment') == 'out' ? "selected" : "" }}>Out</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Payment Type<span class="red_asterik"></span></label>
                                        <select class="form-control select2 payment_type" name="payment_type">
                                            <option value="1" {{ old('payment_type') == 1 ? "selected" : "" }}>Principle</option>
                                            <option value="2" {{ old('payment_type') == 2 ? "selected" : "" }}>Profit on Investment</option>
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Project<span></span></label>
                                        <select class="form-control select2 project" name="project_id">
                                            <option value="">Select Project</option>
                                            @foreach ($projects as $item)
                                                <option value="{{$item->id}}" {{ old('po_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>




                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="bank_id">
                                            <option value="">Select Bank</option>
                                            @foreach ($bank_accounts as $item)
                                                <option value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Cheque Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="cheque_title" class="form-control" placeholder="Cheque Title" value="{{ old('cheque_title') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
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
                                        <input type="text" autocomplete="off"  name="amount" class="form-control amount_format" placeholder="Amount" value="{{ old('amount') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Payment Details<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="payment_details" class="form-control" placeholder="Payment Details" value="{{ old('payment_details') }}" required/>
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
    {!! JsValidator::formRequest('App\Http\Requests\LoanPaymentRequest'); !!}
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



        $('.investor').change(function(){
            var id = $(this).val();

            $.ajax({
                url:'{{ route('getInvestorBalance')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":id
                },
                method: 'post',
                success: function(data) {

                    //console.log(data.message);

                    swal("Investor Balance", `Rs ${data.message}`);

                   
                },
                error: function(data)
                {    
                
                    alert('Balance ERROR!');
                }
            });

            
        });

        $('.payment').change(function(){
            var id = $(this).val();
            var html = '';

            if(id == 'in')
            {
                $('.payment_type').html('');

                html = '<option value="1" >Principle</option>'

                $('.project').removeAttr('disabled');


            }
            else{
                $('.payment_type').html('');

                    html += '<option value="1" >Principle</option>'
                    html += '<option value="2" >Profit on Investment</option>'

            }

            $('.payment_type').append(html);

        })

        $('.payment_type').change(function(){
           
            var id = $(this).val();
            var payment = $('.payment :selected').val();

            if(id == 2 && payment == 'out')
            {
                $('.project').attr('disabled', 'disabled');

            }
            else{

                $('.project').removeAttr('disabled');


            }

        });




    </script>

@endsection

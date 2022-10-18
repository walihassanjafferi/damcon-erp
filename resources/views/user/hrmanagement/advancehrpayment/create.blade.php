@extends('layout.main')
@section('hr_advance_payment_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Advance HR Payment</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('advancehrpayment.index')}} @endsection
@section('main_btn_text') All Advance HR Payment @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Advance HR Payment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('advancehrpayment.store')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="row">


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Advance HR payment title</label>
                                    <input type="text" class="form-control" name="advance_hr_title"  value="{{ old('advance_hr_title') }}" placeholder="Advance HR title"/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Employee CNIC</label>
                                    <select name="employee_cnic" class="form-control select2" id="employee_cnic">
                                        <option value="" selected>Select CNIC</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->cnic}}"  {{old('employee_cnic') == $emp->cnic ? 'selected' : '' }} data-cnicid = {{$emp->id}}>{{$emp->cnic}} ({{$emp->name}})</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                        <select name="emp_name" class="form-control select2" id="employee_name">
                                            <option value="" selected>Select Employee</option>
                                            @foreach ($employees as $emp)
                                                <option value="{{$emp->name}}" {{old('emp_name') == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
                                            @endforeach
                                        </select>
                                    @error('employee_name')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <select name="employee_id" class="form-control select2" id="employee_id">
                                        <option value="" selected>Select Employee ID</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->id}}" {{old('employee_id') == $emp->id ? 'selected' : '' }}>{{$emp->employee_damcon_id}} </option>
                                        @endforeach
                                    </select>
                                    @error('employee_name')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Father Name</label>
                                    <input type="text" name="father_name" class="form-control father_name" value="{{ old('father_name') }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="text" name="joining_date" class="form-control joining_date" value="{{ old('joining_date') }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control designation" value="{{ old('designation') }}" placeholder="Designation" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" name="region" class="form-control region" value="{{ old('region') }}" placeholder="Region" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control location" value="{{ old('location') }}" placeholder="Location"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Advance Type Catgory</label>
                                    <select class="form-control" name="category_id">
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}" {{old('category_id') == $cat->id ? 'selected' : ''}} >{{$cat->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="Amount"/>
                                </div>
                            </div>
                       

                             
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment ID</label>
                                    <input type="number" name="payment_id" class="form-control" value="{{ old('payment_id') }}" placeholder="Payment ID"/>
                                </div>
                            </div>

                          
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Advance Type</label>
                                    <select class="form-control" name="advance_type">
                                        <option value="personal">Personal</option>
                                        <option value="project">Project</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select class="form-control payment_method" name="payment_mode">
                                        <option value="">Selects Payment mode</option>
                                        <option value="direct">Direct Payment</option>
                                        <option value="batch">Batch Payment</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 debited_bank">
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}" placeholder="Bank Account"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 debited_cheque_title">
                                <div class="form-group">
                                    <label>Cheque Title</label>
                                    <input type="text" name="cheque_title" class="form-control" value="{{ old('cheque_title') }}" placeholder="Cheque title"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 debited_cheque_no">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_number" class="form-control" value="{{ old('cheque_number') }}" placeholder="Cheque Number"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control date" value="{{ old('date') }}" placeholder="Date"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select class="form-control" name="payment_type" required>
                                       <option value="">Select Payment Type</option>
                                       <option value="payment_in" {{old('payment_type')=='payment_in' ? "selected": ''}}>Payment IN</option>
                                       <option value="payment_out" {{old('payment_type')=='payment_out' ? "selected": ''}}>Payment Out</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description"  class="form-control" rows="2"  required>{{ old('description') }}</textarea>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea name="comments"  class="form-control" rows="2"  required>{{ old('comments') }}</textarea>     
                                </div>
                            </div>

                            <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                <small>**multiple items can be selected</small><br/>
                                <label for="formFileMultiple" class="form-label">File Attachment</label>
                                <input class="form-control" type="file" name="document_file[]" id="file-input" multiple>
                                <small>files supported jpg | jpeg | png | pdf</small><br/>
                            </div>
    
                            <div class="col-12" style="margin-bottom: 20px;">
                                <div id="preview" class="gallery col-12"></div>
                                <div id="preview_pdf" class="gallery col-12"></div>
                            </div>
    


                     

                        
                        
                        
                
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            </div>
                        </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AdvanceHrRequest'); !!}

<script>
   
    $(function(){

        var data = {!! json_encode($employees) !!};

        $('#employee_cnic').change(function(){

            // empty values
            $('#employee_name').val('').change();
            $('#employee_id').val('').change();
            $('.father_name').val('');
            $('.joining_date').val('');
         


            var id = $(this).find(":selected").data('cnicid');
            
            $.each( data, function( key, value ) {
               if(id === value.id)
               {    
                 
                    $('#employee_name').val(value.name).change();
                    $('#employee_id').val(value.id).change();
                    $('.father_name').val(value.father_name);
                    $('.joining_date').val(value.joining_date);
                    $('.designation').val(value.designation);
                    $('.region').val(value.region);
                    $('.location').val(value.location);
                    
                
               }
            });
            

        });



        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.joining_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });

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

                $("[name='bank_account']").prop('disabled', true);
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
            
            if(file.size > 1000000)
            {
                return alert(file.name + " size can't be greater than 1 MB");
            }

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
       
    document.querySelector('#file-input').addEventListener("change", previewImages);

    
</script>
@endsection


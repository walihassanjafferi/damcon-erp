@extends('layout.main')
@section('hr_qualityhealthsafety-sidebar') active @endsection
@section('title')
<title>Damcon ERP - Quality Health Safety Event</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('qualityhealthSafety.index')}} @endsection
@section('main_btn_text') All Quality Health Safety @endsection
{{-- back btn --}}
@section('css')
   
@endsection
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Quality Health Safety Management</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('qualityhealthSafety.store')}}"  method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form_status">
                            <label>Status</label> &nbsp;
                            <label class="switch">
                                <input type="checkbox" checked name = 'status'>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    
                        <div class="row">
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
                                    <label>Date of Joining</label>
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
                                    <input type="text" name="location" class="form-control location" value="{{ old('location') }}" placeholder="Location" />
                                </div>
                            </div>
                            


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Event Date</label>
                                    <input type="text" name="event_date" class="form-control event_date" value="{{ old('event_date') }}" placeholder="Event Date" readonly/>
                                </div>
                            </div>

                          
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label> Asset ID (optional)</label>
                                    {!! Form::select('asset_id',[''=>'Select Asset']+$assets,
                                    old('asset_id'), ['class' => 'form-control select2 asset_id','required'=>'true']) !!}
                                    @error('asset_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Event Reporting Date</label>
                                    <input type="text" name="event_reporting_date" class="form-control event_reporting_date" value="{{ old('event_reporting_date') }}" placeholder="Event Reporting Date" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Event Supervisor</label>
                                    <input type="text" name="event_supervisor" class="form-control event_supervisor" value="{{ old('event_supervisor') }}" placeholder="Event Supervisor" />
                                </div>
                            </div>


                            

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Detailed Event Report</label>
                                    <textarea name="detailed_event_report"  class="form-control" rows="2"  required>{{ old('detailed_event_report') }}</textarea>     
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Insurance Company</label>
                                    <input type="text" name="insurance_company" class="form-control insurance_company" value="{{ old('insurance_company') }}" placeholder="Insurance Company"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Claim Category</label>
                                    <input type="text" name="claim_category" class="form-control claim_category" value="{{ old('claim_category') }}" placeholder="Claim Category"/>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Limit Details</label>
                                    <textarea name="limit_details"  class="form-control" rows="2"  required>{{ old('limit_details') }}</textarea>     
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Event Details</label>
                                    <textarea name="event_details"  class="form-control" rows="2"  required>{{ old('event_details') }}</textarea>     
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Claim Details</label>
                                    <textarea name="claim_details"  class="form-control" rows="2"  required>{{ old('claim_details') }}</textarea>     
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Claim Amount (PKR)</label>
                                    <input type="text" name="claim_amount" class="form-control claim_amount amount_format" value="{{ old('claim_amount') }}" placeholder="Claim Amount"/>
   
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque title</label>
                                    <input type="text" name="cheque_title" class="form-control cheque_title" value="{{ old('cheque_title') }}" placeholder="Cheque title"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_number" class="form-control cheque_number" value="{{ old('cheque_number') }}" placeholder="Check Number"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Date</label>
                                    <input type="text" name="cheque_date" class="form-control cheque_date" value="{{ old('cheque_date') }}" placeholder="Cheque Date" readonly/>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                   
                                    <label>Select Bank<span class="red_asterik"></span></label>
                                 
                                    <select class="form-control select2 banks" name="bank_id">
                                        <option value="">Select Bank</option>
                                        @foreach ($bankaccounts as $item)
                                            <option value="{{$item->id}}" {{ old('bank_id') == $item->id ? "selected" : "" }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-help-block"></span>    
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



                            
                            <div class="col-12"></div>
                                
                
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
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\QualityHealthSafetyRequest'); !!}

<script>
   
    $(function(){

        var data = {!! json_encode($employees) !!};

        $('#employee_cnic').change(function(){

            // empty values
            $('#employee_name').val('').change();
            $('#employee_id').val('').change();
            $('.father_name').val('');
            $('.joining_date').val('');
            $('.basic_salary').val('').change();
            $('.current_project').val('').change();

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
       
        $('.event_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });

        $('.event_reporting_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });

        $('.cheque_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
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
      

        

  

    });
</script>
@endsection


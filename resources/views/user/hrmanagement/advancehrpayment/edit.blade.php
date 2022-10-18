@extends('layout.main')
@section('hr_advance_payment_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Advance HR Payment</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('advancehrpayment.show',encrypt($advancehrpayment->employeemanagement_id))}} @endsection
@section('main_btn_text') Back @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Advance HR Payment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('advancehrpayment.update',encrypt($advancehrpayment->id))}}"  method="post" enctype="multipart/form-data">
                        @csrf 
                        @method('patch')
                    
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Employee CNIC</label>
                                    <select name="employee_cnic" class="form-control select2" id="employee_cnic">
                                        <option value="" selected>Select CNIC</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->cnic}}"  {{$advancehrpayment->employee_cnic == $emp->cnic ? 'selected' : '' }} data-cnicid = {{$emp->id}}>{{$emp->cnic}} </option>
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
                                                <option value="{{$emp->name}}" {{ $advancehrpayment->emp_name == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
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
                                            <option value="{{$emp->id}}" {{ $advancehrpayment->employeemanagement_id == $emp->id ? 'selected' : '' }}>{{$emp->employee_damcon_id}} </option>
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
                                    <input type="text" name="father_name" class="form-control father_name" value="{{ $advancehrpayment->father_name}}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Joining Date</label>
                                    <input type="text" name="joining_date" class="form-control joining_date" value="{{ $advancehrpayment->joining_date }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control designation" value="{{ $advancehrpayment->designation }}" placeholder="Designation" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" name="region" class="form-control region" value="{{ $advancehrpayment->region }}" placeholder="Region" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control location" value="{{ $advancehrpayment->location }}" placeholder="Location"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Advance Type Catgory</label>
                                    <select class="form-control" name="category_id">
                                        @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}" {{$advancehrpayment->category_id == $cat->id ? 'selected' : ''}} >{{$cat->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" value="{{ $advancehrpayment->amount }}" placeholder="Amount"/>
                                </div>
                            </div>
                       

                             
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment ID</label>
                                    <input type="number" name="payment_id" class="form-control" value="{{ $advancehrpayment->payment_id }}" placeholder="Payment ID"/>
                                </div>
                            </div>

                          
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Advance Type</label>
                                    <select class="form-control" name="advance_type">
                                        <option value="personal" {{$advancehrpayment->advance_type == 'personal' ? 'selected' : ''}}>Personal</option>
                                        <option value="project" {{$advancehrpayment->advance_type == 'project' ? 'selected' : ''}}>Project</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select class="form-control" name="payment_mode">
                                        <option value="direct_payment" {{$advancehrpayment->payment_mode == 'direct' ? 'selected' : ''}}>Direct Payment</option>
                                        <option value="batch_payment" {{$advancehrpayment->payment_mode == 'batch' ? 'selected' : ''}}>Batch Payment</option>
                                    </select>
                                </div>
                            </div>

                            @if($advancehrpayment->payment_mode == 'direct')

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <input type="text" name="bank_account" class="form-control" value="{{ $advancehrpayment->bank_account }}" placeholder="Bank Account"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Title</label>
                                    <input type="text" name="cheque_title" class="form-control" value="{{ $advancehrpayment->cheque_title }}" placeholder="Cheque title"/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_number" class="form-control" value="{{ $advancehrpayment->cheque_number }}" placeholder="Cheque Number"/>
                                </div>
                            </div>

                            @endif


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" class="form-control date" value="{{ $advancehrpayment->date }}" placeholder="Date"/>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description"  class="form-control" rows="2"  required>{{ $advancehrpayment->description }}</textarea>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea name="comments"  class="form-control" rows="2"  required>{{ $advancehrpayment->comments }}</textarea>     
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

                            
                            {{-- remove picture code --}}

                                @php
                        
                                    $files = json_decode($advancehrpayment->document_file)
                                   
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/advancehrpayment/'.$path) }}"/>

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
                                        <a class="pdf_file" href="{{ asset('/storage/advancehrpayment/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>
                            
                            {{-- remove picture code --}}


                     

                        
                        
                        
                
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
                   console.log(value);
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


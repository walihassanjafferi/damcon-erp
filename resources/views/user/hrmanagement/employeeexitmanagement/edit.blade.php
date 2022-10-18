@extends('layout.main')
@section('hr_employee-exits-sidebar') active @endsection
@section('title')
<title>Damcon ERP - Employee Exit Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employeeExitManagement.index')}} @endsection
@section('main_btn_text') All Employee Exit Management @endsection
{{-- back btn --}}
@section('css')
   
@endsection
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Employee Exit Management </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employeeExitManagement.update',encrypt($empExit->id))}}"  method="post" enctype="multipart/form-data">
                        @csrf @method('patch')
    
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control title" value="{{ $empExit->title }}" placeholder="Title" />
                                </div>
                            </div>



                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Employee CNIC</label>
                                    <select name="employee_cnic" class="form-control select2" id="employee_cnic">
                                        <option value="" selected>Select CNIC</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->cnic}}"  {{$empExit->employee_cnic == $emp->cnic ? 'selected' : '' }} data-cnicid = {{$emp->id}}>{{$emp->cnic}} </option>
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
                                                <option value="{{$emp->name}}" {{$empExit->emp_name == $emp->name ? 'selected' : '' }}>{{$emp->name}} </option>
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
                                            <option value="{{$emp->id}}" {{$empExit->employeemanagement_id  == $emp->id ? 'selected' : '' }}>{{$emp->employee_damcon_id}} </option>
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
                                    <input type="text" name="father_name" class="form-control father_name" value="{{ $empExit->father_name }}" placeholder="Father name" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of Joining</label>
                                    <input type="text" name="joining_date" class="form-control joining_date" value="{{ $empExit->joining_date }}" placeholder="Joining Date" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" name="designation" class="form-control designation" value="{{ $empExit->designation }}" placeholder="Designation" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region</label>
                                    <input type="text" name="region" class="form-control region" value="{{ $empExit->region }}" placeholder="Region" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control location" value="{{ $empExit->location }}" placeholder="Location" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Project Name</label>
                                    {!! Form::select('current_project',[''=>'Select Project']+$projects,
                                    $empExit->project_id, ['class' => 'form-control select2 current_project','required'=>'true']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Last Working day</label>
                                    <input type="text" name="last_working_date" class="form-control last_working_date" value="{{ $empExit->last_working_date }}" placeholder="Last working date" readonly/>
                                </div>
                            </div>



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Assigned Assets</label>
                                    <select name="assignedasests[]" class="assigned_assets form-control select2" multiple='multiple'>
                                        
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>HR Advance Payment</label>
                                  
                                    <select name="advancehr[]" class="advance_hr_payment form-control select2" multiple='multiple'>
                                        
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Project Advances</label>
                                    <select name="projectadvances[]" class="project_advances form-control select2" multiple='multiple'>
                                       
                                    </select>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="form-group">
                                    <label>Notice Period</label>
                                    <textarea name="notice_period"  class="form-control" rows="2"  required>{{ $empExit->notice_period }}</textarea>     
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>No of days Notice Period</label>
                                    <input type="number" name="notice_period_days" class="form-control notice_period_days" value="{{ $empExit->notice_period_days }}" placeholder="Notice Period Days" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Short Days</label>
                                    <input type="number" name="short_days" class="form-control short_days" value="{{ $empExit->short_days }}" placeholder="Short Days" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Settlement Month</label>
                                    <input type="month" name="settlement_month" class="form-control valid" value="{{ $empExit->settlement_month }}" placeholder="Settlement Month" >
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reason of Termination</label>
                                    <textarea name="reason_of_termination"  class="form-control" rows="2"  required>{{ $empExit->reason_of_termination }}</textarea>     
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Final Settlement Offer</label>
                                    <textarea name="final_settlement_offer"  class="form-control" rows="2"  required>{{ $empExit->final_settlement_offer }}</textarea>     
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Final Settlement Comments</label>
                                    <textarea name="final_settlement_comments"  class="form-control" rows="2"  required>{{ $empExit->final_settlement_comments }}</textarea>     
                                </div>
                            </div>
                          

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="c_p_m_c" class="custom-control-input" id="c_p_m_c">
                                        <label class="custom-control-label" for="c_p_m_c">Customer Project Manager Comments</label>
                                    </div>
                                    <textarea name="customer_project_manager_comments"  class="form-control customer_project_manager_comments" rows="2"  required>{{ $empExit->customer_project_manager_comments }}</textarea>     
                                </div>
                            </div>
                           

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="d_d_c" class="custom-control-input" id="d_d_c">
                                        <label class="custom-control-label" for="d_d_c">Damcon Director Comments</label>
                                    </div>
                                    <textarea name="damcon_direct_comments"  class="form-control damcon_direct_comments" rows="2"  required>{{ $empExit->damcon_director_comments }}</textarea>     
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="p_m_c" class="custom-control-input" id="p_m_c">
                                        <label class="custom-control-label" for="p_m_c">Procurement Manager Comments</label>
                                    </div>
                                    <textarea name="procurement_manager_comments"  class="form-control procurement_manager_comments" rows="2"  required>{{ $empExit->procurement_manager_comments }}</textarea>     
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="a_m_c" class="custom-control-input" id="a_m_c">
                                        <label class="custom-control-label" for="a_m_c">Assets Manager Comments</label>
                                    </div>
                                    <textarea name="assets_manager_comments"  class="form-control assets_manager_comments" rows="2"  required>{{ $empExit->assets_manager_comments }}</textarea>     
                                </div>
                            </div>


                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="f_m_c" class="custom-control-input" id="f_m_c">
                                        <label class="custom-control-label" for="f_m_c">Finanace Manager Comments</label>
                                    </div>
                                    <textarea name="finanace_manager_comments"  class="form-control finance_manager_comments" rows="2"  required>{{ $empExit->finanace_manager_comments }}</textarea>     
                                </div>
                            </div>


                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox " style="padding-bottom:10px;">
                                        <input type="checkbox" name="hr_m_c" class="custom-control-input" id="hr_m_c">
                                        <label class="custom-control-label" for="hr_m_c">HR Manager Comments</label>
                                    </div>
                                    <textarea name="hr_manager_comments"  class="form-control hr_manager_comments" rows="2"  required>{{ $empExit->hr_manager_comments }}</textarea>     
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


                                {{-- remove picture code --}}

                                    @php
                                        
                                        $files = json_decode($empExit->document_file)
                                    
                                    @endphp
                                    @if(isset($files) && count($files))
                                        <div class="col-12"></div>
                                        @php $pdf = array(); @endphp
                                        @foreach ($files as $path)
                                            @if(!preg_match("/\.(pdf)$/", $path))
                                                <span class="pip col-3">
                                            <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                            <img class="images_upload" type="file" src="{{ asset('/storage/employeeExit/'.$path) }}"/>

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
                                            <a class="pdf_file" href="{{ asset('/storage/employeeExit/PDF/'.$item) }}" target="_blank">{{$item}}</a>
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

        //  hide fields
        var cpmc = {!! $empExit->customer_project_manager_status !!};
        var dds = {!! $empExit->damcon_director_status !!};
        var pms = {!! $empExit->procurement_manager_status !!};
        var ams =  {!! $empExit->assets_manager_status !!};
        var fms = {!! $empExit->finance_manager_status !!};
        var hms = {!! $empExit->hr_manager_status !!}
        var advanceHr =  {!!  $empExit->advancehr !!}
        var hradvances_obj = {!!  $hradvances_obj !!}
        $.each( hradvances_obj, function( key, value1 ) {

                var advances = value1;
              
                if(!advanceHr.includes(advances.id))
                {
                    $('.advance_hr_payment').append(
                    '<option value='+advances.id+' >'+advances.payment_id+' ('+advances.advance_type+') x'+'</option>'
                    ); 
                }
                else{
                    console.log('else mein ');
                    $('.advance_hr_payment').append(
                    '<option value='+advances.id+' selected>'+advances.payment_id+' ('+advances.advance_type+') x'+'</option>'
                    ); 
                }
               
            
        });
        // if(advanceHr != null )
        // {
        //     console.log(advanceHr);
        //     $('.advance_hr_payment').val([advanceHr]).change();
        // }
       
        if(!cpmc)
        {
            $('.customer_project_manager_comments').hide();
        }
        else{
            $('#c_p_m_c').prop('checked', true);
        }
        if(!dds)
        {
            $('.damcon_direct_comments').hide();
        }
        else{
         
            $('#d_d_c').prop('checked', true);

        }
        if(!pms)
        {
            $('.procurement_manager_comments').hide();
        }
        else{
            $('#p_m_c').prop('checked', true);

        }
        if(!ams)
        {
            $('.assets_manager_comments').hide();

        }
        else{
            
            $('#a_m_c').prop('checked', true);

        }

        if(!fms)
        {
            $('.finance_manager_comments').hide();

        }
        else{
            $('#f_m_c').prop('checked', true);

        }
        if(!hms)
        {   
            $('.hr_manager_comments').hide();
        }
        else{
            $('#hr_m_c').prop('checked', true);

        }

        var data = {!! json_encode($employees) !!};
      

        $('#employee_cnic').change(function(){

            $('.advance_hr_payment').val('');
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
                    $('.current_project').val(value.project.id).change();
                  
                   
                    
                    // advanced hr payment
                    if(value.advance_h_rpayments!=null)
                    {
                        var advancehrpayments = value.advance_h_rpayments;
                        //console.log(advancehrpayments);

                        $.each( advancehrpayments, function( key, value1 ) {
                          
                           if(value1.employeemanagement_id === id)
                           {
                                var advances = value1;
                                $('.advance_hr_payment').append(
                                    '<option value='+advances.id+' selected>'+advances.payment_id+' ('+advances.advance_type+') x'+'</option>'
                                ); 
                                
                           }
                        });
                    

                    }
                   
                
               }
            });
            

        });





        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
       
        $('.joining_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });

        $('.last_working_date').datepicker({
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

        var remove_images = [];
        $(".remove").click(function(){
            event.preventDefault();
            let img_val =  $(this).attr('href');
            remove_images.push(img_val);
            $('#remove_images').val(remove_images);
            $(this).parent(".pip").remove();
        });
      

        // damcon director

        $('#d_d_c').change(function() {
         
            if($(this).is(":checked")) {
                console.log('Hello abc');
                $('.damcon_direct_comments').slideDown();
            }
            else{
                $('.damcon_direct_comments').slideUp();
            }
        
        });

        // customer project manager

        $('#c_p_m_c').change(function() {
         
            if($(this).is(":checked")) {
               
                $('.customer_project_manager_comments').slideDown()
            }
            else{
                $('.customer_project_manager_comments').slideUp();
            }
           
        });

        $('#p_m_c').change(function() {
         
            if($(this).is(":checked")) {
                
                $('.procurement_manager_comments').slideDown();
            }
            else{
                $('.procurement_manager_comments').slideUp();
            }
         
        }); 


        $('#a_m_c').change(function() {
         
         if($(this).is(":checked")) {
            
             $('.assets_manager_comments').slideDown();
            }
            else{
                $('.assets_manager_comments').slideUp();
            }  
        });

        $('#f_m_c').change(function() {
         
         if($(this).is(":checked")) {
            
             $('.finance_manager_comments').slideDown();
            }
            else{
                $('.finance_manager_comments').slideUp();
            }  
        });


        $('#hr_m_c').change(function() {
         
         if($(this).is(":checked")) {
            
             $('.hr_manager_comments').slideDown();
            }
            else{
                $('.hr_manager_comments').slideUp();
            }  
        });

        




        

  

    });
</script>
@endsection


@extends('layout.main')
@section('hr_emptrafficchalan-sidebar') active @endsection
@section('title')
<title>Damcon ERP - Add Employee Challan</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employeechallan.index')}} @endsection
@section('main_btn_text') All Employee Challan< @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Inter Project Transfers</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employeechallan.store')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group " multiple='multiple'>
                                    <label>Select Employee</label>
                                    <select name="employee_id" class="form-control select2">
                                        <option value="" selected>Select Employee</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{$emp->id}}"  {{old('employee_id') == $emp->id ? 'selected' : '' }} >{{$emp->cnic}} ({{$emp->name}})</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Challan Date</label>
                                      <input type="text" class="form-control challan_date" name="challan_date" />  
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Challan Amount</label>
                                      <input type="text" class="form-control amount_format" name="challan_amount" />  
                                </div>
                            </div>

                               
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Challan ID</label>
                                      <input type="text" class="form-control" name="challan_id" />  
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Challan Paid Date</label>
                                      <input type="text" class="form-control challan_paid_date" name="challan_paid_date" />  
                                </div>
                            </div>


                            

                            
                            <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                <small>**multiple items can be selected</small><br />
                                <label for="formFileMultiple" class="form-label">File Attachments</label>
                                <input class="form-control" type="file" name="document_file[]" id="file-input"
                                    multiple>
                                <small>files supported jpg | jpeg | png | pdf</small><br />
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
<script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script>

<script>
   
    $(function(){

      
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        
        $('.challan_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
        
        $('.challan_paid_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        });
      


    });
</script>
@endsection


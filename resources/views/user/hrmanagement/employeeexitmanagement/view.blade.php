@extends('layout.main')
@section('hr_employee-exits-sidebar') active @endsection
@section('title')
<title>Damcon ERP - Employee Exit Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employeeExitManagement.index')}} @endsection
@section('main_btn_text') All Employee Exit Management @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <h6 class="mt-1 ml-1">Employee Details</h6>   
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                          
                            </div>
                            <div class="customer_details">
                                <label>Employee Cnic</label>
                                <span>{{$employee->cnic}}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Employee Name</label>
                                <span>{{ $employee->name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Father Name</label>
                                <span>{{ $employee->father_name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Joining Date</label>
                                <span>{{ $employee->joining_date }}</span>
                            </div>  
                            

                            <div class="customer_details">
                                <label>Project</label>
                                <span>{{ $empExit->project->name }}</span>
                            </div>

                            <div class="customer_details">
                                <label>Region</label>
                                <span>{{ ucfirst($employee->region) }}</span>
                            </div>  


                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Employee Exit Details</h6>   
                    <div class="card-body project_item_card">
                        <div class="customer_details">
                            <label>Last Working Date</label>
                            <span>{{ date('d-m-Y',strtotime($empExit->last_working_date)); }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Notice Period Days</label>
                            <span>{{$empExit->notice_period_days}}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Short Days</label>
                            <span>{{ $empExit->short_days }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Settlement Month</label>
                            <span>{{ $empExit->settlement_month }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Joining Date</label>
                            <span>{{ $employee->joining_date }}</span>
                        </div>  

                      

                    
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                      
                            <label><b>HR Advances</b></label>
                            @foreach ($hradvances as $item)
                                
                            @endforeach
                     
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <div class="col-12">
                            <label><b>Notice Period</b></label>
                            <p class="more">{{ $empExit->notice_period}}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Reason of Termination</b></label>
                            <p class="more">{{ $empExit->reason_of_termination}}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Final Settlement Offer</b></label>
                            <p class="more">{{ $empExit->final_settlement_offer}}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Final Settlement Comments</b></label>
                            <p class="more">{{ $empExit->final_settlement_comments}}</p>
                        </div>


                        <div class="col-12">
                            <label><b>Customer Project Manager Comments</b></label>
                            <p class="more">{{ $empExit->customer_project_manager_comments}}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Damcon Director Comments</b></label>
                            <p class="more">{{ $empExit->damcon_director_comments}}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Procurement Manager Comments</b></label>
                            <p class="more">{{ $empExit->procurement_manager_comments}}</p>
                        </div>


                        <div class="col-12">
                            <label><b>Assets Manager Comments</b></label>
                            <p class="more">{{ $empExit->assets_manager_comments}}</p>
                        </div>

                        
                        <div class="col-12">
                            <label><b>Finance Manager Comments</b></label>
                            <p class="more">{{ $empExit->finanace_manager_comments}}</p>
                        </div>


                        <div class="col-12">
                            <label><b>HR Manager Comments</b></label>
                            <p class="more">{{ $empExit->hr_manager_comments}}</p>
                        </div>

                        @php
                            $files = json_decode($empExit->document_file)
                         @endphp

                        <div class="col-12">
                            <label style="padding-bottom: 6px;"><b>File Attachments</b></label>
                            @if(isset($files) && count($files))
                            <div class="col-12"></div>
                            @php $pdf = array(); @endphp
                            @foreach ($files as $path)
                                @if(!preg_match("/\.(pdf)$/", $path))
                                    <span class="pip col-3">
                                <a  download="download" href={{ asset('/storage/employeeExit/'.$path) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
        
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
                                    <a  download="download" href={{ asset('/storage/employeeExit/PDF/'.$item) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                                    <a class="pdf_file" href="{{ asset('/storage/employeeExit/PDF/'.$item) }}" target="_blank">{{$item}}</a>
                                </span>
                                @endforeach
                            @endif
                           
                        </div>

                       
                       




                        



                        
                    </div>
                </div>
            </div>
          


           
    
            
            
    </div>

    


@endsection

@section('scripts')
    <script>
      

        $(document).ready(function() {
            var showChar = 100;
            var ellipsestext = "...";
            var moretext = "more";
            var lesstext = "less";
            $('.more').each(function() {
                var content = $(this).html();

                if(content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar-1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        }); 

        


    </script>
@endsection
@extends('layout.main')
@section('hr_employee_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Employess</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('employees') }} @endsection
@section('main_btn_text') All Employees @endsection

@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-8"> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_status">
                            <h4>Employee Details</h4>
                        </div>
                        <br />
                        <div class="customer_details">
                            <label>Name</label>
                            <span>{{ $employee->name }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Father Name</label>
                            <span>{{ $employee->father_name }} </span>
                        </div>
                        <div class="customer_details">
                            <label>CNIC</label>
                            <span>{{ $employee->cnic }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Employee Damcon ID</label>
                            <span>{{ $employee->employee_damcon_id }} </span>
                        </div>

                        <div class="customer_details">
                            <label>EOBI number</label>
                            <span>{{ $employee->eobi_number }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Email address 1</label>
                            <span>{{ $employee->email_address_1 }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Email address 2</label>
                            <span>{{ $employee->email_address_2 }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Gender</label>
                            <span>{{ ucfirst($employee->gender) }} </span>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        {{-- <div class="customer_status">
                            <h4>Employee Details</h4>   
                            </div> --}}
                        <br />
                        <div class="customer_details">
                            <label>Project</label>
                            <span>{{ $employee->project->name }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Joining Date</label>
                            <span>{{ date('d-m-Y', strtotime($employee->joining_date)) }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Designation</label>
                            <span>{{ $employee->designation }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Date of Birth</label>
                            <span>{{ date('d-m-Y', strtotime($employee->date_of_birth)) }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Contact no 1</label>
                            <span>{{ $employee->contact_no_1 }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Contact no 2</label>
                            <span>{{ $employee->contact_no_2 }} </span>
                        </div>


                        <div class="customer_details">
                            <label>Marital Status</label>
                            <span>{{ ucfirst($employee->marital_status) }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Religion</label>
                            <span>{{ ucfirst($employee->religion) }} </span>
                        </div>


                        <div class="customer_details">
                            <label>Region</label>
                            <span>{{ ucfirst($employee->region) }} </span>
                        </div>


                        

                        



                        {{-- <div class="customer_details">
                                <label>Current Address</label>
                                <span class="more">{{ $employee->current_address }} </span>
                            </div>  

                            <div class="customer_details">
                                <label>Permanent Address</label>
                                <span class="more">{{ $employee->permanent_address }} </span>
                            </div> --}}



                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Current Address</label>
                            <span>{{ $employee->current_address }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Permanent Addresss</label>
                            <span>{{ $employee->permanent_address }} </span>
                        </div>

                         <div class="customer_details">
                            <label>Line Manager</label>
                            <span>({{$employee->lineManager->employee_damcon_id ?? 'Not Found!'}}) {{ $employee->lineManager->name ?? 'Not Found!' }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Subordinates</label>
                            @foreach ( $employee->subOrdinates as $index=>$item)
                                @if ($index > 0) <span style="margin-right: 3px;">,</span> @endif

                            <span style="margin-right:3px;" >({{ $item->employee_damcon_id }}) {{$item->name}}</span>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="col-12 mb-1">
                {{-- <div class="card mb-1">
                    <div class="card-body"> --}}
                        <div class="d-flex flex-wrap">
                            <div class="col-4">
                               <div class="employee_tiles">
                                <a href="{{ route('leave-management.show',encrypt($employee->id)) }}" target="_blank">Leave Balance</a>
                               </div>
                            </div>
                            <div class="col-4">
                                <div class="employee_tiles">
                                    <a href="{{ route('salaryTransactions',encrypt($employee->id)) }}" target="_blank">Salary Transactions</a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="employee_tiles">
                                    <a href="{{ route('increment-management.show',encrypt($employee->id)) }}" target="_blank">Increment Salaries</a>
                                </div>
                            </div>
                            {{-- ***** --}}
                            <div class="col-4">
                                <div class="employee_tiles">
                                    <a href="" target="_blank">Terminate</a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="employee_tiles">
                                    <a href="{{ route('interproject-management.show',encrypt($employee->id)) }}" target="_blank">Transfers</a>
                                </div>
                            </div>
                            @if($employee->employeeChallans()->exists())
                                <div class="col-4">
                                    <div class="employee_tiles">
                                        <a href="{{ route('employeechallan.index',['emp_id'=>encrypt($employee->id)]) }}" target="_blank">Traffic Challans</a>
                                    </div>
                                </div>
                            @endif
                        
                
                        </div>
                    {{-- </div>
                </div> --}}
            </div>



            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                      
                        @php
                            $files = json_decode($employee->document_file);
                        @endphp

                        <div class="col-12">
                            <label style="padding-bottom: 6px;"><b>File Attachments</b></label>
                            @if (isset($files) && count($files))
                                <div class="col-12"></div>
                                @php $pdf = array(); @endphp
                                @foreach ($files as $path)
                                    @if (!preg_match("/\.(pdf)$/", $path))
                                        <span class="pip col-3">
                                            <a download="download" href={{ asset('/storage/damcon_employee/' . $path) }}
                                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <img class="images_upload" type="file"
                                                src="{{ asset('/storage/damcon_employee/' . $path) }}" />

                                        </span>
                                    @else
                                        @php array_push($pdf,$path) @endphp
                                    @endif
                                @endforeach

                                @if (isset($pdf))
                                    <div class="col-12 mt-3"></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-3 pip">
                                            <a download="download" href={{ asset('/storage/damcon_employee/PDF/' . $item) }}
                                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <a class="pdf_file"
                                                href="{{ asset('/storage/SecurityBond/PDF/' . $item) }}"
                                                target="_blank">{{ $item }}</a>
                                        </span>
                                    @endforeach
                                @endif
                            @else
                                <p>No Attachment's Found!</p>
                            @endif


                        </div>

                    </div>
                </div>
            </div>






            {{-- </div> --}}
            {{-- <div class="col-3">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details_no project_cards_height">
                            <h5>Balance PO</h5>
                            <h2>Rs. 500</h2>
                            <br/>
                            <h5>Invoices</h5>
                            <h2>Rs. 1000</h2>
                            
                        </div>  
                    </div>
                </div>
            </div>
           
            <div class="col-3">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details_no project_cards_height">
                            <h5>Start Date</h5>
                            <h3>{{ date('d-m-Y',strtotime($project->project_start_date)) }}</h3>
                            <br/>
                            <h5>End Date</h5>
                            <h3>{{ date('d-m-Y',strtotime($project->project_end_date));  }}</h3>
                            
                        </div>  
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                     
                        <div class="customer_details">
                            <label>Customer Project manager</label>
                            <span>{{ $project->customer_project_manager_contact_no}} </span>
                        </div> 
                        <div class="customer_details">
                            <label>Customer PM contact</label>
                            <span>{{ $project->customer_project_manager_name}} </span>
                        </div> 
                        
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Damcon Project Manager</label>
                            <span>{{ $project->damcon_project_manager_name}} </span>
                        </div>
                        <div class="customer_details">
                            <label>Damcco PM Contact</label>
                            <span>{{ $project->damcon_project_manager_contact_no}} </span>
                        </div>
                        
                    </div>
                </div>
            </div> --}}


            {{-- <div class="col-12 mb-3 mt-2" style="display:flex;flex-wrap:wrap;">
                
                    <a href="#" class="col-2 mb-1 project_tiles">Project Assets (10) </a>
              
                    <a href="#" class="col-2 mb-1 project_tiles">Project Income  (20)</a>
               
                    <a href="#" class="col-2 mb-1 project_tiles">Project Payments  (5)</a>
                
                    <a href="#" class="col-2 mb-1 project_tiles">Project Issued Items Expense  (3)</a>
               
                    <a href="#" class="col-2 mb-1 project_tiles">Project HR Expense  (10)</a>
               
          
               
                    <a href="#" class="col-2 mb-1 project_tiles">Project Fuel Expense  (10)</a>
              
                    <a href="#" class="col-2 mb-1 project_tiles">Project Rental Expense  (100)</a>
             
                    <a href="#" class="col-2 mb-1 project_tiles">Asset Maintenance Expense (20)</a>
              
                    <a href="#" class="col-2 mb-1 project_tiles">Project Advances (30)</a>
               
                    <a href="#" class="col-2 mb-1 project_tiles">ROI Expense (40)</a>
                
            </div> --}}




            {{-- <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-body customer_cards">
                            <div class="card-text">
                                <h4>Recent Invoices</h4><br/>
                                <div class="customer_projects">
                                        <label class="label_heading">Project name</label>
                                     
                                        <label class="label_value">Project mirag</label>
                                            <br/>
                                        <label class="label_heading">Project Code</label>
                                     
                                        <label class="label_value">12345</label>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-body customer_cards">
                            <div class="card-text">
                                <h4>Recent Payments</h4><br/>
                                <div class="customer_projects">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                  </div> --}}


            {{-- <div class="col-12">
                    <a class="btn btn-danger mb-1" onclick="deleteProject({{$project->id}})"
                         style="float:right;margin-left:10px;">Delete</i>
                    </a>
                    <a class="btn btn-primary mb-1" href="{{route('projectmanagement.edit',encrypt($project->id))}}" style="float:right;">Edit</a>
                </div> --}}

        </div>

        {{-- toast --}}

        <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="5000" style="top: 1rem; right: 1rem">
            <div class="toast-header">
                <img src="{{ asset('app-assets/images/ico/favicon.png') }}" class="mr-1" alt="Toast image"
                    height="22" width="24" />
                <strong class="mr-auto">Damcon ERP</strong>
                <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
        <button class="btn btn-outline-primary toast-basic-toggler mt-2" id="status_toast" hidden>Toast</button>


    @endsection

    @section('scripts')
        <script>
            function deleteProject(id) {
                var id = id;
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this project",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {

                        if (willDelete) {
                            $.ajax({
                                url: '{{ route('projectmanagement.destroy', 'id') }}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": id

                                },
                                method: 'DELETE',
                                success: function(data) {

                                    swal(data.message, {
                                        icon: "success",
                                    });

                                    let url = "{{ route('projectmanagement.index') }}";

                                    document.location.href = url;


                                },
                                error: function(data) {
                                    alert('Error Failed');

                                }
                            });
                        }
                    });

            }


            function statusChange($id) {

                $.ajax({
                    url: '{{ route('project_status_change') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": $id
                    },
                    method: 'post',
                    success: function(data) {

                        $('.toast-body').html(data.message);
                        $('#status_toast').click();

                    },
                    error: function(data) {
                        $('.toast-body').html(data.message);
                        $('#status_toast').click();

                    }
                });

            }

            $(document).ready(function() {
                var showChar = 80;
                var ellipsestext = "...";
                var moretext = "more";
                var lesstext = "less";
                $('.more').each(function() {
                    var content = $(this).html();

                    if (content.length > showChar) {

                        var c = content.substr(0, showChar);
                        var h = content.substr(showChar - 1, content.length - showChar);

                        var html = c + '<span class="moreellipses">' + ellipsestext +
                            '&nbsp;</span><span class="morecontent"><span>' + h +
                            '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                        $(this).html(html);
                    }

                });

                $(".morelink").click(function() {
                    if ($(this).hasClass("less")) {
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

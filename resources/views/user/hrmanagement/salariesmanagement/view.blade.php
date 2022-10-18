@extends('layout.main')
@section('hr_salary_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Salary</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('salary_management.index') }} @endsection
@section('main_btn_text') All Salaries @endsection
{{-- back btn --}}
@section('content')

    `

    <div class="col-12">

        <div class="d-flex justify-content-between mb-1">

            <div class="col-4">
                <h5 class="mb-1">Import Template</h5>
                <a class="btn btn-secondary" href="{{ asset('/storage/sheet_imports/salary_sheet/damcon_salary_sheet_import.xlsx') }}" download>Download &nbsp; <i class="fa fa-download"></i></a>
            </div>

            <div class="col-4">
                <form method="post" action='{{ route('importSalaries') }}' enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h5>Import Employees Salaries</h5>
                        <input type="file" class="form-control" name="import_file" required />
                    </div>
                    <input type="submit" class="btn btn-secondary" value="submit" />

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="padding-bottom: 5px;">
                {{-- <div style="display: inline-flex;">
                    <h2>{{$salary_record->employee}}</h2></div>   
            </div> --}}
                <div class="col-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="bank_details col-6">
                                    <label>Payment ID</label>
                                    <span><b>{{ $salary_record->payment_id }}</b></span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>Salary Month</label>
                                    <span>{{ date('M-Y', strtotime($salary_record->salary_month)) }}</span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>No of Days</label>
                                    <span>{{ $salary_record->no_of_days }}</span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>Payment Method</label>
                                    <span>{{ ucfirst($salary_record->payment_method) }}</span>
                                </div>
                                @if($salary_record->bank)
                                <div class="bank_details col-6">
                                    <label>Debited Bank </label>
                                    <span>{{ $salary_record->bank->name }} ({{ $salary_record->bank->title }})</span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>Cheque Number</label>
                                    <span>{{ $salary_record->cheque_number }}</span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>Cheque Title</label>
                                    <span>{{ $salary_record->cheque_title }}</span>
                                </div>
                                @endif
                                <div class="bank_details col-6">
                                    <label>Date</label>
                                    <span>{{ date('d-M-y', strtotime($salary_record->date)) }}</span>
                                </div>
                                <div class="bank_details col-6">
                                    <label>Amount</label>
                                    <span> PKR {{ number_format($salary_record->amount, 2) }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="col-12">
                                <label><b>Payment Details</b></label>
                                <p class="more">{{ $salary_record->payment_details }}</p>
                            </div>
                            <div class="col-12">
                                <label><b>Comments</b></label>
                                <p class="more">{{ $salary_record->comments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($import_salaries))
                @php $i = 0; @endphp
                <div class="col-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <h4 class="card-title">Employee Salaries</h4>
                            <p class="card-text">
                                <table class="table table-striped table-bordered import_salaries_table table-responsive"
                                    style="width:100%" id="import_salaries_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Payment ID</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Joining Date</th>
                                            <th>Cnic</th>
                                            <th>Salary Account Type</th>
                                            <th>Salary Receiving Emp Name</th>
                                            <th>Salary Receiving Emp Bank</th>
                                            <th>Self Bank Acc Details</th>
                                            <th>Employee Email</th>
                                            <th>Designation</th>
                                            <th>Project</th>
                                            <th>Region</th>
                                            <th>Location</th>
                                            <th>Income Tax</th>
                                            <th>Final Adjustments</th>
                                            <th>Final Comments</th>
                                            <th>Basic Salary</th>
                                            <th>Medical Allowance</th>
                                            <th>Mobile Allowance</th>
                                            <th>Laptop Bonus</th>
                                            <th>Conveyance Allowance</th>
                                            <th>Other Allowance</th>
                                            <th>Over Time</th>
                                            <th>Overtime Comments</th>
                                            <th>Kpi Other Bonus</th>
                                            <th>Kpi Other Bonus Comments</th>
                                            <th>EDA Allowance</th>
                                            <th>EDA Allowance Comments</th>
                                            <th>Tada Allowance</th>
                                            <th>Tada Allowance Comments</th>
                                            <th>Advanced Salary</th>
                                            <th>Advanced Salary Comments</th>
                                            <th>Final Settlement Termination</th>
                                            <th>Final Settlement Termination Comm..</th>
                                            <th>Miscellaneous Payment</th>
                                            <th>Miscellaneous Payment Comments</th>
                                            <th>Gross Payment</th>
                                            <th>Life Insurance deduction</th>
                                            <th>Eobi Education</th>
                                            <th>Absent Deduction</th>
                                            <th>Absent Deduction Comments</th>
                                            <th>Advanced Salary deduction</th>
                                            <th>KPI deduction</th>
                                            <th>Late Coming deduction</th>
                                            <th>Miscellaneous deduction</th>
                                            <th>Total Deduction</th>

                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($import_salaries as $salaries)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>{{$salaries->payment_id}}</td>
                                                <td>{{$salaries->employee_code}}</td>
                                                <td>{{$salaries->name}}</td>
                                                <td>{{ date('d-m-y',strtotime($salaries->joining_date)) }}</td>
                                                <td>{{$salaries->cnic}}</td>
                                                <td>{{$salaries->salary_account_type}}</td>
                                                <td>{{$salaries->salaray_receiving_emp_name}}</td>
                                                <td>{{$salaries->salaray_receiving_emp_bank_id}}</td>
                                                <td>{{$salaries->self_bank_account_details}}</td>
                                                <td>{{$salaries->emp_email}}</td>
                                                <td>{{$salaries->desgination}}</td>
                                                <td>{{$salaries->project}}</td>
                                                <td>{{$salaries->region}}</td>
                                                <td>{{$salaries->location}}</td>
                                                <td>{{$salaries->income_tax}}</td>
                                                <td>{{$salaries->final_adjustments}}</td>
                                                <td>{{$salaries->final_comments}}</td>
                                                <td>{{$salaries->basic_salary}}</td>
                                                <td>{{$salaries->medical_allowance}}</td>
                                                <td>{{$salaries->mobile_allowance}}</td>
                                                <td>{{$salaries->laptop_bonus}}</td>
                                                <td>{{$salaries->conveyance_Allowance}}</td>
                                                <td>{{$salaries->other_allowance}}</td>
                                                <td>{{$salaries->over_time}}</td>
                                                <td>{{$salaries->over_time_comments}}</td>
                                                <td>{{$salaries->kpi_other_bonus}}</td>
                                                <td>{{$salaries->kpi_other_bonus_comments}}</td>
                                                <td>{{$salaries->eda_allowance}}</td>
                                                <td>{{$salaries->eda_allowance_comments}}</td>
                                                <td>{{$salaries->tada_allowance}}</td>
                                                <td>{{$salaries->tada_allowance_comments}}</td>
                                                <td>{{$salaries->advanced_salary}}</td>
                                                <td>{{$salaries->advanced_salary_comments}}</td>
                                                <td>{{$salaries->final_settlement_termination}}</td>
                                                <td>{{$salaries->final_settlement_termination_comments}}</td>
                                                <td>{{$salaries->miscellaneous_payment}}</td>
                                                <td>{{$salaries->miscellaneous_payment_comments}}</td>
                                                <td>{{$salaries->gross_payment}}</td>
                                                <td>{{$salaries->health_life_insurance_deduction}}</td>
                                                <td>{{$salaries->eobi_deduction}}</td>
                                                <td>{{$salaries->absent_deduction}}</td>
                                                <td>{{$salaries->absent_deduction_comments}}</td>
                                                <td>{{$salaries->advanced_salary_deduction}}</td>
                                                <td>{{$salaries->kpi_deduction}}</td>
                                                <td>{{$salaries->late_coming_deduction}}</td>
                                                <td>{{$salaries->miscellaneous_deduction}}</td>
                                                <td>{{$salaries->total_deduction}}</td>
                                            </tr>        
                                        @endforeach

                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                @else
                    <p class="pl-1"><b>Salaries not imported yet!</b></p>
                @endif



                <div class="col-12">
                    {{-- <a class="btn btn-danger mb-1" onclick="deleteProject({{$bankaccount->id}})"
                        style="float:right;margin-left:10px;">Delete</i>
                </a> --}}
                    <a class="btn btn-primary mb-1"
                        href="{{ route('salary_management.edit', encrypt($salary_record->id)) }}"
                        style="float:right;">Edit</a>
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                var showChar = 300;
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


            //Salaries Import table
            
            var table = $('.import_salaries_table').DataTable({
                "drawCallback": function( settings ) {
                    //Load Icons
                    feather.replace();
                    //Load CheckBoxs
                    $('.item_check').on('change', function(e) {
                        if($(this).is(':checked'))
                        {
                            $(this).prop('checked', true);
                            $(this).parent().parent().addClass('deleted');

                        } else {
                            $(this).prop('checked',false);
                            $(this).parent().parent().removeClass('deleted');
                        }
                    });
                },
                dom: 'Bfrtip',
                buttons: [
                    // {
                    //     extend: 'excelHtml5',
                    //     title: "Employee's Data",
                    //     className: 'btn btn-primary',
                    //     exportOptions: {
                    //         columns: [  1, 2, 3, 4,5,6]
                    //     },
                    //     filename:"Employee's Data",
                    // },
                    // {
                    //     extend: 'pdfHtml5',
                    //     title: 'Rental Items',
                    //     className: 'btn btn-danger',
                    //     exportOptions: {
                    //         columns: [  1, 2, 3, 4,5,6]
                    //     },
                    //     filename:"Employee's Data",
                    // }
                  
                ],
                // processing: true,
                // serverSide: true,
                // ajax: "{{ route('ajaxSalariesImport',$salary_record->payment_id) }}",
                // columns: [
                //     {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                //     {data: 'payment_id', name: 'payment_id'},
                //     {data: 'employee_code', name: 'employee_code'},
                //     {data: 'name', name: 'name'},
                //     {data: 'joining_date', name: 'joining_date'},
                //     {data: 'cnic', name: 'cnic'},
                //     {data: 'salary_account_type', name: 'salary_account_type'},
                //     {data: 'salaray_receiving_emp_name', name: 'salaray_receiving_emp_name'},
                //     {data: 'salaray_receiving_emp_bank_id', name: 'salaray_receiving_emp_bank_id'},
                //     {data: 'self_bank_account_details', name: 'self_bank_account_details'},
                //     {data: 'emp_email', name: 'emp_email'},
                //     {data: 'desgination', name: 'desgination'},
                //     {data: 'project', name: 'project'},
                //     {data: 'region', name: 'region'},
                //     {data: 'location', name: 'location'},
                //     {data: 'income_tax', name: 'income_tax'},
                //     {data: 'final_adjustments', name: 'final_adjustments'},
                //     {data: 'final_comments', name: 'final_comments'},
                //     {data: 'basic_salary', name: 'basic_salary'},
                //     {data: 'medical_allowance', name: 'medical_allowance'},
                //     {data: 'mobile_allowance', name: 'mobile_allowance'},
                //     {data: 'laptop_bonus', name: 'laptop_bonus'},
                //     {data: 'conveyance_Allowance', name: 'conveyance_Allowance'},
                //     {data: 'other_allowance', name: 'other_allowance'},
                //     {data: 'over_time', name: 'over_time'},
                //     {data: 'over_time_comments', name: 'over_time_comments'},
                //     {data: 'kpi_other_bonus', name: 'kpi_other_bonus'},
                //     {data: 'kpi_other_bonus_comments', name: 'kpi_other_bonus_comments'},
                //     {data: 'eda_allowance', name: 'eda_allowance'},
                //     {data: 'eda_allowance_comments', name: 'eda_allowance_comments'},
                //     {data: 'tada_allowance', name: 'tada_allowance'},
                //     {data: 'tada_allowance_comments', name: 'tada_allowance_comments'},
                //     {data: 'advanced_salary', name: 'advanced_salary'},
                //     {data: 'advanced_salary_comments', name: 'advanced_salary_comments'},
                //     {data: 'final_settlement_termination', name: 'final_settlement_termination'},
                //     {data: 'final_settlement_termination_comments', name: 'final_settlement_termination_comments'},
                //     {data: 'miscellaneous_payment', name: 'miscellaneous_payment'},
                //     {data: 'miscellaneous_payment_comments', name: 'miscellaneous_payment_comments'},
                //     {data: 'gross_payment', name: 'gross_payment'},
                //     {data: 'health_life_insurance_deduction', name: 'health_life_insurance_deduction'},
                //     {data: 'eobi_deduction', name: 'eobi_deduction'},
                //     {data: 'absent_deduction', name: 'absent_deduction'},
                //     {data: 'absent_deduction_comments', name: 'absent_deduction_comments'},
                //     {data: 'advanced_salary_deduction', name: 'advanced_salary_deduction'},
                //     {data: 'kpi_deduction', name: 'kpi_deduction'},
                //     {data: 'late_coming_deduction', name: 'late_coming_deduction'},
                //     {data: 'miscellaneous_deduction', name: 'miscellaneous_deduction'},
                //     {data: 'total_deduction', name: 'total_deduction'},
                
                //     {
                //         data: 'action',
                //         name: 'action',
                //         orderable: true,
                //         searchable: false
                //     },
                // ],
            }); 


            });
        </script>
    @endsection

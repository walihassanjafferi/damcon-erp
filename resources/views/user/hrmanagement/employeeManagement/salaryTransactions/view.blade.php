@extends('layout.main')
@section('hr_employee_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Salary Transactions</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employees')}} @endsection
@section('main_btn_text') All Employees @endsection
{{-- back btn --}}
@section('css')
    <style>
    .project_item_card{
        min-height:320px;
    }
    </style>
@endsection
@section('content')
    
    <div class="col-12">
        <div class="customer_details">
            <label>Employee Name</label>
            {{ $employee->name }}
        </div>  
        <div class="customer_details">
            <label>CNIC</label>
            {{ $employee->cnic }}
        </div>

        <br/>  
        <div class="row">
            @php $i = 0; @endphp
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <h4 class="card-title">Employee Salary Transactions</h4>
                        <p class="card-text">
                            <table class="table table-striped table-bordered import_salaries_table table-responsive"
                                style="width:100%" id="import_salaries_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Salary Month</th>
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
                                    @foreach ($salarires as $salaries)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{ date('d-M',strtotime($salaries->salary_month)) }}</td>
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

            var table = $('.leave_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Leaves Data",
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5]
                        },
                        filename:"Leaves Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Leaves Data',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5]
                        },
                        filename:"Leaves Data",
                    }
                ],
            });
        });



    </script>
@endsection
@extends('layout.main')
@section('hr_increment_sidebar')
    active
@endsection
@section('title')
    <title>Damcon ERP - View Increment Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href')
    {{ route('increment-management.index') }}
@endsection
@section('main_btn_text')
    All Increments Management
@endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-8"> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Increment Details</h6>
                    <div class="card-body project_item_card">
                        <div class="customer_status">

                        </div>
                        <div class="customer_details">
                            <label>Employee Cnic</label>
                            <span>{{ $employee->cnic }}</span>
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

                    </div>
                </div>
            </div>
            {{-- </div> --}}
            @if(isset($currentSalary))
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                                <h6>Current Salary (PKR)</h6>
                            </div>
                            <div class="customer_details">
                                <label>Basic Salary</label>
                                <span>{{ number_format($currentSalary->basic_salary) ?? '' }}</span>
                            </div>
                            <div class="customer_details">
                                <label>Medical Allowance</label>
                                <span>{{ number_format($currentSalary->medical_allowance) ?? '' }}</span>
                            </div>
                            <div class="customer_details">
                                <label>Mobile Allowance</label>
                                <span>{{ number_format($currentSalary->mobile_allowance) ?? '' }}</span>
                            </div>
                            <div class="customer_details">
                                <label>Laptop Bonus</label>
                                <span>{{ number_format($currentSalary->laptop_bonus) ?? '' }}</span>
                            </div>
                            <div class="customer_details">
                                <label>Conveyance Allowance</label>
                                <span>{{ number_format($currentSalary->conveyance_allowance) ?? '' }}</span>
                            </div>
                            <div class="customer_details">
                                <label>Other Allowance</label>
                                <span>{{ number_format($currentSalary->other_allowance) ?? '' }}</span>
                            </div>


                        </div>
                    </div>
                </div>




                <div class="col-12">
                    <div class="card p-2">
                        <div class="row">
                            <label class="col-6"
                                style="padding: 10px 0px 10px 15px;font-size: 15px; font-weight: 600;">Previous Salary
                                Increments</label>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped incrememt_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Increment Date</th>
                                        <th>Basic Salary</th>
                                        <th>Medical Allowance</th>
                                        <th>Mobile Allowance</th>
                                        <th>Laptop Bonus</th>
                                        <th>Conveyance Allowance</th>
                                        <th>Other Allowance</th>
                                        <th>Actions</th>


                                    </tr>
                                </thead>
                                @php $i = 0; @endphp
                                <tbody>

                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <th>{{ isset($currentSalary->updated_at) ? date('d-M-Y', strtotime($currentSalary->updated_at)) : '' }}
                                        </th>
                                        <td>{{ number_format($currentSalary->basic_salary) ?? '' }}</td>
                                        <td>{{ number_format($currentSalary->medical_allowance) ?? '' }}</td>
                                        <td>{{ number_format($currentSalary->mobile_allowance) ?? '' }}</td>
                                        <td>{{ number_format($currentSalary->laptop_bonus) ?? '' }}</td>
                                        <td>{{ number_format($currentSalary->conveyance_allowance) ?? '' }}</td>
                                        <td>{{ number_format($currentSalary->other_allowance) ?? '' }}</td>
                                        @if (isset($last_increment->id))
                                            <td> <a
                                                    href="{{ route('increment-management.edit', encrypt($last_increment->id)) }}"><i
                                                        data-feather="edit" data-toggle="tooltip" data-placement="top"
                                          
                                                        data-original-title="Edit"></i></a>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                    @foreach ($increment as $inc)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <th>{{ date('d-M-Y', strtotime($inc->created_at)) }}</th>
                                            <td>{{ number_format($inc->current_basic_salary) }}</td>
                                            <td>{{ number_format($inc->current_medical_allowance) }}</td>
                                            <td>{{ number_format($inc->current_mobile_allowance) }}</td>
                                            <td>{{ number_format($inc->current_laptop_bonus) }}</td>
                                            <td>{{ number_format($inc->current_conveyance_allowance) }}</td>
                                            <td>{{ number_format($inc->current_other_allowance) }}</td>
                                            <td> <a href="{{ route('increment-management.edit', encrypt($inc->id)) }}"><i
                                                        data-feather="edit" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else

            <div class="col-12">
                <h4 class="text-center m-2">Increment detail's not Found!</h4>
            </div>

            @endif




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

            var table = $('.incrememt_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        title: "Increment Data",
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: "Increment Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Increment Data',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        filename: "Increment Data",
                    }
                ],
            });
        </script>
    @endsection

@extends('layout.main')
@section('hr_leaves_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  View leave Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('leave-management.index')}} @endsection
@section('main_btn_text') All Leaves Management @endsection
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
                                <label>Employee Damcon ID</label>
                                <span>{{ $employee->employee_damcon_id }}</span>
                            </div>  

                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <div class="customer_status">
                            <h6>Leaves Detail</h6>   
                        </div>
                        <div class="customer_details">
                            <label class="pr-2">Allowed Annual leaves</label>
                            <span>{{ $employee->preallowedleaves->annual_leaves ?? 'No found!' }}</span>
                        </div>  
                        <div class="customer_details">
                            <label class="pr-2">Allowed Casual leaves</label>
                            <span>{{ $employee->preallowedleaves->casual_leaves ?? 'No found!' }}</span>
                        </div>  
                        <div class="customer_details">
                            <label class="pr-2">Allowed Sick leaves</label>
                            <span>{{ $employee->preallowedleaves->sick_leaves ?? 'No found!' }}</span>
                        </div>  
                        <div class="customer_details">
                            <label class="pr-2">Allowed Off leaves</label>
                            <span>{{ $employee->preallowedleaves->off_leaves ?? 'No found!' }}</span>
                        </div>  
                        <hr/>
                        <div class="customer_status">
                            <h6>Remaining Leaves</h6>   
                        </div>
                       
                        <div class="customer_details">
                            <label class="pr-2">Remaining Annual leaves</label>
                            <span>{{ $annual_leave ?? 'Not found!' }}</span>
                        </div>  

                        <div class="customer_details">
                            <label class="pr-2">Remaining Sick leaves</label>
                            <span>{{ $sick_leave ?? 'Not found!' }}</span>
                        </div>  

                        <div class="customer_details">
                            <label class="pr-2">Remaining Off leaves</label>
                            <span>{{ $off_leave ?? 'Not found!' }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Remaining Casual leaves</label>
                            <span>{{ $casual_leave ?? 'Not found!' }}</span>
                        </div>  
                       
                    </div>
                </div>
            </div>
          


           
            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Leaves Record</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped leave_table"  style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>off Days Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php $i = 0; @endphp
                            <tbody>
                                    @foreach ($employee->used_leaves as $leave)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{ ucfirst($leave->leave_type)}}</td>
                                            <td>{{$leave->title}}</td>
                                            <td>{{date('d-M-Y',strtotime($leave->start_date))}}</td>
                                            <td>{{ date('d-M-Y',strtotime($leave->end_date)) }}</td>
                                            <td>{{$leave->no_off_Days}}</th>
                                            <td> <a href="{{route('leave-management.edit',encrypt($leave->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
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
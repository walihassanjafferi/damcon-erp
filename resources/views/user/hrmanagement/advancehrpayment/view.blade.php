@extends('layout.main')
@section('hr_advance_payment_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  Advance HR Payment</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('advancehrpayment.index')}} @endsection
@section('main_btn_text') All Advance HR Payment @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-12">
                    <div class="card mb-1">
                        <h6 class="mt-1 ml-1">Advance HR payment Details</h6>   
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                          
                            </div>

                           

                            
                            <div class="customer_details">
                                <label>Employee Damcon ID</label>
                                <span>{{$employee->employee_damcon_id}}</span>
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

                        </div>
                    </div>
                </div>
            {{-- </div> --}}
          


           
            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Advance HR Payments</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped advance_hr" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Advance HR title</th>
                                    <th>Advance Type</th>
                                    <th>Payment ID</th>
                                    <th>Payment Mode</th>
                                    <th>Bank Account</th>
                                    <th>Cheque title</th>
                                    <th>Cheque No</th>
                                    <th>date</th>
                                    <th>Payment Type</th>
                                    <th>Actions</th>
                                    
    
                                </tr>
                            </thead>
                            @php $i = 0; @endphp
                            <tbody>
                                    @foreach ($advancehrpayment as $adv)
                                        <tr>
                                           
                                            <td>{{++$i}}</td>
                                            <td>{{ $adv->advance_hr_title }}</td>
                                            <td>{{ $adv->hrCategories->category_name }}</td>
                                            <td>{{ $adv->payment_id }}</td>
                                            <td>{{ $adv->payment_mode }}</td>
                                            <td>{{ $adv->bank_account }}</td>
                                            <td>{{ $adv->cheque_title }}</td>
                                            <td>{{ $adv->cheque_number }}</td>
                                            <td>{{ date('d-M-Y',strtotime($adv->date)) }}</td>
                                            <td>{{ ($adv->payment_id == 'payment_in') ? " IN ":" OUT " }}</td>
                                            <td> <a href="{{route('advancehrpayment.edit',encrypt($adv->id))}}"><i data-feather="edit" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i></a>
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

            var table = $('.advance_hr').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: "Advance HR Payment Data",
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7]
                        },
                        filename:"Increment Data",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Advance HR Payment Data',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [  1, 2, 3, 4,5,6,7 ]
                        },
                        filename:"Advance HR Payment Data",
                    }
                ],
            });
        });



    </script>
@endsection
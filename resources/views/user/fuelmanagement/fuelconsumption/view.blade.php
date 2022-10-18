@extends('layout.main')
@section('fuel_consumption_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Fuel Consumption</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('fuelconsumption.index')}} @endsection
@section('main_btn_text') All Fuel Consumption  @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                            <h4>Fuel Consumption Details</h4>   
                            </div>
                            <br/>
                            <div class="customer_details">
                                <label>Title PO Number</label>
                                <span>{{ $fuel_consumption->title_po_number }}</span>
                            </div>

                            <div class="customer_details">
                                <label>Project</label>
                                <span>{{ $fuel_consumption->project->name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Date of Entry</label>
                                <span>{{ $fuel_consumption->date_of_entry }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Entry Person</label>
                                <span>{{ $fuel_consumption->entry_person }}</span>
                            </div> 

                            <div class="customer_details">
                                <label>Item Type</label>
                                <span>{{ ucfirst($fuel_consumption->item_type) }}</span>
                            </div> 
                            
                            <div class="customer_details">
                                <label>Driver Person</label>
                                <span>{{ $fuel_consumption->driver_person }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Fueling Item ID</label>
                                <span>{{ $fuel_consumption->fuelItem->item_name }}</span>
                            </div>  
                          
                            
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <br/>
                        <div class="customer_details">
                            <label>Fuel Item Code</label>
                            <span>{{ $fuel_consumption->fuelItem->item_code  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Supplier</label>
                            <span>{{ $fuel_consumption->supplier->name   }}</span>
                        </div> 

                        
                        <div class="customer_details">
                            <label>Consumption Month</label>
                            <span>{{ $fuel_consumption->consumption_month }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Amount with Sale Tax</label>
                            <span>{{ number_format($fuel_consumption->amount_with_sale_tax)  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Quantity in liters</label>
                            <span>{{ $fuel_consumption->quantity_in_liter  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Rate of Fuel/Liter</label>
                            <span>{{ number_format($fuel_consumption->rate_fuel_per_liter)  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Current Mileage/Hours</label>
                            <span>{{ $fuel_consumption->milage_hours  }}</span>
                        </div> 
                       
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <div class="customer_details">
                            <label>Fuel Amount W/O Tax</label>
                            <span>{{ number_format($fuel_amount_without_tax) }}</span>
                        </div> 
                        <div class="customer_details">
                            <label>Tax Amount</label>
                            <span>{{ number_format(intval($fuel_consumption->consumption_month)) }}</span>
                        </div> 
                        <div class="customer_details">
                            <label>Total After Deductions</label>
                            <span>{{ number_format($total_after_deductions) }}</span>
                        </div> 
                        <div class="customer_details">
                            <label>Mileage/Hours during month</label>
                            <span>{{ number_format($milage_hours_during_month) }}</span>
                        </div> 
                        <div class="customer_details">
                            <label>Mileage/Hours per Liter</label>
                            <span>{{ number_format($milage_hours_per_liter) }}</span>
                        </div> 
                        <div class="customer_details">
                            <label>Fuel Expense Per Unit</label>
                            <span>{{ number_format($fuel_expense) }}</span>
                        </div> 
                    </div>
                </div>
            </div>


          
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Comments</label>
                            <label class="comment more">{{ $fuel_consumption->comments }}</label>
                        </div>  
                    </div>
                </div>   
            </div>         
            

            
        @php $files = json_decode($fuel_consumption->file_attachments) @endphp

        <div class="col-12">
            <h6 class="mb-1"><i data-feather='link'></i> Attachment's</h6>

            @if (isset($files) && count($files))
                <div class="col-12"></div>
                @php $pdf = array(); @endphp
                @foreach ($files as $path)
                    @if (!preg_match("/\.(pdf)$/", $path))
                        <span class="pip col-3 m-1">
                            <a download="download" href={{ asset('/storage/fuel_consumption/' . $path) }}
                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                            <img class="images_upload" type="file"
                                src="{{ asset('/storage/fuel_consumption/' . $path) }}" />
                        </span>
                    @else
                        @php array_push($pdf,$path) @endphp
                    @endif
                @endforeach


                @if (isset($pdf))
                    <div class="col-12 mt-3"></div>
                    @foreach ($pdf as $item)
                        <span class="col-4 pip">
                            <a download="download" href={{ asset('/storage/fuel_consumption/PDF/' . $item) }}
                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                            <a class="pdf_file" href="{{ asset('/storage/fuel_consumption/PDF/' . $item) }}"
                                target="_blank">{{ $item }}</a>
                        </span>
                    @endforeach
                @endif

            @else
                <p>No Attachment's Found!</p>
            @endif
        </div>


           
            
              
              

                <div class="col-12">
                    <a class="btn btn-primary mb-1" href="{{route('fuelconsumption.edit',encrypt($fuel_consumption->id))}}" style="float:right;">Edit</a>
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
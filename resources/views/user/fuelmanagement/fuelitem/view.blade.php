@extends('layout.main')
@section('fuel_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Fuel Items</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('fuelitem.index')}} @endsection
@section('main_btn_text') All Fuel Items  @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                            <h4>Fuel Item Details</h4>   
                            </div>
                            <br/>
                            <div class="customer_details">
                                <label>Item Name</label>
                                <span>{{ $fuel_item->item_name }}</span>
                            </div>

                            <div class="customer_details">
                                <label>Project</label>
                                <span>{{ $fuel_item->project->name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Supplier</label>
                                <span>{{ $fuel_item->supplier->name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Fuel Type</label>
                                <span>{{ $fuel_item->fuel_type }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Fuel Card Number</label>
                                <span>{{ $fuel_item->fuel_card_no }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Addition Date</label>
                                <span>{{ date('d-m-Y',strtotime($fuel_item->date_of_addition)) }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Card Issue Date</label>
                                <span>{{ date('d-m-Y',strtotime($fuel_item->card_issue_date)) }}</span>
                            </div> 

                            <div class="customer_details">
                                <label>Card Expiry Date</label>
                                <span>{{ date('d-m-Y',strtotime($fuel_item->card_expiry_date)) }}</span>
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
                            <label>Item Code</label>
                            <span>{{ $fuel_item->item_code  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Monthly Limit in liters</label>
                            <span>{{ $fuel_item->monthly_limit  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Monthly Limit in Rupees</label>
                            <span>{{ $fuel_item->monthly_limit_rupees  }}</span>
                        </div> 

                        
                        <div class="customer_details">
                            <label>Current Balance Item</label>
                            <span>{{ $fuel_item->current_balance_item  }}</span>
                        </div> 

                        <div class="customer_details">
                            <label>Current Stock Cost</label>
                            <span>{{ number_format($fuel_item->current_stock_cost)  }}</span>
                        </div> 
                       
                    </div>
                </div>
            </div>
          
            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Comments</label>
                            <span class="comment more">{{ $fuel_item->comments }}</span>
                        </div>  
                    </div>
                </div>   
            </div>         
        


           
            
              
              

                <div class="col-12">
                    <a class="btn btn-primary mb-1" href="{{route('fuelitem.edit',encrypt($fuel_item->id))}}" style="float:right;">Edit</a>
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
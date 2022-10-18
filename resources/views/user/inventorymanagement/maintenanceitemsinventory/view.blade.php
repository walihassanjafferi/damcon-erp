@extends('layout.main')
@section('maintenanace_item_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Maintenance Items</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('maintenanaceiteminventory.index')}} @endsection
@section('main_btn_text') All Maintenances Inventory Items  @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                            <h6>Maintenance Items Details</h6>   
                            </div>
                            <h3 style="padding: 7px 0px;">{{ $maintenance_inventory->item_name }} ({{ $maintenance_inventory->item_code }})</h3>
                            <div class="customer_details">
                                <label>Item code</label>
                                <span>{{$maintenance_inventory->item_code}}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Item name</label>
                                <span>{{ $maintenance_inventory->item_name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Service ID</label>
                                <span>{{ $maintenance_inventory->service_id }}</span>
                            </div>


                            @if(isset($maintenance_inventory->cat_parent_id ))
                                <div class="customer_details">
                                    <label>Parent Category</label>
                                    <span>{{ $maintenance_inventory->category->category_name}}</span>
                                </div> 
                            @endif

                            @if(isset($maintenance_inventory->cat_main_id ))
                                <div class="customer_details">
                                    <label>Main Category</label>
                                    <span>{{ $maintenance_inventory->main_category->category_name}}</span>

                                </div> 
                            @endif

                            @if(isset($maintenance_inventory->cat_sub_id ))
                            <div class="customer_details">
                                <label>Sub Category</label>
                                <span>{{ $maintenance_inventory->subCategory->category_name}}</span>
                            </div> 
                            @endif

                            @if(isset($maintenance_inventory->cat_sub_id ))
                            <div class="customer_details">
                                <label>Sub Child Category</label>
                                <span>{{ $maintenance_inventory->subsubCategory->category_name}}</span>
                            </div> 
                            @endif 
                            
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        
                        <div class="customer_details">
                            <label>Current Balance</label>
                            <span>{{ $maintenance_inventory->current_balance_item }}</span>
                        </div>  


                        <div class="customer_details">
                            <label>Current Stock Cost</label>
                            <span>{{ number_format($maintenance_inventory->current_stock_cost) }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Brand Item</label>
                            <span>{{ $maintenance_inventory->item_brand }}</span>
                        </div>   

                        <div class="customer_details">
                            <label>Unit of Measure</label>
                            <span>{{ $maintenance_inventory->unit_of_measure }}</span>
                        </div>  
                        
                        <div class="customer_details">
                            <label>Addition Date</label>
                            <span>{{ isset($maintenance_inventory->date_of_addition) ? date('d-M-Y',strtotime($maintenance_inventory->date_of_addition)) : '' }}</span>
                        </div> 
                        
                        
                        <div class="customer_details">
                            <label>Average Unit Cost</label>
                            <span>{{ number_format($maintenance_inventory->average_unit_cost) }}</span>
                        </div>  
                       
                       
                       
                    </div>
                </div>
            </div>
          
        
            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Description</label>
                            <span class="comment more view_details_text">{{ $maintenance_inventory->description }}</span>
                        </div>  


                        <div class="customer_details">
                            <label>Technical Specification 1</label>
                            <span class="comment more view_details_text">{!! $maintenance_inventory->technical_specification_1 !!}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Technical Specification 2</label>
                            <span class="comment more view_details_text">{!! $maintenance_inventory->technical_specifications_2 !!}</span>
                        </div>  

                        
                        <div class="customer_details">
                            <label >Comments</label>
                            <span class="comment more view_details_text">{{ $maintenance_inventory->comments }}</span>
                        </div>  


                    </div>
                </div>    

            </div>


            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Maintenance Item Inventory Updates</label>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-striped inventory_updates">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Update Date</th>
                                    <th>Stock type</th>
                                    <th>Opening QTY balance</th>
                                    <th>Opening QTY cost (PKR)</th>
                                    <th>QTY in/out</th>
                                    <th>Updated Stock</th>
                                    <th>Update stock cost (PKR)</th>
                                    <th>Avg unit cost (PKR)</th>
                                    <th>Closing Qty balance</th>
                                    <th>Closing balance (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventory_updates as $index=>$item)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{ date('d-M-y',strtotime($item->date_of_update)) }}</td>
                                        <td>{{ strtoupper($item->stock_update) }}</td>
                                        <td>{{ $item->opening_stock }}</td>
                                        <td>{{ number_format($item->opening_stock_cost) }}</td>
                                        <td>{{ $item->quantity_type }}</td>
                                        <td>{{ $item->updated_stock}}</td>
                                        <td>{{ number_format($item->updated_stock_cost) }}</td>
                                        <td>{{ number_format($item->avg_stock_unit_cost)}}</td>
                                        <td>{{ $item->current_closing_stock}}</td>
                                        <td>{{ number_format($item->current_closing_stock_cost) }}</td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


           
          
                  
              
              

                <div class="col-12">
                    <a class="btn btn-primary mb-1" href="{{route('maintenanaceiteminventory.edit',encrypt($maintenance_inventory->id))}}" style="float:right;">Edit</a>
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


    $('.inventory_updates').DataTable({

    });


    </script>
@endsection
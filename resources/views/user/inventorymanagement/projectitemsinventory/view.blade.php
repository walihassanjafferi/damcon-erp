@extends('layout.main')
@section('porject_item_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Project Items</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('projectitems.index')}} @endsection
@section('main_btn_text') All Project Inventory Items  @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                            <h5>Project Items Details</h5>   
                            </div>
                            <h3 style="padding: 7px 0px;">{{ $project_inventory->item_name }} ({{ $project_inventory->item_code }})</h3>
                            <div class="customer_details">
                                <label>Item code</label>
                                <span>{{$project_inventory->item_code}}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Item name</label>
                                <span>{{ $project_inventory->item_name }}</span>
                            </div>  

                            {{-- <div class="customer_details">
                                <label>Category</label>
                                <span>{{ $project_inventory->category->name }}</span>
                            </div>   --}}

                            {{-- @if(isset($project_inventory->childcategory->name))
                            <div class="customer_details">
                                <label>Child Category</label>
                                <span>{{ $project_inventory->childcategory->name }}</span>
                            </div>    
                            @endif --}}

                            {{-- @if(isset($project_inventory->cat_parent_id ))
                                <div class="customer_details">
                                    <label>Parent Category</label>
                                    <span>{{ \App\Models\ImprovedCategories::where('module_name','project_item')->where('id',$project_inventory->cat_parent_id)->value('category_name') ?? 'N/A' }}</span>
                                </div> 
                            @endif --}}

                            @if(isset($project_inventory->cat_parent_id ))
                                <div class="customer_details">
                                    <label>Parent Category</label>
                                    <span>{{ $project_inventory->category->category_name}}</span>
                                </div> 
                            @endif

                            @if(isset($project_inventory->cat_main_id ))
                                <div class="customer_details">
                                    <label>Main Category</label>
                                    <span>{{ $project_inventory->main_category->category_name}}</span>

                                </div> 
                            @endif

                            @if(isset($project_inventory->cat_sub_id ))
                            <div class="customer_details">
                                <label>Sub Category</label>
                                <span>{{ $project_inventory->subCategory->category_name}}</span>
                            </div> 
                            @endif

                            @if(isset($project_inventory->cat_sub_id ))
                            <div class="customer_details">
                                <label>Sub Child Category</label>
                                <span>{{ $project_inventory->subsubCategory->category_name}}</span>
                            </div> 
                            @endif 

                         
                            <div class="customer_details">
                                <label>Projects</label>
                                @foreach ($project_inventory->projects as $index=>$item)
                                   <span>{{$item->name}}</span>
                                   {{ (count($project_inventory->projects)-1 > $index) ? ',' : ''}}
                                @endforeach
                            </div>    
                          
                            
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_item_card">

                        <div class="customer_details">
                            <label>Suppliers</label>
                            @foreach ($project_inventory->suppliers as $index=>$item)
                               <span>{{$item->name}}</span>
                               {{ (count($project_inventory->suppliers)-1 > $index) ? ',' : ''}}
                            @endforeach
                        </div>
                        
                        <div class="customer_details">
                            <label>Current Stock QTY</label>
                            <span>{{ $inventoryStockIn - $inventoryStockOut }}</span>
                        </div>  


                        <div class="customer_details">
                            <label>Current Stock Cost</label>
                            <span>{{ number_format($stock_cost) }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Average Unit Cost</label>
                            <span>{{ number_format($project_inventory->average_unit_cost) }}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Brand Item</label>
                            <span>{{ $project_inventory->item_brand }}</span>
                        </div>   

                        <div class="customer_details">
                            <label>Unit of Measure</label>
                            <span>{{ $project_inventory->unit_of_measure }}</span>
                        </div>  
                        
                        <div class="customer_details">
                            <label>Addition Date</label>
                            <span>{{ date('d-M-Y',strtotime($project_inventory->date_of_addition)) }}</span>
                        </div> 
                        
                        
                       
                       
                    </div>
                </div>
            </div>
          
        
            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body">
                        <div class="customer_details">
                            <label>Description</label>
                            <span class="comment more view_details_text">{{ $project_inventory->description }}</span>
                        </div>  


                        <div class="customer_details">
                            <label>Technical Specification 1</label>
                            <span class="view_details_text">{!! $project_inventory->technical_specification_1 !!}</span>
                        </div>  

                        <div class="customer_details">
                            <label>Technical Specification 2</label>
                            <span class="view_details_text">{!! $project_inventory->technical_specifications_2 !!}</span>
                        </div>  

                        
                        <div class="customer_details">
                            <label>Comments</label>
                            <span class="comment more view_details_text">{{ $project_inventory->comments }}</span>
                        </div>  


                    </div>
                </div>    

            </div>


           
            <div class="col-12">
                <div class="card p-2">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 20px;font-size: 15px; font-weight: 600;">Inventory Ledger</label>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped inventory_updates">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="display:none;">Update Date</th>
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
                                        <td style="display: none;">{{ $item->date_of_update }}</td>
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
                    <a class="btn btn-primary mb-1" href="{{route('projectitems.edit',encrypt($project_inventory->id))}}" style="float:right;">Edit</a>
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
            "order": [],
                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Inventory Items ledger',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 1, 3, 4 ,5, 6, 7, 8, 9, 10, 11]
                        },
                        filename:"Inventory Items ledger",    
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Inventory Items ledger',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 1, 3, 4 ,5, 6, 7, 8, 9, 10, 11]
                        },
                        filename:"Inventory Items ledger",       
                    }
                ]
        });


    </script>
@endsection
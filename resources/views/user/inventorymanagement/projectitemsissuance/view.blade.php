@extends('layout.main')
@section('project_issuance_sidebar') active @endsection
@section('title')
<title>Damcon ERP - View Project Items Issuance</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('projectitemsissuance.index')}} @endsection
@section('main_btn_text') All Project Items Issuance @endsection
{{-- back btn --}}
@section('content')
    
    <div class="row">
        <div class="col-6" style="text-align: start;padding: 20px;">
            <label style="font-weight: 900;margin-right: 5%;
            font-size: 15px;min-width: 10px;padding-left:10px;">Issued to : </label>  <span> {{ ucwords($project_items_issuance->employee->name.' '.$project_items_issuance->employee->father_name)}}</span>
        </div>
        <div class="col-6" style="text-align: end;padding: 20px; font-weight:900;font-size:15px;">
            {{date('d-M-Y',strtotime($project_items_issuance->date_of_issuance))}}
        </div>
    </div>
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_issuance_card">
                            <div class="customer_status">
                            </div>
                            <h3 style="padding: 7px 0px;">{{ $project_items_issuance->title }}</h3>
                                
                            
                            <div class="customer_details">
                                <label>Project</label>
                                <span>{{ $project_items_issuance->project->name }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Region</label>
                                <span>{{ $project_items_issuance->region}}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Comments</label>
                                <span class="comment more view_details_text">{{ $project_items_issuance->comments}}</span>
                            </div>  
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            {{-- <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body project_issuance_card">

                        <div class="customer_details">
                            <label>No of Items</label>
                            <span>{{ $quantity }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Average unit cost</label>
                            <span>{{ $avg_unit_cost }} (PKR)</span>
                        </div>
                       
                       
                    </div>
                </div>
            </div> --}}
           

           
            <div class="col-12">
                <div class="card">
                    <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Inventory Updates</label>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item code</th>
                                    <th>Item name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (PKR)</th>
                                    <th>Items Cost (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($project_items_issuance->items as $item)
                                    <tr>
                                       
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->project_inventory->item_code}}</td> 
                                        <td>{{$item->project_inventory->item_name}}</td> 
                                        <td>{{$item->item_qunatity}}</td>
                                        <td>{{number_format($item->item_cost)}}</td>
                                        <td>{{ number_format(floatval($item->item_cost) * floatval($item->item_qunatity))  }} </td>

                                    </tr>
                                @endforeach
                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                  
              
            <div class="col-12">
                <h5 class="mt-1 mb-1">File Attachments</h5>
                    @if(isset($files) && count($files))
                    <div class="col-12"></div>
                        <div class="row">
                            <?php $pdf = array(); ?>
                            @foreach ($files as $path) 
                                @if(!preg_match("/\.(pdf)$/", $path))
                                    <span class="pip col-3 mb-1">
                                        <a download="download" href={{ asset('/storage/items_issuance/' . $path) }}
                                        class="img_pdf_download"><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/items_issuance/'.$path) }}"/>
                                    </span>
                                @else
                                <?php array_push($pdf,$path) ?>                                
                                @endif
                            @endforeach
                        </div>
                        @if(isset($pdf))
                        <div class="col-12 mt-3" ></div>
                        @foreach ($pdf as $item)
                            <span class="col-3 pip">
                                <a download="download" href={{ asset('/storage/items_issuance/PDF/' . $item) }}
                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <a class="pdf_file" href="{{ asset('/storage/items_issuance/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                            </span>
                        @endforeach
                        @endif
                    @else
                    <p>No Attachment's Found!</p>
                    @endif
            </div>

            

              

            <div class="col-12">
                <a class="btn btn-primary mb-1" href="{{route('projectitemsissuance.edit',encrypt($project_items_issuance->id))}}" style="float:right;">Edit</a>
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



    </script>
@endsection
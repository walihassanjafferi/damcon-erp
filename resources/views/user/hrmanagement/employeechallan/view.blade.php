@extends('layout.main')
@section('hr_emptrafficchalan-sidebar') active @endsection
@section('title')
<title>Damcon ERP - Employee Challan</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employeechallan.index')}} @endsection
@section('main_btn_text') All Employee Challan @endsection
{{-- back btn --}}
@section('content')
    
    
    
    <div class="col-12">
        
        <div class="row">
            {{-- <div class="col-8"> --}}
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body project_item_card">
                            <div class="customer_status">
                            </div>
                            {{-- <h3 style="padding: 7px 0px;">{{ $main_items_issuance->title }}</h3> --}}
                            
                            <div class="customer_details">
                                <label>Challan ID</label>
                                <span>{{ $challan->challan_id }}</span>
                            </div>  
                            
                            <div class="customer_details">
                                <label>Challan Date</label>
                                <span>{{ $challan->challan_date }}</span>
                            </div>  


                            <div class="customer_details">
                                <label>Challan Amount</label>
                                <span>{{ $challan->challan_amount }}</span>
                            </div>  

                            <div class="customer_details">
                                <label>Paid Date</label>
                                <span>{{$challan->paid_date}}</span>
                            </div>  

                           
 
                        </div>
                    </div>
                </div>
        
            
                  
            <div class="col-12">
                <h5 class="mt-1 mb-1">File Attachments</h5>
                 
                    @if(isset($challan->document_file))
                    @php $files = json_decode($challan->document_file) @endphp
                    <div class="col-12"></div>
                        <div class="row">
                            <?php $pdf = array(); ?>
                            @foreach ($files as $path) 
                                @if(!preg_match("/\.(pdf)$/", $path))
                                    <span class="pip col-3 mb-1">
                                        <img class="images_upload" type="file" src="{{ asset('/storage/emp_challan_images/'.$path) }}"/>
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
                                    <a class="pdf_file" href="{{ asset('/storage/emp_challan_images/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                </span>
                            @endforeach
                        @endif
                    @else    
                         <p>No Attachment's Found!</p>       
                    @endif
            </div>

            
    

              

            {{-- <div class="col-12">
                <a class="btn btn-primary mb-1" href="{{route('maintenanaceitemconsumption.edit',encrypt($main_items_issuance->id))}}" style="float:right;">Edit</a>
            </div> --}}
            
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
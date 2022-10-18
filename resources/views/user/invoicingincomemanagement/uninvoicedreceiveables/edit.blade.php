@extends('layout.main')
@section('uninvoiced-receiveables-sidebar') active @endsection
@section('title')
<title>Damcon ERP Customer Invoice Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('uninvoicedreceivables.index')}} @endsection
@section('main_btn_text') All Un-Invoiced Receivables Management @endsection
{{-- back btn --}}
@section('css')
    <style>
    .table th, .table td {
        padding: 0.72rem 0.98rem;
    }
    </style>
@endsection

@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Un-Invoiced Receivables</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('uninvoicedreceivables.update',encrypt($uir->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf @method('patch')
                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"  value="{{ $uir->title }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date<span class="red_asterik"></span></label>
                                    <input type="text" name="date" class="form-control date" placeholder="Date"  value="{{ $uir->date }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Project</label>
                                    {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                    $uir->project_id, ['class' => 'form-control select2 select_project','required'=>'true','id'=>'project_id']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                    

                           

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Month<span class="red_asterik"></span></label>
                                    <input type="month" name="month" class="form-control month" placeholder="month"  value="{{ $uir->month }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region<span class="red_asterik"></span></label>
                                    <input type="text" name="region" class="form-control" placeholder="Region"  value="{{ $uir->region }}" required/>
                                </div>
                            </div>


                            
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reason of Un-invoicing<span class="red_asterik"></span></label>
                                    <textarea name="reason_of_uninvoicing"  class="form-control" rows="3"  required>{{ $uir->reason_of_uninvoicing }}</textarea>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Estimated QTY<span class="red_asterik"></span></label>
                                    <input type="number" name="estimated_qty" class="form-control" placeholder="Estimated QTY"  value="{{ $uir->estimated_qty }}" required/>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Estimated Unit Price<span class="red_asterik"></span></label>
                                    <input type="number" name="estimated_unit_price" class="form-control" placeholder="Estimated Unit Price" value="{{ $uir->estimated_unit_price }}"  />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Percentage<span class="red_asterik"></span></label>
                                    <input type="number" name="sales_tax_percentage" class="form-control" placeholder="Sales Tax Percentage" value="{{ $uir->sales_tax_percentage }}" />
                                </div>
                            </div> 
                            


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_id',[null=>'Select Tax body']+$tax_bodies,
                                    $uir->tax_id, ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax body Percentage<span class="red_asterik"></span></label>
                                    <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ $uir->tax_body_percentage }}"  readonly/>
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax type Comments<span class="red_asterik"></span></label>
                                    <textarea name="tax_type_comment"  class="form-control" rows="3"  required>{{ $uir->tax_type_comment }}</textarea>
                                </div>
                            </div> 
            
                


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                    <input type="number" name="sales_tax_source_percentage" class="form-control" placeholder="Sales Tax Withheld at Source Percentage" value="{{ $uir->sales_tax_source_percentage }}" />
                                </div>
                            </div> 


                        


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withholding tax Percentage <span class="red_asterik"></span></label>
                                    <input type="number" name="withhold_tax_percentage" class="form-control" placeholder="Withholding tax Percentage" value="{{ $uir->withhold_tax_percentage }}" />
                                </div>
                            </div> 


                            <div class="col-12">
                                <div class="form-group">
                                    <label>WH Tax Comments<span class="red_asterik"></span></label>
                                    <textarea name="wh_type_comments"  class="form-control" rows="3"  required>{{ $uir->wh_type_comments }}</textarea>
                                </div>
                            </div> 


                             {{-- remove picture code --}}

                        @php
                        $files = json_decode($uir->document_file)
                        @endphp
                      @if(isset($files) && count($files))
                          <div class="col-12"></div>
                          @php $pdf = array(); @endphp
                          @foreach ($files as $path)
                              @if(!preg_match("/\.(pdf)$/", $path))
                                  <span class="pip col-3">
                              <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                              <img class="images_upload" type="file" src="{{ asset('/storage/customerUn-Invoice/'.$path) }}"/>

                          </span>
                              @else
                                  @php array_push($pdf,$path) @endphp
                              @endif
                          @endforeach
                      @endif
                   
                      @if(isset($pdf))
                          <div class="col-12 mt-3" ></div>
                          @foreach ($pdf as $item)
                              <span class="col-4 pip">
                              <a  class="remove" href={{$item}}><i class="fa fa-times"></i></a>
                              <a class="pdf_file" href="{{ asset('/storage/customerUn-Invoice/PDF/'.$item) }}" target="_blank">{{$item}}</a>
                          </span>
                          @endforeach
                      @endif

                      <input type="text" id="remove_images"  name="remove_images" hidden>
                    
                    {{-- remove picture code --}}
                            
                            
                         <div class="col-12"></div> 


                        <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                            <small>**multiple items can be selected</small><br/>
                            <label for="formFileMultiple" class="form-label">File Attachment</label>
                            <input class="form-control" type="file" name="document_file[]" id="file-input" multiple>
                            <small>files supported jpg | jpeg | png | pdf</small><br/>
                        </div>

                        <div class="col-12" style="margin-bottom: 20px;">
                            <div id="preview" class="gallery col-12"></div>
                            <div id="preview_pdf" class="gallery col-12"></div>
                        </div>


                            

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1" >Submit</button>
                            </div>
  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</section>

@endsection


@section('scripts')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/imageupload.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\UninvoicedReceiveablesRequest'); !!}

<script>
      
      

    $(function(){

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });

    });

    function fetch_tax__body_percentage(){
            $id = $(".tax_id option:selected").val();
           
            $.ajax({
                url:'{{ route('get_tax_boby')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":$id
                },
                method: 'post',
                success: function(data) {

                    $('#tax_body_percentage').val(data.message);
                   
                },
                error: function(data)
                {    
                
                    
                }
            });

        }

  


</script>
   
@endsection
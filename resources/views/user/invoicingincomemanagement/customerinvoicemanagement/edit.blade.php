@extends('layout.main')
@section('customer_invoice_sidebar') active @endsection
@section('title')
<title>Damcon ERP Customer Invoice Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('uninvoicedreceivables.index')}} @endsection
@section('main_btn_text') All Customer Invoice Management @endsection
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
                    <h4 class="card-title">Edit Customer Invoices</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('customerinvoice.update',encrypt($cvm->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf  @method('patch')
                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Invoice Number<span class="red_asterik"></span></label>
                                    <input type="text"  name="invoice_number" class="form-control" placeholder="Invoice Number"  value="{{ $cvm->invoice_number }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"  value="{{ $cvm->title }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Type <span class="red_asterik"></span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="1" {{$cvm->type == 1 ? 'selected' : ''}}>Services</option>
                                        <option value="2" {{$cvm->type == 2 ? 'selected' : ''}}>Parts</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of Invoicing<span class="red_asterik"></span></label>
                                    <input type="text" name="date_of_invoicing" class="form-control date_of_invoicing" placeholder="Date of Invoicing"  value="{{ $cvm->date_of_invoicing }}" required/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Detail of Invoice<span class="red_asterik"></span></label>
                                    <textarea name="detail_of_invoice"  class="form-control" rows="3"  required>{{ $cvm->detail_of_invoice }}</textarea>
                                </div>
                            </div>  


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Customer PO<span class="red_asterik"></span></label>
                                    <select name="customer_po_id" class="form-control select2 customer_po">
                                        <option value="">Select Customer PO</option>
                                        @foreach ($customer_po as $val)
                                            <option value="{{$val->id}}" {{ $cvm->customer_po_id == $val->id ? 'selected' : ''}} >{{$val->customer_po_number}} ({{$val->toProject->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>PO Balance<span class="red_asterik"></span></label>
                                    <input type="text" name="po_balance" class="form-control po_balance" placeholder="PO Balance"  value="{{ $cvm->po_balance }}" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cutomer Name<span class="red_asterik"></span></label>
                                    <input type="text" name="customer_name" class="form-control customer_name" placeholder="Customer Name"  value="{{ $cvm->customer_name }}" readonly/>
                                    <input type="hidden" name="customer_id" class="customer_id" value={{$cvm->customer_id}} >

                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Project<span class="red_asterik"></span></label>
                                    <input type="text" name="project_name" class="form-control project_name" placeholder="Project Name"  value="{{ old('project_name') }}" readonly />
                                    <input type="hidden" name="project_id" class="project_id" >

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Invoice Month<span class="red_asterik"></span></label>
                                    <input type="month" name="invoice_month" class="form-control invoice_months" placeholder="Invoicing"  value="{{ $cvm->invoice_month }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region<span class="red_asterik"></span></label>
                                    <input type="text" name="region" class="form-control" placeholder="Region"  value="{{ $cvm->region }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_id',[null=>'Select Tax body']+$tax_bodies,
                                    $cvm->tax_id, ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax Body Description<span class="red_asterik"></span></label>
                                    <textarea name="tax_body_description"  class="form-control" rows="3"  required>{{ $cvm->tax_body_description }}</textarea>
                                </div>
                            </div>  


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" name="taxation_month" class="form-control taxation_month" placeholder="Taxation Month"  value="{{ $cvm->taxation_month }}" readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax body Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ $cvm->tax_body_percentage }}"  readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax type Comments<span class="red_asterik"></span></label>
                                    <textarea name="tax_type_comments"  class="form-control" rows="3"  required>{{ $cvm->tax_type_comments }}</textarea>
                                </div>
                            </div> 
            
                    

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Penalty Deduction Amount Before Tax</label>
                                    <input type="number" name="penality_deduction_amount" class="form-control" placeholder="Penalty Deduction Amount Before Tax" value="{{ $cvm->penality_deduction_amount }}" />
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Penalty Deduction Comment<span class="red_asterik"></span></label>
                                    <textarea name="penality_deduction_comment"  class="form-control" rows="3"  required>{{ $cvm->penality_deduction_comment }}</textarea>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                     <div class="input-group">   
                                        <input type="number" name="sales_tax_source_percentage" class="form-control sales_tax_source_percentage" placeholder="Sales Tax Withheld at Source Percentage" value="{{ $cvm->sales_tax_source_percentage }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                     </div>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>After Tax Deduction<span class="red_asterik"></span></label>
                                    <input type="number" name="after_tax_deduction" class="form-control" placeholder="After Tax Deduction" value="{{ $cvm->after_tax_deduction }}" />

                                </div>
                            </div> 


                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>After Tax Deduction comments<span class="red_asterik"></span></label>
                                    <textarea name="after_tax_deduction_comments"  class="form-control" rows="3"  required>{{ $cvm->after_tax_deduction_comments }}</textarea>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withholding tax 1 Percentage <span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="withhold_tax1_percentage" class="form-control" placeholder="Withholding tax 1 Percentage" value="{{ $cvm->withhold_tax1_percentage }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withholding tax 2 Percentage <span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="withhold_tax2_percentage" class="form-control" placeholder="Withholding tax 2 Percentage" value="{{ $cvm->withhold_tax2_percentage }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 


                            <table class="table variations_table col-12" id="items_table">
                                <thead>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>
                                            <div class="position-relative form-group"><label  class="">Item Name</label>
                                                <input type="text"  name="item_name[]" value=""  class="form-control" required/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Quantity</label>
                                                <input name="item_quantity[]" type="number" class="form-control price" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Cost</label>
                                                <input name="item_cost[]" type="number" class="form-control price" required>
                                            </div>
                                        </td>
                                        
                                    </tr>    --}}
                                    @foreach ($customer_invoice_items as $item)    
                                    <tr>
                                        <td>
                                            <div class="position-relative form-group"><label  class="">Item Name</label>
                                                <input type="text"  name="item_name[]" value={{ $item->item_name }}  class="form-control"   required/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Quantity</label>
                                                <input name="item_quantity[]" value={{ $item->item_qunatity }} type="number" class="form-control price" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Cost</label>
                                                <input name="item_cost[]" type="number" value={{ $item->item_cost }} class="form-control price" required>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-secondary delete_variation_row" onclick="delete_item()">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach

                                
                                </tbody>
                            </table>  
    
                            @if($errors->any())
                                <div class="col-12" style="margin:20px;">
                                    @error('item_name[]')
                                    <span class="alert alert-warning col-4">{{ $message }}</span>
                                    @enderror
                                    @error('item_quantity[][]')
                                    <span class="alert alert-warning col-4">{{ $message }}</span>
                                    @enderror
                                    @error('item_cost[]')
                                    <span class="alert alert-warning col-4">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            
                            
                            <div class="col-12">
                                <button class="btn btn-secondary" onclick="add_variation()">
                                    <i data-feather='plus'></i> Add Item
                                </button>
                            </div>
                            
                            
                            <div class="col-12 mt-1">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $cvm->comments }}</textarea>
                                </div>
                            </div> 

    


                            


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



                    {{-- remove picture code --}}

                        @php
                            $files = json_decode($cvm->document_file)
                          @endphp
                          @if(isset($files) && count($files))
                              <div class="col-12"></div>
                              @php $pdf = array(); @endphp
                              @foreach ($files as $path)
                                  @if(!preg_match("/\.(pdf)$/", $path))
                                      <span class="pip col-3">
                                  <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                  <img class="images_upload" type="file" src="{{ asset('/storage/customerInvoice/'.$path) }}"/>

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
                                  <a class="pdf_file" href="{{ asset('/storage/customerInvoice/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                              </span>
                              @endforeach
                          @endif

                          <input type="text" id="remove_images"  name="remove_images" hidden>
                        
                        {{-- remove picture code --}}
      

                            

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

{!! JsValidator::formRequest('App\Http\Requests\CustomerInvoice'); !!}


<script>
      
      

    $(function(){

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_invoicing').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });

        $('.invoice_month').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });

        $('.taxation_month').datepicker({
            format: 'yyyy-mm',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });
        



    });

    var customer_po = {!! json_encode($customer_po) !!}
    var customer = {!! json_encode($customer) !!}

    $('.customer_po').change(function(){
           
        var customerpo_val = $('.customer_po :selected').val(); 

        $.each( customer_po, function( key, value ) {
            if(value.id == customerpo_val)
            {
                $('.po_balance').val(value.amount_with_tax);
                var project = value.to_project;
                $('.project_id').val(project.id);
                $('.project_name').val(project.name);
                $.each( customer, function( key, item ) {
                    if(item.id == project.customer_id)
                    {
                        $('.customer_name').val(item.name);
                        $('.customer_id').val(item.id);
                    }
                });
            }
        });

    });

    function add_variation(){
            event.preventDefault();
            var content = '';
            content +='<tr>';
            content +='<td>';
            content +='<div class="position-relative form-group"><label>Item Name</label>';
            content +='<input name="item_name[]" type="text" class="form-control" required>';
            content +='</select>';
            content +='</div>';
            content +='</td>';
            content +='<td><div class="position-relative form-group ">';
            content +='<label  class="required">Item Quantity</label>';
            content +='<input name="item_quantity[]" type="number" class="form-control" required>';
            content +='</div></td>';
            content +='<td><div class="position-relative form-group ">';
            content +='<label  class="required">Item Cost</label>';
            content +='<input name="item_cost[]" type="number" class="form-control" required>';
            content +='</div></td>';
            content +='<td ><button class="btn btn-secondary delete_variation_row"  onclick="delete_item()">';
            content +='<i class="fa fa-times"></i>';
            content +='</button></td>';
            content +='</tr>';

            $('#items_table tr:last').after(content);

    }

        $("#items_table").on('click', '.delete_variation_row', function () {
            event.preventDefault();
            $(this).closest('tr').remove();
        });

        function fetch_tax__body_percentage(){

            var type = '';

            if($("[name='type']").val() == 1)
            {
                type = "services";
            }

            $id = $(".tax_id option:selected").val();

            $.ajax({
                url:'{{ route('get_tax_boby')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":$id,
                    "type":type
                },
                method: 'post',
                success: function(data) {
                    console.log(data);
                    $('#tax_body_percentage').val(data.message);
                    $('.sales_tax_source_percentage').val(data.withhold);
                
                },
                error: function(data)
                {    
                
                    
                }
            });

        }



</script>
   
@endsection
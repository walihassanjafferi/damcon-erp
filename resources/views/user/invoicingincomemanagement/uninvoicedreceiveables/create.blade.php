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
                    <h4 class="card-title">Add Un-Invoiced Receivables</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('uninvoicedreceivables.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"  value="{{ old('title') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date<span class="red_asterik"></span></label>
                                    <input type="text" name="date" class="form-control date" placeholder="Date"  value="{{ old('date') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Select Project</label>
                                    {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                    old('project_id'), ['class' => 'form-control select2 select_project','required'=>'true','id'=>'project_id']) !!}
                                    @error('project_id')
                                    <div class="error-help-block">{{ $message }}</div>
                                    @enderror  
                                </div>
                            </div>

                    

                           

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Month<span class="red_asterik"></span></label>
                                    <input type="month" name="month" class="form-control month" placeholder="month"  value="{{ old('month') }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region<span class="red_asterik"></span></label>
                                    <input type="text" name="region" class="form-control" placeholder="Region"  value="{{ old('region') }}" required/>
                                </div>
                            </div>



                            {{-- <table class="table variations_table col-12" id="items_table">
                                <thead>
                                </thead>
                                <tbody>
                                    <label class="ml-1"><b>Items</b></label>
                                    @if(old('item_name') && old('item_quantity') && old('item_cost'))
                                   
                                        @for( $i =0; $i < count(old('item_name')); $i++)                            
                                        <tr>
                                            <td>
                                                <div class="position-relative form-group"><label  class="">Item Name</label>
                                                    <input type="text"  name="item_name[]" value="{{ old('item_name.'.$i)}}"  class="form-control" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative form-group ">
                                                    <label for="price" class="required">Item Quantity</label>
                                                    <input name="item_quantity[]" value={{ old('item_quantity.'.$i)}} type="number" class="form-control price" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative form-group ">
                                                    <label for="price" class="required">Item Cost</label>
                                                    <input name="item_cost[]" type="number" value={{ old('item_cost.'.$i)}} class="form-control price" required>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-secondary delete_variation_row" onclick="delete_item()">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td> 
                                        </tr>
                                        @endfor
                                    @else
                                    <tr>
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
                                        
                                    </tr>
                                    @endif
    
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


                            <div class="col-12 mb-1">
                                <button class="btn btn-secondary" onclick="add_variation()">
                                    <i data-feather='plus'></i> Add Item
                                </button>
                            </div> --}}


                            
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reason of Un-invoicing<span class="red_asterik"></span></label>
                                    <textarea name="reason_of_uninvoicing"  class="form-control" rows="3"  required>{{ old('reason_of_uninvoicing') }}</textarea>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Estimated QTY<span class="red_asterik"></span></label>
                                    <input type="number" name="estimated_qty" class="form-control" placeholder="Estimated QTY"  value="{{ old('estimated_qty') }}" required/>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Estimated Unit Price<span class="red_asterik"></span></label>
                                    <input type="number" name="estimated_unit_price" class="form-control" placeholder="Estimated Unit Price" value="{{ old('estimated_unit_price') }}"  />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="sales_tax_percentage" class="form-control" placeholder="Sales Tax Percentage" value="{{ old('sales_tax_percentage') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_id',[null=>'Select Tax body']+$tax_bodies,
                                    old('tax_id'), ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax body Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ old('tax_body_percentage') }}"  readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax type Comments<span class="red_asterik"></span></label>
                                    <textarea name="tax_type_comment"  class="form-control" rows="3"  required>{{ old('tax_type_comment') }}</textarea>
                                </div>
                            </div> 
            
                


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="sales_tax_source_percentage" class="form-control" placeholder="Sales Tax Withheld at Source Percentage" value="{{ old('sales_tax_source_percentage') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 


                        


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withholding tax Percentage <span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="withhold_tax_percentage" class="form-control" placeholder="Withholding tax Percentage" value="{{ old('withhold_tax_percentage') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> 


                            <div class="col-12">
                                <div class="form-group">
                                    <label>WH Tax Comments<span class="red_asterik"></span></label>
                                    <textarea name="wh_type_comments"  class="form-control" rows="3"  required>{{ old('wh_type_comments') }}</textarea>
                                </div>
                            </div> 
                            
                            

                            <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                <small>**multiple items can be selected</small><br/>
                                <label for="formFileMultiple" class="form-label">File Attachment</label>
                                <input class="form-control" type="file" name="document_file[]" id="file-input" accept="application/pdf, image/*"
                                multiple>
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


    
    function add_variation()
        {
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
            content +='<td class="text-center"><button class="btn btn-secondary delete_variation_row" style="margin-top:20px;" onclick="delete_item()">';
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
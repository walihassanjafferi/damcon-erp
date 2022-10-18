@extends('layout.main')
@section('customer_invoice_sidebar') active @endsection
@section('title')
<title>Damcon ERP Customer Invoice Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customerinvoice.index')}} @endsection
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
                    <h4 class="card-title">Add Customer Invoices</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('customerinvoice.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Invoice Number<span class="red_asterik"></span></label>
                                    <input type="text"  name="invoice_number" class="form-control" placeholder="Invoice Number"  value="{{ old('invoice_number') }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"  value="{{ old('title') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Type <span class="red_asterik"></span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="1">Services</option>
                                        <option value="2">Parts</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of Invoicing<span class="red_asterik"></span></label>
                                    <input type="text" name="date_of_invoicing" class="form-control date_of_invoicing" placeholder="Date of Invoicing"  value="{{ old('date_of_invoicing') }}" required/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Detail of Invoice<span class="red_asterik"></span></label>
                                    <textarea name="detail_of_invoice"  class="form-control" rows="3"  required>{{ old('detail_of_invoice') }}</textarea>
                                </div>
                            </div>  



                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Customer PO<span class="red_asterik"></span></label>
                                    <select name="customer_po_id" class="form-control select2 customer_po">
                                        <option value="">Select Customer PO</option>
                                        @foreach ($customer_po as $val)
                                            <option value="{{$val->id}}">{{$val->customer_po_number}} ({{$val->toProject->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>PO Balance<span class="red_asterik"></span></label>
                                    <input type="text" name="po_balance" class="form-control po_balance" placeholder="PO Balance"  value="{{ old('po_balance') }}" readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cutomer Name<span class="red_asterik"></span></label>
                                    <input type="text" name="customer_name" class="form-control customer_name" placeholder="Customer Name"  value="{{ old('customer_name') }}" readonly/>
                                    <input type="hidden" name="customer_id" class="customer_id" >

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
                                    <input type="month" name="invoice_month" class="form-control invoice_months" placeholder="Invoicing"  value="{{ old('invoice_month') }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region<span class="red_asterik"></span></label>
                                    <input type="text" name="region" class="form-control" placeholder="Region"  value="{{ old('region') }}" required/>
                                </div>
                            </div>

                            

                            <table class="table variations_table col-12" id="items_table">
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
                                <label>Tax body Percentage<span class="red_asterik"></span></label>
                                <div class="input-group">
                                    <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ old('tax_body_percentage') }}"  readonly/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>


                            
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax Body Description<span class="red_asterik"></span></label>
                                    <textarea name="tax_body_description"  class="form-control" rows="3"  required>{{ old('tax_body_description') }}</textarea>
                                </div>
                            </div>  


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" name="taxation_month" class="form-control taxation_month" placeholder="Taxation Month"  value="{{ old('taxation_month') }}" readonly/>
                                </div>
                            </div>


                            

                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tax type Comments<span class="red_asterik"></span></label>
                                    <textarea name="tax_type_comments"  class="form-control" rows="3"  required>{{ old('tax_type_comments') }}</textarea>
                                </div>
                            </div> 
            
                    

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Penalty Deduction Amount Before Tax</label>
                                    <input type="number" name="penality_deduction_amount" class="form-control" placeholder="Penalty Deduction Amount Before Tax" value="{{ old('penality_deduction_amount') }}" />
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Penalty Deduction Comment<span class="red_asterik"></span></label>
                                    <textarea name="penality_deduction_comment"  class="form-control" rows="3"  required>{{ old('penality_deduction_comment') }}</textarea>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withheld Tax<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="sales_tax_source_percentage" class="form-control sales_tax_source_percentage" placeholder="Sales Tax Withheld at Source Percentage" value="{{ old('sales_tax_source_percentage') }}" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>After Tax Deduction<span class="red_asterik"></span></label>
                                    <input type="number" name="after_tax_deduction" class="form-control" placeholder="After Tax Deduction" value="{{ old('after_tax_deduction') }}" />

                                </div>
                            </div> 


                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>After Tax Deduction comments<span class="red_asterik"></span></label>
                                    <textarea name="after_tax_deduction_comments"  class="form-control" rows="3"  required>{{ old('after_tax_deduction_comments') }}</textarea>
                                </div>
                            </div> 


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Withholding tax 1 Percentage <span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="withhold_tax1_percentage" class="form-control" placeholder="Withholding tax 1 Percentage" value="{{ old('withhold_tax1_percentage') }}" />
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
                                        <input type="number" name="withhold_tax2_percentage" class="form-control" placeholder="Withholding tax 2 Percentage" value="{{ old('withhold_tax2_percentage') }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 


                      
                            
                            
                          
                            
                            <div class="col-12 mt-1">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
                                </div>
                            </div> 
                        
                            

                            <div class="col-12">
                                <span id="calculatePayment" class="btn btn-primary mb-1" >Calculate Payment &nbsp; <i class='fa fa-calculator'></i>
                                </span>

                                <div  id="calculated_values"  style="display: none;">
                                    <div class="col-12 d-flex flex-wrap">
                                        <div class="col-3"><b>Sub total</b> = <span id="sub_total"></span></div> &nbsp;
                                         <div class="col-3"><b>Before Tax total</b>  = <span id="before_tax_total"></span></div>&nbsp;
                                         <div class="col-3"><b>Tax Amount</b>  = <span id="tax_amount"></span></div>&nbsp;
                                         <div class="col-3"><b>Total amount</b> = <span id="total_amount"></span></div>&nbsp;
                                         <div class="col-3"><b>Sales tax WH at src</b> = <span id="sales_tax_wh"></span></div>&nbsp;
                                         <div class="col-3"><b>After tax total </b> = <span id="after_tax_total"></span></div>&nbsp;
                                         <div class="col-3"><b>WH tax 1 </b> = <span id="wh_tax_1"></span></div>&nbsp;
                                         <div class="col-3"><b>WH tax 2 </b> = <span id="wh_tax_2"></span></div>&nbsp;
                                         <div class="col-3"><b>After deductions </b> = <span id="total_deduction"></span></div>&nbsp;
                                         <div class="col-3"><b>Net Income</b> = <span id="net_income"></span></div>&nbsp;
                                    </div>
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

    var po_balance = '';

    $('.customer_po').change(function(){
           
        var customerpo_val = $('.customer_po :selected').val(); 

        $.each( customer_po, function( key, value ) {
            if(value.id == customerpo_val)
            {
                po_balance = value.amount_without_tax;
                $('.select_project').val(value.project_id).change();
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

        // getting logs last balance

        $.ajax({
            url:'{{ route('getLastInsertedInvoice')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "po_id":customerpo_val
            },
            method: 'post',
            success: function(data) {
                console.log(data.new_po_balance);
                if(data.customer_PO_balance_logs!=null)
                {
                    $('.po_balance').val(data.customer_PO_balance_logs.new_po_balance);
                }
                else{
                    $('.po_balance').val(po_balance);
                }
                
            },
            error: function(data)
            {    
            
                
            }
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

    
        // var $name = [], $cost = [], $quantity = []; $total_items_cost = [];
        // var item_costs_quan = [];sub_total = 0; before_tax_total = 0; tax_amount = 0; total_amount = 0;
        // sales_tax_wh_at_src = 0; after_tax_total = 0; total_after_deduction = 0; net_income = 0; sum_cost = 0;
        $('#calculatePayment').click(function(){
           
           
            var $name = [], $cost = [], $quantity = []; $total_items_cost = [];
            var item_costs_quan = [];sub_total = 0; before_tax_total = 0; tax_amount = 0; total_amount = 0;
            sales_tax_wh_at_src = 0; after_tax_total = 0; total_after_deduction = 0; net_income = 0; sum_cost = 0;
            
            var item_name = $("[name='item_name[]']");
            var item_quantity = $("[name='item_quantity[]']");
            var item_costs = $("[name='item_cost[]")


            item_name.each(function(key){
                    // console.log('q Index',item_quantity[key].value);
                    // console.log('P Index',item_costs[key].value);

                   var item_cost = (Number(item_quantity[key].value) * Number(item_costs[key].value));
                    item_costs_quan.push(item_cost);
            })


            // sum of cost

            sum_cost = item_costs_quan.reduce(function(a, b){
          	    return a + b;
            }, 0);



            sub_total = sum_cost;
            before_tax_total = sub_total - $("input[name=penality_deduction_amount]").val();
            tax_amount = before_tax_total * ($("input[name=tax_body_percentage]").val()/100);
            total_amount = before_tax_total + tax_amount;
            sales_tax_wh_at_src = tax_amount * ($("input[name=sales_tax_source_percentage]").val()/100);
            after_tax_total = total_amount - $("input[name=after_tax_deduction]").val();
            wh_tax_1 = after_tax_total * ($("input[name=withhold_tax1_percentage]").val()/100)
            wh_tax_2 = total_amount * ($("input[name=withhold_tax2_percentage]").val()/100)
            total_after_deduction = total_amount - sales_tax_wh_at_src - wh_tax_1 - wh_tax_2;
            net_income = before_tax_total - wh_tax_1 - wh_tax_2;

          //  alert(sales_tax_wh_at_src);

          console.log('Sub Total', sub_total);

          console.log('Before tax total', before_tax_total);

            
            $('#calculated_values').css('display','block');



            $('#sub_total').html(sub_total.toFixed(2));
            $('#before_tax_total').html(before_tax_total.toFixed(2));
            $('#tax_amount').html(tax_amount.toFixed(2));  
            $('#total_amount').html(total_amount.toFixed(2));  
            $('#sales_tax_wh').html(sales_tax_wh_at_src.toFixed(2));  
            $('#after_tax_total').html(after_tax_total.toFixed(2));  
            $('#wh_tax_1').html(wh_tax_1.toFixed(2));
            $('#wh_tax_2').html(wh_tax_2.toFixed(2));
            $('#total_deduction').html(total_after_deduction.toFixed(2));
            $('#net_income').html(net_income.toFixed(2));

          



        });

   

       

    


</script>
   
@endsection
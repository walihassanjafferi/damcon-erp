@extends('layout.main')
@section('supplierpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Suppliers POs Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('supplierspos.index')}} @endsection
@section('main_btn_text') All Suppliers POs Management @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
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
                        <h4 class="card-title">Add Suppliers Purchase Order</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('supplierspos.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Purchase Order Number<span class="red_asterik"></span></label>
                                        <input type="text"  name="purchase_od_number" class="form-control" placeholder="Purchase Order Number" value="{{ old('purchase_od_number') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>GRN Number</label>
                                        <input type="text"  name="grm_number" class="form-control" placeholder="GRN Number" value="{{ old('grm_number') }}" required/>
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
                                        <label>Select Supplier</label>
                                        {!! Form::select('supplier_id',$supplies+[NULL=>'Select Supplier'],
                                        NULL, ['class' => 'form-control select2 select_supplier','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Number (optional)</label>
                                        <input type="text"  name="customer_optional_number" class="form-control" placeholder="Customer Optional Number" value="{{ old('customer_optional_number') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Requesting person</label>
                                        <input type="text"  name="requesting_person" class="form-control" placeholder="Requesting person" value="{{ old('requesting_person') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Issue Date</label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="issue_date" class="form-control issue_date form-date" placeholder="Issue Date" value="{{ old('issue_date') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Items Delivery Date</label>
                                        <input type="text" autocomplete="off" tabindex="-1"  name="items_delivery_date" class="form-control items_delivery_date form-date" placeholder="Items Delivery Date" value="{{ old('items_delivery_date') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Payment Terms</label>
                                        <input type="text" autocomplete="off"   name="payment_terms" class="form-control" placeholder="Payment Terms" value="{{ old('payment_terms') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>PR Number</label>
                                        <input type="text" autocomplete="off"   name="pr_number" class="form-control" placeholder="PR Number" value="{{ old('pr_number') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Select Tax Body</label>
                                        {!! Form::select('tax_body_id',$taxbodys+[NULL=>'Select Tax Body'],
                                        NULL, ['class' => 'form-control select2 tax_id','required'=>'true','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Taxation Month<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="taxation_month" class="form-control taxation_month_date form-date" placeholder="Taxation Month" value="{{ old('taxation_month') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Tax Body %<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax Body %" value="{{ old('tax_body_percentage') }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Witholding tax %<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="sales_tax_wh" class="form-control sales_tax_wh" placeholder="Sales Tax WH" value="{{ old('sales_tax_wh') }}" readonly/>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier withheld Tax Deduction 1(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_deduction_1" class="form-control" placeholder="Tax Deduction 1(%)" value="{{ old('tax_deduction_1') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier withheld Tax Deduction 2(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_deduction_2" class="form-control" placeholder="Tax Deduction 2(%)" value="{{ old('tax_deduction_2') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> 
                                        {{-- <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}" style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label> --}}
                                        <input id="file-input" type="file" class="form-control" name="document_file[]" multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>



                                <table class="table variations_table col-12" id="items_table">
                                    <thead>
                                    </thead>
                                    <tbody>
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
                                                    {{-- <input type="text"  name="item_name[]" value=""  class="form-control" required/> --}}
                                                    <select class="form-control inventory_items  item_price_select item_dropdown_append select2" name="item_name[]" onChange="getPrice(event,0)">
                                                    </select>
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
                                                    <input name="item_cost[]" type="number" class="form-control price price_0" required>
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


                                <div class="col-12">
                                    <button class="btn btn-secondary add_variation" >
                                        <i data-feather='plus'></i> Add Item
                                    </button>
                                </div>


                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ old('comments') }}</textarea>
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
    <script type="text/javascript" src="{{ asset('js/imageupload.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SupplierPORequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        var items = "";
        var items_list=[];
        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.issue_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.items_delivery_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                maxDate: function () {
                    return $('.customer_po_end_date').val();
                }
            });

            $('.taxation_month_date').datepicker({
                format: 'yyyy-mm',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });


            //  repeater fields
            var increment = 1;

            $('.add_variation').click(function name(params) {
                event.preventDefault();
                items_list=[];

                $(".item_dropdown_append").find(':selected').each(function( index ) {
                    items_list.push($(this).val());
                });

                var content = '';
                content +='<tr>';
                content +='<td>';
                content += '<div class="position-relative form-group ">';
                content +='<div class="position-relative form-group"><label>Item Name</label>';
                content +='<select class="form-control select2 item_dropdown_append inventory_items" name="item_name[]" onChange="getPrice(event,'+increment+')">';
                // content +='<input name="item_name[]" type="text" class="form-control price_'+increment+'" required>';
                content +='<option value=>Select Item</option>';
                $.each(items,function(key,value){
                    if(items_list.includes(value.id.toString())){
                        var check_list = "disabled";
                    }else{
                        var check_list = "";
                    }
                    content += '<option value='+value.id+'  '+check_list+' data-parent_cat="'+value.category.category_name+'"  data-main_cat="'+value.main_category.category_name+'" data-sub_cat="'+value.sub_category.category_name+'" data-subsub_cat="'+value.subsub_category.category_name+'" data-avgcost="'+value.average_unit_cost+'" >'+value.item_code+' ( '+value.item_name+' ) '+'</option>';
                });
                content +='</select>';
                        
                content +='</div></td>';
                content +='<td><div class="position-relative form-group ">';
                content +='<label  class="required">Item Quantity</label>';
                content +='<input name="item_quantity[]" type="number" class="form-control" required>';
                content +='</div></td>';
                content +='<td><div class="position-relative form-group ">';
                content +='<label  class="required">Item Cost</label>';
                content +='<input name="item_cost[]" type="number" class="form-control price_'+increment+'" required>';
                content +='</div></td>';
                content +='<td class="text-center"><button class="btn btn-secondary delete_variation_row" style="margin-top:20px;" onclick="delete_item()">';
                content +='<i class="fa fa-times"></i>';
                content +='</button></td>';
                content +='</tr>';


                $('#items_table tr:last').after(content);
                increment++;
            });


            $("#items_table").on('click', '.delete_variation_row', function () {
                event.preventDefault();
                $(this).closest('tr').remove();
            });
        });

        //CKEDITOR.replace('details_input');

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
                    $('.sales_tax_wh').val(data.withhold);
                
                },
                error: function(data)
                {    
                
                    
                }
            });

        }

        var html = '';
        $(".select_supplier").change(function(){
            var supplier_id = $('.select_supplier').val();
            $.ajax({
                url:'{{ route('get_supplier_items_po')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "supplier_id":supplier_id
                },
                method: 'post',
                success: function(data) {
                    // console.log('abc=>',data);
                    $("#items_table").find("tr:gt(0)").remove();
                    items = data.items;
                    items_list = [];
                    $('.inventory_items').html('');

                    html = '';

                    $('.inventory_items').append(
                        '<option value="" >Select Item</option>'
                    )
                    $.each(items,function(key,value) {
                        
                        html += '<option  value='+value.id+' data-parent_cat="'+value.category.category_name+'"  data-main_cat="'+value.main_category.category_name+'" data-sub_cat="'+value.sub_category.category_name+'" data-subsub_cat="'+value.subsub_category.category_name+'" data-avgcost="'+value.average_unit_cost+'" >'+value.item_code+' ( '+value.item_name+' ) '+'</option>'
                    
                    })

                    $('.inventory_items').append(html);
                },
                error: function(data)
                {
                }
            });
        });

        function getPrice(event,id){
          
          var select2_obj = event.target;
          console.log('select2 obj',select2_obj);
          var item_value = event.target.value;
          console.log('Item value',item_value);
          items_list.push(item_value);
          $.each(items,function(key,value) {

              if(item_value == value.id)
              { 
                //  console.log(value.average_unit_cost);
                  $(`.price_${id}`).val(value.average_unit_cost);
              }
          })
        }

        $(document).on('change','.inventory_items',function(){

            if($(this).find(":selected").val() != '')
            {
                var parent_category = $(this).find(":selected").data('parent_cat');
                var main_category = $(this).find(":selected").data('main_cat');
                var sub_category = $(this).find(":selected").data('sub_cat');
                var subsub_cat = $(this).find(":selected").data('subsub_cat');
                var avg_cost = $(this).find(":selected").data('avgcost');
                swal("Item Catgories", `Parent Category : ${parent_category} \n\n Main Category : ${main_category} \n\n Sub Category : ${sub_category} \n\n Sub child Category : ${subsub_cat} \n\n Average Unit Cost : ${avg_cost} PKR`);
            }
        })


    </script>

@endsection

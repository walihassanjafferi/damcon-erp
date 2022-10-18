@extends('layout.main')
@section('rentalpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Rental POs Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('rentalpos.index')}} @endsection
@section('main_btn_text') All Rental POs Management @endsection
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
                        <h4 class="card-title">Add Rental Purchase Order</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('rentalpos.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
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
                                        <label>Agreement Number</label>
                                        <input type="text"  name="agreement_number" class="form-control" placeholder="Agreement Number" value="{{ old('agreement_number') }}" required/>
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
                                        <label>Select Supplier<span class="red_asterik"></span></label>
                                        {!! Form::select('supplier_id',$supplies+[NULL=>'Select Supplier'],
                                        NULL, ['class' => 'form-control select2 select_supplier','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Project<span class="red_asterik"></span></label>
                                        {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                        NULL, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
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
                                        <label>Issue Date</label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="issue_date" class="form-control issue_date form-date" placeholder="Issue Date" value="{{ old('issue_date') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Purchase Order Month</label>
                                        <input type="text" autocomplete="off" tabindex="-1"  name="purchase_order_month" class="form-control purchase_order_month form-date" placeholder="Purchase Order Month" value="{{ old('purchase_order_month') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Region</label>
                                        <input type="text" autocomplete="off"   name="region" class="form-control" placeholder="Region" value="{{ old('region') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Select Tax Body<span class="red_asterik"></span></label>
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
                                        <label>Sales Tax WH<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="sales_tax_wh" class="form-control" placeholder="Sales Tax WH" value="{{ old('sales_tax_wh') }}" required/>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier withheld Tax Deduction 1(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="supplier_tax_deduction_1" class="form-control" placeholder="Supplier withheld Tax Deduction 1(%)" value="{{ old('supplier_tax_deduction_1') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier withheld Tax Deduction 2(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="supplier_tax_deduction_2" class="form-control" placeholder="Supplier withheld Tax Deduction 2(%)" value="{{ old('supplier_tax_deduction_2') }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}" style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label>
                                        <input id="file_input" type="file" class="form-control" name="document_file[]" multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br/>
                                    </div>
                                </div>


                                <table class="table variations_table col-12" id="items_table">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="position-relative form-group"><label  class="">Item Name</label>
                                                <select class="form-control inventory_items select2 item_price_select item_dropdown_append" name="item_name[]" onChange="getPrice(event,0)">
                                                </select>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Quantity</label>
                                                <input name="item_quantity[]" type="number" class="form-control quantity_hello" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="position-relative form-group ">
                                                <label for="price" class="required">Item Monthly Rent</label>
                                                <input name="item_monthly_rent[]" type="number" class="form-control price_0" required readonly>
                                            </div>
                                        </td>
                                    </tr>
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
                                        @error('item_monthly_rent[]')
                                        <span class="alert alert-warning col-4">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif


                                <div class="col-12">
                                    <button class="btn btn-secondary add_variation" >
                                        <i data-feather='plus'></i> Add Item
                                    </button>
                                </div>



                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>


                                <div class="col-md-12 mb-2">
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\RentalPORequest'); !!}
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

            $('.purchase_order_month').datepicker({
                format: 'yyyy-mm',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.taxation_month_date').datepicker({
                format: 'yyyy-mm',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            function selectRefresh() {
                $('.select2').select2();
            }


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
                content +='<div class="position-relative form-group"><label>Item Name</label>';
                content +='<select class="form-control select2 item_dropdown_append inventory_items abc" name="item_name[]" onChange="getPrice(event,'+increment+')">';
                content +='<option value=>Select Item</option>';
                $.each(items,function(key,value){
                    if(items_list.includes(value.id.toString())){
                        var check_list = "disabled";
                    }else{
                        var check_list = "";
                    }
                    content +='<option   value='+value.id+'  '+check_list+'>'+value.rental_name+'</option>';
                });
                content +='</select>';
                content +='</div>';
                content +='</td>';
                content +='<td><div class="position-relative form-group ">';
                content +='<label  class="required">Item Quantity</label>';
                content +='<input name="item_quantity[]" type="number" class="form-control" required>';
                content +='</div></td>';
                content +='<td><div class="position-relative form-group ">';
                content +='<label  class="required">Item Monthly Rent</label>';
                content +='<input name="item_monthly_rent[]" type="number" class="form-control rent_price price_'+increment+'" required readonly>';
                content +='</div></td>';
                content +='<td class="text-center"><button class="btn btn-secondary delete_variation_row" style="margin-top:20px;">';
                content +='<i class="fa fa-times"></i>';
                content +='</button></td>';
                content +='</tr>';

                $('#items_table tr:last').after(content);
                increment++;

                selectRefresh();
            });

            $("#items_table").on('click', '.delete_variation_row', function () {
                event.preventDefault();
                var index = $(this).parent().parent().find('td .item_dropdown_append').val();
                var rowIndex = items_list.indexOf(index);//get  "car" index
                items_list.splice(rowIndex, 1);
                $(this).closest('tr').remove();
            });
        });



        $('.item_price_select').change(function() {
            var me = $(this);
            var item_value = $('.item_price_select').val();
            $.each(items,function(key,value) {
                if(item_value == value.id)
                {
                    me.parent().parent().siblings().find('.price').val(value.monthly_rental_amount);
                }
            })
        });

        function getPrice(event,id){
            var select2_obj = event.target;
            var item_value = event.target.value;
            items_list.push(item_value);
            $.each(items,function(key,value) {

                if(item_value == value.id)
                {
                    $(`.price_${id}`).val(value.monthly_rental_amount);
                }
            })
        }

        $(".select_supplier").change(function(){
            project_id = $('.select_supplier').val();
            $.ajax({
                url:'{{ route('getSupplier')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "supplier_id":project_id
                },
                method: 'post',
                success: function(data) {
                    $("#items_table").find("tr:gt(0)").remove();
                    items = data.items;
                    items_list = [];
                    $('.inventory_items').html('');

                    $('.inventory_items').append(
                        '<option value=>Select Item</option>'
                    )
                    $.each(items,function(key,value) {

                        $('.inventory_items').append(
                            '<option  value='+value.id+'>'+value.rental_name+'</option>'
                        )
                    })
                },
                error: function(data)
                {
                }
            });
        });

        //CKEDITOR.replace('details_input');


        function previewImages() {

            var preview = document.querySelector('#preview');

            if (this.files) {
                [].forEach.call(this.files, readAndPreview);
            }

            function readAndPreview(file) {

                // Make sure `file.name` matches our extensions criteria
                var filename = file.name;
                var file_extension = filename.split('.').pop();

                if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                    return alert(file.name + " is not an image");
                } // else...

                var reader = new FileReader();

                reader.addEventListener("load", function() {

                    if(file_extension!='pdf')
                    {
                        $("<span class=\"pip col-3\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name + "\"/>" +
                            "</span>").insertAfter("#preview");
                    }
                    else{

                        $("<span class=\"pip col-4\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>"+file.name+"</span>" +
                            "</span>").insertAfter("#preview_pdf");
                    }

                    $(".remove").click(function(){
                        $(this).parent(".pip").delay(200).fadeOut();
                    });
                });
                reader.readAsDataURL(file);
            }
        }

        document.querySelector('#file_input').addEventListener("change", previewImages);

        function fetch_tax__body_percentage(){

            var type = '';

            if($("[name='type']").val() == 1)
            {
                type = "services";
            }

            $id = $(".tax_id option:selected").val();
            if($id){
                $.ajax({
                    url:'{{ route('get_tax_boby')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":$id,
                        "type":type
                    },
                    method: 'post',
                    success: function(data) {
                        $('#tax_body_percentage').val(data.message);
                    },
                    error: function(data)
                    {
                    }
                });
            }else{
                alert("Select Tax Body");
                $('#tax_body_percentage').val("");
            }
        }

        $(".inventory_items").on('change',function (){
            var id = event.target.value;
            items_list.push(id);
        });
    </script>

@endsection

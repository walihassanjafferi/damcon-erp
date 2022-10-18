@extends('layout.main')
@section('supplierpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Suppliers POS Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('supplierspos.index')}} @endsection
@section('main_btn_text') All Suppliers POS Management @endsection
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
                        <h4 class="card-title">Edit Suppliers Purchase Order</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('supplierspos.update',encrypt($supplier_purchase_order->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Purchase Order Number<span class="red_asterik"></span></label>
                                        <input type="text"  name="purchase_od_number" class="form-control" placeholder="Purchase Order Number" value="{{ $supplier_purchase_order->purchase_od_number }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>GRN Number </label>
                                        <input type="text"  name="grm_number" class="form-control" placeholder="GRM Number" value="{{ $supplier_purchase_order->grm_number }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Type <span class="red_asterik"></span></label>
                                        <select name="type" class="form-control" required>
                                            <option @if($supplier_purchase_order->type == 1){{ 'selected' }}@endif value="1">Services</option>
                                            <option @if($supplier_purchase_order->type == 2){{ 'selected' }}@endif value="2">Parts</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Supplier <span class="red_asterik"></span></label>
                                        {!! Form::select('supplier_id',$supplies+[NULL=>'Select Supplier'],
                                        $supplier_purchase_order->supplier_id, ['class' => 'form-control select2 select_supplier','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Number (optional)</label>
                                        <input type="text"  name="customer_optional_number" class="form-control" placeholder="Customer Optional Number" value="{{ $supplier_purchase_order->customer_optional_number }}"/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Requesting person</label>
                                        <input type="text"  name="requesting_person" class="form-control" placeholder="Requesting person" value="{{ $supplier_purchase_order->requesting_person }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Issue Date</label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="issue_date" class="form-control issue_date form-date" placeholder="Issue Date" value="{{ $supplier_purchase_order->issue_date }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Items Delivery Date</label>
                                        <input type="text" autocomplete="off" tabindex="-1"  name="items_delivery_date" class="form-control items_delivery_date form-date" placeholder="Items Delivery Date" value="{{ $supplier_purchase_order->items_delivery_date }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Payment Terms</label>
                                        <input type="text" autocomplete="off"   name="payment_terms" class="form-control" placeholder="Payment Terms" value="{{ $supplier_purchase_order->payment_terms }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>PR Number</label>
                                        <input type="text" autocomplete="off"   name="pr_number" class="form-control" placeholder="PR Number" value="{{ $supplier_purchase_order->pr_number }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Select Tax Body</label>
                                        {!! Form::select('tax_body_id',$taxbodys+[NULL=>'Select Tax Body'],
                                        $supplier_purchase_order->tax_body_id, ['class' => 'form-control select2 tax_id','required'=>'true','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Taxation Month<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="taxation_month" class="form-control taxation_month_date form-date" placeholder="Taxation Month" value="{{ $supplier_purchase_order->taxation_month }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Tax Body %<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax Body %" value="{{ $supplier_purchase_order->tax_body_percentage }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Withholding tax %<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="sales_tax_wh" class="form-control sales_tax_wh" placeholder="Sales Tax WH" value="{{ $supplier_purchase_order->sales_tax_wh }}" required readonly/>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Tax Deduction 1(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_deduction_1" class="form-control" placeholder="Tax Deduction 1(%)" value="{{ $supplier_purchase_order->tax_deduction_1 }}" required readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Tax Deduction 2(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_deduction_2" class="form-control" placeholder="Tax Deduction 2(%)" value="{{ $supplier_purchase_order->tax_deduction_2 }}" required readonly/>
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

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                @php
                                    $files = json_decode($supplier_purchase_order->document_file)
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/supplier_pos/'.$path) }}"/>

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
                                        <a class="pdf_file" href="{{ asset('/storage/supplier_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>


                                <table class="table variations_table col-12 mt-2" id="items_table">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    @if(!$supplier_items->isEmpty())
                                    @foreach ($supplier_items as $item)
                                        <tr>
                                            <td>
                                                <div class="position-relative form-group">
                                                    <label  class="">Item Name</label>
                                                    <input type="text"  name="item_name[]" value="{{ $item->item }}"  class="form-control"   required readonly/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative form-group ">
                                                    <label for="price" class="required">Item Quantity</label>
                                                    <input name="item_quantity[]" value="{{ $item->qty }}" type="number" class="form-control price" required readonly />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="position-relative form-group ">
                                                    <label for="price" class="required">Item Cost</label>
                                                    <input name="item_cost[]" type="number" value="{{ $item->cost }}" class="form-control price" required readonly/>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <button class="btn btn-secondary delete_variation_row" onclick="delete_item()">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                    @endif
                                    {{-- @if(old('item_name') && old('item_quantity') && old('item_cost'))

                                        @for( $i =0; $i < count(old('item_name')); $i++)
                                            <tr>
                                                <td>
                                                    <div class="position-relative form-group"><label  class="">Item Name OLD</label>
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
                                    @endif --}}
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


                                {{-- <div class="col-12">
                                    <button class="btn btn-secondary add_variation" >
                                        <i data-feather='plus'></i> Add Item
                                    </button>
                                </div> --}}

                                <div class="col-md-12 mb-2 mt-3">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ $supplier_purchase_order->comments }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\SupplierPORequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        var items = "";
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
            var increment = 0;

            $('.add_variation').click(function name(params) {
                event.preventDefault();
                var content = '';
                content +='<tr>';
                content +='<td><div class="position-relative form-group ">';
                content +='<label  class="required">Item Name</label>';
                content +='<input name="item_name[]" type="text" class="form-control price_'+increment+'" required>';
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

        // CKEDITOR.replace('details_input');


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


        // function fetch_tax__body_percentage(){
        //     $id = $(".tax_id option:selected").val();

        //     var type = '';

        //     if($("[name='type']").val() == 1)
        //     {
        //         type = "services";
        //     }

        //     if($id){
        //         $.ajax({
        //             url:'{{ route('get_tax_boby')}}',
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "id":$id,
        //                 "type":type
        //             },
        //             method: 'post',
        //             success: function(data) {
        //                 $('#tax_body_percentage').val(data.message);
                        
        //             },
        //             error: function(data)
        //             {
        //             }
        //         });
        //     }else{
        //         alert("Select Tax Body");
        //         $('#tax_body_percentage').val("");
        //     }
        // }

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

        var remove_images = [];
        $(".remove").click(function(){
            event.preventDefault();
            let img_val =  $(this).attr('href');
            remove_images.push(img_val);
            $('#remove_images').val(remove_images);
            $(this).parent(".pip").remove();
        });
    </script>

@endsection

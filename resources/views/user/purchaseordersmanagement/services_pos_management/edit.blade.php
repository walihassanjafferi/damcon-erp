@extends('layout.main')
@section('servicespos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Services POs Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('servicespos.index')}} @endsection
@section('main_btn_text') All Maintenance Items & Services POs Management  @endsection
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
                        <h4 class="card-title">Update Maintenance Items and Services PO</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('servicespos.update',encrypt($services_order->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Title PO Number<span class="red_asterik"></span></label>
                                        <input type="text"  name="title_po_number" class="form-control" placeholder="Title PO Number" value="{{ $services_order->title_po_number }}" required/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Type <span class="red_asterik"></span></label>
                                        <select name="type" class="form-control" required>
                                            <option @if($services_order->type == 1){{ 'selected' }}@endif value="1">Services</option>
                                            <option @if($services_order->type == 2){{ 'selected' }}@endif value="2">Parts</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>GRN Number <span class="red_asterik"></span></label>
                                        <input type="text"  name="grm_number" class="form-control" placeholder="GRM Number" value="{{ $services_order->grm_number }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Supplier</label>
                                        {!! Form::select('supplier_id',$supplies+[NULL=>'Select Supplier'],
                                        $services_order->supplier_id, ['class' => 'form-control select2 select_supplier','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Requesting Person <span class="red_asterik"></span></label>
                                        <input type="text"  name="requesting_person" class="form-control" placeholder="Requesting Person" value="{{ $services_order->requesting_person }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Number (optional)<span class="red_asterik"></span></label>
                                        <input type="text"  name="customer_po_number" class="form-control" placeholder="Customer PO Number" value="{{ $services_order->customer_po_number }}"/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Delivery Date<span class="red_asterik"></span></label>
                                        <input type="text" tabindex="-1"  name="delivery_date" class="form-control delivery_date form-date" placeholder="Delivery Date" value="{{ $services_order->delivery_date }}" required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Issue Date<span class="red_asterik"></span></label>
                                        <input type="text" tabindex="-1"  name="isseu_date" class="form-control isseu_date form-date" placeholder="Issue Date" value="{{ $services_order->isseu_date }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>PR Number<span class="red_asterik"></span></label>
                                        <input type="text"   name="pr_number" class="form-control" placeholder="PR Number" value="{{ $services_order->pr_number }}" required/>
                                    </div>
                                </div>

                                
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Taxation Month<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="taxation_month" class="form-control taxation_month_date form-date" placeholder="Taxation Month" value="{{ $services_order->taxation_month }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Select Tax Body</label>
                                        {!! Form::select('tax_body_id',$taxbodys+[NULL=>'Select Tax Body'],
                                        $services_order->tax_body_id , ['class' => 'form-control select2 tax_id','required'=>'true','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Tax Body %<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax Body %" value="{{ $services_order->tax_body_percentage }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Sales Tax WH<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="sales_tax_wh" class="form-control sales_tax_wh" placeholder="Sales Tax WH" value="{{ $services_order->sales_tax_wh }}" required/>
                                    </div>
                                </div>



                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier Tax Deduction 1(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="supplier_tax_deduction_1" class="form-control" placeholder="Supplier Tax Deduction 1(%)" value="{{ $services_order->supplier_tax_deduction_1 }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Supplier Tax Deduction 2(%)<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="supplier_tax_deduction_2" class="form-control" placeholder="Supplier Tax Deduction 2(%)" value="{{ $services_order->supplier_tax_deduction_2 }}" required/>
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
                                    @if(!$services_items->isEmpty())
                                        @foreach ($services_items as $item)
                                            <tr>
                                                <td>
                                                    <div class="position-relative form-group">
                                                        <label  class="">Item Name</label>
                                                        <input type="text"  name="item_name[]" value="{{ $item->item }}"  class="form-control"   required/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group ">
                                                        <label for="price" class="required">Item Quantity</label>
                                                        <input name="item_quantity[]" value="{{ $item->qty }}" type="number" class="form-control price" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="position-relative form-group ">
                                                        <label for="price" class="required">Item Cost</label>
                                                        <input name="item_cost[]" type="number" value="{{ $item->cost }}" class="form-control price" required>
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                    <button class="btn btn-secondary delete_variation_row" onclick="delete_item()">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @else    
                                      <div class="col-4">
                                        <p>No Items Found!</p>
                                      </div>
                                    @endif
                                    {{-- @if(old('item_name') && old('item_quantity') && old('item_cost'))

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
                                                        <input name="item_cost[]" type="number" value="{{ old('item_cost.'.$i)}}" class="form-control price" required>
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



                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                @php
                                    $files = json_decode($services_order->document_file)
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/services_pos/'.$path) }}"/>

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
                                        <a class="pdf_file" href="{{ asset('/storage/services_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>


                                <div class="col-md-12 mb-2 mt-3">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ $services_order->comments }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\ServicesPORequest'); !!}
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

            $('.delivery_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.isseu_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
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

        //     var type = '';

        //     if($("[name='type']").val() == 1)
        //     {
        //         type = "services";
        //     }

        //     $id = $(".tax_id option:selected").val();
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
    </script>

@endsection

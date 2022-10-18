@extends('layout.main')
@section('import_sidebar') active @endsection
@section('title')
<title>Import Purchases Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('importpurchases.index')}} @endsection
@section('main_btn_text') All Import Purchases @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Import Purchases</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('importpurchases.update',encrypt($imports->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text"  name="title" class="form-control" placeholder="Title" value="{{ $imports->title }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier Name<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_name" class="form-control" placeholder="Supplier Name"  value="{{ $imports->supplier_name }}" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier NTN number<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_ntn_number" class="form-control" placeholder="Supplier Ntn number"  value="{{ $imports->supplier_ntn_number }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier STRN number<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_strn_number" class="form-control" placeholder="Supplier Strn number"  value="{{ $imports->supplier_strn_number }}"  required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >Invoice no<span class="red_asterik"></span></label>
                                    <input type="text"  name="invoice_no" class="form-control" placeholder="Invoice No"  value="{{ $imports->invoice_no }}" required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_id',[null=>'Select Tax body']+$tax_bodies,
                                    $imports->tax_id, ['class' => 'form-control select2']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" id="taxation_month"  name="taxation_month" class="form-control" placeholder="" value={{ $imports->taxation_month }}  required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax body Percentage<span class="red_asterik"></span></label>
                                    <input type="text" name="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ $imports->tax_body_percentage }}"  required readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date<span class="red_asterik"></span></label>
                                    {!! Form::text('date',  $imports->date, ['class' => 'form-control','required','id'=>'date']) !!}

                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Sending Bank<span class="red_asterik"></span></label>
                                    {!! Form::select('sending_bank',[null=>'Select Bank']+$banks,
                                    $imports->payment_sending_bank, ['class' => 'form-control select2','disabled']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Payment Sending Amount<span class="red_asterik"></span></label>
                                    <input type="text"  name="sending_amount" class="form-control" placeholder="Payment Sending Amount" value="{{ $imports->sending_amount }}" required readonly />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cash Receiving Bank<span class="red_asterik"></span></label>
                                    {!! Form::select('cash_receiving_bank',[null=>'Select Bank']+$banks,
                                    $imports->cash_receiving_bank, ['class' => 'form-control select2','disabled']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cash Receiving Amount<span class="red_asterik"></span></label>
                                    <input type="text"  value="{{ $imports->cash_receiving_amount }}" name="cash_receiving_amount" class="form-control" placeholder="Payment Sending Amount"  required readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                    <input type="text"  name="sales_tax_withheld_at_source_per" class="form-control" placeholder="" value="{{ $imports->sales_tax_withheld_at_source_per }}"  required readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier withheld Tax 1 Deduction Percentage<span class="red_asterik"></span></label>
                                    <input type="text" name="supplier_withheld_tax_1_deduction_per" value="{{ $imports->supplier_withheld_tax_1_deduction_per }}"  class="form-control" placeholder=""  required readonly/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Damcon Gain Percentage<span class="red_asterik"></span></label>
                                    <input type="text"  name="damcon_gain_percentage"  value="{{ $imports->damcon_gain_percentage }}" class="form-control" placeholder=""  required readonly/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $imports->comments }}</textarea>
                                </div>
                            </div>

                           
                               

                           <table class="table variations_table col-12" id="items_table">
                            <thead>
                            </thead>
                            <tbody>
                            @foreach ($imports->purchase_items as $item)    
                            <tr>
                                <td>
                                    <div>
                                        <label  class="">Item Name</label>
                                        <input type="text"  name="item_name[]" value={{ $item->item_name }}  class="form-control"  readonly required/>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label for="price" class="required">Item Quantity</label>
                                        <input name="item_quantity[]" value={{ $item->item_qunatity }} type="number" class="form-control price" readonly required>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label for="price" class="required">Item Cost</label>
                                        <input name="item_cost[]" type="number" value={{ $item->item_cost }} class="form-control price" required readonly>
                                    </div>
                                </td>
                                <td>
                                    {{-- <button class="btn btn-secondary delete_variation_row" onclick="delete_item()">
                                        <i class="fa fa-times"></i>
                                    </button> --}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>  

                        
                        {{-- <div class="col-12">
                            <button class="btn btn-secondary" onclick="add_variation()">
                                <i data-feather='plus'></i> Add Item
                            </button>
                        </div> --}}

                     
                        <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                            <small>**multiple items can be selected</small><br/>
                            <label for="formFileMultiple" class="form-label"><b>File Attachment</b></label>
                            <input class="form-control" type="file" name="images[]" id="file-input" multiple>
                            <small>files supported jpg | jpeg | png</small><br/>
                        </div>
                        <div class="col-12"></div>
                        <input type="text" id="remove_images" name="remove_images" hidden/>
                        @foreach ($images as $path)
                           
                            <span class="pip col-3">
                            <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                             <img class="images_upload" type="file" src="{{ asset('/storage/import_invoices/'.$path) }}"/>
                            </span>
                        @endforeach
                        <div class="col-12" style="margin-bottom: 20px;">
                            <div id="preview" class="gallery col-12"></div>
                        </div>
                           
                          

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
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
{!! JsValidator::formRequest('App\Http\Requests\ImportPurchaseRequest'); !!}

<script>


    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
      //  minDate: today,
        // maxDate: function () {
        //     return $('#project_end_date').val();
        // }
    });

    $('#taxation_month').datepicker({
        format: 'yyyy-mm',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    });

    function previewImages() {

        var preview = document.querySelector('#preview');

        if (this.files) {
            [].forEach.call(this.files, readAndPreview);
        }

        function readAndPreview(file) {

            // Make sure `file.name` matches our extensions criteria
            if (!/\.(jpe?g|png)$/i.test(file.name)) {
                return alert(file.name + " is not an image");
            } // else...
            
            var reader = new FileReader();
            
            reader.addEventListener("load", function() {
                // var image = new Image();
                // image.className = "images_upload col-4"
                // image.title  = file.name;
                // image.src    = this.result;
                // preview.appendChild(image);
                $("<span class=\"pip col-3\">" +
                "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +    
                "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name + "\"/>" +
                "</span>").insertAfter("#preview");
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });


            });
            
            reader.readAsDataURL(file);
                
        }

    }
    document.querySelector('#file-input').addEventListener("change", previewImages);
    var remove_images = [];
    $(".remove").click(function(){
        event.preventDefault();
        var img_val =  $(this).attr('href');
        remove_images.push(img_val);
        $('#remove_images').val(remove_images);
        img_val = ''
        $(this).parent(".pip").remove();
        console.log(remove_images);
     });



    //  repeater fields
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


        // function delete_item(){
        //     alert();
        //     event.preventDefault();
        //     $(this).closest('td').remove();
        // }


</script>
   
@endsection
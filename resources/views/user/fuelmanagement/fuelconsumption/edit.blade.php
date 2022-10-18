@extends('layout.main')
@section('fuel_consumption_sidebar') active @endsection
@section('title')
<title>Damcon ERP -Edit Fuel Consumption</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('fuelconsumption.index')}} @endsection
@section('main_btn_text') All Fuel Cosumptions @endsection
{{-- back btn --}}
@section('css')

@endsection

@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Fuel Consumption</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('fuelconsumption.update',encrypt($fuel_consumption->id))}}"  method="post" class="import_purchases"  enctype="multipart/form-data">
                         @csrf  @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Title PO Number<span class="red_asterik"></span></label>
                                    <input type="text" name="title_po_number" class="form-control" placeholder="Title Po Number" value="{{ $fuel_consumption->title_po_number }}" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Project</label>
                                     {!! Form::select('project_id',[NULL=>'Select Project']+$projects, $fuel_consumption->project_id , ['class' => 'form-control select2 select_project','required'=>'true']) !!}
 
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of entry</label>
                                    <input type="text" name="date_of_entry" value="{{ $fuel_consumption->date_of_entry }}"  class="form-control date_of_entry"  readonly required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Entry Person</label>
                                    <input type="text"  name="entry_person" class="form-control" placeholder="Entry Person"  value="{{ $fuel_consumption->entry_person }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Driver Name</label>
                                    <input type="text"  name="driver_person" class="form-control" placeholder="Driver Person"  value="{{ $fuel_consumption->driver_person }}" required/>
                                </div>
                            </div>


                            
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Item Type<span class="red_asterik"></span></label>
                                    <select class="form-control select2 item_type" name="item_type" required>
                                        <option value="">Select Item type</option>
                                        <option value="fueling" {{ $fuel_consumption->item_type == 'fueling' ? 'selected' : ''}}>Fueling</option>
                                        <option value="other" {{ $fuel_consumption->item_type == 'other' ? 'selected' : ''}}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Asset Type<span class="red_asterik"></span></label>
                                    <select class="form-control select2 asset_type" name="asset_type" >
                                        <option value="">Select Asset type</option>
                                        <option value="damcon" {{ $fuel_consumption->asset_type == 'damcon' ? 'selected' : ''}}>Damcon</option>
                                        <option value="customer" {{  $fuel_consumption->asset_type == 'customer' ? 'selected' : ''}}>Customer</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <label>Select Fueling Item<span class="red_asterik"></span></label>
                                <select class="form-control select2 fueling_item" name="fueling_item_id">
                                    <option value="" selected>Select Fueling Item</option>
                                   
                                </select>
                            </div>


                        {{-- add fuel item --}}

                        <div class="col-md-6 col-12">
                            <label>Select Fueling Item code<span class="red_asterik"></span></label>
                            <select class="form-control select2 fueling_item_code" name="fuel_item_code">
                                <option value="" selected>Select Fueling Item code</option>
                            
                            </select>
                        </div>

                           


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label >Select Supplier</label>
                                     {!! Form::select('supplier_id',$suppliers,$fuel_consumption->supplier_id
                                     , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Consumption Month<span class="red_asterik"></span></label>
                                    <input type="month" name="consumption_month" class="form-control consumption_month" placeholder="Consumption Month" value="{{ $fuel_consumption->consumption_month }}" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quantity in Liters<span class="red_asterik"></span></label>
                                    <input type="number" name="quantity_in_liter" class="form-control quantity_in_liter" placeholder="Quantity in Liters" value="{{ $fuel_consumption->quantity_in_liter }}" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Total Amount with Sales Tax<span class="red_asterik"></span></label>
                                    <input type="number" name="amount_with_sale_tax" class="form-control amount_with_sale_tax" placeholder="Total Amount with Sales Tax" value="{{ $fuel_consumption->amount_with_sale_tax }}" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Rate of Fuel Per Liter (Rs)<span class="red_asterik"></span></label>
                                    <input type="number" name="rate_fuel_per_liter" class="form-control rate_fuel_per_liter" placeholder="Rate of Fuel Per Lite" value="{{ $fuel_consumption->rate_fuel_per_liter }}" required />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Mileage/Hours<span class="red_asterik"></span></label>
                                    <input type="number" name="milage_hours" class="form-control" placeholder="Current Mileage/Hours" value="{{ $fuel_consumption->milage_hours }}" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Oil Filter change Due<span class="red_asterik"></span></label>
                                    <input type="number" name="oil_filter_due_date" class="form-control" placeholder="Oil Filter change Due" value="{{ $fuel_consumption->oil_filter_due_date }}" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_body_id',[null=>'Select Tax body']+$tax_bodies,
                                    $fuel_consumption->tax_body_id, ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" id="taxation_month" name="taxation_month" class="form-control taxation_month" placeholder="" value="{{ $fuel_consumption->taxation_month }}"  readonly />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax body Percentage<span class="red_asterik"></span></label>
                                    <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ $fuel_consumption->tax_body_percentage }}"  readonly/>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $fuel_consumption->comments }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source <span class="red_asterik"></span></label>
                                    <input type="text"  name="sales_tax_withheld_at_source_per" class="form-control" placeholder="" value="{{ $fuel_consumption->sales_tax_withheld_at_source_per }}"  required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier withheld Tax 1 Deduction <span class="red_asterik"></span></label>
                                    <input type="text" name="supplier_withheld_tax_1_deduction_per" value="{{ $fuel_consumption->supplier_withheld_tax_1_deduction_per }}"  class="form-control" placeholder=""  required/>
                                </div>
                            </div>


                            <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                <small>**multiple items can be selected</small><br/>
                                <label for="formFileMultiple" class="form-label">File Attachment</label>
                                <input class="form-control" type="file" name="document_file[]" id="file-input" multiple>
                                <small>files supported jpg | jpeg | png | pdf</small><br/>
                            </div>
                            <input type="text" id="remove_images" name="remove_images" hidden/>
                         
                            @if(isset($files) && count($files))
                                <div class="col-12"></div>
                                <?php $pdf = array(); ?>
                                @foreach ($files as $path) 
                                    @if(!preg_match("/\.(pdf)$/", $path))
                                        <span class="pip col-3">
                                            <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                            <img class="images_upload" type="file" src="{{ asset('/storage/fuel_consumption/'.$path) }}"/>
                                        </span>
                                    @else
                                    <?php array_push($pdf,$path) ?>                                
                                    @endif
                                @endforeach
                            @endif
                              
                            @if(isset($pdf))
                                    <div class="col-12 mt-3" ></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-3 pip">
                                            <a  class="remove" href={{$item}}><i class="fa fa-times"></i></a>
                                            <a class="pdf_file" href="{{ asset('/storage/fuel_consumption/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                        </span>
                                    @endforeach
                            @endif
                            
    
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
{!! JsValidator::formRequest('App\Http\Requests\FuelConsumptionRequest'); !!}

<script>
   
    $(function(){

    var selectetd_project_id = {{ $fuel_consumption->project_id }};
    var selectetd_fuel_item_id = {{ $fuel_consumption->fueling_item_id }};
    var selectetd_fuel_item_code = {{ $fuel_consumption->fuel_item_code }};

    
    // getting fuelitems according to selected project
    
        $.ajax({
            url:'{{ route('get_project_fuel_items')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":selectetd_project_id
            },
            method: 'get',
            success: function(data) {
               
               
                $('.fueling_item').html('');
                
                assets = data.assets;
                fuel_items = data.fuel_items
                customer_assets = data.customer_assets
                
                // fueling item
                $('.fueling_item').append(
                        '<option value="">Select Fueling Items</option>'
                );
                
                $.each(assets,function(key,value) {
                  
                    $('.fueling_item').append(
                        '<option value='+value.id+'>'+value.asset_item_id+' ( '+value.registration_no+' )'+'- Damcon'+'</option>'
                    );
                });

                $.each(customer_assets,function(key,value) {
                    $('.fueling_item').append(
                        '<option value='+value.id+'>'+value.asset_item_id+' ( '+value.registration_number+' )'+'- Customer'+'</option>'
                    );
                });

                // fueling item code

                
                $('.fueling_item_code').html('');

                $('.fueling_item_code').append(
                        '<option value="">Select Fueling Item code</option>'
                );
                
                $.each(fuel_items,function(key,value) {
                  
                    $('.fueling_item_code').append(
                        '<option value='+value.id+'>'+value.item_code+' ( '+value.item_name+' )'+'</option>'
                    );
                });
                
                $('.fueling_item option[value='+selectetd_fuel_item_id+']').attr("selected", "selected").change();  
                $('.fueling_item_code option[value='+selectetd_fuel_item_code+']').attr("selected", "selected").change();  

            },
            error: function(data)
            {    
            
                alert(data.message);
                
            }
        });
         // getting fuelitems according to project
         

        


    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('.date_of_entry').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    
    });

    $('.taxation_month').datepicker({
        format: 'yyyy-mm',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
    
    });


    // $('.consumption_month').datepicker({
    //     format: 'yyyy-mm-dd',
    //     uiLibrary: 'bootstrap4',
    //     iconsLibrary: 'fontawesome',
    
    // });


   
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
    document.querySelector('#file-input').addEventListener("change", previewImages);

    var remove_images = [];
    $(".remove").click(function(){
        event.preventDefault();
        var img_val =  $(this).attr('href');
        remove_images.push(img_val);
        $('#remove_images').val(remove_images);
        img_val = ''
        $(this).parent(".pip").remove();
      
    });

    var items = '';
   $('.select_project').on('change',function(){
        $project_id = $(".select_project option:selected").val();

        $.ajax({
            url:'{{ route('get_project_fuel_items')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":$project_id
            },
            method: 'get',
            success: function(data) {
               
               
                $('.fueling_item').html('');
                
                items = data.data;
                
                // fueling item
                $('.fueling_item').append(
                        '<option value="">Select Fueling Items</option>'
                );
                
                $.each(items,function(key,value) {
                  
                    $('.fueling_item').append(
                        '<option value='+value.id+'>'+value.item_name+'</option>'
                    );
                });

                // fueling item code

                
                $('.fueling_item_code').html('');

                $('.fueling_item_code').append(
                        '<option value="">Select Fueling Item code</option>'
                );
                
                $.each(items,function(key,value) {
                  
                    $('.fueling_item_code').append(
                        '<option value='+value.id+'>'+value.item_code+'</option>'
                    );
                });

                
            },
            error: function(data)
            {    
            
                alert(data.message);
                
            }
        });


   });

   $('.fueling_item').on('change',function(){
        var selected_fuel = $('.fueling_item :selected').val();
        $('.fueling_item_code option[value='+selected_fuel+']').attr("selected", "selected").change();

   });

   $('.quantity_in_liter').on('keyup',function(){
        $quantity_in_liter = $('.quantity_in_liter').val();
        $amount_with_sale_tax = $('.amount_with_sale_tax').val();

        if($quantity_in_liter.length!=0 && $amount_with_sale_tax.length!=0)
        {
            var rate_of_fuel = $amount_with_sale_tax/$quantity_in_liter;

            $('.rate_fuel_per_liter').val(rate_of_fuel);
        }
        else{
            return;
        }
   });

   $('.amount_with_sale_tax').on('keyup',function(){
        $quantity_in_liter = $('.quantity_in_liter').val();
        $amount_with_sale_tax = $('.amount_with_sale_tax').val();

        if($quantity_in_liter.length!=0 && $amount_with_sale_tax.length!=0)
        {
            var rate_of_fuel = $amount_with_sale_tax/$quantity_in_liter;

            $('.rate_fuel_per_liter').val(rate_of_fuel);
        }
        else{
            return;
        }
   });

});



</script>
   
@endsection
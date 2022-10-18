@extends('layout.main')
@section('fuel_consumption_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Fuel Consumption</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('fuelconsumption.index')}} @endsection
@section('main_btn_text') All Fuel Consumptions @endsection
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
                    <h4 class="card-title">Add Fuel Consumption</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('fuelconsumption.store')}}"  method="post" class="import_purchases"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Title PO Number<span class="red_asterik"></span></label>
                                    <input type="text" name="title_po_number" class="form-control" placeholder="Title Po Number" value="{{ old('title_po_number') }}" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Project<span class="red_asterik"></span></label>
                                     {!! Form::select('project_id',[NULL=>'Select Project']+$projects, old('project_id') , ['class' => 'form-control select2 select_project','required'=>'true']) !!}
 
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of entry</span></label>
                                    <input type="text" name="date_of_entry" value="{{ old('date_of_entry') }}"  class="form-control date_of_entry"  readonly required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Entry Person</label>
                                    <input type="text"  name="entry_person" class="form-control" placeholder="Entry Person"  value="{{ old('entry_person') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Driver Name</label>
                                    <input type="text"  name="driver_person" class="form-control" placeholder="Driver Person"  value="{{ old('driver_person') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Item Type<span class="red_asterik"></span></label>
                                    <select class="form-control select2 item_type" name="item_type" required>
                                        <option value="">Select Item type</option>
                                        <option value="fueling" {{old('item_type') == 'fueling' ? 'selected' : ''}}>Fueling</option>
                                        <option value="other" {{old('item_type') == 'other' ? 'selected' : ''}}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Asset Type<span class="red_asterik"></span></label>
                                    <select class="form-control select2 asset_type" name="asset_type" >
                                        <option value="">Select Asset type</option>
                                        <option value="damcon" {{old('asset_type') == 'damcon' ? 'selected' : ''}}>Damcon</option>
                                        <option value="customer" {{old('asset_type') == 'customer' ? 'selected' : ''}}>Customer</option>
                                        <option value="rental" {{old('asset_type') == 'rental' ? 'selected' : ''}}>Rental</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <label>Select Fueling Item<span class="red_asterik"></span></label>
                                <select class="form-control fueling_item" name="fueling_item_id">
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
                                     {!! Form::select('supplier_id',$suppliers,old('supplier_id')
                                     , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div>


                          


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Quantity in Liters<span class="red_asterik"></span></label>
                                    <input type="number" name="quantity_in_liter" class="form-control quantity_in_liter" placeholder="Quantity in Liters" value="{{ old('quantity_in_liter') }}" required />
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Total Amount with Sales Tax<span class="red_asterik"></span></label>
                                    <input type="text" name="amount_with_sale_tax" class="form-control amount_with_sale_tax amount_format" placeholder="Total Amount with Sales Tax" value="{{ old('amount_with_sale_tax') }}" required />
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Rate of Fuel Per Liter (Rs)<span class="red_asterik"></span></label>
                                    <input type="number" name="rate_fuel_per_liter" class="form-control rate_fuel_per_liter" placeholder="Rate of Fuel Per Lite" value="{{ old('rate_fuel_per_liter') }}" required />
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Current Mileage/Hours<span class="red_asterik"></span></label>
                                    <input type="number" name="milage_hours" class="form-control milage_hours" placeholder="Current Mileage/Hours" value="{{ old('milage_hours') }}" required />
                                </div>
                            </div>

                           


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Per Km fuel Consumption<span class="red_asterik"></span></label>
                                    <input type="text" name="per_km_fuel_consumption" class="form-control per_km_fuel_consumption" placeholder="Per Km fuel comsumption" value="{{ old('per_km_fuel_consumption') }}" required />
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Per Km fuel cost<span class="red_asterik"></span></label>
                                    <input type="text" name="per_km_fuel_cost" class="form-control per_km_fuel_cost" placeholder="Per Km fuel cost" value="{{ old('per_km_fuel_cost') }}" required />
                                </div>
                            </div>




                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Consumption Month<span class="red_asterik"></span></label>
                                    <input type="month" name="consumption_month" class="form-control consumption_month" placeholder="Consumption Month" value="{{ old('consumption_month') }}" required />
                                </div>
                            </div>


                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Oil Filter change Due<span class="red_asterik"></span></label> --}}
                                    <input type="number" name="oil_filter_due_date" class="form-control" placeholder="Oil Filter change Due" value="0"  hidden/>
                                {{-- </div>
                            </div> --}}


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_body_id',[null=>'Select Tax body']+$tax_bodies,
                                    old('tax_id'), ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" id="taxation_month" name="taxation_month" class="form-control taxation_month" placeholder="" value="{{ old('taxation_month') }}"  readonly />
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
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text"  name="sales_tax_withheld_at_source_per" class="form-control" placeholder="" value="{{ old('sales_tax_withheld_at_source_per') }}"  required/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Supplier withheld Tax 1 Deduction<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" name="supplier_withheld_tax_1_deduction_per" value="{{ old('supplier_withheld_tax_1_deduction_per') }}"  class="form-control" placeholder=""  required/>
                                    </div>
                                </div>
                            </div>

                            <input type="text" name="asset_total_km" class="asset_total_km" hidden/>


                            {{-- formulas calculation --}}
                            <div class="col-12">
                                <span id="calculatePayment" class="btn btn-primary mb-1" >Calculate Payment &nbsp; <i class='fa fa-calculator'></i>
                                </span>

                                <div  id="calculated_values"  style="display: none;">
                                    <div class="col-12 d-flex flex-wrap mt-1">
                                        <div class="col-4 mb-1"><b>Fuel Amount W/O Tax</b> = <span id="fuel_amout_tax"></span></div> 
                                         <div class="col-4 mb-1"><b>Tax Amount</b>  = <span id="tax_amount"></span></div>
                                         <div class="col-4 mb-1"><b>Total After Deductions</b> = <span id="total_after_deduction"></span></div>
                                         <div class="col-4 mb-1"><b>Mileage/Hours during month </b> = <span id="milage_during_month"></span></div>
                                         <div class="col-4 mb-1"><b>Mileage/Hours per Liter </b> = <span id="milage_per_liter"></span></div>
                                         <div class="col-4 mb-1"><b>Fuel Expense Per Unit</b> = <span id="fuel_expense_unit"></span></div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            {{-- formulas calculation --}}
                            
                            <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                                <small>**multiple items can be selected</small><br/>
                                <label for="formFileMultiple" class="form-label">File Attachment</label>
                                <input class="form-control" type="file" name="document_file[]" id="file-input" multiple>
                                <small>files supported jpg | jpeg | png</small><br/>
                            </div>
    
                            <div class="col-12" style="margin-bottom: 20px;">
                                <div id="preview" class="gallery col-12"></div>
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
{!! JsValidator::formRequest('App\Http\Requests\FuelConsumptionRequest'); !!}

<script>
   
    $(function(){

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
                
                assets = data.assets;

                fuel_items = data.fuel_items
                
                customer_assets = data.customer_assets

                rental_items = data.rental_items;
               
                // fueling item
                $('.fueling_item').append(
                        '<option value="">Select Fueling Items</option>'
                );
                
                $.each(assets,function(key,value) {
                  
                    $('.fueling_item').append(
                        '<option value='+value.id+' data-asset_maintenance_duration="'+value.asset_maintenance_duration+'">'+value.asset_item_id+' ( '+value.registration_no+' )'+'- Damcon'+'</option>'
                    );
                });


                $.each(customer_assets,function(key,value) {
                 
                  $('.fueling_item').append(
                      '<option value='+value.id+'>'+value.asset_item_id+' ( '+value.registration_number+' )'+'- Customer'+'</option>'
                  );
                });

                // rental items

                $.each(rental_items,function(key,value) {
                    
                    $('.fueling_item').append(
                        '<option value='+value.id+'>'+value.rental_id+' ( '+value.rental_name+' )'+'- Rental Items'+'</option>'
                    );
                });

                // fueling item code

                
                $('.fueling_item_code').html('');

                $('.fueling_item_code').append(
                        '<option value="">Select Fueling Item code</option>'
                );
                
                $.each(fuel_items,function(key,value) {

                    $('.fueling_item_code').append(
                        '<option value='+value.id+' data-fuelquantity='+value.current_balance_item+' data-monthlylimit='+value.monthly_limit+'>'+value.item_code+' ( '+value.item_name+' )'+'</option>'
                    );
                });

                
            },
            error: function(data)
            {    
            
                alert(data.message);
                
            }
        });


   });

   var pre_fuel_milage = 0;

   $('.fueling_item').on('change',function(){
    

        var selected_fuel = $('.fueling_item :selected').val();
        var item_type = $('.fueling_item :selected').html();

        item_type = item_type.split("-");

        item_type = item_type[item_type.length-1].replace(/ /g, '').toLowerCase();

        if(selected_fuel != '')
        {
            $('.fueling_item_code option[value='+selected_fuel+']').attr("selected", "selected").change();
        }

        // getting previous milage  
        if(selected_fuel != '')
        {
            $.ajax({
                url:'{{ route('getfuelmilage')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":selected_fuel,
                    "item_type":item_type
                },
                method: 'post',
                success: function(data) {


                    console.log(data.fuel_milage);

                    pre_fuel_milage = data.fuel_milage;

                    
                    
                },
                error: function(data)
                {    
                    alert('Error Occured!');
                    
                }
            });

        }
       

        // getting previous milage
   });


   $('.milage_hours').on('keyup',function(){
        var self = this;
        var value = $(this).val();
        var oil_filter = '';
        var per_km_fuel_consumption = '';
        var per_km_fuel_cost = '';

        var item_type = $('.item_type :selected').val();
        
        // this check is for fueling items only
        if(item_type == 'fueling')
        {
            var asset_maintenance_duration =  Number($('.fueling_item').find(":selected").data('asset_maintenance_duration'));
            if (self.timer)
            clearTimeout(self.timer);


            var milage = Number(value) + Number(pre_fuel_milage);

            $('.asset_total_km').val(milage)
            
            // per km fuel consumption
            per_km_fuel_consumption = Number(value)/Number($('.quantity_in_liter').val());
            $('.per_km_fuel_consumption').val(per_km_fuel_consumption.toFixed(2));
            
            //per km fuel cost

            per_km_fuel_cost = Number($('.amount_with_sale_tax').val().replace(',', ''))/Number(value);

            $('.per_km_fuel_cost').val(per_km_fuel_cost.toFixed(2));



            if(milage >= asset_maintenance_duration)
            {
              oil_filter = "Oil Filter Limit Reached";
            }

            self.timer = setTimeout(function ()
            {


                swal({
                    title: "Milage/Oil details",
                    text: `Current Milage : ${value} KM \n\n Previous Milage : ${pre_fuel_milage} KM  \n\n Driven Milage : ${milage} KM \n\n ${oil_filter}`,
                    closeOnClickOutside: false
                });

            

                self.timer = null;
                
            }, 1000);
        }
      
   })



   $('.quantity_in_liter').on('keyup',function(){
        $quantity_in_liter = $('.quantity_in_liter').val();
        $amount_with_sale_tax = $('.amount_with_sale_tax').val();

        if($quantity_in_liter.length!=0 && $amount_with_sale_tax.length!=0)
        {
            var rate_of_fuel = $amount_with_sale_tax/$quantity_in_liter;

            $('.rate_fuel_per_liter').val(rate_of_fuel.toFixed(2));
        }
        else{
            return;
        }
   });

   $('.amount_with_sale_tax').on('keyup',function(){
        $quantity_in_liter = $('.quantity_in_liter').val();
        $amount_with_sale_tax = $('.amount_with_sale_tax').val().split(",").join("");

        $amount_with_sale_tax = parseFloat($amount_with_sale_tax);

        if($quantity_in_liter.length!=0 && $amount_with_sale_tax.length!=0)
        {
            var rate_of_fuel = $amount_with_sale_tax/$quantity_in_liter;

            $('.rate_fuel_per_liter').val(rate_of_fuel.toFixed(2));
        }
        else{
            return;
        }
   });


   $('.fueling_item_code').change(function(){
       var fuelitem =  $('.fueling_item_code').find(":selected").data('fuelquantity');
       var montlylimit =  $('.fueling_item_code').find(":selected").data('monthlylimit');

        $('.quantity_in_liter').attr('placeholder',fuelitem);

        swal({
            title:"Fuel Item detail", 
            text: `Fuel Quantity : ${fuelitem} liters \n\n Monthly Limit : ${montlylimit} liters`,
            closeOnClickOutside: false

        });


   })




                                        

        // var fuel_amout_tax = 0, tax_amount = 0, total_after_deduction = 0,
        // milage_during_month = 0,milage_per_liter = 0, fuel_expense_unit = 0;

   
        
        $('#calculatePayment').click(function(){
            

            var fuel_amout_tax = 0, tax_amount = 0, total_after_deduction = 0,
        milage_during_month = 0,milage_per_liter = 0, fuel_expense_unit = 0;

          
            // sum of cost
            fuel_amout_tax =  $('.amount_with_sale_tax').val().replaceAll(',', '') / (1+($('#tax_body_percentage').val())/100);
            console.log('Fuel',fuel_amout_tax);
            tax_amount = fuel_amout_tax / ($('#tax_body_percentage').val()/100);
            total_after_deduction = fuel_amout_tax - ($("input[name=sales_tax_withheld_at_source_per]").val()/100) - ($("input[name=supplier_withheld_tax_1_deduction_per]").val()/100)
            milage_during_month = $('.milage_hours').val() - pre_fuel_milage;
            milage_per_liter = $('.milage_hours').val()/ $('.quantity_in_liter').val();
            fuel_expense_unit = $('.rate_fuel_per_liter').val() /milage_per_liter;

            $('#calculated_values').css('display','block');

            $('#fuel_amout_tax').html(fuel_amout_tax.toFixed(2));
            $('#tax_amount').html(tax_amount.toFixed(2));
            $('#total_after_deduction').html(total_after_deduction.toFixed(2));  
            $('#milage_during_month').html(milage_during_month.toFixed(2));  
            $('#milage_per_liter').html(milage_per_liter.toFixed(2));  
            $('#fuel_expense_unit').html(fuel_expense_unit.toFixed(2));  
         


        })



</script>
   
@endsection
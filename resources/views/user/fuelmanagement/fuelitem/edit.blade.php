@extends('layout.main')
@section('fuel_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Edit Fuel Item</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('fuelitem.index')}} @endsection
@section('main_btn_text') All Fuel Items @endsection
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
                    <h4 class="card-title">Edit Fuel Item</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('fuelitem.update',encrypt($fuel_item->id)) }}"  method="post" class="import_purchases">
                        @csrf  @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Item Code<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_code" class="form-control" placeholder="Item Code" value="{{ $fuel_item->item_code }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Item Name<span class="red_asterik"></span></label>
                                    <input type="text"  name="item_name" class="form-control" placeholder="Item Name"  value="{{ $fuel_item->item_name }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Fuel type</label>
                                     <select class="form-control fuel_card_type" name="fuel_type_card" required>
                                        <option value="">Select Fuel Card</option>
                                        <option value="pso_fuel_card" {{$fuel_item->fuel_type_card == 'pso_fuel_card' ? 'selected' : ''}}>PSO Fuel Card</option>
                                        <option value="cash_purchased_fuel" {{$fuel_item->fuel_type_card == 'cash_purchased_fuel' ? 'selected' : ''}}>Cash Purchased Fuel</option>
                                        <option value="customer_fuel" {{$fuel_item->fuel_type_card == 'customer_fuel' ? 'selected' : ''}}>Customer Fuel</option>
                                     </select>
 
                                </div>
                            </div>


                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Project</label>
                                     {!! Form::select('project_id',$projects, $fuel_item->project_id , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div> --}}


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label >Select Supplier</label>
                                     {!! Form::select('supplier_id',$suppliers, $fuel_item->supplier_id
                                     , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div>


                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Balance<span class="red_asterik"></span></label>
                                    <input type="number" name="current_balance_item" class="form-control" placeholder="Current balance item" value="{{ $fuel_item->current_balance_item }}" required readonly/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Stock Cost<span class="red_asterik"></span></label>
                                    <input type="number" name="current_stock_cost" class="form-control" placeholder="Current stock cost" value="{{ $fuel_item->current_stock_cost }}" required readonly/>
                                </div>
                            </div>
                             --}}


                            <div class="col-md-6 col-12 fuel_purchasing_person_name" style="display: none;">
                                <div class="form-group">
                                    <label>Fuel Purchasing Person name<span class="red_asterik"></span></label>
                                    <input type="text"  value="{{ $fuel_item->person_name }}" name="person_name" class="form-control" placeholder="Person name"  />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Fuel Type<span class="red_asterik"></span></label>
                                    <input type="text"  value="{{ $fuel_item->fuel_type }}" name="fuel_type" class="form-control" placeholder="Fuel Type"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>PSO Card Number<span class="red_asterik"></span></label>
                                    <input type="text"  name="fuel_card_no" class="form-control" placeholder="" value="{{ $fuel_item->fuel_card_no }}"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Date of Creation<span class="red_asterik"></span></label>
                                    <input type="text" name="date_of_addition" value="{{ $fuel_item->date_of_addition }}"  class="form-control date_of_addition"  readonly required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Monthly Limit in liters<span class="red_asterik"></span></label>
                                    <input type="text"  name="monthly_limit" class="form-control" placeholder="" value="{{ $fuel_item->monthly_limit }}"  required/>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Monthly Limit in Rupees<span class="red_asterik"></span></label>
                                    <input type="text"  name="monthly_limit_rupees" class="form-control" placeholder="" value="{{ $fuel_item->monthly_limit_rupees }}"  required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Card Issue Date</label>
                                    <input type="text"  name="card_issue_date" class="form-control card_issue_date" placeholder="" value="{{ $fuel_item->card_issue_date }}"  />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Card Expiry Date<span class="red_asterik"></span></label>
                                    <input type="text"  name="card_expiry_date" class="form-control card_expiry_date" placeholder="" value="{{ $fuel_item->card_expiry_date }}" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $fuel_item->comments }}</textarea>
                                </div>
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
        $('.date_of_addition').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });

         // fuel card changes

    $('.fuel_card_type').change(function(){

        var fuel_card_type = $('.fuel_card_type').find(":selected").val();

        if(fuel_card_type=='customer_fuel')
        {
            $('.card_no').hide();
            $('.fuel_purchasing_person_name').show();
            $('.monthly_limit_in_liter').hide();
            $('.monthly_limit_in_rupee').hide();
            $('.card_expiry_date_v').hide();
            $('.card_issue_date_v').hide();

            // remove requried attributes
            // $('.monthly_limit_in_liter input').prop('required',false);
            // $('.monthly_limit_in_rupee input').prop('required',false);
            // $('.card_expiry_date_v input').prop('required',false);
            // $('.card_issue_date_v input').prop('required',false);
            // $('.card_no input').prop('required',false);



        }
        else if(fuel_card_type == 'cash_purchased_fuel'){
            $('.card_no').hide();
            $('.fuel_purchasing_person_name').show();
            $('.monthly_limit_in_liter').hide();
            $('.monthly_limit_in_rupee').hide();
            $('.card_expiry_date_v').hide();
            $('.card_issue_date_v').hide();


            // remove requried attributes
            // $('.monthly_limit_in_liter input').prop('required',false);
            // $('.monthly_limit_in_rupee input').prop('required',false);
            // $('.card_expiry_date_v input').prop('required',false);
            // $('.card_issue_date_v input').prop('required',false);
            // $('.card_no input').prop('required',false);





        }
        else if(fuel_card_type=='pso_fuel_card')
        {
            $('.card_no').show();
            $('.fuel_purchasing_person_name').hide();
            $('.monthly_limit_in_liter').show();
            $('.monthly_limit_in_rupee').show();
            $('.card_expiry_date_v').show();
            $('.card_issue_date_v').show();



        }


    })



    });


</script>
   
@endsection
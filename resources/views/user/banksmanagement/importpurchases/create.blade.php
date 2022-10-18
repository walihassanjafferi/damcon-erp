@extends('layout.main')
@section('import_sidebar') active @endsection
@section('title')
<title>Import Purchases Add</title>
@endsection
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
                    <h4 class="card-title">Add Import Purchases</h4>
                </div>
               
                <div class="card-body">
                    <form action="{{ route('importpurchases.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text"  name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Supplier Name<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_name" class="form-control" placeholder="Supplier Name"  value="{{ old('supplier_name') }}" required/>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Supplier NTN number<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_ntn_number" class="form-control" placeholder="Supplier Ntn number"  value="{{ old('supplier_ntn_number') }}" required/>
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
                            
                            
                            <div class="col-12">
                                <button class="btn btn-secondary" onclick="add_variation()">
                                    <i data-feather='plus'></i> Add Item
                                </button>
                            </div>

                            <div class="col-12 mt-2"></div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Supplier STRN number<span class="red_asterik"></span></label>
                                    <input type="text"  name="supplier_strn_number" class="form-control" placeholder="Supplier Strn number"  value="{{ old('supplier_strn_number') }}"  required/>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Invoice no</label>
                                    <input type="text"  name="invoice_no" class="form-control" placeholder="Invoice No"  value="{{ old('invoice_no') }}" required/>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Tax Body<span class="red_asterik"></span></label>
                                    {!! Form::select('tax_id',[null=>'Select Tax body']+$tax_bodies,
                                    old('tax_id'), ['class' => 'tax_id form-control select2','onchange'=>'fetch_tax__body_percentage()','id'=>'tax_body']) !!}
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Taxation Month<span class="red_asterik"></span></label>
                                    <input type="text" id="taxation_month" name="taxation_month" class="form-control" placeholder="" value="{{ old('taxation_month') }}"  readonly />
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <label>Tax body Percentage<span class="red_asterik"></span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="tax_body_percentage" id="tax_body_percentage" class="form-control" placeholder="Tax body percentage" value="{{ old('tax_body_percentage') }}"  readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Date<span class="red_asterik"></span></label>
                                    {!! Form::text('date',  old('date') , ['class' => 'form-control','required','id'=>'date','readonly']) !!}

                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Payment Sending Bank<span class="red_asterik"></span></label>
                                    <select class="form-control select2" name="sending_bank">
                                        <option value="">Select Sender Bank</option>
                                        @foreach ($banks as $val)
                                            <option value="{{$val->id}}">{{$val->name}}  </option>
                                        @endforeach
                                    </select>

                                    <span class="error-help-block"></span>    
                                </div>
                            </div>

                            


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Cash Receiving Bank<span class="red_asterik"></span></label>
                                    <select class="form-control select2" name="cash_receiving_bank">
                                        <option value="">Select Receiver Bank</option>
                                        @foreach ($banks as $val)
                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-help-block"></span>    
                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text"  name="sales_tax_withheld_at_source_per" class="form-control" placeholder="" value="{{ old('sales_tax_withheld_at_source_per') }}"  required/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <label>Supplier withheld Tax 1 Deduction Percentage<span class="red_asterik"></span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="supplier_withheld_tax_1_deduction_per" value="{{ old('supplier_withheld_tax_1_deduction_per') }}"  class="form-control" placeholder=""  required/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <label>Damcon Gain Percentage<span class="red_asterik"></span></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text"  name="damcon_gain_percentage"  value="{{ old('damcon_gain_percentage') }}" class="form-control" placeholder=""  required/>
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


                            <div class="col-12">
                                <span id="calculatePayment" class="btn btn-primary mb-1" >Calculate Payment &nbsp; <i class='fa fa-calculator'></i>
                                </span>

                                <div  id="calculated_values"  style="display: none;">
                                    <div class="col-12 d-flex flex-wrap">
                                        <div class="col-3 m-1"><b>Sub total</b> = <span id="sub_total"></span></div> &nbsp;
                                         <div class="col-3 m-1"><b>Tax Amount</b>  = <span id="tax_amount"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Total amount</b> = <span id="total_amount"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Sales tax WH at src</b> = <span id="sales_tax_wh"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Supplier wh tax 1 </b> = <span id="supplier_wh_tax_1"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Damcon gain </b> = <span id="damcon_gain"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Supplier gain </b> = <span id="supplier_gain"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Sending amount </b> = <span id="sending_amount"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Receiving amount</b> = <span id="receiving_amount"></span></div>&nbsp;
                                         <div class="col-3 m-1"><b>Transaction expense</b> = <span id="transaction_expense"></span></div>&nbsp;

                                    </div>
                                </div>
                                
                            </div>




                            {{-- extra items --}}
                        {{-- <div class="col-12" >   
                            <div data-repeater-list="items">
                                <div data-repeater-item>
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="itemname">Item</label>
                                                <input type="text" class="form-control" id="item34name" name="item_name" value="{{ old('item_name') }}" aria-describedby="itemname" placeholder="" required />
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="itemcost">Item Quantity</label>
                                                <input type="number" class="form-control" id="itemcost" name="item_qunatity" value="{{ old('item_qunatity') }}" aria-describedby="itemcost" placeholder="" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="itemquantity">Item Cost</label>
                                                <input type="number" class="form-control" id="item_cost" name="item_cost" value="{{ old('item_cost') }}"  aria-describedby="itemquantity" placeholder="" required/>
                                            </div>
                                        </div>

                        

                                        <div class="col-md-2 col-12 mb-50">
                                            <div class="form-group">
                                                <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                    <i data-feather="x" class="mr-25"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            <div class="col-12" style="margin:20px;">
                                @error('item_name')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                                @error('item_qunatity')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                                @error('item_cost')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row mb-50">
                                <div class="col-12">
                                    <button class="btn btn-icon btn-secondary" type="button" data-repeater-create>
                                        <i data-feather="plus" class="mr-25"></i>
                                        <span>Add New</span>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                           {{-- <br/> --}}



                        {{-- <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label>Payment Sending Amount<span class="red_asterik"></span></label>
                                <input type="text"  name="sending_amount" class="form-control amount_format" placeholder="Payment Sending Amount" value="{{ old('sending_amount') }}" required readonly/>
                            </div>
                        </div>



                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label>Cash Receiving Amount<span class="red_asterik"></span></label>
                                <input type="text"  value="{{ old('cash_receiving_amount') }}" name="cash_receiving_amount" class="form-control amount_format" placeholder="Cash Receving Amount"  required readonly/>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4 col-12" style="margin-top: 30px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="cal_sending_receiving">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Calculate Sending / Receiving Amount
                                </label>
                              </div>
                        </div> --}}


                        <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                            <small>**multiple items can be selected</small><br/>
                            <label for="formFileMultiple" class="form-label">File Attachment</label>
                            <input class="form-control" type="file" name="images[]" id="file-input" multiple>
                            <small>files supported jpg | jpeg | png</small><br/>
                        </div>

                        <div class="col-12" style="margin-bottom: 20px;">
                            <div id="preview" class="gallery col-12"></div>
                        </div>
                           
                          

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            {{-- <button type="reset" class="btn btn-outline-secondary">Reset</button> --}}
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
<script type="text/javascript" src="{{ asset('js/imageupload.js')}}"></script>

{{-- <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script> --}}


<script>
   
// $(function () {
//   'use strict';

//   // form repeater jquery
//   $('.import_purchases, .repeater-default').repeater({
//             show: function () {
//             $(this).slideDown();
//             // Feather Icons
//             if (feather) {
//                 feather.replace({ width: 14, height: 14 });
//             }
//             },
//             hide: function (deleteElement) {
//             if (confirm('Are you sure you want to delete this element?')) {
//                 $(this).slideUp(deleteElement);
//             }
//             }
//         });
//     });

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        //minDate: today,
        // maxDate: function () {
        //     return $('#project_end_date').val();
        // }
    });

    $('#taxation_month').datepicker({
        format: 'yyyy-mm',
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
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


        // $('#cal_sending_receiving').change(function(){
        //     if($("#cal_sending_receiving").is(':checked'))
        //     {

        //         var item_name = $("[name='item_name[]']");
        //         var item_quantity = $("[name='item_quantity[]']");
        //         var item_costs = $("[name='item_cost[]");
        //         var item_costs_quan = [],item_costs_quan_sum = 0,total_amount = 0, supplier_wh_tax_1 = 0,
        //         damcon_gain = 0; sending_amount = 0, receiving_amount = 0,tax_amount = 0,total_amount = 0,
        //         supplier_wh_tax_per = 0;

        //         item_name.each(function(key){
        //             // console.log('q Index',item_quantity[key].value);
        //             // console.log('P Index',item_costs[key].value);

        //            var item_cost = (Number(item_quantity[key].value) * Number(item_costs[key].value));
        //             item_costs_quan.push(item_cost);
        //         })



        //         for(var i=0 ; i< item_costs_quan.length; i++)
        //         {
        //             //sub total
        //             item_costs_quan_sum += Number(item_costs_quan[i]);
        //         }

        //         var tax_percentage = $('#tax_body_percentage').val();

        //         // supplier wh tax 1
        //         supplier_wh_tax_per = $("[name='supplier_withheld_tax_1_deduction_per']").val();

        //         console.log('supplier_wh_tax_per ',supplier_wh_tax_per);

        //         tax_percentage = Number(tax_percentage) / 100;

        //         console.log('Sub total ',item_costs_quan_sum);

        //         console.log('tax percentage ',tax_percentage);


        //         tax_amount = item_costs_quan_sum * tax_percentage;

        //         console.log('tax amount ',tax_amount);

        //         total_amount = item_costs_quan_sum + tax_amount;

        //         console.log('total amount ',total_amount);

        //         var damcon_gain_per =  $("input[name=damcon_gain_percentage]").val() / 100;  
        //         var damcon_gain = item_costs_quan_sum * damcon_gain_per;

        //         supplier_wh_tax_1 = total_amount * (supplier_wh_tax_per/100);

        //         console.log('supplier_wh_tax_1 ',supplier_wh_tax_1)

        //         var supplier_gain = tax_amount - supplier_wh_tax_1 - damcon_gain;

        //         sending_amount = total_amount - supplier_wh_tax_1;

        //         receiving_amount = sending_amount - supplier_gain;


        //         $("input[name='sending_amount']").val(sending_amount)

        //         $("input[name='cash_receiving_amount']").val(receiving_amount)


        //         console.log('Sending amount',sending_amount);

        //         console.log('Receiving amount',receiving_amount);

        //     }
        // });


        $(function(){
        
            $('#calculatePayment').click(function(){


                var $name = [], $cost = [], $quantity = []; $total_items_cost = [];
                var item_costs_quan = [];sub_total = 0; tax_amount = 0; total_amount = 0;
                sales_tax_wh_at_src = 0; supplier_wh_tax_1 = 0; total_after_deduction = 0; sending_amount = 0; damcon_gain = 0; supplier_gain = 0;
                receiving_amount = 0; transaction_expenses = 0;

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

                var sum_cost = item_costs_quan.reduce(function(a, b){
                    return a + b;
                }, 0);



                sub_total = sum_cost;
                tax_amount = sub_total * ($("input[name=tax_body_percentage]").val()/100);
                total_amount = sub_total + tax_amount;
                sales_tax_wh_at_src = tax_amount * ($("input[name=sales_tax_withheld_at_source_per]").val()/100);
                supplier_wh_tax_1 = total_amount * ($("input[name=supplier_withheld_tax_1_deduction_per]").val()/100);
                damcon_gain = sub_total * ($("input[name=damcon_gain_percentage]").val()/100);
                supplier_gain = tax_amount - supplier_wh_tax_1 - damcon_gain;
                sending_amount = total_amount - supplier_wh_tax_1;
               // console.log(total_amount,sending_amount);
                receiving_amount = sending_amount - supplier_gain;
                transaction_expenses = (sending_amount - receiving_amount) + supplier_gain;


              
                
                $('#calculated_values').css('display','block');

                $('#sub_total').html(sub_total.toFixed(2));
                $('#tax_amount').html(tax_amount.toFixed(2));  
                $('#total_amount').html(total_amount.toFixed(2));  
                $('#sales_tax_wh').html(sales_tax_wh_at_src.toFixed(2));  
                $('#supplier_wh_tax_1').html(supplier_wh_tax_1.toFixed(2));  
                $('#damcon_gain').html(damcon_gain.toFixed(2));  
                $('#supplier_gain').html(supplier_gain.toFixed(2));  
                $('#sending_amount').html(sending_amount.toFixed(2));  
                $('#receiving_amount').html(receiving_amount.toFixed(2));  
                $('#transaction_expense').html(transaction_expenses.toFixed(2));  





            });

        })

</script>
   
@endsection
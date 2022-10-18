@extends('layout.main')
@section('uninvoiced-receiveables-sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Customer Un-invoice Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('uninvoicedreceivables.index')}} @endsection
@section('main_btn_text') All Un-Invoiced Receivables Management @endsection
{{-- back btn --}}
@section('css')
<style>

#exampleModal table tr td {
    padding: 5px;   
}

</style>
@endsection

@section('content')
@include('alert.alert')
    <div class="col-12">

        <div class="row">
            @if (!$uninvoiced->converted_to_invoice)
                <div class="col-12 d-flex justify-content-end mb-1">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Convert to Invoice</button>
                </div>
            @endif
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <h3>{{ $uninvoiced->title }}</h3>
                        <br />
                        <div class="customer_details">
                            <label>Date</label>
                            <span>{{ date('d-M-y', strtotime($uninvoiced->date)) }}</span>
                        </div>
                        
                        <div class="customer_details">
                            <label>Project</label>
                            <span>{{ $uninvoiced->project->name }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Month</label>
                            <span>{{ date('d-M-y', strtotime($uninvoiced->month))  }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Region</label>
                            <span>{{ $uninvoiced->region }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Estimated QTY</label>
                            <span>{{ $uninvoiced->estimated_qty }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Estimated Unit Price</label>
                            <span>{{ number_format($uninvoiced->estimated_unit_price) }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Sales tax Percentage</label>
                            <span>{{ $uninvoiced->sales_tax_percentage }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Tax Body </label>
                            <span>{{ isset($uninvoiced->taxBody->name) ?? $uninvoiced->taxBody->name  }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Tax body %</label>
                            <span>{{ $uninvoiced->tax_body_percentage }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Sales Tax WH at Source Percentage</label>
                            <span>{{ $uninvoiced->sales_tax_source_percentage }} </span>
                        </div>
                        <div class="customer_details">
                            <label>WH Tax Percentage</label>
                            <span>{{ $uninvoiced->withhold_tax_percentage }} </span>
                        </div>

                        
               

                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body import_purchase_top">
                        <div class="import_purchase_details_no">
                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Subtotal Amount</h5>
                                </span>
                                <h4>PKR {{ number_format($subbtotal) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Tax Amount</h5>
                                </span>
                                <h4>PKR {{ number_format($taxamount) }}</h4>
                            </div>
                            <hr />


                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Total Amount</h5>
                                </span>
                                <h4>PKR {{ number_format($totalamount) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Sales Tax WH at Source Percentage</h5>
                                </span>
                                <h4>PKR {{ number_format($sales_tax_wh_source) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0"> WH Tax 1</h5>
                                </span>
                                <h4>PKR {{ number_format($wh_tax_1) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Customer Cheque</h5>
                                </span>
                                <h4>PKR {{ number_format($customer_cheque) }}</h4>
                            </div>
                            <hr />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mr-2 mb-1">
                            <label style="padding-right: 10px;" ><b>Reason of Invoicing</b></label>
                                <span class="comment more">{{ $uninvoiced->reason_of_uninvoicing }}</span>
                        </div>
                       
                        <div class="mr-2 mb-1">
                            <label style="padding-right: 10px;"><b>Tax Type Comments</b></label>
                                <span class="comment more">{{ $uninvoiced->tax_type_comment }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label style="padding-right: 10px;"><b>WH Tax Comments</b></label>
                                <span class="comment more">{{ $uninvoiced->wh_type_comments }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label style="padding-right: 10px;"><b>Comments</b></label>
                                <span class="comment more">{{ $uninvoiced->comments }}</span>
                        </div>
                    </div>
                </div>
            </div>


           

            @php $files = json_decode($uninvoiced->document_file) @endphp

            <div class="col-12">
                <h6 class="mb-1"><i data-feather='link'></i> Attachment of Sales Tax Invoice</h6>
        
              @if(isset($files) && count($files))
                  <div class="col-12"></div>
                  @php $pdf = array(); @endphp
                  @foreach ($files as $path)
                      @if(!preg_match("/\.(pdf)$/", $path))
                        <span class="pip col-3 m-1">
                            <a  download="download" href={{ asset('/storage/customerUn-Invoice/'.$path) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                            <img class="images_upload" type="file" src="{{ asset('/storage/customerUn-Invoice/'.$path) }}"/>
                        </span>
                      @else
                          @php array_push($pdf,$path) @endphp
                      @endif
                  @endforeach
             
           
                @if(isset($pdf))
                    <div class="col-12 mt-3" ></div>
                    @foreach ($pdf as $item)
                        <span class="col-4 pip">
                        <a  download="download" href={{ asset('/storage/customerUn-Invoice/PDF/'.$item) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                        <a class="pdf_file" href="{{ asset('/storage/customerUn-Invoice/PDF/'.$item) }}" target="_blank">{{$item}}</a>
                    </span>
                    @endforeach
                @endif

                @else
                <p>No Attachment's Found!</p>
              @endif
            </div>


            <div class="col-12">
                {{-- <a class="btn btn-danger mb-1" onclick="deleteImport({{ $cvm->id }})"
                    style="float:right;margin-left:10px;">Delete</i>
                </a> --}}
                <a class="btn btn-primary mb-1" href="{{ route('uninvoicedreceivables.edit', encrypt($uninvoiced->id)) }}"
                    style="float:right;">Edit</a>
            </div>

        </div>

        {{-- convert to invoice Modal --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Convert to Invoice</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            
                <form action="{{ route('convertToInvoice')}}"  method="post" >
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Invoice Number<span class="red_asterik"></span></label>
                                    <input type="text"  name="invoice_number" class="form-control" placeholder="Invoice Number"  value="{{ old('invoice_number') }}" required/>
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
                                    <label>Project<span class="red_asterik"></span></label>
                                    <input type="text" name="project_name" class="form-control project_name" placeholder="Project Name"  value="{{ old('project_name') }}" readonly />
                                    <input type="hidden" name="project_id" class="project_id" >
    
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
                                    <input type="text" name="customer_name" class="form-control customer_name" placeholder="Customer Name"  value="{{ old('customer_name') }}" />
                                    <input type="hidden" name="customer_id" class="customer_id" >
    
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Sales Tax Withheld at Source Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="number" name="sales_tax_source_percentage" class="form-control" placeholder="Sales Tax Withheld at Source Percentage" value="{{ old('sales_tax_source_percentage') }}" />
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

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Penalty Deduction Amount Before Tax</label>
                                    <input type="number" name="penality_deduction_amount" class="form-control" placeholder="Penalty Deduction Amount Before Tax" value="{{ old('penality_deduction_amount') }}" />
                                </div>
                            </div>

                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Detail of Invoice<span class="red_asterik"></span></label>
                                <textarea name="detail_of_invoice"  class="form-control" rows="3"  required>{{ old('detail_of_invoice') }}</textarea>
                            </div>
                        </div>  
                        
                        <input type="text" name="uninvoiced_id" value="{{$uninvoiced->id}}" hidden/>


                        <div class="col-12">
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
                                    <i data-feather='plus'></i>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        {{-- convert to invouce modal --}}
    </div>

@endsection

@section('scripts')
    <script>
        function deleteImport(id) {
            var id = id;
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Import Purchase",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url: '{{ route('importpurchases.destroy', 'id') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('importpurchases.index') }}";

                                document.location.href = url;
                            },
                            error: function(data) {
                                alert('Error Failed');

                            }
                        });
                    }
                });

        }

        var table = $('.items_table').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: "Customer Invoice Items",
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    },
                    filename: "Customer invoice Data",
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Customer Invoice Items',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    },
                    filename: "Customer invoice Data",
                }
            ],
        });


        $(document).ready(function() {
            var showChar = 200;
            var ellipsestext = "...";
            var moretext = "more";
            var lesstext = "less";
            $('.more').each(function() {
                var content = $(this).html();

                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar - 1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext +
                        '&nbsp;</span><span class="morecontent"><span>' + h +
                        '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function() {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });


            // customer PO

            var customer_po = {!! json_encode($customer_po) !!} 

            var customer = {!! json_encode($customer) !!}


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
                content +='<td class="text-center"><button class="btn btn-secondary delete_variation_row" style="margin-top:6px;" onclick="delete_item()">';
                content +='<i class="fa fa-times"></i>';
                content +='</button></td>';
                content +='</tr>';

                $('#items_table tr:last').after(content);

            }

            $("#items_table").on('click', '.delete_variation_row', function () {
                event.preventDefault();
                $(this).closest('tr').remove();
            });
    </script>
@endsection
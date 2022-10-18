@extends('layout.main')
@section('import_sidebar') active @endsection
@section('title')
<title>Damcon ERP -  View Import Purchase</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('importpurchases.index')}} @endsection
@section('main_btn_text') All Import Purchases @endsection
{{-- back btn --}}
@section('content')
    
    <div class="col-12">
        
        <div class="row">
                <div class="col-6">
                    <div class="card mb-1">
                        <div class="card-body">
                        
                            <h3>{{$imports->title}}</h3>
                            <br/>
                            <div class="customer_details">
                                <label>Invoice No</label>
                                <span>{{$imports->invoice_no}}</span>
                            </div> 
                            <div class="customer_details">
                                <label>Supplier Name</label>
                                <span>{{ucfirst($imports->supplier_name)}}</span>
                            </div>  
                            <div class="customer_details">
                                <label>Supplier NTN</label>
                                <span>{{$imports->supplier_ntn_number}}</span>
                            </div>  
                            <div class="customer_details">
                                <label>Supplier STRN</label>
                                <span>{{ $imports->supplier_strn_number}} </span>
                            </div>  
                           
                            <div class="customer_details">
                                <label>Payment S-Bank</label>
                                <span>{{ $imports->senderBank->name }} </span>
                            </div> 
                            <div class="customer_details">
                                <label>Sending Amount (PKR)</label>
                                <span> {{ number_format($imports->sending_amount) }} </span>
                            </div> 
                            <div class="customer_details">
                                <label>Cash R-Bank</label>
                                <span>{{ $imports->receiverBank->name }} </span>
                            </div>  
                            <div class="customer_details">
                                <label>Receiving Amount</label>
                                <span>PKR {{ number_format($imports->cash_receiving_amount) }} </span>
                            </div> 
                            <div class="customer_details">
                                <label>Tax Body</label>
                                <span>{{ $imports->taxBody->name }} </span>
                            </div> 
                            <div class="customer_details">
                                <label>Tax body %</label>
                                <span>{{ $imports->tax_body_percentage}} </span>
                            </div>
                            <div class="customer_details">
                                <label>Taxation month</label>
                                <span>{{ date('M-Y',strtotime($imports->taxation_month))}} </span>
                            </div>

                            <div class="customer_details">
                                <label>Sales Tax Withheld at Source Percentage (%)</label>
                                <span>{{ $imports->sales_tax_withheld_at_source_per }} </span>
                            </div>


                            <div class="customer_details">
                                <label>Supplier withheld Tax 1 Deduction Percentage (%)</label>
                                <span>{{ $imports->supplier_withheld_tax_1_deduction_per }} </span>
                            </div>


                            <div class="customer_details">
                                <label>Damcon Gain Percentage (%)</label>
                                <span>{{ $imports->damcon_gain_percentage }} </span>
                            </div>



                            <div class="customer_details">
                                <label>Date</label>
                                <span>{{ date('d-M-Y',strtotime($imports->date))}} </span>
                            </div>
                            <div class="customer_details">
                                <label>Comments</label>
                                <span>{{ $imports->comments}} </span>
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
                                 <h4>PKR {{number_format($sub_total_amount)}}</h4>
                            </div><hr/>
                          
                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0">Tax Amount</h5> 
                            </span>
                            <h4>PKR {{number_format($tax_amount)}}</h4>
                            </div><hr/>
                        
                            
                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0">Total Amount</h5> 
                            </span>
                            <h4>PKR {{number_format($total_amount)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0">Sales Tax WH at Source</h5> 
                            </span>
                            <h4>PKR {{number_format($sales_tax_withheld_at_source_per)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0"> Supplier WH Tax 1</h5> 
                            </span>
                            <h4>PKR {{number_format($supplier_withheld_tax_1_deduction_per)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0">Damcon Gain</h5> 
                            </span>
                            <h4>PKR {{number_format($damcon_gain_percentage)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                            <span>
                                <h5 class="pb-0 mb-0">Supplier Gain</h5> 
                            </span>
                            <h4>PKR {{number_format($supplier_gain)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Sending Amount</h5> 
                                </span>
                                <h4>PKR {{number_format($sending_amount)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Receiving Amount</h5> 
                                </span>
                                <h4>PKR {{number_format($receiving_amount)}}</h4>
                            </div><hr/>

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Transaction Expense</h5> 
                                </span>
                                <h4>PKR {{number_format($transaction_expense)}}</h4>
                            </div>
                             
                          
                             
                        </div>  
                    </div>
                </div>
            </div>
           
        
        <div class="col-12">
            <div class="card p-2">
                <div class="row">
                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Items Details</label>
                
                    <?php $increment = 1; ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Item Cost</th>
                                    <th>Total</th>
                                    <th>Tax Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imports->purchase_items as $item)
                                <tr>
                                    <td>{{$increment}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>{{$item->item_qunatity}}</td>
                                    <td>{{ number_format($item->item_cost) }} </td>
                                    <td>{{ number_format($item->item_qunatity*$item->item_cost) }} </td>
                                    <td>{{  number_format(($item->item_qunatity*$item->item_cost) * $tax_body_percentage)  }}</td>
                                </tr>
                                <?php $increment++; ?>
                                @endforeach   
                            </tbody>

                            <tfoot>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td> {{number_format($sub_total_amount)}}</td>
                                  <td> {{number_format($tax_amount)}}</td>

                                </tr>
                              </tfoot>
                        </table>
                    </div>
                </div>
            </div>  
        </div>  
          



        @php $files = $images @endphp

        <div class="col-12">
            <h6 class="mb-1"><i data-feather='link'></i> Attachment's</h6>

            @if (isset($files) && count($files))
                <div class="col-12"></div>
                @php $pdf = array(); @endphp
                @foreach ($files as $path)
                    @if (!preg_match("/\.(pdf)$/", $path))
                        <span class="pip col-3 m-1">
                            <a download="download" href={{ asset('/storage/import_purchases/' . $path) }}
                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                            <img class="images_upload" type="file"
                                src="{{ asset('/storage/import_purchases/' . $path) }}" />
                        </span>
                    @else
                        @php array_push($pdf,$path) @endphp
                    @endif
                @endforeach


                @if (isset($pdf))
                    <div class="col-12 mt-3"></div>
                    @foreach ($pdf as $item)
                        <span class="col-4 pip">
                            <a download="download" href={{ asset('/storage/import_purchases/PDF/' . $item) }}
                                class="img_pdf_download"><i class="fa fa-download"></i></a>
                            <a class="pdf_file" href="{{ asset('/storage/import_purchases/PDF/' . $item) }}"
                                target="_blank">{{ $item }}</a>
                        </span>
                    @endforeach
                @endif

            @else
                <p>No Attachment's Found!</p>
            @endif
        </div>
  

        <div class="col-12">
            <a class="btn btn-danger mb-1" onclick="deleteImport({{$imports->id}})"
                    style="float:right;margin-left:10px;">Delete</i>
            </a>
            <a class="btn btn-primary mb-1" href="{{route('importpurchases.edit',encrypt($imports->id))}}" style="float:right;">Edit</a>
        </div>
            
    </div>
</div>

@endsection

@section('scripts')
    <script>
         function deleteImport(id){
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
                        url:'{{route('importpurchases.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });

                                let url = "{{ route('importpurchases.index') }}";
                              
                                document.location.href=url;                    
                        },
                        error: function(data)
                        {
                             alert('Error Failed');
                                
                        }
                    }); 
                }   
            });   
           
        }


      
    </script>
@endsection
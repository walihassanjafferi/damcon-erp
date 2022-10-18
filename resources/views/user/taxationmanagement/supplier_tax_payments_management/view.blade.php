@extends('layout.main')
@section('supplier_tax_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Supplier Tax Payments Management List</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('sales_tax_return_management.index') }} @endsection
@section('main_btn_text') All Supplier Tax Payment Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Date</label>
                            <span>{{ date('d-M-y', strtotime($supplier_tax_payment_management->date)) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Supplier Name</label>
                            <span>{{$supplier_tax_payment_management->suppliers->name }}</span>
                        </div>
                        

                        <div class="customer_details">
                            <label>Payable tax</label>
                            <span>PKR {{ number_format($supplier_tax_payment_management->payable_tax) }}</span>
                        </div>
                    
    
                        
                        <div class="customer_details">
                            <label>Manual Adjustments</label>
                            <span>PKR {{ number_format($supplier_tax_payment_management->manual_adjustments) }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Final Amount</label>
                            <span>PKR {{ number_format($supplier_tax_payment_management->final_amount) }} </span>
                        </div>

                    
                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Payment Method</label>
                            <span> {{ $supplier_tax_payment_management->payment_method }} </span>
                        </div>

                        @if($supplier_tax_payment_management->bank)
                            <div class="customer_details">
                                <label>Bank Name</label>
                                <span>{{ $supplier_tax_payment_management->bank->name }}</span>
                            </div>

                            <div class="customer_details">
                                <label>Cheque Title</label>
                                <span>{{ $supplier_tax_payment_management->cheque_title }}</span>
                            </div>

                            <div class="customer_details">
                                <label>Cheque Number</label>
                                <span>{{ $supplier_tax_payment_management->cheque_number }}</span>
                            </div>
                        @endif

                
                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mr-2 mb-1">
                            <label class="pr-1"><b>Manual Adjustment Comments</b></label>
                            <span
                                class="comment more">{{ $supplier_tax_payment_management->manual_adjustment_comments }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label class="pr-1"><b>Payment Details</b></label>
                            <span class="comment more">{{ $supplier_tax_payment_management->payment_details }}</span>
                        </div>

                        <div class="mr-2 mb-1">
                            <label class="pr-1"><b>Comments</b></label>
                            <span class="comment more">{{ $supplier_tax_payment_management->comments }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6"
                            style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Supplier Tax Payment Ledger</label>

                        <?php $increment = 1; ?>
                        <div class="table-responsive p-3">
                            <table class="table table-striped items_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Payment title</th>
                                        <th>Tax ledger Amount</th>
            
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier_tax_payment_ledger as $item)
                                        <tr>
                                            <td>{{ $increment }}</td>
                                            <td>{{ ucfirst($item->payment_title) }}</td>
                                            <td>PKR {{ $item->tax_ledger_amount }} </td>
                                        </tr>
                                        <?php $increment++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            @php $files = json_decode($supplier_tax_payment_management->document_file) @endphp

            <div class="col-12">
                <h6 class="mb-1"><i data-feather='link'></i> Attachment's</h6>

                @if (isset($files) && count($files))
                    <div class="col-12"></div>
                    @php $pdf = array(); @endphp
                    @foreach ($files as $path)
                        @if (!preg_match("/\.(pdf)$/", $path))
                            <span class="pip col-3">
                                <a download="download" href={{ asset('/storage/supplier_tax_payments/' . $path) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <img class="images_upload" type="file"
                                    src="{{ asset('/storage/supplier_tax_payments/' . $path) }}" />
                            </span>
                        @else
                            @php array_push($pdf,$path) @endphp
                        @endif
                    @endforeach


                    @if (isset($pdf))
                        <div class="col-12 mt-3"></div>
                        @foreach ($pdf as $item)
                            <span class="col-3 pip">
                                <a download="download" href={{ asset('/storage/supplier_tax_payments/PDF/' . $item) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <a class="pdf_file" href="{{ asset('/storage/supplier_tax_payments/PDF/' . $item) }}"
                                    target="_blank">{{ $item }}</a>
                            </span>
                        @endforeach
                    @endif

                @else
                    <p>No Attachment's Found!</p>
                @endif



                <div class="col-12">
                    {{-- <a class="btn btn-danger mb-1" onclick="deleteImport({{ $cvm->id }})"
                    style="float:right;margin-left:10px;">Delete</i>
                </a> --}}
                    {{-- <a class="btn btn-primary mb-1" href="{{ route('customerinvoice.edit', encrypt($cvm->id)) }}"
                        style="float:right;">Edit</a> --}}
                </div>

            </div>
        </div>

    @endsection

    @section('scripts')
        <script>
          
          


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
            });
        </script>
    @endsection

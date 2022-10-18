@extends('layout.main')
@section('customer_invoice_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Customer Invoice Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('customerinvoice.index') }} @endsection
@section('main_btn_text') All Customer Invoice Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <h3>{{ $cvm->title }}</h3>
                        <br />
                        <div class="customer_details">
                            <label>Invoice No</label>
                            <span>{{ $cvm->invoice_number }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Date of Invoicing</label>
                            <span>{{ date('d-M-y', strtotime($cvm->date_of_invoicing)) }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Customer PO</label>
                            <span>{{ $cvm->customerPO->customer_po_number }}</span>
                        </div>
                        <div class="customer_details">
                            <label>PO Balance</label>
                            <span>{{ $cvm->po_balance }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Customer Name</label>
                            <span>{{ $cvm->customer_name }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Invoice Month</label>
                            <span>{{ date('d-M-y', strtotime($cvm->invoice_month)) }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Region</label>
                            <span>{{ $cvm->region }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Tax ID</label>
                            <span>{{ $cvm->taxBody->name }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Tax Month </label>
                            <span>{{ date('d-M-y', strtotime($cvm->taxation_month)) }} </span>
                        </div>
                        <div class="customer_details">
                            <label>Tax body %</label>
                            <span>{{ $cvm->tax_body_percentage }} </span>
                        </div>
                        {{-- <div class="customer_details">
                            <label>Taxation month</label>
                            <span>{{ date('M-Y', strtotime($cvm->taxation_month)) }} </span>
                        </div> --}}
                        <div class="customer_details">
                            <label>Penality Deduction Amount</label>
                            <span>{{ $cvm->penality_deduction_amount }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Type</label>
                            <span>{{ $cvm->type == 1 ? 'Services' : 'Parts' }} </span>
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
                                <h4>PKR {{ number_format($sub_total_amount) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Before Tax Total</h5>
                                </span>
                                <h4>PKR {{ number_format($before_tax_total) }}</h4>
                            </div>
                            <hr />


                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Tax Amount</h5>
                                </span>
                                <h4>PKR {{ number_format($tax_amount) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Total Amount</h5>
                                </span>
                                <h4>PKR {{ number_format($total_amount) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0"> Sales_tax_wh_at_source</h5>
                                </span>
                                <h4>PKR {{ number_format($sales_tax_wh_at_source) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">After Tax Total</h5>
                                </span>
                                <h4>PKR {{ number_format($after_tax_total) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">WH Tax 1</h5>
                                </span>
                                <h4>PKR {{ number_format($wh_tax_1) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">WH Tax 2</h5>
                                </span>
                                <h4>PKR {{ number_format($wh_tax_2) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Total After Deductions</h5>
                                </span>
                                <h4>PKR {{ number_format($total_after_deductions) }}</h4>
                            </div>
                            <hr />

                            <div class="import_formuals">
                                <span>
                                    <h5 class="pb-0 mb-0">Net Income</h5>
                                </span>
                                <h4>PKR {{ number_format($net_income) }}</h4>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mr-2 mb-1">
                            <label><b>Detail of Invoice</b></label>
                            <span class="comment more">{{ $cvm->detail_of_invoice }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label><b>Tax Body Description</b></label>
                            <span class="comment more">{{ $cvm->tax_body_description }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label><b>Tax Type Comments</b></label>
                            <span class="comment more">{{ $cvm->tax_type_comments }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label><b>Penality Deduction Comment</b></label>
                            <span class="comment more">{{ $cvm->penality_deduction_comment }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label><b>Comments</b></label>
                            <span class="comment more">{{ $cvm->comments }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="row p-1">
                        <label class="col-6"
                            style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Items Details</label>

                        <?php $increment = 1; ?>
                        <div class="table-responsive p-2">
                            <table class="table table-striped items_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Item Quantity</th>
                                        <th>Item Cost</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cvm->items as $item)
                                        <tr>
                                            <td>{{ $increment }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->item_cost }}</td>
                                            <td>Rs. {{ $item->item_qunatity }} </td>
                                            <td>Rs. {{ $item->item_qunatity * $item->item_cost }} </td>
                                        </tr>
                                        <?php $increment++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            @php $files = json_decode($cvm->document_file) @endphp

            <div class="col-12">
                <h6 class="mb-1"><i data-feather='link'></i> Attachment's</h6>

                @if (isset($files) && count($files))
                    <div class="col-12"></div>
                    @php $pdf = array(); @endphp
                    @foreach ($files as $path)
                        @if (!preg_match("/\.(pdf)$/", $path))
                            <span class="pip col-3 m-1">
                                <a download="download" href={{ asset('/storage/customerInvoice/' . $path) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <img class="images_upload" type="file"
                                    src="{{ asset('/storage/customerInvoice/' . $path) }}" />
                            </span>
                        @else
                            @php array_push($pdf,$path) @endphp
                        @endif
                    @endforeach


                    @if (isset($pdf))
                        <div class="col-12 mt-3"></div>
                        @foreach ($pdf as $item)
                            <span class="col-4 pip">
                                <a download="download" href={{ asset('/storage/customerInvoice/PDF/' . $item) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <a class="pdf_file" href="{{ asset('/storage/customerInvoice/PDF/' . $item) }}"
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
                    <a class="btn btn-primary mb-1" href="{{ route('customerinvoice.edit', encrypt($cvm->id)) }}"
                        style="float:right;">Edit</a>
                </div>

            </div>
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
            });
        </script>
    @endsection

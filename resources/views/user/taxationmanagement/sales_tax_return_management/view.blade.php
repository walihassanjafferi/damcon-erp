@extends('layout.main')
@section('sales_tax_return_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Sales Tax Return Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('sales_tax_return_management.index') }} @endsection
@section('main_btn_text') All Sales Tax Return Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Date</label>
                            <span>{{ date('d-M-y', strtotime($sales_tax_return_management->date)) }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Tax Body</label>
                            <span>{{ $sales_tax_return_management->taxbody->name }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Taxation Month</label>
                            <span>{{ date('d-M-y', strtotime($sales_tax_return_management->taxation_month)) }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Payable TaxBody</label>
                            <span>PKR {{ $sales_tax_return_management->payable_taxbody }}</span>
                        </div>
                        <div class="customer_details">
                            <label>Manual Adjustments</label>
                            <span>PKR {{ $sales_tax_return_management->manual_adjustments }} </span>
                        </div>

                    
                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <div class="card-body">

                        <div class="customer_details">
                            <label>Net Payable</label>
                            <span>PKR {{ $sales_tax_return_management->net_payable }} </span>
                        </div>

                        <div class="customer_details">
                            <label>Bank Name</label>
                            <span>{{ $sales_tax_return_management->bank->name }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Title</label>
                            <span>{{ $sales_tax_return_management->cheque_title }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Number</label>
                            <span>{{ $sales_tax_return_management->cheque_number }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Amount</label>
                            <span>{{ $sales_tax_return_management->amount }}</span>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mr-2 mb-1">
                            <label><b>Manual Adjustment Comments</b></label>
                            <span
                                class="comment more">{{ $sales_tax_return_management->manual_adjustment_comments }}</span>
                        </div>
                        <div class="mr-2 mb-1">
                            <label><b>Payment Details</b></label>
                            <span class="comment more">{{ $sales_tax_return_management->payment_details }}</span>
                        </div>

                        <div class="mr-2 mb-1">
                            <label><b>Comments</b></label>
                            <span class="comment more">{{ $sales_tax_return_management->comments }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <label class="col-6"
                            style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Purchase Order/Invoices
                            Details</label>

                        <?php $increment = 1; ?>
                        <div class="table-responsive p-3">
                            <table class="table table-striped items_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Invoice/Purchase ID</th>
                                        <th>Type</th>
                                        <th>Avalible Input/Output</th>
                                        <th>Adjusted Input/Output</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales_tax_return_incoices_po as $item)
                                        <tr>
                                            <td>{{ $increment }}</td>
                                            <td>{{ $item->invoice_po_id }}</td>
                                            <td>{{ ucfirst($item->type) }}</td>
                                            <td>PKR {{ $item->amount }} </td>
                                            <td>PKR {{ $item->adjusted_input_output }} </td>
                                        </tr>
                                        <?php $increment++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            @php $files = json_decode($sales_tax_return_management->document_file) @endphp

            <div class="col-12">
                <h6 class="mb-1"><i data-feather='link'></i> Attachment's</h6>

                @if (isset($files) && count($files))
                    <div class="col-12"></div>
                    @php $pdf = array(); @endphp
                    @foreach ($files as $path)
                        @if (!preg_match("/\.(pdf)$/", $path))
                            <span class="pip col-3">
                                <a download="download" href={{ asset('/storage/sales_tax_retums/' . $path) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <img class="images_upload" type="file"
                                    src="{{ asset('/storage/sales_tax_retums/' . $path) }}" />
                            </span>
                        @else
                            @php array_push($pdf,$path) @endphp
                        @endif
                    @endforeach


                    @if (isset($pdf))
                        <div class="col-12 mt-3"></div>
                        @foreach ($pdf as $item)
                            <span class="col-3 pip">
                                <a download="download" href={{ asset('/storage/sales_tax_retums/PDF/' . $item) }}
                                    class="img_pdf_download"><i class="fa fa-download"></i></a>
                                <a class="pdf_file" href="{{ asset('/storage/sales_tax_retums/PDF/' . $item) }}"
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

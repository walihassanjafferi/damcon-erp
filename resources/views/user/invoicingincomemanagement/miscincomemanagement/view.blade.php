@extends('layout.main')
@section('misc_income_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Misc Income Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('miscincome.index') }} @endsection
@section('main_btn_text') All Misc Income Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-8"> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Misc Income Details</h6>
                    <div class="card-body project_item_card">
                        <div class="customer_status">

                        </div>
                        <div class="customer_details">
                            <label>Title</label>
                            <span>{{ $misc_income->title }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Date</label>
                            <span>{{ date('d-m-Y', strtotime($misc_income->misc_date)) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Income Type</label>
                            <span>{{ ucfirst(\App\Models\ErpCategories::find($misc_income->income_type)->category_name ?? 'N/A') }}</span>
                        </div>



                        <div class="customer_details">
                            <label>Project</label>
                            <span>{{ $misc_income->project->name }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Mode of Payment</label>
                            <span>{{ ucfirst($misc_income->mode_of_payment) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cash Deposit Bank ID</label>
                            <span>{{ $misc_income->bank->name }} ({{$misc_income->bank->title}})</span>
                        </div>



                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Misc Income Details</h6>
                    <div class="card-body project_item_card">

                        @if($misc_income->mode_of_payment == 'cheque')
                        <div class="customer_details">
                            <label>Cheque Receiving Date</label>
                            <span>{{ date('d-m-Y', strtotime($misc_income->cheque_receving_date)) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Received Cheque Bank</label>
                            <span>{{ $misc_income->received_cheque_bank }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Clearing Date</label>
                            <span>{{ date('d-m-Y', strtotime($misc_income->cheque_clearing_date)) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Number</label>
                            <span>{{ $misc_income->cheque_number }}</span>
                        </div>
                        @endif
                        <div class="customer_details">
                            <label>Cheque Amount</label>
                            <span>PKR {{ number_format($misc_income->cheque_amount) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Associated Outward Payment ID (Optional)</label>
                            <span>{{ $misc_income->outward_payment_id ?? 'Not Found!' }}</span>
                        </div>




                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <div class="col-12">
                            <label><b>Miscellaneous Income Details</b></label>
                            <p class="more">{{ $misc_income->misc_income_detail }}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Outward Payment ID Comments</b></label>
                            <p class="more">{{ $misc_income->outward_payment_comments }}</p>
                        </div>

                        @php
                            $files = json_decode($misc_income->document_file);
                        @endphp

                        <div class="col-12">
                            <label style="padding-bottom: 6px;"><b>File Attachments</b></label>
                            @if (isset($files) && count($files))
                                <div class="col-12"></div>
                                @php $pdf = array(); @endphp
                                @foreach ($files as $path)
                                    @if (!preg_match("/\.(pdf)$/", $path))
                                        <span class="pip col-3">
                                            <a  download="download" href={{ asset('/storage/MiscIncome/'.$path) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <img class="images_upload" type="file"
                                                src="{{ asset('/storage/MiscIncome/' . $path) }}" />

                                        </span>
                                    @else
                                        @php array_push($pdf,$path) @endphp
                                    @endif
                                @endforeach

                                @if (isset($pdf))
                                    <div class="col-12 mt-3"></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-3 pip">
                                            <a class="remove" href={{ $item }}>
                                            <a  download="download" href={{ asset('/storage/MiscIncome/PDF/'.$item) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <a class="pdf_file" href="{{ asset('/storage/MiscIncome/PDF/' . $item) }}"
                                                target="_blank">{{ $item }}</a>
                                        </span>
                                    @endforeach
                                @endif
                            @else
                             <p>No Attachment's Found!</p>

                            @endif

                           
                        </div>

                    </div>
                </div>
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

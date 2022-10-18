@extends('layout.main')
@section('principal_investment_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Principle Investment Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('principalinvestment.index') }} @endsection
@section('main_btn_text') All Principle Investment Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            {{-- <div class="col-8"> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Principal Investment Details</h6>
                    <div class="card-body project_item_card">
                        <div class="customer_status">

                        </div>
                        <div class="customer_details">
                            <label>Title</label>
                            <span>{{ $principal_investment->title }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Investor</label>
                            <span>{{ ucfirst($principal_investment->investor->name) }}</span>
                        </div>


                        <div class="customer_details">
                            <label>Current Balance </label>
                            <span>PKR {{ number_format($principal_investment->current_balance_investor,2) }}</span>
                        </div>


                        <div class="customer_details">
                            <label>Cash Deposit Bank ID</label>
                            <span>{{ $principal_investment->bank->name }}
                                ({{ $principal_investment->bank->title }})</span>
                        </div>

                    </div>
                </div>
            </div>
            {{-- </div> --}}
            <div class="col-6">
                <div class="card mb-1">
                    <h6 class="mt-1 ml-1">Principal Investment Details</h6>
                    <div class="card-body project_item_card">
                        <div class="customer_details">
                            <label>Cheque Clearing Date</label>
                            <span>{{ date('d-m-Y', strtotime($principal_investment->cheque_clearing_date)) }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Number</label>
                            <span>{{ $principal_investment->cheque_number }}</span>
                        </div>

                        <div class="customer_details">
                            <label>Cheque Amount</label>
                            <span>PKR {{ number_format($principal_investment->cheque_amount,2) }}</span>
                        </div>

                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card mb-1">
                    <div class="card-body project_item_card">
                        <div class="col-12">
                            <label><b>Payment Details</b></label>
                            <p class="more">{{ $principal_investment->payment_details }}</p>
                        </div>

                        <div class="col-12">
                            <label><b>Comments</b></label>
                            <p class="more">{{ $principal_investment->comments }}</p>
                        </div>

                        @php
                            $files = json_decode($principal_investment->document_file);
                        @endphp

                        <div class="col-12">
                            <label style="padding-bottom: 6px;"><b>File Attachments</b></label>
                            @if (isset($files) && count($files))
                                <div class="col-12"></div>
                                @php $pdf = array(); @endphp
                                @foreach ($files as $path)
                                    @if (!preg_match("/\.(pdf)$/", $path))
                                        <span class="pip col-3">
                                            <a  download="download" href={{ asset('/storage/PrincipalInvestment/'.$path) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <img class="images_upload" type="file"
                                                src="{{ asset('/storage/PrincipalInvestment/' . $path) }}" />

                                        </span>
                                    @else
                                        @php array_push($pdf,$path) @endphp
                                    @endif
                                @endforeach

                                @if (isset($pdf))
                                    <div class="col-12 mt-3"></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-3 pip">
                                            <a  download="download" href={{ asset('/storage/PrincipalInvestment/PDF/'.$item) }} class="img_pdf_download"><i class="fa fa-download"></i></a>
                                            <a class="pdf_file"
                                                href="{{ asset('/storage/PrincipalInvestment/PDF/' . $item) }}"
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

@extends('layout.main')
@section('customerpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - View Customer POs Management</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customerpos.index')}} @endsection
@section('main_btn_text') All Customer POs Management @endsection
{{-- back btn --}}
@section('content')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h1><b>{{ $customer_pos->toProject->name }}</b></h1><h1 class="ml-2">(CPO No. {{ $customer_pos->customer_po_number }})</h1>
                </div>
                <div>
                    <h4>{{ date('d-M-Y',strtotime($customer_pos->customer_po_start_date )) }}<b> - </b>{{ date('d-M-Y',strtotime($customer_pos->customer_po_end_date)) }}
                    <div style="float: right;margin-top: -25px;">
                        <label class="switch">
                            <input type="checkbox" {{$customer_pos->status ? 'checked' : ''}} onclick="statusChange({{$customer_pos->id}});">
                            <span class="slider round"></span>
                        </label><br/>
                        <label class="status_label_{{$customer_pos->id}}_d" style="text-align: center;font-weight:900;">{{$customer_pos->status ? 'Active' : 'Inactive'}}</label>
                    </div>
                    </h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" style="display: flex;align-items: stretch;">
                    <div class="col-md-8 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body ">
                                <div class="rental bank_details">
                                    <label>PO Issue:</label>
                                    <span>{{ $customer_pos->customer_po_issue_date }}</span>
                                    <br>
                                    <label>PO Project:</label>
                                    <span>{{ $customer_pos->toProject->name }}</span>
                                    <br>
                                    <label>Customer PO Balance:</label>
                                    <span>{{ number_format($customer_pos->customer_po_balance) }}</span>
                                    <br>
                                    <label>PO Details:</label>
                                    <span class="addReadMore showlesscontent">@php echo $customer_pos->details_input @endphp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 card card-updated">
                        <div class=" mb-4">
                            <div class="card-body">
                                <div class="bank_details">
                                    <label>PO Balance</label>
                                    <span style="float: right;">PKR <b>{{ number_format($customer_pos->customer_po_balance) }}</b></span>
                                </div>
                                <div class="bank_details">
                                    <label>PO w/o Tax</label>
                                    <span style="float: right;">PKR <b>{{ number_format($customer_pos->amount_without_tax) }}</b></span>
                                </div>
                                <div class="bank_details">
                                    <label>PO w Tax</label>
                                    <span style="float: right;">PKR <b>{{ number_format($customer_pos->amount_with_tax) }}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="card">
                            <div class="row">
                            <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">Customer PO Balance Logs</label>
                            </div>
                            <div class="table-responsive p-2">
                                <table class="table table-striped invoice_updates">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Invoice Amount (PKR) ( - )</th>
                                            <th>Previous PO Balance (PKR)</th>
                                            <th>New PO Balance (PKR)</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($po_logs as $index=>$item)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{ number_format($item->invoice_amount) }}</td>
                                                <td>{{ number_format($item->previous_po_balance) }}</td>
                                                <td>{{ number_format($item->new_po_balance) }}</td>
                                                <td>{{ date('d-M-y',strtotime($item->created_at)) }}</td>

                                            </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    @if(isset($files) && count($files) > 0)
                        <div class="col-md-12  card card-updated">
                            <div class="">
                                <div class="row">
                                    <label class="col-6" style="padding: 10px 0px 10px 30px;font-size: 15px; font-weight: 600;">File Attachments</label>
                                    <div class="col-md-12 pl-3 pr-3">
                                        <div class="rental bank_details">

                                            @if(isset($files) && count($files))
                                                <div class="col-12 mb-2">
                                                    Images
                                                </div>
                                                @php $pdf = array(); @endphp
                                                @foreach ($files as $path)
                                                    @if(!preg_match("/\.(pdf)$/", $path))
                                                        <span class="pip col-3">
                                        <a  download="download" style="font-size: 24px;position: absolute;bottom: 5px;right: 25px;color: #33217c" href={{ asset('/storage/customer_pos/'.$path) }} ><i class="fa fa-download"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/customer_pos/'.$path) }}"/>

                                    </span>
                                                    @else
                                                        @php array_push($pdf,$path) @endphp
                                                    @endif
                                                @endforeach
                                            @endif

                                            @if(isset($pdf))
                                                <div class="col-12 mt-3" >Pdf's</div>
                                                @foreach ($pdf as $item)
                                                    <span class="col-12 pip" style="padding: 16px;">
                                        <a  download="download" href={{ asset('/storage/customer_pos/PDF/'.$path) }}><i class="fa fa-download"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/customer_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteOrder({{ $customer_pos->id }})"
                   style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{route('customerpos.edit',encrypt($customer_pos->id))}}" style="float:right;">Edit</a>
            </div>
        </div>
    </div>

    <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
        <div class="toast-header">
            <img src="{{ asset('app-assets/images/ico/favicon.png') }}" class="mr-1" alt="Toast image" height="22" width="24" />
            <strong class="mr-auto">Damcon ERP</strong>
            <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body"></div>
    </div>
    <button class="btn btn-outline-primary toast-basic-toggler mt-2"  id="status_toast" hidden>Toast</button>


@endsection

@section('scripts')
    <script>


        function deleteOrder(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Item",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url:'{{route('customerpos.destroy','id')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('customerpos.index') }}";

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

        function statusChange($id){

            $.ajax({
                url:'{{ route('customerpos_status_change')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":$id
                },
                method: 'post',
                success: function(data) {

                    if(data.value == 1)
                    {
                        $('.status_label_'+data.class+'_d').html('Active');
                    }
                    else{
                        $('.status_label_'+data.class+'_d').html('Inactive');
                    }

                    $('.toast-body').html(data.message);
                    $('#status_toast').click();

                },
                error: function(data)
                {
                    $('.toast-body').html(data.message);
                    $('#status_toast').click();
                }
            });
        }

        $('.invoice_updates').DataTable({

        });
    </script>
@endsection

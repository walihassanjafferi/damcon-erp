@extends('layout.main')
@section('bank_sidebar') active @endsection
@section('title')
    <title>View bank</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('bankaccounts.index') }} @endsection
@section('main_btn_text') All Bank Accounts @endsection
{{-- back btn --}}
@section('content')

    <div class="col-12">

        <div class="row">
            <div class="col-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h2>{{ ucfirst($bankaccount->title) }}</h2>
                    <h3 class="ml-5">{{ isset($bankaccount->account_number) ?  '( '.$bankaccount->account_number.' )' : ''}}</h3>
                </div>
            </div>

            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="bank_details">
                            <label>Bank Name</label>
                            <span>{{ ucfirst($bankaccount->name) }}</span>
                        </div>
                        <div class="bank_details">
                            <label>Opening Date</label>
                            <span>{{ isset($bankaccount->opening_date) ? date('d-M-Y', strtotime($bankaccount->opening_date)) : '' }}</span>
                        </div>
                        <div class="bank_details">
                            <label>Current Balance</label>
                            <span>PKR. {{ number_format($bankaccount->current_balance) }}</span>
                        </div>
                        <div class="bank_details">
                            <label>Avaliable funds</label>
                            <span>PKR. {{ number_format($bankaccount->avaliable_funds) }}</span>
                        </div>
                        <div class="bank_details">
                            <label>Overdraft limit</label>
                            <span>PKR. {{ number_format($bankaccount->overdraft_limit) }}</span>
                        </div>
                        <div class="bank_details">
                            <label>Overdraft Used</label>
                            <span>PKR. {{ number_format($bankaccount->overdraft_used) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="bank_details_balance">
                            <h2>Current Balance</h2>
                            <h3>PKR. {{ number_format($bankaccount->avaliable_funds) }}</h3>
                            <small>(current balance + overdraft limit)</small>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-12">
                <div class="card p-2">
                    <div class="row">
                        <label class="col-6"
                            style="padding: 10px 0px 10px 20px;font-size: 15px; font-weight: 600;">Bank Statements</label>
                        <a class="col-6" href={{ route('interbanktransfer.index') }} style="text-align: end;
                            padding: 10px 30px 10px 0px;cursor: pointer; font-size: 14px;font-weight: 500;">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped bank_transaction_table">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th style="display: none;">Transaction Date</th>
                                    <th>Transaction Date</th>
                                    <th>Bank Name</th>
                                    <th>Title</th>
                                    <th>Description/Refrence</th>
                                    <th>Withdrawals (PKR)</th>
                                    <th>Deposit (PKR)</th>
                                    {{-- <th>Amount (PKR)</th> --}}
                                    <th>Remaining Balance (PKR)</th>
                                    <th>Comments</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction_logs as $item)
                                    <tr>
                                        <td style="display: none;">{{ $item->transaction_date }}</td>
                                        <td>{{ isset($item->transaction_date) ? date('d-M-Y', strtotime($item->transaction_date)) : 'Not Found!' }}</td>
                                        <td>{{$item->bank_name}}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->payment_title }}</td>
                                        <td>{{ number_format($item->withdraw_amount) }}</td>
                                        <td>{{ number_format($item->deposit_amount) }}</td>
                                        {{-- <td>{{ number_format($item->transfer_amount) }}</td> --}}
                                        <td>{{ number_format($item->remaining_balance) }}</td>
                                        <td>{{ $item->comments }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <a class="btn btn-danger mb-1" onclick="deleteProject({{ $bankaccount->id }})"
                    style="float:right;margin-left:10px;">Delete</i>
                </a>
                <a class="btn btn-primary mb-1" href="{{ route('bankaccounts.edit', encrypt($bankaccount->id)) }}"
                    style="float:right;">Edit</a>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        function deleteProject(id) {
            var id = id;
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this BankAccount",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {

                    if (willDelete) {
                        $.ajax({
                            url: '{{ route('bankaccounts.destroy', 'id') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id

                            },
                            method: 'DELETE',
                            success: function(data) {

                                swal(data.message, {
                                    icon: "success",
                                });

                                let url = "{{ route('bankaccounts.index') }}";

                                document.location.href = url;


                            },
                            error: function(data) {
                                alert('Error Failed');

                            }
                        });
                    }
                });

        }

        $(function(){
            // investor ledger table
            var table = $('.bank_transaction_table').DataTable({
                dom: 'Bfrtip',
                columnDefs: [
                    // { targets: 'no-sort', orderable: false }
                ],
                order:[],
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Bank Statements',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8 ]
                        },
                        filename:"Bank Account Statements",
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Bank Statements',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8 ]
                        },
                        filename:"Bank Account Statements",
                    }
                ]
            });
        });
    </script>
@endsection

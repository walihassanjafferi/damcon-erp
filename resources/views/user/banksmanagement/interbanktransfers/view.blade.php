@extends('layout.main')
@section('title')
<title>Damcon ERP - View Interbank transfer</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('interbanktransfer.index')}} @endsection
@section('main_btn_text') All Inter-Banks Transfer @endsection
{{-- back btn --}}
@section('interbank_sidebar') active @endsection
@section('content')
    
    <div class="col-12">
        
        <div class="row">
            <div class="col-12" style="padding-bottom: 5px;">
                <div style="display: inline-flex;">
                    <h3>Inter-bank Transfers</h3></div>   
            </div>
        
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="inter_transfer_details">
                            <label>Transaction Date</label>
                            <span>{{  isset($inter_transfer->transaction_date) ?  date('d-M-Y',strtotime($inter_transfer->transaction_date)) : ''}}</span>
                        </div>  
                        <div class="inter_transfer_details">
                            <label>Title of transfer </label>
                            <span>{{ $inter_transfer->title_of_transfer }}</span>
                        </div>  
                        <div class="inter_transfer_details">
                            <label>Sender Bank</label>
                            <span> {{$inter_transfer->sender_bankaccount->name}}</span>
                        </div>  
                        <div class="inter_transfer_details">
                            <label>Receiver Bank</label>
                            <span> {{$inter_transfer->receiver_bankaccount->name}}</span>
                        </div> 
                        <div class="inter_transfer_details">
                            <label>Transaction Type</label>
                            <span> {{$inter_transfer->transaction_type}}</span>
                        </div> 
                        @if($inter_transfer->transaction_type == 'cheque')
                        <div class="inter_transfer_details">
                            <label>Cheque Number</label>
                            <span> {{$inter_transfer->cheque_no}}</span>
                        </div> 
                        @endif
                        <div class="inter_transfer_details">
                            <label>Comments</label>
                            <span> {{$inter_transfer->comments}}</span>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="bank_details_balance">
                            <h2>Transfer Amount</h2>
                           <h3>PKR. {{number_format($inter_transfer->amount)}}</h3>
        
                        </div>  
                    </div>
                </div>
            </div>
                <div class="col-12">
                    <a class="btn btn-danger mb-1" onclick="deleteTransfer({{$inter_transfer->id}})"
                        style="float:right;margin-left:10px;">Delete
                   </a>
                    <a class="btn btn-primary mb-1" href="{{route('interbanktransfer.edit',encrypt($inter_transfer->id))}}" style="float:right;">Edit</a>

                </div>
        </div>
    </div>


@endsection

@section('scripts')
<script>
     function deleteTransfer(id){
            var id = id;
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Inter-Transfer",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willDelete) => {
                
                if (willDelete) {
                    $.ajax({
                        url:'{{route('interbanktransfer.destroy','id')}}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id":id

                        },
                        method: 'DELETE',
                        success: function(data) {
                        
                                swal(data.message, {
                                icon: "success",
                                });
                            
                            let url = "{{ route('interbanktransfer.index') }}";
                              
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
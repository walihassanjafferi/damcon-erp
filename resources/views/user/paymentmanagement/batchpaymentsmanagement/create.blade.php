@extends('layout.main')
@section('batches_payment_management_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Batches Payments Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('batches_payment_management.index')}} @endsection
@section('main_btn_text') All Batches Payments Management @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Batches Payment</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('batches_payment_management.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text"  name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label>Select Batch<span class="red_asterik"></span></label>
                                        <select class="form-control select2 batch" name="batch_id">
                                            <option value="">Select Batch</option>
                                            @foreach ($batches as $item)
                                                <option value="{{$item->id}}" {{ old('batch_id') == $item->id ? "selected" : "" }}>{{$item->name_of_batch}}</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Date of Cheque<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="date_of_cheque" class="form-control date_of_cheque" placeholder="Date of Cheque" value="{{ old('date_of_cheque') }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Bank Of Batch<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="bank_of_batch" id="bank_of_batch" class="form-control" placeholder="Bank of Batch" value="{{ old('bank_of_batch') }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Amount<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" id="amount"  name="amount" class="form-control" placeholder="Amount" value="{{ old('amount') }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Cheque Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="cheque_title" class="form-control" placeholder="Cheque Title" value="{{ old('cheque_title') }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Cheque Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="cheque_number" class="form-control" placeholder="Cheque Number" value="{{ old('cheque_number') }}" required/>
                                    </div>
                                </div>



                                <div class="col-md-12 mb-2">
                                    <label>Batch Description</label>
                                    <textarea class="form-control" name="batch_description" rows="5" required>{{ old('batch_description') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Comment Box</label>
                                    <textarea class="form-control" name="comment_box" rows="5" required>{{ old('comment_box') }}</textarea>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1" >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\BatchPaymentsManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>
        var items = "";
        $(function() {

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.date_of_cheque').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            // CKEDITOR.replace('description_input');
        });

        $(".batch").change(function (){
            $id = $(this).val();
            if($id){
                $.ajax({
                    url:'{{ route('get_batch_bank')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id":$id
                    },
                    method: 'post',
                    success: function(data) {
                        //$('#bank_of_batch').val(data.message);
                        $('#bank_of_batch').val(data.name);
                        $('#amount').val(data.amount);
                    },
                    error: function(data)
                    {
                    }
                });
            }else{
                alert("Select Tax Body");
                $('#bank_of_batch').val("");
            }
        })
    </script>

@endsection

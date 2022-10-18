@extends('layout.main')
@section('director_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Add Director Withdraws</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('directorwithdraw.index') }} @endsection
@section('main_btn_text') All Director Withdraws @endsection
{{-- back btn --}}
@section('content')
    @include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Director Withdraws</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('directorwithdraw.store') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Partner Name</label>
                                    <input type="text" name="partner_name" class="form-control"
                                        value="{{ Auth::user()->name }}" readonly />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <select name="debited_bank_id" class="select2">
                                        <option value=" ">Select Bank</option>
                                        @foreach ($banks as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('debited_bank_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }} ({{ $item->title }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Amount Withdrawn</label>
                                    <input type="text" name="amount" class="form-control amount_format" value="{{ old('amount') }}"
                                        id="date" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_number" class="form-control"
                                        value="{{ old('cheque_number') }}" placeholder="Cheque Number" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque Title</label>
                                    <input type="text" name="cheque_title" class="form-control"
                                        value="{{ old('cheque_title') }}" placeholder="Cheque Title" required />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Cheque clearing Date</label>
                                    <input type="text" name="cheque_clearing_date" class="form-control"
                                        value="{{ old('cheque_clearing_date') }}" id="cheque_clearing_date" required />
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea name="comments" class="form-control" rows="3"
                                        required>{{ old('comments') }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    @endsection


    @section('scripts')


        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
        {{-- {!! JsValidator::formRequest('App\Http\Requests\CategoriesRequest'); !!} --}}

        <script>
            $(function() {

                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                $('#cheque_clearing_date').datepicker({
                    format: 'yyyy-mm-dd',
                    uiLibrary: 'bootstrap4',
                    iconsLibrary: 'fontawesome',
                });



            });
        </script>
    @endsection

@extends('layout.main')
@section('regions_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Add Regions</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{ route('regions.index') }} @endsection
@section('main_btn_text') All Regions @endsection
{{-- back btn --}}
@section('content')
    @include('alert.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Region</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('regions.store') }}" method="post">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status<span class="red_asterik"></span></label>
                                    {!! Form::select('status', ['1' => 'Active','0' => 'In active'],
                                    1, ['class' => 'form-control', 'id' => 'is_active']) !!}
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

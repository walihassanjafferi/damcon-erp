@extends('layout.main')
@section('investor_sidebar')
    active
@endsection
@section('title')
    <title>Damcon ERP - Edir Investor</title>
@endsection
{{-- back btn --}}
@section('main_btn_href')
    {{ route('investors.index') }}
@endsection
@section('main_btn_text')
    All Investor
@endsection
{{-- back btn --}}
@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Investors</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($investor, ['route' => ['investors.update', encrypt($investor->id)], 'method' => 'PATCH']) !!}
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Investor Name<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="form-group">
                                    <label>Type of Investors<span class="red_asterik"></span></label>
                                    {!! Form::select('type_of_invester', ['profit_making_terms' => 'Investor with profit taking terms', 'zero_markup' => 'Investor with zero markup', 'company_director' => 'Company Director'], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="state">Desciption<span class="red_asterik"></span></label>
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'required', 'rows' => 3]) !!}

                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Contact No<span class="red_asterik"></span></label>
                                    {!! Form::text('contact_no', null, ['class' => 'form-control', 'required']) !!}

                                </div>
                            </div>


                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Date of Creation<span class="red_asterik"></span></label>
                                    {!! Form::text('date_of_creation', null, ['class' => 'form-control date_of_creation', 'required']) !!}

                                </div>
                            </div>




                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status<span class="red_asterik"></span></label>
                                    {!! Form::select('status', ['0' => 'In active', '1' => 'Active'], null, ['class' => 'form-control', 'id' => 'is_active']) !!}
                                </div>
                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1">Update</button>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\InvestorRequest') !!}

    <script>
    
        $(function(){
    
            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    
            $('.date_of_creation').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
    
    
        });
        
    
    
    </script>
@endsection

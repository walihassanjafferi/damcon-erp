@extends('layout.main')
@section('employees_tax_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Employees Tax Management Create</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('employees_tax_management.index')}} @endsection
@section('main_btn_text') All Employees Tax Management @endsection
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
                        <h4 class="card-title">Add Employees Tax</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('employees_tax_management.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Title<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="title" class="form-control" placeholder="Title" value="{{ old('title') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Law of Tax<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="law_of_tax" class="form-control" placeholder="Law of Tax" value="{{ old('law_of_tax') }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Law of Tax Update Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="law_of_tax_update_date" class="form-control law_of_tax_update_date form-date" placeholder="Law of Tax Update Date" value="{{ old('law_of_tax_update_date') }}" readonly required/>
                                    </div>
                                </div>



                                <div class="col-md-4 col-12">
                                    <label>Income Tax Percentage on salary<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="income_tax_percentage_on_salary" class="form-control" placeholder="Tax" value="{{ old('income_tax_percentage_on_salary') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <label>EOBI Tax Percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="EOBI_tax_percentage" class="form-control" placeholder="Tax" value="{{ old('EOBI_tax_percentage') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2 mt-2">
                                    <label>Description of Tax</label>
                                    <textarea class="form-control" name="description_input" rows="5" required>{{ old('description_input') }}</textarea>
                                    <span id="description_input_error" class="custome_error" style="display: block;"></span>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Tax Details</label>
                                    <textarea class="form-control" name="details_input" rows="5" required>{{ old('details_input') }}</textarea>
                                    <span id="tax_details" class="custome_error" style="display: block;"></span>
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
    {!! JsValidator::formRequest('App\Http\Requests\EmployeesTaxManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>


        $(function(){
            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.law_of_tax_update_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
        });

        CKEDITOR.replace('details_input');
        CKEDITOR.replace('description_input');

        $(".import_purchases").submit( function(e) {
            var specifications_1 = CKEDITOR.instances['description_input'].getData().replace(/<[^>]*>/gi, '').length;
            if( !specifications_1 ) {
                $("#description_input_error").html("Description of Tax field is required.");
                e.preventDefault();
            }else {
                $("#description_input_error").html("");
            }

            var specifications_2 = CKEDITOR.instances['details_input'].getData().replace(/<[^>]*>/gi, '').length;
            if( !specifications_2 ) {
                $("#tax_details").html("Tax Details field is required.");
                e.preventDefault();
            }else {
                $("#tax_details").html("");
            }
        });
    </script>

@endsection

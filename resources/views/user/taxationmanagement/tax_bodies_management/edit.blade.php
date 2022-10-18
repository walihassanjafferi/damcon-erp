@extends('layout.main')
@section('tax_bodies_modules_sidebar') active @endsection
@section('title')
    <title>Damcon ERP -  Tax Bodies Management Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('bank_payment_management.index')}} @endsection
@section('main_btn_text') All Tax Bodies Management @endsection
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
                        <h4 class="card-title">Edit Tax Body</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('tax_bodies.update',encrypt($tax_body->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Tax Body Name<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"   name="name" class="form-control" placeholder="Tax Body Name" value="{{ $tax_body->name }}"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <label>Sales Tax Percentage on Items<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="sale_tax_item" class="form-control" placeholder="Tax" value="{{ $tax_body->sales_tax_percentage_items }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <label>Sales Tax Percentage on Services<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="sale_tax_services" class="form-control" placeholder="Tax" value="{{ $tax_body->sales_tax_percentage_services }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-12">
                                    <label>Sales Tax withheld at source percentage<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="source_percentage" class="form-control" placeholder="Tax" value="{{ $tax_body->sales_tax_withheld_source_percentage }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-md-4 col-12">
                                    <label>Withholding tax on Items<span class="red_asterik"></span></label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"   name="withholding_items" class="form-control" placeholder="Tax" value="{{ $tax_body->withholding_items }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    </div>
    
    
                                    <div class="col-md-4 col-12">
                                        <label>Withholding tax on Services<span class="red_asterik"></span></label>
                                        <div class="input-group">
                                            <input type="text" autocomplete="off"   name="withholding_services" class="form-control" placeholder="Tax" value="{{ $tax_body->withholding_services }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-md-4 col-12" >
                                    <div class="form-group">
                                        <label>Modification Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" tabindex="-1" name="modification_date" class="form-control modification_date form-date" placeholder="Modification Date" value="{{ $tax_body->rule_creation_date }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-12 mb-2">
                                    <label>Comments</label>
                                    <textarea class="form-control" name="comments" rows="5" required>{{ $tax_body->comments_about_law }}</textarea>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label>Description</label>
                                    <textarea class="form-control" name="details_input" rows="5" required>{{ $tax_body->description }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\TaxBodyRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>


        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.modification_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

        });

        // CKEDITOR.replace('details_input');

    </script>

@endsection

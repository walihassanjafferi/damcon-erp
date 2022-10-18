@extends('layout.main')
@section('project_siderbar') active @endsection
@section('title')
<title>Damcon ERP -  Create Project</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('projectmanagement.index')}} @endsection
@section('main_btn_text') All Projects @endsection
{{-- back btn --}}
@section('content')
@include('alert.alert')
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Project</h4>
                </div>
                <div class="card-body">
                   {!! Form::open(['route' => 'projectmanagement.store']) !!}
                        <div class="row">
                            <div class="col-md-4 col-12" >
                                <div class="form-group">
                                    <label >Project Name<span class="red_asterik"></span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label >Project Code<span class="red_asterik"></span></label>
                                    {!! Form::text('project_code', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Customer Name<span class="red_asterik"></span></label>
                                    {!! Form::select('customer_id',[null=>"Select Customer"]+$customers,
                                   null, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label > Project Desciption</label>
                                    {!! Form::textarea('project_description', null, ['class' => 'form-control','required','rows'=>3]) !!}

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >Customer PM Name / Contact no</label>
                                    {!! Form::text('customer_project_manager_name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>

                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Customer PM Contact no</label>
                                    {!! Form::number('customer_project_manager_contact_no', null, ['class' => 'form-control','required','placeholder'=>'03007659356']) !!}
                                </div>
                            </div> --}}

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label >Damcon PM Name / Contact no</label>
                                    {!! Form::text('damcon_project_manager_name', null, ['class' => 'form-control','required']) !!}
                                </div>
                            </div>

                            {{-- <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label >Damcon PM Contact no</label>
                                    {!! Form::number('damcon_project_manager_contact_no', null, ['class' => 'form-control','required','placeholder'=>'03007659356']) !!}
                                </div>
                            </div> --}}


                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Project Region Box</label>
                                    {!! Form::text('project_region_box', null, ['class' => 'form-control','required']) !!}

                                </div>
                            </div>


                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Start Date<span class="red_asterik"></span></label>
                                    {{-- <input type="text" id="project_start_date"  name="project_start_date" class="form-control" placeholder="Start Date"  required/> --}}
                                    {!! Form::text('project_start_date', null, ['class' => 'form-control','required','id'=>'project_start_date','readonly']) !!}

                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>End Date<span class="red_asterik"></span></label>
                                    {{-- <input type="text" id="project_start_date"  name="project_start_date" class="form-control" placeholder="Start Date"  required/> --}}
                                    {!! Form::text('project_end_date', null, ['class' => 'form-control','required','id'=>'project_end_date','readonly']) !!}

                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="is_active">Status<span class="red_asterik"></span></label>
                                    {!! Form::select('status', ['0' => 'In active', '1' => 'Active'],
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
    </div>
</section>

@endsection


@section('scripts')
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ProjectManagementRequest'); !!}

<script>
     var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#project_start_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        //    icons: {
        //         rightIcon: '<i data-feather="calendar"></i>',
        //         previousMonth: '<i data-feather="chevron-left"></i>',
        //         nextMonth: '<i data-feather="chevron-right"></i>'
        //     },
           // minDate: today,
            maxDate: function () {
                return $('#project_end_date').val();
            }
        });
        $('#project_end_date').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#project_start_date').val();
            }
        });
</script>

@endsection

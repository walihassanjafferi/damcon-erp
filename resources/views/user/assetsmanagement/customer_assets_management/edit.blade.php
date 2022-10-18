@extends('layout.main')
@section('customerassets_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Customer Assets Edit</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customerassets.index')}} @endsection
@section('main_btn_text') All Customer Assets Management @endsection
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
                        <h4 class="card-title">Update Customer Assets</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('customerassets.update',encrypt($customer_assets->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Asset Item ID<span class="red_asterik"></span></label>
                                        <input type="text"  name="asset_item_id" class="form-control" readonly placeholder="Asset Item ID" value="{{ $customer_assets->asset_item_id }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Customer</label>
                                        {!! Form::select('customer_id',$customers+[NULL=>'Select Customer'],
                                        $customer_assets->customer_id, ['class' => 'form-control select2 select_customer','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Project</label>
                                        {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                        $customer_assets->project_id, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Date of Handover<span class="red_asterik"></span></label>
                                        <input type="text"  name="date_of_handover" class="form-control date_of_handover" placeholder="Date of Handover" value="{{ $customer_assets->date_of_handover }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Item Condition<span class="red_asterik"></span></label>
                                        <input type="text"  name="item_condition" class="form-control"  placeholder="Item Condition"  value="{{ $customer_assets->item_condition }}" required/>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Incharge<span class="red_asterik"></span></label>
                                        <input type="text"  name="asset_incharge" class="form-control"  placeholder="Asset Incharge"  value="{{ $customer_assets->asset_incharge }}"/>
                                    </div>
                                </div> --}}

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Incharge<span class="red_asterik"></span></label>
                                        {{-- <input type="text"  name="asset_incharge" class="form-control"  placeholder="Asset Incharge"  value="{{ old('asset_incharge') }}"/> --}}
                                        <select class="form_control select2" name="asset_incharge_id">
                                            <option value="">Select Employee</option>
                                            @foreach ($employee as $item)
                                                <option value="{{$item->id}}"  {{$customer_assets->asset_incharge_id == $item->id ? 'selected': ''}}>{{$item->cnic}} ( {{$item->name}} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Asset Brand<span class="red_asterik"></span></label>
                                        <input type="text"  name="asset_brand" class="form-control" placeholder="Asset Brand" value="{{ $customer_assets->asset_brand }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Model<span class="red_asterik"></span></label>
                                        <input type="text" name="model" class="form-control" placeholder="Model" value="{{ $customer_assets->model }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Registration Number<span class="red_asterik"></span></label>
                                        <input type="text" name="registration_number" class="form-control" placeholder="Registration Number" value="{{ $customer_assets->registration_number }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Name<span class="red_asterik"></span></label>
                                        <input type="text" name="engine_name" class="form-control" placeholder="Engine Name" value="{{ $customer_assets->engine_name }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Chassis Number<span class="red_asterik"></span></label>
                                        <input type="text" name="chassis_number" class="form-control" placeholder="Chassis Number" value="{{ $customer_assets->chassis_number }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Color<span class="red_asterik"></span></label>
                                        <input type="text" name="color" class="form-control" placeholder="Color" value="{{ $customer_assets->color }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Capacity<span class="red_asterik"></span></label>
                                        <input type="text" name="engine_capacity" class="form-control" placeholder="Engine Capacity" value="{{ $customer_assets->engine_capacity }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Mileage/Hours on Purchase<span class="red_asterik"></span></label>
                                        <input type="text" name="milage" class="form-control" placeholder="Mileage/Hours on Purchase" value="{{ $customer_assets->milage }}" required />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Asset Location<span class="red_asterik"></span></label>
                                        <input type="text" name="asset_Location" class="form-control" placeholder="Asset Location" value="{{ $customer_assets->asset_Location }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Estimated Market Price<span class="red_asterik"></span></label>
                                        <input type="text" name="market_price" class="form-control" placeholder="Estimated Market Price" value="{{ $customer_assets->market_price }}" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}" style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label>
                                        <input id="file_input" type="file" class="form-control" name="document_file[]" multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>
                                @php
                                    $files = json_decode($customer_assets->document_file)
                                @endphp
                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/customer_asset_management/'.$path) }}"/>

                                    </span>
                                        @else
                                            @php array_push($pdf,$path) @endphp
                                        @endif
                                    @endforeach
                                @endif

                                @if(isset($pdf))
                                    <div class="col-12 mt-3" ></div>
                                    @foreach ($pdf as $item)
                                        <span class="col-4 pip">
                                        <a  class="remove" href={{$item}}><i class="fa fa-times"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/customer_asset_management/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif

                                <input type="text" id="remove_images"  name="remove_images" hidden>
                                <div class="col-md-12 col-12 mt-2">
                                    @error('specifications_1')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 1<span class="red_asterik"></span></label>
                                        <textarea name="specifications_1" class="form-control" rows="4"  required>{{ $customer_assets->specifications_1 }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    @error('specifications_2')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 2<span class="red_asterik"></span></label>
                                        <textarea name="specifications_2" class="form-control" rows="4"  required>{{ $customer_assets->specifications_2 }}</textarea>
                                    </div>
                                </div>

                                @error('description_input')
                                <div class="help-block error-help-block">{{ $message }}</div>
                                @enderror

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description_input" class="form-control" rows="4"  required>{{ $customer_assets->description_input }}</textarea>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea name="comments"  class="form-control" rows="3"  required>{{ $customer_assets->comments }}</textarea>
                                    </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\CustomerAssetsManagementRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>

        var items = "";
        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

            $('.date_of_handover').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
        });

        // CKEDITOR.replace('description_input');
        // CKEDITOR.replace('specifications_1');
        // CKEDITOR.replace('specifications_2');

        function previewImages() {

            var preview = document.querySelector('#preview');

            if (this.files) {
                [].forEach.call(this.files, readAndPreview);
            }

            function readAndPreview(file) {

                // Make sure `file.name` matches our extensions criteria
                var filename = file.name;
                var file_extension = filename.split('.').pop();

                if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                    return alert(file.name + " is not an image");
                } // else...

                var reader = new FileReader();

                reader.addEventListener("load", function() {

                    if(file_extension!='pdf')
                    {
                        $("<span class=\"pip col-3\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name + "\"/>" +
                            "</span>").insertAfter("#preview");
                    }
                    else{

                        $("<span class=\"pip col-4\">" +
                            "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" +
                            "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>"+file.name+"</span>" +
                            "</span>").insertAfter("#preview_pdf");
                    }

                    $(".remove").click(function(){
                        $(this).parent(".pip").delay(200).fadeOut();
                    });
                });
                reader.readAsDataURL(file);
            }
        }

        document.querySelector('#file_input').addEventListener("change", previewImages);

        var remove_images = [];
        $(".remove").click(function(){
            event.preventDefault();
            let img_val =  $(this).attr('href');
            remove_images.push(img_val);
            $('#remove_images').val(remove_images);
            $(this).parent(".pip").remove();
        });
    </script>
@endsection

@extends('layout.main')
@section('customerpos_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Customer POs Management Update</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('customerpos.index')}} @endsection
@section('main_btn_text') All Customer POs Management @endsection
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
                        <h4 class="card-title">Update Customer Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customerpos.update',encrypt($customer_pos->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="top-status-btn">
                                <label class="switch">
                                    <input type="checkbox" {{$customer_pos->status ? 'checked' : ''}} onclick="statusChange({{$customer_pos->id}});">
                                    <span class="slider round"></span>
                                </label><br/>
                                <label class="status_label_{{$customer_pos->id}}_d" style="text-align: center;font-weight:900;">{{$customer_pos->status ? 'Active' : 'Inactive'}}</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Select Project</label>
                                        {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                        $customer_pos->project_id, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Number<span class="red_asterik"></span></label>
                                        <input type="text"   name="customer_po_number" class="form-control" placeholder="Customer PO Number" value="{{ $customer_pos->customer_po_number }}" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Amount without Tax<span class="red_asterik"></span></label>
                                        <input type="number"  name="amount_without_tax" class="form-control" placeholder="Amount without Tax" value="{{ $customer_pos->amount_without_tax }}" required readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Amount with Tax<span class="red_asterik"></span></label>
                                        <input type="number"  name="amount_with_tax" class="form-control" placeholder="Amount with Tax" value="{{ $customer_pos->amount_with_tax }}" required readonly/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Issue Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="customer_po_issue_date" class="form-control customer_po_issue_date" placeholder="Customer PO Issue Date" value="{{ $customer_pos->customer_po_issue_date }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Start Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="customer_po_start_date" class="form-control customer_po_start_date" placeholder="Customer PO Start Date" value="{{ $customer_pos->customer_po_start_date }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO End Date<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="customer_po_end_date" class="form-control customer_po_end_date" placeholder="Customer PO End Date" value="{{ $customer_pos->customer_po_end_date }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Customer PO Balance<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  tabindex="-1"  name="customer_po_balance" class="form-control customer_po_balance" placeholder="PO Balance" value="{{ $customer_pos->customer_po_balance }}" readonly required/>
                                    </div>
                                </div>

                                <input type="hidden" name="status" id="status_check" value="{{ $customer_pos->status }}" >

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

                                @if(isset($files) && count($files))
                                    <div class="col-12"></div>
                                    @php $pdf = array(); @endphp
                                    @foreach ($files as $path)
                                        @if(!preg_match("/\.(pdf)$/", $path))
                                            <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/customer_pos/'.$path) }}"/>
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
                                        <a class="pdf_file" href="{{ asset('/storage/customer_pos/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                    @endforeach
                                @endif
                                @error('details_input')
                                <div class="help-block error-help-block">{{ $message }}</div>
                                @enderror

                                <input type="text" id="remove_images"  name="remove_images" hidden>
                                <div class="col-12 mt-3">
                                    <div class="form-group">
                                        <label>Details</label>
                                        <textarea name="details_input" class="form-control" rows="4"  required>{{ $customer_pos->details_input }}</textarea>
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

        <div class="toast toast-basic hide position-fixed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="top: 1rem; right: 1rem">
            <div class="toast-header">
                <img src="{{ asset('app-assets/images/ico/favicon.png') }}" class="mr-1" alt="Toast image" height="22" width="24" />
                <strong class="mr-auto">Damcon ERP</strong>
                <button type="button" class="ml-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
        <button class="btn btn-outline-primary toast-basic-toggler mt-2"  id="status_toast" hidden>Toast</button>
    </section>
@endsection


@section('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CustomerPOsManagement'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script>
        var items = "";
        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('.customer_po_issue_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.customer_po_start_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                maxDate: function () {
                    return $('.customer_po_end_date').val();
                }
            });

            $('.customer_po_end_date').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                minDate: function () {
                    return $('.customer_po_start_date').val();
                }
            });
        });

        CKEDITOR.replace('details_input');

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

        function statusChange($id){

            $.ajax({
                url:'{{ route('customerpos_status_change')}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":$id
                },
                method: 'post',
                success: function(data) {

                    if(data.value == 1)
                    {
                        $('.status_label_'+data.class+'_d').html('Active');
                        $('#status_check').val(1);
                    }
                    else{
                        $('.status_label_'+data.class+'_d').html('Inactive');
                        $('#status_check').val(0);
                    }
                    $('.toast-body').html(data.message);
                    $('#status_toast').click();
                },
                error: function(data)
                {
                    $('.toast-body').html(data.message);
                    $('#status_toast').click();
                }
            });
        }


        $('.amount_without_tax').keyup(function(){
            var amount = $('.amount_without_tax').val();
            $('.customer_po_balance').val(amount);
        })
    </script>
@endsection

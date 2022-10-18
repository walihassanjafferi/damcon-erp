@extends('layout.main')
@section('project_payment_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Project Payment</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('project_payment.index')}} @endsection
@section('main_btn_text') All Project Payments @endsection
{{-- back btn --}}
@section('css')
    <style>
        .table th, .table td {
            padding: 0.72rem 0.98rem;
        }
        /* #file_input{
            opacity: 0;
            position: absolute;
            pointer-events: none;
        } */
    </style>
@endsection


@section('content')
    @include('alert.alert')
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Project Payment</h4>
                    </div>

                    <div class="card-body">
                        <form class="form" method="POST" action="{{route('project_payment.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >Parent Category </label>
                                        <select id="parent_category" name="category_id" class="form-control category select2" required>
                                            <option value="" selected disabled>select Payment category </option>

                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >Main Category </label>
                                        <select id="main_category" name="main_category_id" class="form-control category select2" disabled required>
                                            <option value="" selected disabled> --select expense category -- </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label >Sub Category </label>
                                        <select id="sub_category" name="sub_category_id" class="form-control category select2" disabled required>
                                            <option value="" selected disabled> --select expense category -- </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" value="{{old('title')}}" required/>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Project</label>
                                        <select class="form-control select2" id="project" name="project_id"  required>
                                            <option selected disabled value="">Select Project</option>
                                            @foreach($projects as $p)
                                                <option value="{{$p->id}}" {{old('project_id') == $p->id ? 'selected' : ''}}> {{$p->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Paid To Person</label>
                                        <input type="text" class="form-control" id="paid_person" name="paid_person" value="{{old('paid_person')}}" required/>

                                    </div>
                                </div>
                               
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Transaction Date</label>
                                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{old('payment_date')}}" required/>

                                    </div>

                                    <div class="form-group">
                                        <label for="">Total Paid Amount</label>
                                        <input type="text" class="form-control number" id="total_paid_amount" name="amount"  value="{{old('amount')}}" required/>

                                    </div>

                                    <div class="form-group">
                                        <label for="">Bank Account</label>
                                        <select class="form-control select2" id="account" name="account"  required>
                                            <option selected disabled value="">Select Bank</option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}" {{ old('account') == $account->id ? "selected" : '' }}> {{$account->name}} ({{$account->account_number}}) ({{$account->title}})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <label >Comments</label>
                                    <textarea name="comments" id="" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="col-md-6 col-12 mt-2">
                                    <div class="form-group">
                                        <label>File Attachments</label> <br>
                                        {{-- <label for="file_input">
                                            <img src="{{ asset('/app-assets/images/ico/file_icon.png') }}" style="height: 52px;cursor: pointer;margin-top: -7px;">
                                            <span class="red_asterik"></span>
                                        </label> --}}
                                        <input id="file_input" type="file" class="form-control" name="document_file[]" accept="image/png, image/jpg, image/jpeg, application/pdf"  multiple>
                                        <small>Files supported jpg | jpeg | png | pdf</small><br/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-12" style="margin-bottom: 20px;">
                                        <div id="preview" class="gallery col-12"></div>
                                        <div id="preview_pdf" class="gallery col-12"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-primary mr-1 float-right">Submit</button>
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

 <script>

   
  
    $('#parent_category').on('change', function(e){
        $("#maincategory_id").empty();
        var itemId  = $(this).val();
      
       getAjaxCategories('main',itemId);
    });

    $('#main_category').on('change', function(e){
        $("#sub_category").empty();
        var itemId  = $(this).val();

        getAjaxCategories('sub',itemId);
    });


    function getAjaxCategories(category_select,category_id) {
        $.ajax({
            url:'{{ route('ajaxgetpaymentcategories')}}',
            data: {
                "_token": "{{ csrf_token() }}",
                'category_id':category_id,
                "category_select":category_select
            },
            method: 'post',
            success: function(data) {

                var categories = data.categories;

                if(category_select == 'main')
                {
                    // handling parent categories
                    $('#main_category').html('');

                    $('#main_category').html('<option value="">Select Main Category</option>');
                    
                    $.each(categories,function(key,value) {
                        $('#main_category').append(
                            '<option value='+value.id+'>'+value.category_name+'</option>'
                        )
                    })

                    if(categories!='')   $('#main_category').prop("disabled", false);


                }
                else if(category_select == 'sub')
                {
                    // handling main categoires
                    $('#sub_category').html('');

                    $('#sub_category').html('<option value="">Select Main Category</option>');


                    $.each(categories,function(key,value) {
                        $('#sub_category').append(
                            '<option value='+value.id+'>'+value.category_name+'</option>'
                        )
                    })
                    

                    if(categories!='')   $('#sub_category').prop("disabled", false);

                


                
                }
               
                
    
            },
            error: function(data)
            {
                alert('error occured')
            }
        });
    }

    
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


    
    




</script>


@endsection

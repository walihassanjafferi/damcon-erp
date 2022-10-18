@extends('layout.main')
@section('project_issuance_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Project Items Issuance</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('projectitemsissuance.index')}} @endsection
@section('main_btn_text') All Project Inventory Issuance @endsection
{{-- back btn --}}
@section('css')
    <style>
    .table th, .table td {
        padding: 0.72rem 0.98rem;
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
                    <h4 class="card-title">Add Project Items Issuance</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('projectitemsissuance.store')}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Date of Issuance<span class="red_asterik"></span></label>
                                    <input type="text"  name="date_of_issuance" class="form-control date_of_issuance" value="{{ old('date_of_issuance') }}" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title<span class="red_asterik"></span></label>
                                    <input type="text"  name="title" class="form-control" placeholder="Title"  value="{{ old('title') }}" required/>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Project</label>
                                     {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                     NULL, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Employee</label>
                                    <select name="issued_person_id" class="form-control select2 select_employee">
                                        
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Region<span class="red_asterik"></span></label>
                                    <input type="text" name="region" class="form-control" placeholder="Region" value="{{ old('region') }}" required />
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ old('comments') }}</textarea>
                                </div>
                            </div>

                           <table class="table variations_table col-12" id="items_table">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="position-relative form-group"><label  class="">Item Name</label>
                                            {{-- <input type="text"  name="item_name[]" value=""  class="form-control" required/> --}}
                                            <select class="form-control inventory_items item_dropdown_append item_price_select select2" name="item_name[]">
                                            </select>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="position-relative form-group ">
                                            <label for="price" class="required">Item Quantity</label>
                                            <input name="item_quantity[]" type="number" class="form-control qty_chk" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="position-relative form-group ">
                                            <label for="price" class="required">Item Cost</label>
                                            <input name="item_cost[]" type="number" class="form-control price_0" required readonly>
                                        </div>
                                    </td>

                                </tr>
                                {{-- @endif --}}

                            </tbody>
                        </table>

                        @if($errors->any())
                            <div class="col-12" style="margin:20px;">
                                @error('item_name[]')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                                @error('item_quantity[][]')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                                @error('item_cost[]')
                                <span class="alert alert-warning col-4">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif


                        <div class="col-12">
                            <button class="btn btn-secondary add_variation" >
                                <i data-feather='plus'></i> Add Item
                            </button>
                        </div>


                        <div class="mb-3 mt-20 col-4" style="margin-top: 20px;">
                            <small>**multiple items can be selected</small><br/>
                            <label for="formFileMultiple" class="form-label">File Attachment</label>
                            <input class="form-control" type="file" name="images[]" id="file-input" multiple>
                            <small>files supported jpg | jpeg | png | pdf</small><br/>
                        </div>

                        <div class="col-12" style="margin-bottom: 20px;">
                            <div id="preview" class="gallery col-12"></div>
                            <div id="preview_pdf" class="gallery col-12"></div>
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
{!! JsValidator::formRequest('App\Http\Requests\Project_inventory_issuance'); !!}


<script>

   var items = "";
   var items_list=[];

    $(function(){

        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_issuance').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',

        });


        $(".select_project").change(function(){

            project_id = $('.select_project').val();
            $.ajax({
                 url:'{{ route('getProjects')}}',
                 data: {
                     "_token": "{{ csrf_token() }}",
                     "project_id":project_id
                 },
                 method: 'post',
                 success: function(data) {

                     items = data.items;

                    $('.inventory_items').html('');


                    $('.inventory_items').append(
                           '<option value=>Select Item</option>'
                    )


                     $.each(items,function(key,value) {
                       $('.inventory_items').append(
                           '<option value='+value.id+'>'+value.item_name+' ( '+value.item_code+' ) '+'</option>'
                       )
                     })

                 },
                 error: function(data)
                 {
                    alert('Error Occured!');
                 }
             });


            //  getting employees
            $.ajax({
                 url:'{{ route('getEmployees')}}',
                 data: {
                     "_token": "{{ csrf_token() }}",
                     "project_id":project_id
                 },
                 method: 'post',
                 success: function(data) {

                    employees = data.employees;
                   
                    $('.select_employee').html('');


                    $('.select_employee').append(
                           '<option value=>Select Employee</option>'
                    )


                     $.each(employees,function(key,value) {
                       $('.select_employee').append(
                           '<option value='+value.id+'>'+value.name+' ( '+value.employee_damcon_id+' )'+'</option>'
                       )
                     })

                 },
                 error: function(data)
                 {

                 }
             });


         });



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
    document.querySelector('#file-input').addEventListener("change", previewImages);


    
    function selectRefresh() {
        $('.select2').select2();
    }

    //  repeater fields
    var increment = 0;

    $('.add_variation').click(function name(params) {
       
        event.preventDefault();
        items_list=[];

        $(".item_dropdown_append").find(':selected').each(function( index ) {
                items_list.push($(this).val());
        });

        var content = '';
        content +='<tr>';
        content +='<td>';
        content +='<div class="position-relative form-group"><label>Item Name</label>';
        content +='<select class="form-control select2 item_dropdown_append inventory_items" name="item_name[]" onChange="getPrice(event,'+increment+')">';
        content +='<option value=>Select Item</option>';
            $.each(items,function(key,value){
                if(items_list.includes(value.id.toString())){
                        var check_list = "disabled";
                       
                }else{
                        var check_list = "";

                }
                content +='<option value='+value.id+' '+check_list+'>'+value.item_name+' ( '+value.item_code+' )'+'</option>';
        });
        content +='</select>';
        content +='</div>';
        content +='</td>';
        content +='<td><div class="position-relative form-group ">';
        content +='<label  class="required">Item Quantity</label>';
        content +='<input name="item_quantity[]" type="number" class="form-control qty_chk qty_'+increment+'"  required>';
        content +='</div></td>';
        content +='<td><div class="position-relative form-group ">';
        content +='<label  class="required">Item Cost</label>';
        content +='<input name="item_cost[]" type="number" class="form-control price_'+increment+'" required readonly>';
        content +='</div></td>';
        content +='<td class="text-center"><button class="btn btn-secondary delete_variation_row" style="margin-top:20px;" onclick="delete_item()">';
        content +='<i class="fa fa-times"></i>';
        content +='</button></td>';
        content +='</tr>';


        $('#items_table tr:last').after(content);
        increment++;

        selectRefresh();

    });


    $("#items_table").on('click', '.delete_variation_row', function () {
            event.preventDefault();
            $(this).closest('tr').remove();
    });



    $('.item_price_select').change(function() {
       var me = $(this);
       var item_value = $('.item_price_select').val();

       $.each(items,function(key,value) {
            if(item_value == value.id)
            {
            //me.parent().parent().siblings().find('.price|').val(value.average_unit_cost);
            //  me.parent().parent().siblings().find('.qty_chk').data('data_qty',value.current_closing_stock);
            $('.price_0').val(value.average_unit_cost); 
        }

        })

    });


    });


    function getPrice(event,id){
        var select2_obj = event.target;

        var item_value = event.target.value;

        $.each(items,function(key,value) {

            if(item_value == value.id)
            {

                $(`.price_${id}`).val(value.average_unit_cost);
                // $(`.qty_${id}`).data('data_qty',value.current_closing_stock);

            }

        });
    }  
    


    $(document).on('keyup', '.qty_chk', function(e){
        $exist_qty = $(this).data('data_qty');
        $qty = $(this).val();
        if($qty > $exist_qty)
        {
            // alert('Entered quantity is more than a the stock!');
            // $(this).val($exist_qty);
        }
    })

       

    
    $(".inventory_items").on('change',function (){
        var id = event.target.value;
        items_list.push(id);
    });


</script>

@endsection

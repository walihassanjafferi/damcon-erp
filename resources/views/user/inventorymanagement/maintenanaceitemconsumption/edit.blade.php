@extends('layout.main')
@section('maintenanace_consumption_sidebar') active @endsection
@section('title')
<title>Damcon ERP - Maintenance Item Consumption</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('maintenanaceitemconsumption.index')}} @endsection
@section('main_btn_text') All Maintenance Item Consumption @endsection
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
                    <h4 class="card-title">Edit Maintenance Items Consumption</h4>
                </div>
               
                <div class="card-body">
                    <form action={{ route('maintenanaceitemconsumption.update',encrypt($consumption_item->id)) }}  method="post" class="import_purchases" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="row">
                            <div class="col-md-6 col-12" >
                                <div class="form-group">
                                    <label>Date of Issuance<span class="red_asterik"></span></label>
                                    <input type="text"  name="date_of_issuance" class="form-control date_of_issuance" value="{{ $consumption_item->date_of_issuance }}" required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text"  name="title" class="form-control" placeholder="Title"  value="{{ $consumption_item->title }}" required/>
                                </div>
                            </div>
                    

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Project<span class="red_asterik"></span></label>
                                     {!! Form::select('project_id',$projects+[NULL=>'Select Project'],
                                     $consumption_item->project_id, ['class' => 'form-control select2 select_project','required'=>'true','id'=>'select_project','disabled']) !!}
 
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Damcon Asset<span class="red_asterik"></span></label>
                                     {!! Form::select('damcon_assset_id',$assets+[NULL=>'Select Damcon Asset'],
                                      $consumption_item->damcon_assset_id, ['class' => 'form-control select2 select_project','required'=>'true']) !!}
 
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Possession</label>
                                    <input type="text" name="current_possession" class="form-control" placeholder="Current Possession" value="{{ $consumption_item->current_possession }}" required />
                                </div>
                            </div>

                            {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Employee</label>
                                     {!! Form::select('issued_person_id',['1'=>'Murtaza Ahmed','Ali Haider','Baggu khoy wala','Munna Ustad'],$consumption_item->issued_person_id
                                     , ['class' => 'form-control select2','required'=>'true']) !!}
 
                                </div>
                            </div> --}}


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                     <label>Select Employee<span class="red_asterik"></span></label>
                                    <select name="issued_person_id" class="form-control select2 select_employee">
                                        
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Current Mileages / Hours of Asset</label>
                                    <input type="text" name="milage_hours" class="form-control" placeholder="Current Mileages / Hours of Asset" value="{{ $consumption_item->milage_hours }}" required />
                                </div>
                            </div>

                        
                    
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Comments<span class="red_asterik"></span></label>
                                    <textarea name="comments"  class="form-control" rows="3"  required>{{ $consumption_item->comments }}</textarea>
                                </div>
                            </div>  



                           <table class="table variations_table col-12" id="items_table">
                            <thead>
                            </thead>
                            <tbody>
                                @foreach ($sub_items as $val)
                                <tr>
                                    <td>
                                        <div class="position-relative form-group"><label  class="">Item Name</label>
                                            
                                            <select class="form-control inventory_items item_price_select" name="item_name[]" disabled>
                                                <option value='NULL'>Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{$item->id}}"  {{$val->inventory_id == $item->id ? 'selected':''}}>{{$item->item_name}}</option>
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                    </td>
                                    <td>
                                        <div class="position-relative form-group ">
                                            <label for="price" class="required">Item Quantity</label>
                                            <input name="item_quantity[]"  value ="{{$val->item_quantity}}"  type="number" class="form-control quantity_hello" required disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="position-relative form-group ">
                                            <label for="price" class="required">Item Cost</label>
                                            <input name="item_cost[]" type="number" class="form-control price" value ="{{$val->item_cost}}"  required readonly disabled>
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach

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
                        <input type="text" id="remove_images" name="remove_images" hidden/>
                     
                        @if(isset($files) && count($files))
                            <div class="col-12"></div>
                            <?php $pdf = array(); ?>
                            @foreach ($files as $path) 
                                @if(!preg_match("/\.(pdf)$/", $path))
                                    <span class="pip col-3">
                                        <a  class="remove" href={{$path}}><i class="fa fa-times"></i></a>
                                        <img class="images_upload" type="file" src="{{ asset('/storage/maintenance_items_issuance/'.$path) }}"/>
                                    </span>
                                @else
                                <?php array_push($pdf,$path) ?>                                
                                @endif
                            @endforeach
                        @endif
                          
                        @if(isset($pdf))
                                <div class="col-12 mt-3" ></div>
                                @foreach ($pdf as $item)
                                    <span class="col-3 pip">
                                        <a  class="remove" href={{$item}}><i class="fa fa-times"></i></a>
                                        <a class="pdf_file" href="{{ asset('/storage/maintenance_items_issuance/PDF/'.$path) }}" target="_blank">{{$item}}</a>
                                    </span>
                                @endforeach
                        @endif
                        

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


<script>
   
   var items = {!! json_encode($items->toArray()) !!};
   var employee_id = {!! $consumption_item->issued_person_id  !!};


    $(function(){

        /*Getting Employess*/

        var project_id = $('.select_project').val();
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

                     $('.select_employee').val(employee_id).change();

                },
                error: function(data)
                {

                }
        });

        /*Getting Employess*/




        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.date_of_issuance').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
        
        });


        $('form').bind('submit', function () {
                $(this).find('#select_project').prop('disabled', false);
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

  

    var remove_images = [];
    $(".remove").click(function(){
        event.preventDefault();
        var img_val =  $(this).attr('href');
        remove_images.push(img_val);
        $('#remove_images').val(remove_images);
        img_val = ''
        $(this).parent(".pip").remove();
      
     });
   



    //  repeater fields
    var increment = 0;
  
    $('.add_variation').click(function name(params) {
        event.preventDefault();
        var content = '';
        content +='<tr>';
        content +='<td>';
        content +='<div class="position-relative form-group"><label>Item Name</label>';
        content +='<select class="form-control select2 item_dropdown_append inventory_items" name="item_name[]" onChange="getPrice(event,'+increment+')">';
        content +='<option value=>Select Item</option>';
            $.each(items,function(key,value){
        content +='<option value='+value.id+'>'+value.item_name+'</option>';
        });
        content +='</select>';
        content +='</div>';
        content +='</td>';
        content +='<td><div class="position-relative form-group ">';
        content +='<label  class="required">Item Quantity</label>';
        content +='<input name="item_quantity[]" type="number" class="form-control" required>';
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


    function selectRefresh() {
        $('.select2').select2();
    }
    
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
             me.parent().parent().siblings().find('.price').val(value.cost_per_unit);
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
            
                $(`.price_${id}`).val(value.cost_per_unit);
              
            }

        })
    }




</script>
   
@endsection
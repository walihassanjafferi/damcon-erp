@extends('layout.main')
@section('damconassetsales_sidebar') active @endsection
@section('title')
    <title>Damcon ERP - Damcon Assets Sales</title>
@endsection
{{-- back btn --}}
@section('main_btn_href') {{route('damconassetsales.index')}} @endsection
@section('main_btn_text') All Damcon Assets Sales @endsection
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
                        <h4 class="card-title">Update Assets</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('damconassetsales.update',encrypt($damcon_assets_sale->id))}}"  method="post" class="import_purchases" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Damcon Asset ID</label>
                                        {!! Form::select('asset_id',$assets+[NULL=>'Select Asset ID'],
                                        $damcon_assets_sale->asset_id, ['class' => 'form-control select2 select_asset_id','required'=>'true']) !!}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12" >
                                    <div class="form-group">
                                        <label>Asset Brand<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="asset_brand" class="form-control asset_brand" placeholder="Asset Brand" value="{{ $damcon_assets_sale->asset_brand }}" readonly required/>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Model<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="model" class="form-control model" placeholder="Model" value="{{ $damcon_assets_sale->model }}" readonly required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Registration Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="registration_number" class="form-control registration_no" placeholder="Registration Number" value="{{ $damcon_assets_sale->registration_number }}" readonly required />
                                    </div>
                                </div>



                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="engine_name" class="form-control engine_name" placeholder="Engine Name" value="{{ $damcon_assets_sale->engine_name }}" readonly required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Chassis Number<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="chassis_number" class="form-control chassis_number" placeholder="Chassis Number" value="{{ $damcon_assets_sale->chassis_number }}"  readonly required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Color<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="color" class="form-control color" placeholder="Color" value="{{ $damcon_assets_sale->color }}" readonly required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Engine Capacity<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="engine_capacity" class="form-control engine_capacity" placeholder="Engine Capacity" value="{{ $damcon_assets_sale->engine_capacity }}" readonly required />
                                    </div>
                                </div>


                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Mileage/Hours on Purchase<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="milage" class="form-control milage_hours_purchase" placeholder="Mileage/Hours on Purchase" value="{{ $damcon_assets_sale->milage }}" readonly required />
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Last Mileage/Hours<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="last_milage_hours" class="form-control last_milage_hours" placeholder="Last Mileage/Hours" value="{{ $damcon_assets_sale->last_milage_hours }}"  required />
                                    </div>
                                </div>


                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Purchase Price<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off" name="purchase_price" class="form-control purchase_price" placeholder="Purchase Price" value="{{ $damcon_assets_sale->purchase_price }}" readonly required />
                                    </div>
                                </div>



                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Last Depreciated Price<span class="red_asterik"></span></label>
                                        <input type="text" readonly autocomplete="off" name="asset_last_price" class="form-control asset_last_price" placeholder="Asset Last Price" value="{{ $damcon_assets_sale->asset_last_price }}"  />
                                    </div>
                                </div>



                                <div class="col-md-3 col-12" >
                                    <div class="form-group">
                                        <label>Date of Purchase<span class="red_asterik"></span></label>
                                        <input type="text" autocomplete="off"  name="date_of_purchase" class="form-control date_of_purchase" placeholder="Date of Purchase" value="{{ $damcon_assets_sale->date_of_purchase }}" readonly required/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Select Bank<span class="red_asterik"></span></label>
                                        <select class="form-control select2 banks" name="bank_id">
                                            @foreach ($bankaccounts as $item)
                                                <option @if($damcon_assets_sale->bank_id == $item->id){{ 'selected' }}@endif value="{{$item->id}}" {{ old('sender_bank_id') == $item->id ? "selected" : "" }}>{{$item->name}} ({{$item->title}})</option>
                                            @endforeach
                                        </select>
                                        <span class="error-help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-5 col-12">
                                    <div class="form-group">
                                        <label>Cheque number<span class="red_asterik"></span></label>
                                        <input class="form-control avaliable_balance" required=""  name="cheque_no" value="{{ $damcon_assets_sale->cheque_no }}" type="text">

                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Sale Price<span class="red_asterik"></span></label>
                                        <input class="form-control sale_price" required=""  name="sale_price" value="{{ $damcon_assets_sale->sale_price }}" type="text">

                                    </div>
                                </div>



                                <div class="col-md-12 col-12">
                                    @error('specifications_1')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 1<span class="red_asterik"></span></label>
                                        <textarea name="specifications_1" class="form-control " rows="4"  required>{{ $damcon_assets_sale->specifications_1 }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    @error('specifications_2')
                                    <div class="help-block error-help-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label>Technical Specifications 2<span class="red_asterik"></span></label>
                                        <textarea name="specifications_2" class="form-control " rows="4"  required>{{ $damcon_assets_sale->specifications_2 }}</textarea>
                                    </div>
                                </div>

                                @error('description_input')
                                <div class="help-block error-help-block">{{ $message }}</div>
                                @enderror

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description_input" class="form-control" rows="4"  required>{{ $damcon_assets_sale->description_input }}</textarea>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Sold Party Details</label>
                                        <textarea name="sold_party_details" class="form-control" rows="4"  required>{{ $damcon_assets_sale->sold_party_details }}</textarea>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Comments<span class="red_asterik"></span></label>
                                        <textarea name="comments"  class="form-control comments" rows="3"  required>{{ $damcon_assets_sale->comments }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\DamconAssetSalesRequest'); !!}
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <script>

        var items = "";
        $(function(){

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

            $('.date_of_purchase').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.date_of_depreciation').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('.last_date_of_depreciation').datepicker({
                format: 'yyyy-mm-dd',
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });


            CKEDITOR.replace('description_input');
            CKEDITOR.replace('specifications_1');
            CKEDITOR.replace('specifications_2');
            CKEDITOR.replace('sold_party_details');

        });


        $(".select_asset_id").change(function(){
            asset_id = $('.select_asset_id').val();

            if(asset_id){
                $.ajax({
                    url:'{{ route('damcom_get_assets_sales')}}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "asset_id":asset_id
                    },
                    method: 'post',
                    success: function(data) {

                        if(data.success == true){
                            var response = data.message;
                            $(".date_of_purchase").val(response.date_of_purchase);
                            $(".asset_brand").val(response.asset_brand);
                            $(".model").val(response.model);
                            $(".registration_no").val(response.registration_no);


                            $(".engine_name").val(response.engine_no);
                            $(".chassis_number").val(response.chasssis_no);
                            $(".color").val(response.color);
                            $(".engine_capacity").val(response.engine_capacity);
                            $(".milage_hours_purchase").val(response.milage_hours);
                            $(".purchase_price").val(response.purchase_price);

                            CKEDITOR.replace('specifications_1');
                            CKEDITOR.replace('specifications_2');
                            CKEDITOR.replace('description_input');

                            CKEDITOR.instances['specifications_1'].setData(response.technical_specification_1);
                            CKEDITOR.instances['specifications_2'].setData(response.technical_specifications_2);
                            CKEDITOR.instances['description_input'].setData(response.description);


                            $(".comments").val(response.comments);

                            if(data.data.record == true){
                                $(".last_date_of_depreciation").val(data.data.date);
                                $(".asset_last_price").val(data.data.price);
                            }else {
                                $(".last_date_of_depreciation").val("");
                                $(".asset_last_price").val("");
                            };
                        }
                    },
                    error: function(data)
                    {
                        alert("Asset Item not found");
                    }
                });
            }

        });
    </script>

@endsection

@extends('master')

@section('title') Inventory | Edit @endsection

@section('css')
{!! Html::style('global/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
{!! Html::style('global/plugins/summernote/dist/summernote.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
{!! Html::script('global/plugins/summernote/dist/summernote.js') !!}
{!! Html::script('js/inventory.js') !!}
@endsection

@section('script')
<script>

var iconUrl = "{!!url('img/ICO')!!}";
var item = {{ $item->id }};
var possibleSuppliers = {!! $item->suppliers[0] !!};

var selected = [<?php

    $result = '';
    if($item->category_id != null) {
        $roots = $item->category->getAncestorsAndSelf();
        foreach ($roots as $root)
        {
            $result .= $root->id.',';
        }
    } else {
        $result = 1;
    }
    echo substr($result, 0, -1);

    ?>];


    jQuery(document).ready(function() {
        $('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });

        $('#categories').on('change', '.bs-select', function() {
            $(this).parent().closest('.category').nextAll().remove();
            updateCategories( $(this).val(), null);
        });

        $('#brand').on('change', function() {
            changeBrand( $(this).val(), item );
        });


        $('#btn-generateSKU').on('click', function() {
            $.ajax({
                url: APP_URL + '/inventory/{!! $item->id !!}/generateSku',
                dataType: 'json',
                success: function( data ) {
                    $("input[name=sku]").val(data.code);
                }
            });
        });

        $('#btn-download').on('click', function() {
            downloadToolInfo();
            return false;
        });

        $('#btn-save').on('click', function() {
            $.ajax({
                url: APP_URL + '/inventory/{!! $item->id !!}/save',
                data: $('form').serialize() + '&description=' + encodeURIComponent( $('#summernote_1').summernote('code') ),
                dataType: 'json',
                success: function( data ) {
                    console.log(data);
                }
            });
            return false;
        });

        generateSelectBoxes( {{ $item->category_id }} );

        $('#summernote_1').summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']]
            ]});

        });
        </script>
        @endsection


        @section('content')
        <form class="form-horizontal form-row-seperated" method="get">
            <div class="page-bar">
                <div class="row p-t-10 p-b-10">
                    <div class="col-md-2">
                        @if($item->getNextPrev()->prev)
                        <a href="{!!url('inventory/'.($item->getNextPrev()->prev->id).'/edit')!!}" class="btn default"><i class="fa fa-arrow-left"></i> {{ $item->getNextPrev()->prev->id }}</a>
                        @endif

                        <button id="btn-save" class="btn blue">Save</button>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group col-md-12">
                            <span class="input-group-btn">
                                <button id="btn-download" class="btn blue" type="button">Download Details from</button>
                            </span>
                            <select id="supplier" name="supplier_id" class="form-control">
                                @if($item->brand)
                                    @foreach(App\Models\Supplier::getSuppliersByBrand($item->brand->id, true) as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-7">
                        @if($item->getNextPrev()->next)
                        <a href="{!!url('inventory/'.($item->getNextPrev()->next->id).'/edit')!!}" class="btn default pull-right">{{ $item->getNextPrev()->next->id }} <i class="fa fa-arrow-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 p-t-10">
                    <div class="portlet box">
                        <div class="portlet-body form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Serialnr</label>
                                                <div class="col-md-9">
                                                    <input value="{{ $item->serialnr }}" type="text" class="form-control" name="serialnr">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Name</label>
                                                <div class="col-md-9">
                                                    <input name="name" type="text" class="form-control" value="{{ $item->name }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Supplier Name</label>
                                                <div class="col-md-9">
                                                    <input value="{{ $item->getDetails()['title'] }}" type="text" class="form-control" name="title">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Barcode</label>
                                                <div class="col-md-9">
                                                    <input value="{{ $item->getBarcode() }}" type="text" class="form-control" name="barcode">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Sku</label>
                                                <div class="col-md-9">
                                                    <div class="input-group col-lg-8">
                                                        <input value="{!! $item->getSku() !!}" type="text" class="form-control" name="sku">
                                                        <span class="input-group-btn">
                                                            <button id="btn-generateSKU" class="btn grey" type="button">Generate SKU</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Brand</label>
                                                <div class="col-md-4">
                                                        <select id="brand" name="brand_id" class="form-control">
                                                            @foreach($suppliers as $supplier)
                                                                @if($supplier->producer && $item->brand)
                                                                    <option value="{{ $supplier->id }}" {{ ($supplier->id == $item->brand->id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
                                                                @elseif($supplier->producer)
                                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Description</h4>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-1"></label>
                                                <div class="col-md-11">
                                                    <div name="description" id="summernote_1">
                                                        {!! isset($item->details) ? $item->details->description : '' !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-5" >
                                    <h4 class="form-section">Category</h4>
                                    <div id="categories">

                                    </div>

                                    <h4 class="form-section">Pictures</h4>
                                    <table id="pictures" class="table table-bordered table-hover">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th> Image </th>
                                                <th width="1%">First</th>
                                                <th width="1%"></th>
                                                <th width="1%"></th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach($item->pictures as $picture)
                                                    <?php $i = $i + 1; ?>

                                                <tr>
                                                    <td>
                                                        <img id="image{{ $i }}" class="img-responsive" src="{{url('files/'.$picture->path.$picture->title)}}" alt="">
                                                        <input name="images[image][]" type="hidden" value="{{$picture->title}}"></td>
                                                    <td>
                                                        <label><input type="radio" name="picture" value="{{$picture->title}}" {{ ($picture->pivot->first_choice == 1) ? 'checked' : '' }}> </label></td>
                                                    <td>
                                                        <a href="javascript:cropPicture({{ $i }}, '{{$picture->title}}');" class="btn btn-default btn-xs">Crop</a></td>
                                                    <td>
                                                        <a href="javascript:removePicture();" class="btn btn-default btn-xs"><i class="fa fa-times"></i> </a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @endsection

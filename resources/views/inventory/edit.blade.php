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


        $('#btn-generateSKU').on('click', function() {
            $.ajax({
                url: APP_URL + '/inventory/{!! $item->id !!}/generateSku',
                dataType: 'json',
                success: function( data ) {
                    $("input[name=sku]").val(data.code);
                }
            });
        });

        $('#btn-save').on('click', function() {
            $.ajax({
                url: APP_URL + '/inventory/{!! $item->id !!}/save',
                data: $('form').serializeArray(),
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


            var _data;
            var downloadToolInfo = function(supplier_id, searchstr){
                $.ajax({
                    url: "{!! url('plugins/download') !!}",
                    cache: false,
                    dataType: "json",
                    data: {supplier_id: supplier_id, searchstr: searchstr},
                    success: function(data){
                        console.log(data);
                        /*_data = data;
                        $('input[name=title1]').val(data.title1);
                        $('input[name=title2]').val(data.title2);
                        $('textarea[name=description]').html(data.description);

                        var html;
                        data.images.forEach(function(url){
                            $('#images').append('<img src="'+ url +'"><br>');
                        });

                        $('#tool_info').show();
                        $('.save').show();*/
                    },
                    error: function( XMLHttpRequest, jqXHR, textStatus ){
                        console.log(XMLHttpRequest);
                    }
                });
            }

            var saveToolInfo = function(id, data){

                data.title1 = $('input[name=title1]').val();
                data.title2 = $('input[name=title2]').val();
                data.description = $('textarea[name=description]').val();
                //console.log(data);

                $.ajax({
                    url: "{!! url('plugins/download/save') !!}",
                    cache: false,
                    data: {id: id, data: data},
                    success: function(ev){
                        console.log(ev)
                        $('#tool_info').hide();
                        //$('.save').hide();
                    },
                    error: function( XMLHttpRequest, jqXHR, textStatus ){
                        console.log(XMLHttpRequest);
                    }
                });
            }

            $('#btn-download').on('click', function() {
                downloadToolInfo( $("select[name='supplier_id']").val(), $("input[name='name']").val() );
                return false;
            });


        });
        </script>
        @endsection


        @section('content')
        <form class="form-horizontal form-row-seperated" method="get">
            <div class="page-bar">
                <div class="row p-t-10 p-b-10">
                    <div class="col-md-12">
                        @if($item->getNextPrev()->prev)
                        <a href="{!!url('inventory/'.($item->getNextPrev()->prev->id).'/edit')!!}" class="btn default"><i class="fa fa-arrow-left"></i> {{ $item->getNextPrev()->prev->id }}</a>
                        @endif

                        <button id="btn-save" class="btn blue">Save</button>
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
                                                <label class="control-label col-md-2">Serialnr</label>
                                                <div class="col-md-10">
                                                    <input value="{{ $item->serialnr }}" type="text" class="form-control" name="serialnr">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Name</label>
                                                <div class="col-md-10">
                                                    <input name="name" type="text" class="form-control" value="{{ $item->name }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Alt. Name</label>
                                                <div class="col-md-10">
                                                    <input value="{{ $item->name0 }}" type="text" class="form-control" name="name0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Barcode</label>
                                                <div class="col-md-8">
                                                    <input value="{{ $item->getBarcode() }}" type="text" class="form-control" name="barcode">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">Sku</label>
                                                <div class="col-md-10">
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
                                                <label class="control-label col-md-2">Brand</label>
                                                <div class="col-md-10">
                                                    <div class="input-group col-lg-8">
                                                        <select name="supplier_id" class="form-control">
                                                            @foreach($suppliers as $supplier)
                                                            @if($supplier->producer)
                                                            <option value="{{ $supplier->id }}" {{ ($supplier->id == $item->supplier_id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button id="btn-download" class="btn grey" type="button">Download Details</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="form-section">Description</h4>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-1"></label>
                                                <div class="col-md-11">
                                                    <div name="summernote" id="summernote_1"></div>
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
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th> Image </th>
                                                <th width="1%">First</th>
                                                <th width="1%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="../assets/pages/media/works/img1.jpg" class="fancybox-button" data-rel="fancybox-button">
                                                        <img class="img-responsive" src="../assets/pages/media/works/img1.jpg" alt=""> </a>
                                                    </td>
                                                    <td>
                                                        <label><input type="radio" name="product[images][1][image_type]" value="3" checked> </label>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-times"></i> Remove </a>
                                                    </td>
                                                </tr>
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

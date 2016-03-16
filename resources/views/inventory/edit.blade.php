@extends('master')

@section('title') Inventory | Edit @endsection

@section('css')
{!! Html::style('global/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
{!! Html::style('global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
{!! Html::script('global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') !!}
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
                                </div>
                            </div>
                            <div class="col-lg-5" >
                                <h4 class="form-section">Category</h4>
                                <div id="categories">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @endsection

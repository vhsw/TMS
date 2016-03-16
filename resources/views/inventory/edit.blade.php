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
        $(this).parent().closest('div').nextAll().remove();
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
            <div class="col-sm-2">
                @if($item->getNextPrev()->prev)
                <a href="{!!url('inventory/'.($item->getNextPrev()->prev->id).'/edit')!!}" class="btn default"><i class="fa fa-arrow-left"></i> {{ $item->getNextPrev()->prev->id }}</a>
                @endif
            </div>
            <div class="col-sm-10">
                <button id="btn-save" class="btn blue">Save</button>
                @if($item->getNextPrev()->next)
                <a href="url('tool/'.({{ $item->getNextPrev()->next->id }}).'/edit')" class="btn default pull-right">{{ $item->getNextPrev()->next->id }} <i class="fa fa-arrow-right"></i></a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 p-t-20">

            <div class="tabbable-bordered">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_general" data-toggle="tab"> General </a>
                    </li>
                    <li>
                        <a href="#tab_supplier" data-toggle="tab"> Supplier </a>
                    </li>
                    <li>
                        <a href="#tab_download" data-toggle="tab"> Download Supplier Info </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_general">

                        <div class="form-body">

                            <h4 class="form-section">Basic</h4>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Serialnr
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $item->serialnr }}" type="text" class="form-control" name="serialnr">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $item->name }}" type="text" class="form-control" name="name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name 0
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $item->name0 }}" type="text" class="form-control" name="name0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">barcode
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $item->getBarcode() }}" type="text" class="form-control" name="barcode">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Sku
                                </label>
                                <div class="col-md-5">
                                    <div class="input-group input-large">
                                        <input value="{!! $item->getSku() !!}" type="text" class="form-control" name="sku">
                                        <span class="input-group-btn">
                                            <button id="btn-generateSKU" class="btn blue" type="button">Generate SKU</button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Brand
                                </label>
                                <div class="col-md-3">
                                    <select name="supplier_id" class="form-control">
                                        @foreach($suppliers as $supplier)
                                        @if($supplier->producer)
                                        <option value="{{ $supplier->id }}" {{ ($supplier->id == $item->supplier_id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <h4 class="form-section">Category</h4>

                            <div class="form-group">
                                <label class="col-md-1 control-label">
                                </label>
                                <div id="categories">

                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="tab_supplier">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-body">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <th>Supplier</th>
                                        <th>Cost</th>
                                        <th>Updated</th>
                                    </thead>
                                    <tbody>




                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="tab_download">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="sr-only">Download From</label>
                                        <select name="tool_info_supplier" class="form-control">
                                            foreach($suppliers_tool_info as $supplier_tool_info)
                                            <option value="supplier_tool_info->id" SELECTED>supplier_tool_info->name</option>
                                            endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="sr-only">Search String</label>
                                        <input value="tool->name0" type="text" class="form-control" name="searchstr">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-info download">Download</button>
                                        <button class="btn blue save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    if ($detail)
                    Details was last downloaded   \App\Services\CustomDate::formatHuman($detail->updated_at)
                    endif


                </div>
            </div>
        </div>
    </div>
</div>
</form>

    @endsection

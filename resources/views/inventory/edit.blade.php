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
@endsection

@section('script')
<script>
var iconUrl = "{!!url('img/ICO')!!}";

var selected = [<?php

    $result = '';
    if($inventory->category_id != null) {
        $roots = $inventory->category->getAncestorsAndSelf();
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

    var generateSelect = function(id, data, selected){
        var select = '<div id="category-' + id + '" class="col-md-2">'
        +'<select name="category[]" class="bs-select form-control" data-show-subtext="true">'
        +'<option value="0" data-content=""></option>';

        $.each(data, function(i, category){
            var icon = '<img src=\'' + iconUrl + '/' + category.icon + '.png\' height=\'22px\'>';

            var s = '';
            console.log(category.id);
            if(category.id == selected) {
                s = 'SELECTED';
            }
            select = select+'<option value="' + category.id + '" data-content="' + icon + ' '
            + category.name + '" ' + s + '> ' + category.name + '</option>';
        });
        select = select + '</select></div>';

        $("#categories").append(select);
    }

    var updateCategories = function(id, selected){
        $.ajax({
            url: '{!!url("categories/get-immediate-descendants")!!}',
            dataType: 'json',
            data: {id: id},
            success: function( data ) {
                console.log(data);
                if(data.length != 0) {
                    generateSelect( id, data, selected );
                    $('.bs-select').selectpicker('refresh');
                }
            }
        });
    }

    var generateSelectBoxes = function(id) {
        $.ajax({
            url: '{!!url("categories/generate-select-boxes")!!}',
            dataType: 'json',
            data: {id: id},
            success: function( data ) {
                if(data.length != 0) {
                    $.each(data, function(i, categories){
                        generateSelect( id, categories, selected[i+1] );
                        $('.bs-select').selectpicker('refresh');
                    });
                }
            }
        });
    }

    $('#categories').on('change', '.bs-select', function() {
        $(this).parent().closest('div').nextAll().remove();

        updateCategories( $(this).val(), null );
    });

    generateSelectBoxes( {{ $inventory->category_id }} );

});
</script>
@endsection


@section('content')

<form class="form-horizontal form-row-seperated" method="get" action="{!!url('inventory/'.$inventory->id.'/save')!!}">
    <div class="page-bar">
        <div class="row p-t-10 p-b-10">
            <div class="col-sm-2">
                if(navigate['prev'])
                <a href="{!!url('tool/edit')!!}" class="btn default"><i class="fa fa-arrow-left"></i> navigate['prev'] </a>
                endif
            </div>
            <div class="col-sm-10">
                <button class="btn blue">Save</button>
                <button type="submit" class="btn blue">Save</button>
                if(navigate['next'])
                <a href="url('tool/'.(navigate['next']).'/edit')" class="btn default pull-right">navigate['next'] <i class="fa fa-arrow-right"></i></a>
                endif
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
                                    <input value="{{ $inventory->serialnr }}" type="text" class="form-control" name="serialnr">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $inventory->name }}" type="text" class="form-control" name="name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name 0
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $inventory->name0 }}" type="text" class="form-control" name="name0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">barcode
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $inventory->getBarcode() }}" type="text" class="form-control" name="barcode">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Sku
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $inventory->getSku() }}" type="text" class="form-control" name="sku">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Brand
                                </label>
                                <div class="col-md-3">
                                    <select name="supplier_id" class="form-control">
                                        @foreach($suppliers as $supplier)
                                        @if($supplier->producer)
                                        <option value="{{ $supplier->id }}" {{ ($supplier->id == $inventory->supplier_id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
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

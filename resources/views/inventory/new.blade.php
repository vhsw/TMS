@extends('master')

@section('title') Inventory | New @endsection

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

jQuery(document).ready(function() {
    $('.bs-select').selectpicker({
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });


    $('#categories').on('change', '.bs-select', function() {
        $(this).parent().closest('div').nextAll().remove();

        updateCategories( $(this).val(), null );
    });

    updateCategories( 1, null );

});
</script>
@endsection


@section('content')

<form class="form-horizontal form-row-seperated" method="post" action="{!!url('inventory/create')!!}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="page-bar">
        <div class="row p-t-10 p-b-10">
            <div class="col-sm-10">
                <button type="submit" class="btn blue">Save</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Add New Inventory </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="form-horizontal">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-4">
                                    <input name="name" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Alternative name</label>
                                <div class="col-md-4">
                                    <input name="name0" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Serialnr</label>
                                <div class="col-md-4">
                                    <input name="serialnr" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Barcode / SKU</label>
                                <div class="col-md-4">
                                    <input name="sku" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Brand</label>
                                <div class="col-md-4">
                                    <select name="supplier_id" class="form-control">
                                        @foreach($suppliers as $supplier)
                                        @if($supplier->producer)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        @endsection

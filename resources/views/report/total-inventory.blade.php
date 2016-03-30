@extends('master')

@section('title') Tools | Browse @endsection

@section('css')
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
{!! Html::style('global/plugins/icheck/skins/all.css') !!}
@endsection


@section('js')
{!! Html::script('global/scripts/datatable.js') !!}
{!! Html::script('global/plugins/datatables/media/js/jquery.dataTables.js') !!}
{!! Html::script('global/plugins/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js') !!}
{!! Html::script('global/plugins/amcharts3/amcharts/amcharts.js') !!}
{!! Html::script('global/plugins/amcharts3/amcharts/serial.js') !!}
@endsection

@section('script')
<script>

$( document ).ready(function() {
    var table = $('#table1');
    // begin first table
    table.dataTable({
        "autoWidth": false,
        "lengthMenu": [
            [10, 20, 50, -1],
            [10, 20, 50, "All"] // change per page values here
        ],
        "pageLength": 10
    });
});


var initChart = function() {
        var chart = AmCharts.makeChart("chart", {
            "theme": "light",
            "type": "serial",
            "startDuration": 2,

            "fontFamily": 'Open Sans',

            "color":    '#888',

            "dataLoader": {
                "url": APP_URL + "/statistic/total-inventory-per-supplie",
                "format": "json"
            },

            "valueAxes": [{
                "position": "left",
                "axisAlpha": 0,
                "gridAlpha": 0
            }],
            "graphs": [{
                "balloonText": "[[category]]: <b>[[value]]</b>",
                "colorField": "color",
                "fillAlphas": 0.85,
                "lineAlpha": 0.1,
                "type": "column",
                "topRadius": 1,
                "valueField": "value"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "supplier",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0

            },
            "exportConfig": {
                "menuTop": "20px",
                "menuRight": "20px",
                "menuItems": [{
                    "icon": '/lib/3/images/export.png',
                    "format": 'png'
                }]
            }
        }, 0);
    }



$(window).load(function() {
    $('div.dataTables_filter > label').children('input').appendTo('#dataTables_filter').removeClass('input-inline input-sm input-small');
    $('div.dataTables_length > label').children('select').appendTo('#dataTables_length').removeClass('input-inline');
    $('div.dataTables_length').remove();
    $('div.dataTables_filter').remove();

    initChart();
});
</script>
@endsection

@section('content')

<div class="page-bar">
    <div class="row p-t-10 p-b-10">
        <div class="col-md-3">

        </div>
        <div class="col-md-5">

            <div class="input-group input-medium" id="dataTables_filter">
                <span class="input-group-addon">
                    <i class="icon-magnifier"></i>
                </span>
            </div>

        </div>
        <div class="col-md-4">

            <div class="input-group input-small" id="dataTables_length">
                <span class="input-group-addon">
                    <i class="icon-list"></i>
                </span>
            </div>

        </div>
    </div>
</div>



<div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-bar-chart font-green-haze"></i>
                                                <span class="caption-subject bold uppercase font-green-haze"> 3D Chart</span>
                                                <span class="caption-helper">3d cylinder chart</span>
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"> </a>
                                                <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                                <a href="javascript:;" class="reload"> </a>
                                                <a href="javascript:;" class="fullscreen"> </a>
                                                <a href="javascript:;" class="remove"> </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div id="chart" class="chart" style="height: 400px;"> </div>
                                        </div>
                                    </div>



<div class="row">
    <div class="col-lg-12 p-t-20">

        <table class="table table-striped table-bordered table-advance table-hover" id="table1" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="1%">
                        Id
                    </th>
                    <th>
                        Supplier
                    </th>
                    <th>
                        Serialnr
                    </th>
                    <th>
                        Name
                    </th>
                    <th width="1%">
                        Quantity
                    </th>
                    <th width="1%">
                        Value
                    </th>
                    <th width="1%">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($stocks as $stock)
                    @if($stock->quantity > 0)
                    <tr class="odd gradeX">
                        <td>
                            {{ $stock->id }}
                        </td>
                        <td>
                            {{ $stock->item->getCurrentSupplier()->name }}
                        </td>
                        <td>
                            <a href="{!!url('inventory/' . $stock->inventory_id . '/view')!!}">
                                {{ $stock->item->serialnr }}</a>
                            </td>

                            <td>
                                {{ $stock->item->name }}
                            </td>
                            <td>
                                {{ $stock->quantity }}
                            </td>
                            <td>
                                {{ $stock->item->getCurrentSupplierCost() }}
                            </td>
                            <td>
                                {!! ($stock->item->getCurrentSupplierCost() * $stock->quantity) !!}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

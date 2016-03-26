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
{!! Html::script('global/plugins/icheck/icheck.min.js') !!}
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

$(window).load(function() {
    $('div.dataTables_filter > label').children('input').appendTo('#dataTables_filter').removeClass('input-inline input-sm input-small');
    $('div.dataTables_length > label').children('select').appendTo('#dataTables_length').removeClass('input-inline');
    $('div.dataTables_length').remove();
    $('div.dataTables_filter').remove();
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
                        Aisle
                    </th>
                    <th width="1%">
                        Row
                    </th>
                    <th width="1%">
                        Bin
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($stocks as $stock)

                <tr class="odd gradeX">
                    <td>
                        {{ $stock->id }}
                    </td>
                    <td>
                        @if (count($stock->item->suppliers) > 0)
                        {!! $stock->item->suppliers[0]->name !!}
                        @endif
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
                            todo
                        </td>
                        <td>
                            {{ $stock->aisle }}
                        </td>
                        <td>
                            {{ $stock->row }}
                        </td>
                        <td>
                            {{ $stock->bin }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

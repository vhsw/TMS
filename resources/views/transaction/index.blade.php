@extends('master')

@section('title') Requests @endsection

@section('css')
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
{!! Html::style('global/plugins/typeahead.js-bootstrap3.less/typeaheadjs.css') !!}
@endsection

@section('js')
{!! Html::script('js/moment.js') !!}
{!! Html::script('global/scripts/datatable.js') !!}
{!! Html::script('global/plugins/datatables/media/js/jquery.dataTables.js') !!}
{!! Html::script('global/plugins/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js') !!}
{!! Html::script('global/plugins/typeahead.js/dist/typeahead.bundle.min.js') !!}
@endsection

@section('style')
<style>
td {font-size:13px !important;}
</style>
@endsection

@section('script')
<script>
$( document ).ready(function() {

    var toolUrl = "{!!url('inventory')!!}";
    var requestUrl = "{!!url('transaction')!!}";
    var table = $('#table1');

    table.dataTable({
        "bProcessing": true,
        "autoWidth": false,
        "serverSide": true,
        "lengthMenu": [
            [10, 20, 50, -1],
            [10, 20, 50, "All"] // change per page values here
        ],
        "pageLength": 10,
        "order": [[ 1, "desc" ]],
        "ajax":{
            url :"{!!url('transaction/db')!!}", // json datasource
            type: "get",
            error: function(xhr, textStatus, error){  // error handling code
                console.log(textStatus + ": " + error);
                // $(".employee-grid-error").html("");
                //$("#employee_grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                //$("#employee_grid_processing").css("display","none");
            }
        },

        "columns": [
            { "visible" : false},
            null,
            null,
            null,               //{ "visible" : false},
            { "visible" : false},               //{ "visible" : false},
            { "visible" : false},               //{ "width" : "1%", "orderable" : false},
            null,               //{ "width" : "1%"},
            null,               //{ "width" : "1%", "orderable" : false},
            null,               //{"orderable" : false},
            {"data": null, "defaultContent": "", "width" : "1%"}
        ]

        /*"createdRow": function ( row, data, index ){
        var td = $('td', row);
        switch(data[6]){
        case 'REST': btnclass = "warning"; break;
        case 'REQUESTED': btnclass = "danger"; break;
        case 'ORDERED': btnclass = "info"; break;
        case 'RECIEVED': btnclass = "success"; break;
    }
    td.eq(4).html('<span class="label label-'+btnclass+'">'+data[6]+'</span>');

    td.eq(6).html('<span class="hidden">'+data[8]+'</span>'+moment(data[8], 'YYYY-MM-DD HH:mm:ss').add(1, 'h').fromNow());

    if(!data[3] == 0) {
    td.eq(1).html('<a href="'+toolUrl+'/'+data[3]+'/view">'+data[2]+'</a>');
}

td.eq(8).html('<div class="btn-group btn-group-xs btn-group-solid">'+
'<a href="'+requestUrl+'/'+data[0]+'/edit" class="btn blue">Edit</a></div>');
}*/

});
});


$(function() {


    var tools = new Bloodhound({
        datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit: 10,
        remote: {
            url: '{!!url('inventory/typeahead')!!}?query=%QUERY',
            wildcard: '%QUERY',
            filter: function(list) {
                return $.map(list, function(d) { return { tool: d }; });
            }
        }

    });

    tools.initialize();
    $('#tool').typeahead(null, {
        name: 'tool',
        displayKey: 'tool',
        source: tools.ttAdapter()
    });





});


$(window).load(function() {
    $('div.dataTables_filter > label').children('input').appendTo('#dataTables_filter').removeClass('input-inline input-sm input-small').addClass("form-control");
    $('div.dataTables_length > label').children('select').appendTo('#dataTables_length').removeClass('input-inline input-sm input-xsmall').addClass("form-control");
    $('div.dataTables_length').remove();
    $('div.dataTables_filter').remove();
});


$("#btn-add").click(function(){
    reveal();
    $("#form-request").removeClass("hidden").find("input[name='description']").focus();
})


@if (count($errors) > 0)
reveal();
$("#form-request").removeClass("hidden");
@endif

</script>
@endsection


@section('form')
<form action="{!!url('transaction/request')!!}" method="get" id="form-request">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <strong>Error!</strong> {{ $error }}<br>
        @endforeach
    </div>
    @endif

    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input name="name" type="text" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Serialnr</label>
                    <input type="text" name="serialnr" id="tool" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Quantity</label>
                    <div class="input-group input-group-lg input-small">
                        <input name="quantity" type="text" class="form-control input-lg input-small" />
                        <span class="input-group-addon">Stk</span>
                        <span class="input-group-btn pull-right">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Request</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>
@endsection



@section('content')
<div class="page-bar">
    <div class="row p-t-10 p-b-10">
        <div class="col-md-3">

            <button id="btn-add" class="btn blue">Add Request</button>

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
            <table class="table table-striped table-bordered table-hover table-checkable" id="table1">
                <thead>
                    <tr role="row" class="heading">
                        <th>Id</th>
                        <th>State</th>
                        <th>Quantity</th>
                        <th>Updated</th>
                        <th>Quantity</th>
                        <th>User Id</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Serialnr</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

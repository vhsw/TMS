@extends('master')

@section('title') Requests @endsection

@section('css')
{!! HTML::style('global/plugins/datatables/datatables.min.css') !!}
{!! HTML::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
{!! HTML::style('global/plugins/typeahead/typeahead.css') !!}
@endsection

@section('js')
{!! HTML::script('js/moment.js') !!}
{!! HTML::script('global/scripts/datatable.js') !!}
{!! HTML::script('global/plugins/datatables/datatables.js') !!}
{!! HTML::script('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
{!! HTML::script('global/plugins/typeahead/handlebars.min.js') !!}
{!! HTML::script('global/plugins/typeahead/typeahead.bundle.min.js') !!}
@endsection

@section('script')
<script>
$( document ).ready(function() {

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

var toolUrl = "{!!url('tool')!!}";
var requestUrl = "{!!url('tools/request')!!}";
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
        "order": [[ 8, "desc" ]],
        "ajax":{
            url :"{!!url('admin/data/requests/db')!!}", // json datasource
            type: "post",
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
                { "visible" : false},
                { "width" : "1%", "orderable" : false},
                null,
                { "width" : "1%"},
                { "width" : "1%", "orderable" : false},
                null,
                {"orderable" : false},
                {"data": null, "defaultContent": "", "width" : "1%",}
            ],

        "createdRow": function ( row, data, index ){ 
            var td = $('td', row);
            switch(data[6]){
                case 'REST': btnclass = "warning"; break;
                case 'REQUESTED': btnclass = "danger"; break;
                case 'ORDERED': btnclass = "info"; break;
                case 'RECIEVED': btnclass = "success"; break;
            }
            td.eq(4).html('<span class="label label-'+btnclass+'">'+data[6]+'</span>');

            td.eq(6).html('<span class="hidden">'+data[8]+'</span>'+moment(data[8], 'YYYY-MM-DD HH:mm:ss').fromNow());

            if(!data[3] == 0) {
                td.eq(1).html('<a href="'+toolUrl+'/'+data[3]+'/view">'+data[2]+'</a>');
            }

            td.eq(8).html('<div class="btn-group btn-group-xs btn-group-solid">'+
                '<a href="'+requestUrl+'/'+data[0]+'/edit" class="btn blue">Edit</a></div>');
        }

        });
    });  


$(function() {

    
  var tools = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          remote: {
            url: '{!!url('tools/typeahead')!!}?query=%QUERY',
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
<form action="{!!url('tools/requests/create')!!}" method="post" id="form-request">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                <label class="control-label">Description</label>
                <input name="description" type="text" class="form-control input-lg">
            </div>

            <div class="form-group">
                <label class="control-label">Tool Serialnr</label>
                <input type="text" name="serialnr" id="tool" class="form-control input-lg">
            </div> 

            <div class="form-group">
                <label class="control-label">Amount</label>
                <div class="input-group input-group-lg input-small">
                    <input name="amount" type="text" class="form-control input-lg input-small" />
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
<div class="row padding-10">
    <div class="col-sm-3">

        <button id="btn-add" class="btn">Add Request</button> 

    </div>
    <div class="col-sm-5">

        <div class="input-group input-medium" id="dataTables_filter">
        <span class="input-group-addon">
        <i class="icon-magnifier"></i>
        </span>
        </div>

    </div>
    <div class="col-sm-4">

        <div class="input-group input-small" id="dataTables_length">
        <span class="input-group-addon">
        <i class="icon-list"></i>
        </span>
        </div>

    </div>
</div>
</div>



<div class="row">
    <div class="col-md-12">

            <div class="table-container p-t-20">

                    <table class="table table-striped table-bordered table-hover table-checkable" id="table1">
                       <thead>
                       <tr role="row" class="heading">
                            <th>Id</th>
                            <th>Description</th>
                            <th>Tool Serialnr</th>
                            <th>Tool Id</th>
                            <th>Amount</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Updated</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                 <tbody> </tbody>
            </table>
    </div>

</div>
</div>
                   
@endsection
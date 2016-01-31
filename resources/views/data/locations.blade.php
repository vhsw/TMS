@extends('master')

@section('title') Data | Locations @endsection

@section('css')
{!! HTML::style('global/plugins/datatables/datatables.min.css') !!}
{!! HTML::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
@endsection

@section('js')
{!! HTML::script('global/scripts/datatable.js') !!}
{!! HTML::script('global/plugins/datatables/datatables.min.js') !!}
{!! HTML::script('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
@endsection

@section('script')
<script>

$( document ).ready(function() {
var table = $('#table1');
        // begin first table
        table.dataTable({
            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
            "columnDefs": [ {
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
});

$(window).load(function() {
$('div.dataTables_filter > label').children('input').appendTo('#dataTables_filter').removeClass('input-inline input-sm input-small');
$('div.dataTables_length > label').children('select').appendTo('#dataTables_length').removeClass('input-inline');
$('div.dataTables_length').remove();
$('div.dataTables_filter').remove();
//$('#dataTables_filter').addClass('dataTables_filter');
});
</script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="panel-group accordion" id="accordion3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
                    Options </a>
                    </h4>
                </div>
                <div id="collapse_3_1" class="panel-collapse collapse">
                    <div class="panel-body" style="height:100%; overflow-y:auto;">
                        <div class="form-body">
                            <div class="form-group" id="dataTables_filter">
                                <label class="control-label">Search</label>
                            </div>

                            <div class="form-group" id="dataTables_length">
                                <label class="control-label">View per Page</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
                    Generate Locations </a>
                    </h4>
                </div>
                <div id="collapse_3_2" class="panel-collapse">
                    <div class="panel-body">

                        
                    ## TODO: Generate Locations Options

                    </div>
                </div>
            </div>
        </div>
        ## TODO: Show open/closed/empty/amount for every location
    </div>
    <div class="col-md-9">

        <table class="table table-striped table-bordered table-advance table-hover" id="table1" cellspacing="0" width="100%">
               <thead>
                  <tr>
                     <th>
                        Id
                     </th>
                     <th>
                        Location
                     </th>
                     <th>
                        Name
                     </th>
                  </tr>
               </thead>
               <tbody>
                  
@foreach($locations as $location)

              <tr class="odd gradeX">
                     <td>
                        {{ $location->id }}
                     </td>
                     <td>
                        <a href="">
                        {{ $location->location }}</a>
                     </td>
                     <td>
                        {{ $location->name }}
                     </td>
                  </tr>
@endforeach                  
               </tbody>
            </table>
    </div>
</div>
@endsection


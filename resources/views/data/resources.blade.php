@extends('master')

@section('title') Data | Resources @endsection

@section('css')
{!! Html::style('global/plugins/datatables/datatables.min.css') !!}
{!! Html::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
@endsection

@section('js')

{!! Html::script('global/plugins/datatables/datatables.min.js') !!}
{!! Html::script('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
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
});

</script>
@endsection

@section('content')

<div class="page-bar">        
<div class="row p-t-10 p-b-10">
    <div class="col-md-3">

        <button id="btn-add" class="btn blue">Add Resource</button> 

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
                    <th>
                        Id
                     </th>
                     <th>
                        Name
                     </th>
                     <th>
                        Short Name
                     </th>
                     <th>
                        Controller
                     </th>
                  </tr>
               </thead>
               <tbody>
                  
@foreach($resources as $resource)

              <tr class="odd gradeX">
                    <td>
                        {{ $resource->id }}
                     </td>
                     <td>
                        {{ $resource->name }}
                     </td>
                     <td>
                        <a href="">
                        {{ $resource->short_name }}</a>
                     </td>
                     <td>
                        {{ $resource->controller }}
                     </td>
                  </tr>
@endforeach                  
               </tbody>
            </table>

    </div>
</div>
@endsection


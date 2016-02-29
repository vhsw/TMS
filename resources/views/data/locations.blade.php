@extends('master')

@section('title') Data | Locations @endsection

@section('css')
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
@endsection

@section('js')
{!! Html::script('global/scripts/datatable.js') !!}
{!! Html::script('global/plugins/datatables/media/js/jquery.dataTables.js') !!}
{!! Html::script('global/plugins/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js') !!}
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

        <button id="btn-add" class="btn blue">Add Locations</button> 

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


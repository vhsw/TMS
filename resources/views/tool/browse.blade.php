@extends('master')

@section('title') Tools | Browse @endsection

@section('css')
{!! HTML::style('global/plugins/jstree/dist/themes/default/style.css') !!}
{!! HTML::style('global/plugins/datatables/datatables.min.css') !!}
{!! HTML::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
@endsection

@section('js')
{!! HTML::script('global/scripts/datatable.js') !!}
{!! HTML::script('global/plugins/datatables/datatables.js') !!}
{!! HTML::script('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
{!! HTML::script('global/plugins/datatables/plugins/jquery.dataTables.columnFilter.js') !!}
@endsection

@section('script')
<script>
jQuery(document).ready(function() { 

$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

var table = $('#table1');
  table.DataTable({
         "bProcessing": true,
         "serverSide": true,

         "columnDefs": [ {
                "targets": [2, 3],
                "orderable": false,
                "searchable": false
            }],

         "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
         "pageLength": 10,
         "ajax":{
            url :"{!!url('admin/data/tools/db')!!}", // json datasource
            type: "post",
            error: function(xhr, textStatus, error){  // error handling code
              console.log(textStatus + ": " + error);
             // $(".employee-grid-error").html("");
              //$("#employee_grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              //$("#employee_grid_processing").css("display","none");
            }
          }
        });   
});

 /*
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




        $('#tree_1').jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                }            
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "plugins": ["types", "wholerow"],
        });

        // handle link clicks in tree nodes(support target="_blank" as well)
        $('#tree_1').on('select_node.jstree', function(e, data) { 

            var cat = $("li[aria-selected='true']").attr('id').split('-');
            //console.log(cat[1]);
            table.fnFilter(cat[1],[4,5]);
            
            var link = $('#' + data.selected).find('a');
            if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
                if (link.attr("target") == "_blank") {
                    link.attr("href").target = "_blank";
                }
                document.location.href = link.attr("href");
                return false;
            }
        });
});
*/

$(window).load(function() {
$('div.dataTables_filter > label').children('input').appendTo('#dataTables_filter').removeClass('input-inline input-sm input-small').addClass("form-control");
$('div.dataTables_length > label').children('select').appendTo('#dataTables_length').removeClass('input-inline input-sm input-xsmall').addClass("form-control");
$('div.dataTables_length').remove();
$('div.dataTables_filter').remove();
});

</script>
@endsection

@section('content')


<div class="page-bar">        
<div class="row padding-10">
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
    <div class="col-lg-2 p-t-20">
<div class="accordion navbar-collapse collapse" style="width:100%">


{!! $accordion !!}

</div>
</div>



    <div class="col-md-10">

<div class="table-container p-t-20">

        <table class="table table-striped table-bordered table-advance table-hover" id="table1" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>
                        Tool Serialnr
                    </th>
                    <th>
                        Barcode
                    </th>
                    <th>
                        Category Id
                    </th>
                    <th>
                        Category Name
                    </th>
                    <th>
                        Supplier
                    </th>
                </tr>
            </thead>

        </table>
    </div>
</div>


</div>
    @endsection
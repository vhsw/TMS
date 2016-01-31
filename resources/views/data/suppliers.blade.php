@extends('master')

@section('title') Data | Suppliers @endsection


@section('css')
{!! HTML::style('global/plugins/datatables/datatables.min.css') !!}
{!! HTML::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
{!! HTML::style('global/plugins/icheck/skins/all.css') !!}
@endsection


@section('js')
{!! HTML::script('global/scripts/datatable.js') !!}
{!! HTML::script('global/plugins/datatables/datatables.min.js') !!}
{!! HTML::script('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
{!! HTML::script('global/plugins/icheck/icheck.min.js') !!}
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

$("#btn-add").click(function(){
    reveal();
    $("#form-supplier").removeClass("hidden").find("input[name='name']").focus();
});

$('#check-producer').on('ifChecked', function(event) {
    $('#select-supplier').removeClass('hidden');
}).on('ifUnchecked', function(event) {
    $('#select-supplier').addClass('hidden');
});


@if (count($errors) > 0)
    reveal();
    $("#form-supplier").removeClass("hidden");
@endif

</script>
@endsection



@section('form')
<form action="{!!url('admin/data/supplier/create')!!}" method="post" id="form-supplier">
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
            <label class="control-label">Producer / Name</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input id="check-producer" name="producer" type="checkbox" class="icheck" data-checkbox="icheckbox_square-aero">
                </span>
                <input name="name" type="text" class="form-control input-lg">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7"> 
             <div class="form-group">
                <label class="control-label">Website</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input type="text" name="website" class="form-control input-lg">
                </div> 
            </div>
    </div>
    <div class="col-md-5"> 
            <div class="form-group">
                <label class="control-label">Phone</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input name="phone" type="text" class="form-control input-lg" />
                </div>
            </div>        
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div id="select-supplier" class="form-group hidden">
              <label for="select2-single-append" class="control-label">Supplied By</label>
              <div class="input-group input-group-lg select2-bootstrap-prepend">
                <select name="supplied_by" class="form-control select2-allow-clear">
                    @foreach ($suppliers as $supplier)
                        @if($supplier->producer == 0)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
            </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
        <label class="control-label">&nbsp;</label>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-lg green"><i class="fa fa-check"></i> Add</button> 
            </span>
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

        <button id="btn-add" class="btn blue">Add Supplier</button> 

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
                        Website
                     </th>
                     <th>
                        Phone
                     </th>
                     <th>
                        Supplied By
                     </th>
                     <th>
                        Action
                     </th>
                  </tr>
               </thead>
               <tbody>
                  
@foreach($suppliers as $supplier)

              <tr class="odd gradeX">
                     <td>
                        {{ $supplier->id }}
                     </td>
                     <td>
                        <a href="{!!url('admin/data/supplier/' . $supplier->id . '/view')!!}">
                        {!! ($supplier->producer == $supplier->supplied_by) ? '<b>'.$supplier->name.'</b>' : $supplier->name !!}</a>
                     </td>
                     <td>
                        <a href="{{ $supplier->website }}">
                        {{ $supplier->website }}</a>
                     </td>
                     <td>
                        {{ $supplier->phone }}
                     </td>
                     <td>
                        {{ ($supplier->supplied_by != 0) ? $suppliers[$supplier->supplied_by - 1]->name : '' }}
                     </td>
                     <td>
                        <div class="btn-group btn-group-xs btn-group-solid">
                        <a href="{!!url('admin/data/supplier/' . $supplier->id . '/edit')!!}" class="btn blue">Edit</a></div>
                    </td>
                  </tr>
@endforeach                  
               </tbody>
            </table>
    </div>
</div>
@endsection


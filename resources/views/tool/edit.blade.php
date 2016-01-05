@extends('master')

@section('title') Tools | View | {{ $tool->serialnr }} @endsection

@section('css')
{!! HTML::style('global/plugins/bootstrap-select/css/bootstrap-select.min.css') !!}
{!! HTML::style('global/plugins/datatables/datatables.min.css') !!}
{!! HTML::style('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}
@endsection

@section('js')
{!! HTML::script('global/plugins/bootstrap-select/js/bootstrap-select.min.js') !!}
@endsection

@section('script')
<script>

var iconUrl = "{!!url('assets/ICO')!!}";

jQuery(document).ready(function() {  
    $('.bs-select').selectpicker({
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });


    var updateCategories = function(v){

        $.getJSON("{!!url('admin/data/categories/tree')!!}", {id: v})
        .done(function( data ) {
            $("#categories").empty();
            var c=0;

            $.each(data, function(i, item){
                var select = '';
                select = select+'<div class="col-md-2">'
                +'<select name="cat-'+c+'" class="bs-select form-control" data-show-subtext="true">'
                +'<option value="0" data-content=""></option>';
                $.each(data[i].categories, function(j){
                    var icon = '<img src=\''+iconUrl+'/'+data[i].categories[j].icon+'.png\' height=\'22px\'>';
                    var s = '';
                    if(data[i].id == data[i].categories[j].id) { s = 'SELECTED'; }
                    select = select+'<option value="'+data[i].categories[j].id+'" data-content="'+icon+' '+data[i].categories[j].name+'" '+s+'> '+data[i].categories[j].name+'</option>';
                });
                select = select+'</select></div>';
                $("#categories").append(select);
                c=c+1;
            });

            $('.bs-select').selectpicker('refresh');
        })
    };

    $('#categories').on('change', '.bs-select', function() {
        updateCategories($(this).val());
    })

    updateCategories( {{ $tool->category_id }} );

});
</script>
@endsection


@section('content')


<form class="form-horizontal form-row-seperated" method="get" action="{!!url('tool/'.$tool->id.'/save')!!}"> 
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="page-bar">        
<div class="row p-t-10 p-b-10">
    <div class="col-sm-2">
        @if($navigate['prev'])
            <a href="{!!url('tool/'.($navigate['prev']).'/edit')!!}" class="btn default"><i class="fa fa-arrow-left"></i> {{ $navigate['prev'] }} </a> 
        @endif
    </div>
    <div class="col-sm-10">
        <button class="btn blue">Save</button> 
        <button type="submit" class="btn blue">Save @if($navigate['next']) & Goto {{ $navigate['next'] }} @endif</button>
        @if($navigate['next'])
            <a href="{!!url('tool/'.($navigate['next']).'/edit')!!}" class="btn default pull-right">{{ $navigate['next'] }} <i class="fa fa-arrow-right"></i></a> 
        @endif
    </div>  
</div>
</div>


<div class="row">
<div class="col-lg-12 p-t-20">

            <div class="tabbable-bordered">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_general" data-toggle="tab"> General </a>
                    </li>
                    <li>
                        <a href="#tab_supplier" data-toggle="tab"> Supplier </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_general">
                        <div class="form-body">

                            <h4 class="form-section">Basic</h4>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Serialnr
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $tool->serialnr }}" type="text" class="form-control" name="serialnr"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name 0
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $tool->name0 }}" type="text" class="form-control" name="name0"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Name 1
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $tool->name1 }}" type="text" class="form-control" name="name1"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Barcode
                                </label>
                                <div class="col-md-5">
                                    <input value="{{ $tool->barcode }}" type="text" class="form-control" name="barcode"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Brand
                                </label>
                                <div class="col-md-3">
                                    <select name="supplier_id" class="form-control">
                                        @foreach($suppliers as $supplier)
                                            @if($supplier->producer)
                                            <option value="{{ $supplier->id }}" {{ ($supplier->id == $tool->supplier_id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
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
                    </div>

                    <div class="tab-pane fade" id="tab_supplier">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-body">
                             <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                             <thead>
                                <th>Supplier</th>
                                <th>Cost</th>
                                <th>Updated</th>
                             </thead>
                             <tbody>

                        <?php // Get Only Unique Costs
                            $oldid=0;
                            foreach($costs as $cost)
                            {
                                $id = $cost->supplier_id;
                                if($oldid <> $id) {
                                    ?>
                                    <tr>
                                        <td>{{ $cost->supplier->name }}</td>
                                        <td>{{ $cost->cost }}</td>
                                        <td>{{ CustomDate::formatHuman($cost->updated_at) }}</td>
                                    </tr>
                                    <?php
                                }
                                $oldid = $id;
                            }
                        ?>

                             </tbody>
                             </table>  
                        </div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
 

    </div>
</div>
       </form>

@endsection

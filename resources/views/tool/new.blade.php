@extends('master')

@section('title') Inventory | New  @endsection

@section('css')
{!! Html::style('global/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
{!! Html::style('global/plugins/datatables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('global/plugins/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') !!}
{!! Html::style('global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
{!! Html::script('global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') !!}
@endsection

@section('script')
<script>
var iconUrl = "{!!url('img/ICO')!!}";
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

jQuery(document).ready(function() {
    $('.bs-select').selectpicker({
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });

    $('#tool_info').hide();
    $('.save').hide();


    var updateCategories = function(v){
        $.getJSON("{!!url('data/categories/tree')!!}", {id: v})
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
    }

    var _data;
    var downloadToolInfo = function(tool_info_supplier, searchstr){
        $.ajax({
            url: "{!! url('plugins/download') !!}",
            cache: false,
            dataType: "json",
            data: {tool_info_supplier: tool_info_supplier, searchstr: searchstr},
            success: function(data){
                //console.log(data);
                _data = data;
                $('input[name=title1]').val(data.title1);
                $('input[name=title2]').val(data.title2);
                $('textarea[name=description]').html(data.description);

                var html;
                data.images.forEach(function(url){
                    $('#images').append('<img src="'+ url +'"><br>');
                });

                $('#tool_info').show();
                $('.save').show();
            },
            error: function( XMLHttpRequest, jqXHR, textStatus ){
                console.log(XMLHttpRequest);
            }
        });
    }

    var saveToolInfo = function(id, data){

        data.title1 = $('input[name=title1]').val();
        data.title2 = $('input[name=title2]').val();
        data.description = $('textarea[name=description]').val();
        //console.log(data);

        $.ajax({
            url: "{!! url('plugins/download/save') !!}",
            cache: false,
            data: {id: id, data: data},
            success: function(ev){
                console.log(ev)
                $('#tool_info').hide();
                //$('.save').hide();
            },
            error: function( XMLHttpRequest, jqXHR, textStatus ){
                console.log(XMLHttpRequest);
            }
        });
    }

    $('#categories').on('change', '.bs-select', function() {
        updateCategories( $(this).val() );
    });

    $('.download').on('click', function(event) {
        downloadToolInfo( $("select[name='tool_info_supplier']").val(), $("input[name='searchstr']").val() );
        return false;
    });

    $('.save').on('click', function(event) {
        //console.log(_data);
        saveToolInfo( , _data);
        return false;
    });

    updateCategories(  );

});
</script>
@endsection


@section('content')

<form class="form-horizontal form-row-seperated" method="get" action="{!!url('inventory/save')!!}">
    <div class="page-bar">
        <div class="row p-t-10 p-b-10">
            <div class="col-sm-10">
                <button type="submit" class="btn blue">Save</button>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="portlet box blue-hoki">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Add New Inventory </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="#" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-4">
                                    <input name="name0" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Serialnr</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input name="serialnr" type="text" class="form-control"> </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Alternative name</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input name="name1" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Barcode / SKU</label>
                                    <div class="col-md-4">
                                        <input name="sku" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Brand</label>
                                    <div class="col-md-4">
                                        <select name="supplier_id" class="form-control">
                                            {{-- @foreach($suppliers as $supplier)
                                                @if($supplier->producer)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endif
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>

            @endsection

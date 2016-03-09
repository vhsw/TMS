@extends('master')

@section('title') Data | Categories @endsection

@section('css')
{!! Html::style('global/plugins/jquery-nestable/jquery.nestable.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/jquery-nestable/jquery.nestable.js') !!}
@endsection

@section('script')
<script>
var obj = { "node":  };


var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };


function getList(item, $list) {

    if($.isArray(item)){
        $.each(item, function (key, value) {
            getList(value, $list);
        });
        return;
    }

    if (item) {
        var $li = $('<li />').attr({'class':'dd-item', 'data-id':item.id, 'data-name':item.name});
        if (item.name) {
            $li.append($('<div class="dd-handle">' + item.name + '</div>'));
        }
        if (item.children && item.children.length) {
            var $sublist = $("<ol/>").attr('class', 'dd-list');
            getList(item.children, $sublist)
            $li.append($sublist);
        }
        $list.append($li)
    }
}


var $ul = $('<ol></ol>').attr('class', 'dd-list');
getList(obj.node, $ul);
$ul.appendTo("#nestable_list_1");


$('#nestable_list_1').nestable().on('change', updateOutput);


$('#nestable_list_menu').on('click', function (e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });


updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));

</script>
@endsection

@section('content')

<!-- TODO: Rename, Add, Delete Categories =)
-->
<form action="{!!url('admin/data/categories/save')!!}" method="post" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="portlet light bordered">


      <div class="portlet-body ">
         <div class="row">
            <div class="col-md-12">
               <div class="margin-bottom-10" id="nestable_list_menu">
                  <button class="btn green-soft uppercase bold" type="submit">Save</button>
                  <button type="button" class="btn green btn-outline sbold uppercase" data-action="expand-all">Expand All</button>
                  <button type="button" class="btn red btn-outline sbold uppercase" data-action="collapse-all">Collapse All</button>
               </div>
            </div>
         </div>
      </div>
</div>

<div class="row">
   <div class="col-md-6">
      <div class="portlet light bordered">
         <div class="portlet-title">
            <div class="caption">
               <i class="icon-bubble font-green"></i>
               <span class="caption-subject font-green sbold uppercase">Nestable List 1</span>
            </div>
         </div>
         <div class="portlet-body ">
            <div id="nestable_list_1" class="dd"></div>

            <ul>
                @foreach($categories as $node)
                    {!! \App\Services\Metronic::renderNode($node) !!}
                @endforeach
            </ul>

         </div>
      </div>
   </div>
</div>
<textarea name="json" style="visibility:hidden" id="nestable_list_1_output"></textarea>
 </form>

@endsection

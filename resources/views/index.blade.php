@extends('master')

@section('title')   @endsection

@section('css')
{!! Html::style('global/plugins/typeahead.js-bootstrap3.less/typeaheadjs.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/amcharts3/amcharts/amcharts.js') !!}
{!! Html::script('global/plugins/amcharts3/amcharts/serial.js') !!}
{!! Html::script('global/plugins/amcharts3/amcharts/themes/light.js') !!}
{!! Html::script('global/plugins/amcharts3/amcharts/plugins/dataloader/dataloader.min.js') !!}
{!! Html::script('global/scripts/dashboard.js') !!}
@endsection

@section('script')
<script>
jQuery(document).ready(function() {

    $('.mark-read').on('click', function(e) {
        e.preventDefault();

        li = $(this).closest('li');
        id = li.attr('data-id');
        //console.log(id);
        $.ajax({
            url: "{!! url('system/setnotificationasread') !!}",
            cache: false,
            data: {id: id},
            success: function(result){
                console.log(result)
                li.remove();
            },
            error: function( XMLHttpRequest, jqXHR, textStatus ){
                console.log(XMLHttpRequest);
            }
        });
        return false;
    });

});
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-8">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-red">
                    <span class="caption-subject bold uppercase">Tool Budget</span>
                    <span class="caption-helper">expenses...</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="dashboard_amchart_3" style="height:300px" class="CSSAnimationChart">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

@if(Auth::check())


@endif

</div>


@endsection

@section('script')
	<script>

	</script>
@endsection

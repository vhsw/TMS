@extends('master')

@section('title')   @endsection

@section('css')
{!! Html::style('global/plugins/typeahead/typeahead.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/amcharts/amcharts/amcharts.js') !!}
{!! Html::script('global/plugins/amcharts/amcharts/serial.js') !!}
{!! Html::script('global/plugins/amcharts/amcharts/themes/light.js') !!}
{!! Html::script('global/plugins/amcharts/amcharts/plugins/dataloader/dataloader.min.js') !!}
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
<div class="col-md-6 col-sm-6">
                            <div class="portlet light tasks-widget bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-share font-green-haze hide"></i>
                                        <span class="caption-subject font-green bold uppercase">Notifications</span>
                                        <span class="caption-helper">{{ $notifications->count() }} unread</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="task-content">
                                        <div class="scroller" style="height: 312px;" data-always-visible="1" data-rail-visible1="1">
                                            <!-- START TASK LIST -->
                                            <ul class="task-list">



                            @foreach($notifications as $notification) 
                            <li data-id="{{ $notification->id }}">
                                <div class="task-title">
                                    <span class="label label-warning"><i class="fa fa-bar-chart-o"></i></span>
                                    <span class="task-title-sp">
                                    <b>{{ $notification->getObject()->description }} </b>
                                    {{ $notification->body }} 

                                    @if($notification->hasValidObject() && $notification->status == "REQUESTED") 
                                        by 
                                        @if (Auth::user()->id == $notification->getObject()->user->id ) 
                                            You
                                        @else
                                            {{ $notification->getObject()->user->name }} 
                                        @endif
                                    @endif 

                                    <i>{{ \App\Services\CustomDate::formatHuman($notification->created_at) }}</i></span>
                                </div>
                                <div class="task-title task-config">
                                    <span class="label">
                                        <a href="" class="btn btn-sm default mark-read">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </span>
                                </div>
                            </li>
                            {{--  <li class="last-line"> --}}
                            @endforeach


                                            </ul>
                                            <!-- END START TASK LIST -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

@endif

</div>


@endsection

@section('script')
	<script>

	</script>
@endsection
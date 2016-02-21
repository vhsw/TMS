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

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-8">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-red">
                    <span class="caption-subject bold uppercase">Tool Budget</span>
                    <span class="caption-helper">expenses versus budget...</span>
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

<div class="col-md-6 col-sm-6">                     
    <div class="portlet box b-a b-grey">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered form-row-stripped">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-2">Total tool cost requested this week</label>
                        <div class="col-md-5"><input class="form-control" type="text" value="NOK {{ $sum }}"></div>
                        <label class="control-label col-md-5"></label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Total tool spend this month</label>
                        <div class="col-md-5"><input class="form-control" type="text" placeholder="Total tool spend this month"></div>
                        <label class="control-label col-md-5"></label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">This month budget</label>
                        <div class="col-md-5"><input class="form-control" type="text" placeholder="This month budget"></div>
                        <label class="control-label col-md-5"></label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">User Spending</label>
                        <div class="col-md-5"><input class="form-control" type="text" placeholder="User Spending"></div>
                        <label class="control-label col-md-5"></label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">This weeks requests</label>
                        <div class="col-md-5">@foreach($requests as $request) {{$request}} @endforeach</div>
                        <label class="control-label col-md-5"></label>
                    </div>


                    <!-- END FORM-->
                </div></form>
            </div>
        </div>
</div>
</div>

@if(Auth::check())
<div class="row">
    <div class="col-md-6 col-sm-6">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Notifications</span>
                                        <span class="caption-helper">{{ $notifications->count() }} unread</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="scroller" style="height: 338px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <div class="general-item-list">

                                         @foreach($notifications as $notification) 
                                            <div class="item">
                                                <div class="item-head">
                                                    <div class="item-details">{{ $notification->body }} @if($notification->hasValidObject() && $notification->status == "REQUESTED") by <b>{{ $notification->getObject()->user->name }} </b> @endif

                                                        <span class="item-label">{{ \App\Services\CustomDate::formatHuman($notification->created_at) }}</span>
                                                    </div>
                                                </div>
                                                <div class="item-body"> 
                                                Request @if($notification->hasValidObject())
                                                    <a href="" class="item-name primary-link">"{{ $notification->getObject()->description }}" : {{ $notification->getObject()->tool_serialnr }}</a>
                                                has been <span class="label {{ \App\Services\Metronic::classStatus($notification->status) }}">{{ $notification->status }}</span> 
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>
</div>
@endif


@endsection

@section('script')
	<script>

	</script>
@endsection
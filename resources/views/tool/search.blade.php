@extends('master')

@section('title') Tools | Search Tool @endsection

@section('css')
{!! Html::style('pages/css/search.min.css') !!}
@endsection

@section('styles')
<style type="text/css">
	.custombig {
		letter-spacing: 2px;
		font-family: "Oswald",sans-serif;
		color: #636E77;
		font-size: 18px;
		font-weight: 300;
		text-transform: uppercase;
	}
</style>
@endsection

@section('script')
<script>
OnlyStock = function(){
    var input = $("<input>", { type: "hidden", name: "onlystock", value: "true" });
    $('#form-search').append($(input));
}
</script>
@endsection

@section('content')


<div class="search-page search-content-3">
                    <div class="search-bar bordered">
                        <div class="row">
                            <form id="form-search" action="{!!url('tools/search/result')!!}" method="get" >
                            <div class="col-lg-8">
                                
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="input-group">
                                        <input name="term" class="form-control custombig" value="{{ $term or '' }}" placeholder="Search for..." type="text">
                                        <span class="input-group-btn">
                                            <button class="btn green uppercase bold" type="submit">Search All</button>
                                        </span>
                                    </div>
                            </div>
                            <div class="col-lg-4 extra-buttons">
                                <button onclick="OnlyStock();" class="btn grey-steel uppercase" type="submit">Only Stock</button>
                            </div>
                            </form>
                        </div>
                    </div>

    @if (isset($result))

                    <div class="row">
                        <div class="col-lg-12">
                        <?php $i = 0; // Counter ?>
                        @foreach ($result as $tool)
                                    <div class="col-md-3">
                                        <div class="tile-container bordered" style="background-color: #fff">
                                            <div class="tile-thumbnail" style="margin:10px">
                                                <a href="{!!url('tool/' . $tool->id . '/view')!!}">

                                                @if(json_encode($pictures[$i]) != '{}')

                                                    <img src="{!! url('/files'.$pictures[$i]->path) !!}" class="img-responsive" alt="{{ $picture->title }}">
                                                    
                                                @endif

                                                <?php $i++; // Counter ?>

                                                </a>
                                            </div>
                                            <div class="tile-title">
                                                <h3>
                                                    <a href="{!!url('tool/' . $tool->id . '/view')!!}">{{ $tool->serialnr }}</a>
                                                </h3>
                                                <a href="javascript:;">
                                                    <i class="icon-question font-blue"></i>
                                                </a>
                                                <a href="javascript:;">
                                                    <i class="icon-plus font-green-meadow"></i>
                                                </a>
                                                <div class="tile-desc">
                                                    <p>{{ $tool->name0 }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="search-pagination pagination">
                        {!! $paginator->appends(['term' => $term])->render() !!}
                    </div>
</div>
@endif


 

@endsection
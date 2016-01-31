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


@section('content')

              
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="search-page search-content-4">
                        <div class="search-bar bordered">
                            <div class="row">
                                <div class="col-lg-8">
                                <form action="{!!url('tools/search/result')!!}" method="get" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="input-group">
                                        <input name="term" class="form-control custombig" value="{{ $term or '' }}" placeholder="Search for..." type="text">
                                        <span class="input-group-btn">
                                            <button class="btn green-soft uppercase bold" type="submit">Search</button>
                                        </span>
                                    </div>
                                   </form>
                                </div>

                                <div class="col-lg-4 extra-buttons">
                                    <button class="btn grey-steel uppercase bold" type="button">Reset Search</button>
                                    <button class="btn grey-cararra font-blue" type="button">Advanced Search</button>
                                </div>

                            </div>
                        </div>
                        
@if (isset($result))

						<div class="search-table table-responsive">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead class="bg-blue">
                                    <tr>
                                        <th>
                                            <a href="javascript:;">Hente</a>
                                        </th>
                                        <th>
                                            <a href="javascript:;">Kategori</a>
                                        </th>
                                        <th>
                                            <a href="javascript:;">Verktøy / Lagerstatus
                                        </th>
                                        <th>
                                            <a href="javascript:;">Beskrivelse</a>
                                        </th>
                                        <th>
                                            <a href="javascript:;">Download</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($result as $tool)
                                    <tr>
                                        <td class="table-status">
                                            <a href="javascript:;">
                                                <i class="icon-arrow-right font-blue"></i>
                                            </a>
                                        </td>
                                        <td class="table-date font-blue">
                                       		<a href="javascript:;">{{ $tool->barcode }}</a>
                                        </td>
                                        <td class="table-title">
                                            <h3>
                                                <a href="{!!url('tool/' . $tool->id . '/view')!!}">{{ $tool->serialnr }}</a>

                                            </h3>
                                            <p>Lagerplass:
                                                <a href="javascript:;">V02-02-12</a> -
                                                <span class="font-grey-cascade">25 stk</span>
                                            </p>
                                        </td>
                                        <td class="table-desc">{{ $tool->name0 }}</td>
                                        <td class="table-download">
                                            <a href="javascript:;">
                                                <i class="icon-doc font-green-soft"></i>
                                            </a>
                                        </td>
                                    </tr>
                                 @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="search-pagination pagination">
                            {!! $paginator->appends(['term' => $term])->render() !!}
                        </div>


@endif     
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                
                    

@endsection
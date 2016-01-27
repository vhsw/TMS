@extends('master')

@section('title') Tools |  @endsection

@section('css')
{!! HTML::style('global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') !!}
@endsection

@section('js')
{!! HTML::script('global/plugins/bootstrap-markdown/lib/markdown.js') !!}
{!! HTML::script('global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') !!}
@endsection

@section('script')
<script>
</script>
@endsection


@section('content')


<form class="form-horizontal form-row-seperated" method="get" action="{!!url('plugins/download/save')!!}"> 
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="row">
        <div class="col-lg-12 p-t-20">

            <div class="form-body">

            <h4 class="form-section">Downloaded:</h4>

                <div class="form-group">
                    <label class="col-md-2 control-label">Title 1
                    </label>
                    <div class="col-md-5">
                        <input value="{{ $result['title1'] }}" type="text" class="form-control" name="title1"> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Title 2
                    </label>
                    <div class="col-md-5">
                        <input value="{{ $result['title2'] }}" type="text" class="form-control" name="title2"> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Description</label>
                    <div class="col-md-10">
                        <textarea name="description" data-provide="markdown" rows="10">
                            {!! $result['description'] !!}
                        </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Brand
                    </label>
                    <div class="col-md-3">
                        <select name="" class="form-control">
                            
                        </select>
                    </div>
                </div>

                <h4 class="form-section">Images</h4>


            </div>
        </div>
    </div>
</form>

@endsection

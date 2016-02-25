@extends('master')

@section('title') Requests | Edit Request ({{ $request->id }})  @endsection

@section('css')
{!! Html::style('global/plugins/typeahead/typeahead.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/typeahead/handlebars.min.js') !!}
{!! Html::script('global/plugins/typeahead/typeahead.bundle.min.js') !!}
{!! Html::script('global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') !!}
@endsection

@section('script')
<script type="text/javascript">


$(function() {

    
  var tools = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          remote: {
            url: 'http://localhost/api/tools.php?query=%QUERY',
            wildcard: '%QUERY',
            filter: function(list) {
              return $.map(list, function(d) { return { tool: d }; });
            }
            }
          
        });
 
        tools.initialize();
         
        $('#tool').typeahead(null, {
          name: 'tool',
          displayKey: 'tool',
          source: tools.ttAdapter()
        });      


  
  $("#mask-currency").inputmask();


});
</script>
@endsection

@section('content')

{{ isset($gg) ? $gg : "" }}


@if (count($errors) > 0)
  <div class="alert alert-danger">
  @foreach($errors->all() as $error)
    <strong>Error!</strong> {{ $error }}<br>
  @endforeach
  </div>
@endif

<div class="row">
<div class="col-md-8">              

                     <!-- BEGIN FORM-->
                     <form action="{!!url('request/' . $request->id . '/edit')!!}" method="post" class="form-horizontal form-bordered">
                     @if($request->status == "RECIEVED")
                     <fieldset disabled="disabled">
                     @else 
                     <fieldset>
                     @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="form-group">
                              <label class="control-label col-md-3">Request description</label>
                              <div class="col-md-9">
                                 <input name="description" type="text" class="form-control" value="{{ $request->description }}">
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Tool</label>
                              <div class="col-md-6">
                                 <input type="text" name="tool_serialnr" id="tool" value="{{ $request->tool_serialnr }}" class="form-control"/>
                              </div>
                              <label class="control-label col-md-1">Cost</label>
                              <div class="col-md-2">
<input value="{{ $request->cost }}" name="cost" class="form-control" id="mask-currency" data-inputmask="'alias': 'numeric', 'groupSeparator': '.', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'prefix': 'NOK ', 'placeholder': '0'" />
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Barcode</label>
                              <div class="col-md-6">
                                 <input name="barcode" type="text" class="form-control" value="{{ $request->barcode }}">
                              </div>
                              <label class="control-label col-md-1">Amount</label>
                              <div class="col-md-2">
                                 <input name="amount" type="text" class="form-control" value="{{ $request->amount }}">
                              </div>
                           </div>

                        
                           <div class="form-group">
                              <label class="control-label col-md-3">Status</label>
                              <div class="col-md-4">
                                <select class="form-control" name="status">
                                @foreach($request_status as $status)
                                  <option value="{{ $status }}" {{ ($status == $request->status) ? 'SELECTED' : '' }}>{{ $status }}</option>
                                @endforeach
                                </select>
                              </div>
                              <label class="control-label col-md-1">Supplier</label>
                              <div class="col-md-4">
                                <select class="form-control" name="supplier_id">

                                @if (isset($request->tool))
                                    @foreach($suppliers as $supplier)
                                      <option value="{{ $supplier->id }}" {{ ($supplier->id == $request->tool->supplier_id) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                @else 
                                    <option value="" SELECTED></option>
                                    @foreach($suppliers as $supplier)
                                      <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                @endif
                                
                                </select>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Comments</label>
                              <div class="col-md-9">
                                 <input name="comments" type="text" class="form-control" value="{{ $request->comments }}">
                              </div>
                           </div>
                        </div>

                        </fieldset>
                        <div class="form-actions">

                           <div class="row">
                              <div class="col-md-offset-3 col-md-9">
                              @if($request->status != "RECIEVED")
                                 <button type="submit" class="btn green"><i class="fa fa-check"></i> Edit</button>
                              @endif
                                 <a href="{!!url('tools/request/' . $request->id . '/delete')!!}" class="btn red">Delete</a>
                                 <a href="{!!url('tools/requests')!!}" class="btn default">Cancel</a>
                              </div>
                           </div>
                        </div>

                     </form>
</div>
</div>

@endsection
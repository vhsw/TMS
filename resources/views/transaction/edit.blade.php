@extends('master')

@section('title') Requests | Edit Request ({{ $request->id }})  @endsection

@section('css')
{!! Html::style('global/plugins/typeahead.js-bootstrap3.less/typeaheadjs.css') !!}
@endsection

@section('js')
{!! Html::script('global/plugins/typeahead.js/dist/typeahead.bundle.min.js') !!}
{!! Html::script('global/plugins/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
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
                     <form action="{!!url('transaction/' . $request->id . '/edit')!!}" method="post" class="form-horizontal form-bordered">
                     @if( $request->isOrderReceived() )
                     <fieldset disabled="disabled">
                     @else
                     <fieldset>
                     @endif
                        <div class="form-body">
                            <div class="form-group">
                              <label class="control-label col-md-3">Request description</label>
                              <div class="col-md-9">
                                 <input name="description" type="text" class="form-control" value="">
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Tool</label>
                              <div class="col-md-6">
                                 <input type="text" name="tool_serialnr" id="tool" value="{{ $request->stock->item->serialnr }}" class="form-control"/>
                              </div>
                              <label class="control-label col-md-1">Cost</label>
                              <div class="col-md-2">
<input value="" name="cost" class="form-control" id="mask-currency" data-inputmask="'alias': 'numeric', 'groupSeparator': '.', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'prefix': 'NOK ', 'placeholder': '0'" />
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Barcode</label>
                              <div class="col-md-6">
                                 <input name="barcode" type="text" class="form-control" value="">
                              </div>
                              <label class="control-label col-md-1">Amount</label>
                              <div class="col-md-2">
                                 <input name="amount" type="text" class="form-control" value="{{ $request->quantity }}">
                              </div>
                           </div>


                           <div class="form-group">

                              <label class="control-label col-md-1">Supplier</label>
                              <div class="col-md-4">
                                <select class="form-control" name="supplier_id">

                                if (isset($request->tool))
                                    foreach($suppliers as $supplier)
                                      <option value="$supplier->id" ></option>
                                    endforeach
                                else
                                    <option value="" SELECTED></option>
                                    foreach($suppliers as $supplier)
                                      <option value="$supplier->id"></option>
                                    endforeach
                                endif

                                </select>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="control-label col-md-3">Comments</label>
                              <div class="col-md-9">
                                 <input name="comments" type="text" class="form-control" value="">
                              </div>
                           </div>
                        </div>

                        </fieldset>
                        <div class="form-actions">

                           <div class="row">
                              <div class="col-md-offset-3 col-md-9">
                              @if( $request->isRequest() )
                                 <a href="{!!url('transaction/' . $request->id . '/order')!!}" class="btn green">Order</a>
                                 <a href="{!!url('transaction/' . $request->id . '/cancel')!!}" class="btn red">Delete Request</a>
                              @elseif( $request->isOrder() )
                                 <a href="{!!url('transaction/' . $request->id . '/receive')!!}" class="btn green">Receive</a>
                                 <a href="{!!url('transaction/' . $request->id . '/cancel')!!}" class="btn red">Cancel Order</a>
                              @endif


                              </div>
                           </div>
                        </div>

                     </form>
</div>
</div>

@endsection

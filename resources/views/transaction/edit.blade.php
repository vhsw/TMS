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

    $('#btn-save').on('click', function() {
        $.ajax({
            url: APP_URL + '/transaction/{!! $request->id !!}/save',
            data: $('form').serialize(),
            dataType: 'json',
            success: function( data ) {
                console.log(data);
            }
        });
        return false;
    });



    $("#mask-currency").inputmask();
});
</script>
@endsection

@section('content')
<div class="page-bar">
    <div class="row p-t-10 p-b-10">
        <div class="col-md-12">

            @if( $request->isRequest() )
            <a href="{!!url('transaction/' . $request->id . '/order')!!}" class="btn green">Order</a>
            <a href="{!!url('transaction/' . $request->id . '/cancel')!!}" class="btn red pull-right">Delete Request</a>
            @elseif( $request->isOrder() )
            <a href="{!!url('transaction/' . $request->id . '/receive')!!}" class="btn green">Receive</a>
            <a href="{!!url('transaction/' . $request->id . '/cancel')!!}" class="btn red pull-right">Cancel Order</a>
            @endif

            <a href="{!!url('inventory/' . $request->stock->item->id . '/edit')!!}" class="btn blue">Edit Item</a>

        </div>
    </div>
</div>



@if (count($errors) > 0)
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <strong>Error!</strong> {{ $error }}<br>
    @endforeach
</div>
@endif
<div class="row">
    <div class="col-md-12 p-t-10">

        <div class="portlet box">
            <div class="portlet-body form">
                <div class="row">
                    <div class="col-md-6">

                        <!-- BEGIN FORM-->
                        <form action="" method="get" class="horizontal-form">

                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Name</label>
                                        <div class="col-md-10 p-b-10">
                                            <p class="form-control-static">{{ $request->stock->item->name }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Serialnr</label>
                                        <div class="col-md-10 p-b-10">
                                            <p class="form-control-static">{{ $request->stock->item->serialnr }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Barcode</label>
                                        <div class="col-md-10 p-b-10">
                                            <p class="form-control-static">{{ $request->stock->item->getBarcode() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Supplier</label>
                                        <div class="col-md-6 p-b-10">
                                            <select class="form-control" name="supplier_id" {{ !$request->isRequest() ? 'readonly' : '' }}>
                                                @if (isset($request->stock->item))
                                                @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ ( $supplier->id == $request->stock->item->getCurrentSupplier()->id ) ? 'SELECTED' : '' }}>{{ $supplier->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 p-b-10"></div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Quantity</label>
                                            <input type="text" class="form-control" name="quantity" value="{{ $request->original_quantity }}" {{ !$request->isRequest() ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Cost</label>
                                            <input value="{{ $request->stock->item->getCurrentSupplierCost() }}" name="cost" class="form-control" id="mask-currency" data-inputmask="'alias': 'numeric', 'groupSeparator': '.', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" {{ ($request->isOrderReceived() || $request->isCancelled()) ? 'readonly' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Total</label>
                                            <input type="text" class="form-control" name="total" value="{!! ($request->stock->item->getCurrentSupplierCost() * $request->original_quantity) !!}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Comments</label>
                                        <div class="col-md-10 p-b-10">
                                            <input name="comments" type="text" class="form-control" value="{{ $request->comments }}" {{ ($request->isOrderReceived() || $request->isCancelled()) ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        @if (!$request->isOrderReceived() && !$request->isCancelled())
                                            <button id="btn-save" class="btn blue">Save</button>
                                        @endif
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">

                        @foreach( $request->getHistory() as $history )
                        <div class="note note-info margin-20">
                            {{ $history->makeReadable() }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('master')

@section('title') Inventory | View @endsection

@section('css')
{!! Html::style('pages/css/profile-2.min.css') !!}
@endsection


@section('style')
<style>
.page-content {background-color: #ffffff !important;}
</style>
@endsection

@section('script')
<script>

    $("#request").click(function(){
        reveal();
        $("#form-request").removeClass("hidden").find("input[name='quantity']").focus();
    });

    $("#take").click(function(){
        reveal();
        $("#form-take").removeClass("hidden").find("input[name='quantity']").focus();
    });

    @if (count($errors) > 0)
    reveal();
    $("#form-request").removeClass("hidden");
    @endif

</script>
@endsection

@section('form')
<form action="{!!url('transaction/request')!!}" method="get" id="form-request">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <strong>Error!</strong> {{ $error }}<br>
        @endforeach
    </div>
    @endif

    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input name="name" value="{{ $item->name }}" readonly="" type="text" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Serialnr</label>
                    <input type="text" name="serialnr" readonly="" value="{{ $item->serialnr }}" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Quantity</label>
                    <div class="input-group input-group-lg input-small">
                        <input name="quantity" type="text" class="form-control input-lg input-small" />
                        <span class="input-group-addon">Stk</span>
                        <span class="input-group-btn pull-right">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Request</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>


<form action="{!!url('transaction/'.$item->stocks[0]->id.'/take')!!}" method="get" id="form-take">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <strong>Error!</strong> {{ $error }}<br>
        @endforeach
    </div>
    @endif

    <div class="form-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input name="name" value="{{ $item->name }}" readonly="" type="text" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Serialnr</label>
                    <input type="text" name="serialnr" readonly="" value="{{ $item->serialnr }}" class="form-control input-lg">
                    <input type="hidden" name="id" readonly="" value="{{ $item->id }}" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">Quantity</label>
                    <div class="input-group input-group-lg input-small">
                        <input name="quantity" type="text" class="form-control input-lg input-small" />
                        <span class="input-group-addon">Stk</span>
                        <span class="input-group-btn pull-right">
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> Take</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>
@endsection


@section('content')
<div class="page-bar">
<div class="row p-t-10 p-b-10">
    <div class="col-md-3">

        <button id="take" class="btn blue">Take</button>

        <button id="request" class="btn blue">Request</button>

      @if(Auth::check() && Auth::user()->hasRole('admin'))

        <a class="btn blue" href="{!! url('/inventory/'.$item->id.'/edit') !!}"> Edit </a>

      @endif

    </div>
</div>
</div>





<div class="profile">
  <div class="row">
    <div class="col-md-4">
      <ul class="list-unstyled profile-nav">
        @foreach($item->pictures as $picture)
            @if($picture->pivot->first_choice == 1)
                <li class="pic-bordered padding-10">
                    <img src="{{ url('files/'.$picture->path.$picture->title)}}" class="img-responsive" alt="">
                </li>
            @endif
        @endforeach
      </ul>
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-8 profile-info">
          <h1 class="font-green sbold uppercase">{{ $item->serialnr }}</h1>
          <h5 class="font-green sbold uppercase">@if($item->hasDetails()) {{ $item->details->title }} @endif</h5>
          <br>

          <table class="table table-advance table-hover">
            <tbody>
              <tr>
                <td><b>Category</b></td>
                <td> {{ $item->category->name }}</td>
                <td></td>
              </tr>

              <tr>
                <td><b>Current Supplier</b></td>
                <td> {{ $item->getCurrentSupplier()->name }}</td>
                <td></td>
              </tr>

              <tr>
                <td><b>Supplier SN</b></td>
                <td> {{ $item->name }}</td>
                <td></td>
              </tr>

              <tr>
                <td><b>Barcode</b></td>
                <td> </td>
                <td></td>
              </tr>



              <tr>
                <td><b>Brand</b></td>
                <td> {!! $item->brand ? $item->brand->name : '' !!}</td>
                <td></td>
              </tr>
            </tbody>
          </table>

         @if($item->hasDetails()) {!! $item->details->description !!} @endif

        </div>
        <!--end col-md-8-->
        <div class="col-md-4">
          <div class="portlet sale-summary">
            <div class="portlet-title">
              <div class="caption font-red sbold"> Statistics </div>
            </div>
            <div class="portlet-body">
              <ul class="list-unstyled">
                <li>
                  <span class="sale-info"> In Stock
                    <i class="fa fa-img-up"></i>
                  </span>
                  <span class="sale-num"> {{ (int) $item->getTotalStockQuantity() }}</span>
                </li>
                <li>
                  <span class="sale-info"> Cost
                    <i class="fa fa-img-down"></i>
                  </span>
                  <span class="sale-num"> {{ $item->getCurrentSupplierCost($item->suppliers[0]->id) }} </span>
                </li>
                <li>
                  <span class="sale-info"> Total use </span>
                  <span class="sale-num"> 2377 </span>
                </li>
              </ul>
            </div>
          </div>

        </div>
        <!--end col-md-4-->
      </div>
      <!--end row-->
      <br>
    </div>
  </div>
</div>
@endsection

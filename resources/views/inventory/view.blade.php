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
                    <input type="text" name="serialnr" readonly="" value="{{ $item->serialnr }}" id="tool" class="form-control input-lg">
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
@endsection


@section('content')

<?php
// Get Only Unique Costs
/*
$oldid=0;
$costtable = "";
foreach($costs as $cost)
{
  $id = $cost->supplier_id;
  if($oldid <> $id) {
    $costtable ="<tr>
    <td><b>Supplier</b></td><td>".$cost->supplier->name."</td><td>".$cost->cost." NOK</td>
    </tr>";
    $cost = $cost->cost;

  }
  $oldid = $id;
}*/
?>

<div class="profile">
  <div class="row">
    <div class="col-md-4">
      <ul class="list-unstyled profile-nav">
        foreach($tool->pictures as $picture)
        <li class="pic-bordered padding-10">
          <img src="" class="img-responsive" alt="">
        </li>
        endforeach
      </ul>
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-8 profile-info">
          <h1 class="font-green sbold uppercase">{{ $item->serialnr }}</h1>
          <h5 class="font-green sbold uppercase">if($detail) endif</h5>
          <br>

          <table class="table table-advance table-hover">
            <tbody>
              <tr>
                <td><b>Category</b></td>
                <td> {{ $item->category->name }}</td>
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
                <td> </td>
                <td></td>
              </tr>
            </tbody>
          </table>

          if($detail)  endif

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
                  <span class="sale-num"> </span>
                </li>
                <li>
                  <span class="sale-info"> Cost
                    <i class="fa fa-img-down"></i>
                  </span>
                  <span class="sale-num"> </span>
                </li>
                <li>
                  <span class="sale-info"> Total Use </span>
                  <span class="sale-num"> 2377 </span>
                </li>
              </ul>
            </div>
          </div>

          <ul class="list-unstyled profile-nav">
            <li>
              <a href="javascript:;"> Take out </a>
            </li>
            <li>
              <button id="request" class="btn blue">Request</button>
            </li>
            @if(Auth::check() && Auth::user()->hasRole('admin'))
            <li>
              <a href="{!! url('/inventory/'.$item->id.'/edit') !!}"> Edit </a>
            </li>
            @endif
          </ul>
        </div>
        <!--end col-md-4-->
      </div>
      <!--end row-->
      <br>
    </div>
  </div>
</div>
@endsection

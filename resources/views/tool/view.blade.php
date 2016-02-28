@extends('master')

@section('title') Tools | View | {{ $tool->serialnr }} @endsection

@section('css')
{!! Html::style('pages/css/profile-2.css') !!}
@endsection


@section('style')
<style>
.page-content {background-color: #ffffff !important;}
</style>
@endsection


@section('content')

<?php 

                // Get Only Unique Costs
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
}
?>

<div class="profile">
	<div class="row">
        <div class="col-md-4">
            <ul class="list-unstyled profile-nav">

                @foreach($tool->pictures as $picture)
                <li class="pic-bordered padding-10">
                    <img src="{!! url('/files'.$picture->path) !!}" class="img-responsive" alt="{{ $picture->title }}">
                </li>
                @endforeach
            
            </ul>
        </div>

              
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8 profile-info">
                <h1 class="font-green sbold uppercase">{{ $tool->serialnr }}</h1>
                <h5 class="font-green sbold uppercase">@if($detail) {{ $detail->title1 }} @endif</h5>
                <br>


                <table class="table table-advance table-hover">
                    <tbody>
                        <tr>
                            <td><b>Category</b></td>
                            <td> {{ $category }}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Supplier SN</b></td>
                            <td> {{ $tool->name0 }}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Barcode</b></td>
                            <td> {{ $tool->getBarcode() }}</td>
                            <td></td>
                        </tr>

                        {!! $costtable !!}

                        <tr>
                            <td><b>Brand</b></td>
                            <td> {{ $tool->supplier->name }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>


               @if($detail) {!! $detail->description !!} @endif

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
                                <span class="sale-num"> {{ $tool->getTotalStock() }}</span>
                            </li>
                            <li>
                                <span class="sale-info"> Cost
                                    <i class="fa fa-img-down"></i>
                                </span>
                                <span class="sale-num"> {{ $cost }} </span>
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
                        <a href="javascript:;"> Request </a>
                    </li>
@if(Auth::check() && Auth::user()->hasRole('admin'))
                    <li>
                        <a href="{!! url('/tool/'.$tool->id.'/edit') !!}"> Edit </a>
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
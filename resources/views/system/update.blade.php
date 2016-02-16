@extends('master')

@section('title') System | Update @endsection

@section('css')
@endsection

@section('js')
@endsection

@section('script')
<script>
</script>
@endsection

@section('content')


<?php 

chdir('../');

exec("git checkout master", $out);

foreach($out as $line) {
    echo $line."<br>";
}
?>

@endsection


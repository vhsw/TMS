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

exec("git status", $output, $result);

if($result > 0) {
	echo "ERROR ".$result.": Don't have a git repository in this or any parent directory";
} else {
	exec("git pull", $output, $result);

	foreach($output as $out) {
	    echo $out."<br>";
	}
}

?>

@endsection


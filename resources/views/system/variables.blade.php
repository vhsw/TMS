@extends('master')

@section('title') System | Variables @endsection

@section('css')
@endsection

@section('js')
@endsection

@section('script')
<script>

var months = ['January', 'February', 'Mars', 'April', 'May', 'Juny', 'July', 'August', 'September', 'October', 'November', 'December'];
// TODO: Use js date framework instead of array.

@if($budget == null)

    var html = '';
    for (i = 0; i < 12; i++) {
        var button = i == 0 ? '<button id="btn-copy" class="btn blue">Copy</button>' : '';
        var input = '<input type="text" name="budget[]" value="0">';
        html = html + '<tr><td width="1%">' + months[i] + '</td><td>' + input + '</td><td>'
             + button + '</td></tr>';
    }
    $('#budget > tbody').html(html);

@endif

$('#btn-copy').click(function(e){
    e.preventDefault();
    var budget = $('input[name^="budget"]');
    //console.log(janInput.first().val());

    budget.each(function(){
        $(this).val(budget.first().val());
    })
});

</script>
@endsection

@section('content')


<form action="{!! url('system/variables/save') !!}" method="post" class="form-horizontal form-bordered form-row-stripped">
<input type="hidden" name="_token" value="{{ csrf_token() }}">    
    <div class="page-bar">        
        <div class="row p-t-10 p-b-10">
            <div class="col-md-3">
                <button id="btn-add" class="btn blue">Save</button> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 p-t-20">
            <h2>Budget</h2>
            <br>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table id="budget" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="40%"> Month </th>
                                <th width="40%"> Budget </th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($budget != null)
                            <?php $col = '_'.date('Y'); ?>
                            @foreach($budget as $val)
                            <tr>
                                <td width="1%"><?php echo date("F", mktime(0, 0, 0, $val->month)); ?></td>
                                <td><input type="text" name="budget[]" value="{{ $val->budget }}"></td>
                                <td>{!! $val->month == 1 ? '<button id="btn-copy" class="btn blue">Copy</button>' : '' !!}</td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 p-t-20">
            <div class="form-body">
                <h2>Other System Settings</h2>
                <br>
                @foreach($systemvariables as $systemvariable)
                <div class="form-group">
                    <label class="control-label col-md-2">{{ $systemvariable->variable }}</label>
                    <div class="col-md-5">
                        <input value="{{ $systemvariable->content }}" placeholder="small" class="form-control" type="text">
                    </div>
                    @if (unserialize($systemvariable->content) !== false)
                    <label class="control-label col-md-5">
                        {{ print_r(unserialize($systemvariable->content)) }}
                    </label>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection



var generateSelect = function(id, data, selected){

    var i = $('.category').length + 1;
    var select = '<div id="category-' + id + '" class="row category"><div class="form-group"><label class="control-label col-md-' + i + '"></label>'
    +'<div class="col-md-6">'
    +'<select name="category[]" class="bs-select form-control" data-show-subtext="true">'
    +'<option value="0" data-content=""></option>';

    $.each(data, function(i, category){
        var icon = '<img src=\'' + iconUrl + '/' + category.icon + '.png\' height=\'22px\'>';

        var s = '';
        if(category.id == selected) {
            s = 'SELECTED';
        }
        select = select+'<option value="' + category.id + '" data-content="' + icon + ' '
        + category.name + '" ' + s + '> ' + category.name + '</option>';
    });
    select = select + '</select></div></div></div>';

    return select;
}


var generateSelectBoxes = function(id) {
    $.ajax({
        url: APP_URL + '/categories/generate-select-boxes',
        dataType: 'json',
        data: {id: id},
        success: function( data ) {
            if(data.length > 0) {
                $.each(data, function(i, categories){
                    if(categories.length > 0){
                        $("#categories").append( generateSelect(id, categories, selected[i+1]) );
                        $('.bs-select').selectpicker('refresh');
                    }
                });
            }
        }
    });
}

var updateCategories = function(id, selected){
    $.ajax({
        url: APP_URL + '/categories/get-immediate-descendants',
        dataType: 'json',
        data: {id: id},
        success: function( data ) {
            if(data.length != 0) {
                $("#categories").append( generateSelect( id, data, selected ) );
                $('.bs-select').selectpicker('refresh');
            }
        }
    });
}

var changeSupplier = function(id, item){
    $.ajax({
        url: APP_URL + '/inventory/' + item + '/change-supplier',
        dataType: 'json',
        data: {id: id},
        success: function( data ) {

            var html = '';
            $.each(data, function(i, supplier){
                html = html + '<option value="' + supplier.id + '">' + supplier.name + '</option>';
            });

            $('#supplier').find('option').remove().end()
                .append(html);
        }
    });
}

var downloadToolInfo = function(){
    $.ajax({
        url: APP_URL + '/inventory/download',
        cache: false,
        dataType: 'json',
        data: $('form').serializeArray(),
        success: function(data){
            console.log(data);
            $('input[name=name0]').val(data.title1);
            $('#summernote_1').summernote('code', data.description);

            /*data.images.forEach(function(url){
                $('#images').append('<img src="'+ url +'"><br>');
            });

            $('#tool_info').show();
            $('.save').show();*/
        },
        error: function( XMLHttpRequest, jqXHR, textStatus ){
            console.log(XMLHttpRequest);
        }
    });
}

var saveToolInfo = function(id, data){

    data.title1 = $('input[name=title1]').val();
    data.title2 = $('input[name=title2]').val();
    data.description = $('textarea[name=description]').val();
    //console.log(data);

    $.ajax({
        url: "{!! url('plugins/download/save') !!}",
        cache: false,
        data: {id: id, data: data},
        success: function(ev){
            console.log(ev)
            $('#tool_info').hide();
            //$('.save').hide();
        },
        error: function( XMLHttpRequest, jqXHR, textStatus ){
            console.log(XMLHttpRequest);
        }
    });
}

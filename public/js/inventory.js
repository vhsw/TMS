
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

$(function(){

    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
    $('#btn-add').click(function(){
        $('#list').hide();
        $('#add-form').fadeIn();
        resetForm();
    })
    $('#btn-cancel').click(function(){
        cancel();
    })
    $('#btn-edit-cancel').click(function(){
        cancel();
    })
    $('#btn-back').click(function(){
        cancel();
    })
    // SELECT2
    $('.select2-menu').each(function(){
        var data_result = "";
        $(this).select2({
            width:"100%"
            ,placeholder: "Choose Menu.."
            ,ajax: {
                url: vars.menu.url_ajax_menu
                ,dataType: 'json'
                ,data: function (term, page) {
                    return {
                        q: term
                        ,page_limit: 50
                        ,page: page
                    };
                }
                ,results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    data_result = data.results;
                    data_result.push({id:0,text:"No Parent Menu.."});
                    return {
                        results: data_result,
                        more: more
                    };
                }
            }
        }).select2('data', {id:vars.menu.data.id, text:vars.menu.data.name});
    });

    // DATATABLE
    var oTable = $('.list-menu table').DataTable( {
        "iDisplayLength" : 10
        ,"sAjaxSource" : vars.url
        ,"sServerMethod" : "GET"
        ,"fnServerParams" : function ( aoData ) {
            aoData.push(
                { "name": "d", "value" : vars.id },
                { "name": "t", "value" : vars.table },
                { "name": "j", "value" : vars.join },
                { "name": "oj", "value" : vars.on_join_id },
                { "name": "c", "value" : vars.column },
                { "name": "a", "value" : vars.access }
            );
        }
        ,"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            for( var i = 0; i < aData.length ; i++ )
            {
                var string = '';
                if(aData[i] == null){
                    aData[i] = '';
                }
                var thisData = aData[i].toString(); // convert data to string
                if ( thisData == "expand" ) {
                    string = "<a class=\"expand icon-plus tipl\" href=\"javascript:void(0)\" data-original-title=\"Expand\" id=" + aData[0] + "></a>";
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }
                else if ( thisData.indexOf('view') != -1 || thisData.indexOf('edit') != -1 || thisData.indexOf('delete') != -1 ) {
                    var x = thisData.split(',');

                    for( var z = 0; z < x.length; z++ )
                    {
                        if(string.length > 0) string += '&nbsp;&nbsp;';
                        if(x[z] == "view") {
                            string += "<a data-id=" + aData[0] + " id=\"aView\" class=\"view btn btn btn-link btn-icon btn-xs tip\" title data-original-title=\"View data\"><i class=\"icon-zoom-in\"></i></a>";
                        }
                        else if(x[z] == "edit") {
                            string += "<a data-id=" + aData[0] + " id=\"aEdit\" class=\"edit btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Edit data\" ><i class=\"icon-pencil\"></i></a>";
                        }
                        else if(x[z] == "delete") {
                            string += "<a data-toggle=\"modal\" id=\"aRemove\" data-id=" + aData[0] + " data-name=" + aData[2] +" role=\"button\" href=\"#delete_modal\" class=\"remove btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Delete data\"><i class=\"icon-remove5\"></i></a>";
                        }
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }

                if(i == 1){
                    if(thisData == ''){
                        string += '-';
                    }else{
                        string += aData[i];
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }


            }
        }
        ,"aoColumnDefs": [
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 0 ] }
           ,{ "bSortable": false, "bSearchable": false, "sClass": "text-center", "aTargets": [ 5 ] }

        ]
    });

    $(".dataTables_length select").select2({
        minimumResultsForSearch: "-1"
    });


    // A CLICK
    $('.list-menu tbody').on('click', 'tr td a', function(){
        var tr  = $(this).parent().parent();
        var type = $(this).attr('id');
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        if (tr.hasClass('row_selected') ) {
            tr.removeClass('row_selected');
        }
        else {
            oTable.$('tr.row_selected').removeClass('row_selected');
            tr.addClass('row_selected');
        }

        if(type == 'aRemove'){
            $('#delete_modal input[name="menu_id"]').val(id);
            $('#delete_modal #label-name').html(name);

        }else if(type == 'aEdit'){
            $('#list').hide();
            $('#edit-form').fadeIn();
            ajaxEditMenu(id);
            resetForm();
        }else{
            $('#list').hide();
            $('#view-form').fadeIn();
            ajaxViewMenu(id);
            resetForm();
        }
    });


    // FORM SUBMIT
    $('#form-add-menu').submit(function(){
        if($(this).valid()) {
            var validator = $(this).validate();
            $('#btn-save').attr('disabled', 'disabled');
            var url = $(this).attr('action');
            $.post(url, $(this).serializeArray(), function(callback){
                if(callback.status == 1) {
                    console.log(callback.data);
                    oTable.row.add(callback.data).draw();
                    $('#btn-reset').trigger('click');
                    $('#btn-save').removeAttr("disabled");
                    $('#add-form').hide();
                    $('#list').fadeIn();
                    $('#notification-succes').click();
                    validator.resetForm();
                }
                else {
                    $('#btn-save').removeAttr("disabled");
                    $('#notification-error').click();
                }
            }, 'json');
        }
        return false;
    });

    $('#form-edit-menu').submit(function(){
        if($(this).valid()) {
            var validator = $(this).validate();

            $('#btn-save').attr('disabled', 'disabled');
            var url = $(this).attr('action');
            $.post(url, $(this).serializeArray(), function(callback){
                if(callback.status == 1) {
                    oTable.row('.row_selected').remove().draw(false);
                    oTable.row.add(callback.data).draw();

                    $('#btn-reset').trigger('click');
                    $('#btn-save').removeAttr("disabled");
                    $('#edit-form').hide();
                    $('#list').fadeIn();
                    validator.resetForm();
                    $('#notification-succes').click();
                }
                else {
                    $('#btn-save').removeAttr("disabled");
                    $('#notification-error').click();
                }
            }, 'json');
        }
        return false;
    });


    $('#form-modal-delete').submit(function(){
        var url = $(this).attr('action');
        $('#btn-modal-delete').attr('disabled', 'disabled');
        $.post(url, $(this).serializeArray(), function(callback){
            if(callback.status == 1) {
                $('#notification-succes').click();
                $('#btn-modal-delete').removeAttr('disabled');
                oTable.row('.row_selected').remove().draw(false);
                $('#btn-dismis').trigger('click');
            }
            else {
                $('#notification-error').click();
                $('#btn-modal-delete').removeAttr('disabled');
                return false;
            }
        }, 'json');
        return false;
    })


});


// FUNCTION
function resetForm(){
    $('#select2 input[name="parent"]').select2('data', {id:0,text:'No Parent Menu..'});
}

function cancel(){
    $('#list').fadeIn();
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
    resetForm();
}

function ajaxEditMenu(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            if(callback.data.parent == 0){
                $('#edit-select2 input[name="parent"]').select2('data', {id:0,text:'No Parent Menu..'});
            }else{
                $('#edit-select2 input[name="parent"]').select2('data', {id:callback.parent.id,text:callback.parent.name});
            }
            $('#edit-form input[name="id"]').val(callback.data.id);
            $('#edit-form input[name="name"]').val(callback.data.name);
            $('#edit-form input[name="url"]').val(callback.data.url);
            $('#edit-form input[name="sort"]').val(callback.data.sort);
        }
        else {
            console.log('failed');
        }
    }, 'json');

}

function ajaxViewMenu(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            var parent_name = 'No Parent Menu';
            var menu_name = '-';
            var url = '-';
            var sort = '-';

            if(callback.data.parent != 0){
                parent_name = callback.parent.name;
            }
            if(callback.data.name != ''){
                menu_name = callback.data.name;
            }
            if(callback.data.url != ''){
                url = callback.data.url;
            }
            if(callback.data.sort != ''){
                sort = callback.data.sort;
            }
            $('#parent_menu').html(parent_name);
            $('#menu_name').html(menu_name);
            $('#url').html(url);
            $('#sort').html(sort);
        }
        else {
            console.log('failed');
        }
    }, 'json');

}

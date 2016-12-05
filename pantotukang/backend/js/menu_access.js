$(function(){

    var no_sub_menu={id:0,text:"No Sub Menu.."};
    cancel();
    resetForm();
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
    $('.select2-group-menu').each(function(){
        $(this).select2({
            width:"100%"
            ,placeholder: "Choose Group Name.."
            ,ajax: {
                url: vars.user_group.ajax_group_menu
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
                    return {results: data.results, more: more};
                }
            }
        }).select2('data', {id:vars.user_group.data.id,text:vars.user_group.data.name});
    });

    $('.select2-parent-menu').each(function(){
        var editDelete = $(this).attr('id');
        var data_result = "";
        var select2_menu = $(this).select2({
            width:"100%"
            ,placeholder: "Choose Menu.."
            ,ajax: {
                url: vars.parent_menu.ajax_parent_menu
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
        })
            .select2('data', {id:vars.parent_menu.data.id, text:vars.parent_menu.data.name})
            .on("change", function(){
                //alert($(this).select2('val'));
                var editDelete = $(this).attr('id');
                $.get(vars.get_first_row_select2, {
                    id: $(this).select2('val')
                    ,where: "parent"
                    ,table: "backend_menu"
                    ,columns: "id,name"
                    ,order: "name"
                }, function(data){
                    console.log(data);
                    if(data.id) $('.select2-sub-menu').select2('data', data);
                    else $('.select2-sub-menu').select2('data', no_sub_menu);
                }, 'json');
            });
    });


    $('.select2-sub-menu').each(function(){
        $(this).select2({
            width:"100%"
            ,placeholder: "Choose Menu.."
            ,ajax: {
                url: vars.sub_menu.ajax_sub_menu
                ,dataType: 'json'
                ,data: function (term, page) {
                    return {
                        q: term
                        ,page_limit: 50
                        ,page: page
                        ,id: $('.select2-parent-menu').val()
                    };
                }
                ,results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    return {
                        results: data.results,
                        more: more
                    };
                }
            }
        })
    });


    // DATATABLE
    var oTable = $('.list-menu-access table').DataTable( {
        "iDisplayLength" : 10
        ,"sAjaxSource" : vars.url
        ,"sServerMethod" : "GET"
        ,"fnServerParams" : function ( aoData ) {
            aoData.push(
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
                            string += "<a data-toggle=\"modal\" id=\"aRemove\" data-id=" + aData[0] + " data-name=" + htmlspecialchars(aData[1]) + " role=\"button\" href=\"#delete_modal\" class=\"remove btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Delete data\"><i class=\"icon-remove5\"></i></a>";
                        }
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }

                if(i == 2){
                    if(thisData == ''){
                        string += '-';
                    }else{
                        string += aData[i];
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }
                if(i == 4 || i == 5 || i == 6 || i == 7 ){
                    if(thisData == 1){
                        string += 'Yes';
                    }else{
                        string += 'No';
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
    $('.list-menu-access tbody').on('click', 'tr td a', function(){
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
            resetForm();
            ajaxEdit(id);
        }else{
            $('#list').hide();
            $('#view-form').fadeIn();
            ajaxView(id);
            resetForm();
        }
    });

    // FORM SUBMIT
    $('#form-add-access').submit(function(){
        if($(this).valid()) {
            var validator = $(this).validate();

            $('#btn-save').attr('disabled', 'disabled');
            var url = $(this).attr('action');
            $.post(url, $(this).serializeArray(), function(callback){
                if(callback.status == 1) {
                    oTable.row.add(callback.data).draw();
                    $('#btn-reset').trigger('click');
                    $('#btn-save').removeAttr("disabled");
                    resetForm();
                    cancel();
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

    $('#form-edit-access').submit(function(){
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
                    resetForm();
                    cancel();
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
function cancel(){
    $('#list').fadeIn();
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();

    $('#edit-form input[name="view"]').removeAttr('checked');
    $('#edit-form input[name="add"]').removeAttr('checked');
    $('#edit-form input[name="edit"]').removeAttr('checked');
    $('#edit-form input[name="delete"]').removeAttr('checked');

}

function resetForm(){
    $('#select2 input[name="group"]').select2('data', {id:1,text:'System'});
    $('#select2 input[name="parent"]').select2('data', {id:0,text:'No Parent Menu..'});
    $('#select2 input[name="submenu"]').select2('data', {id:0,text:'Choose Sub Menu..'});
    $('#add-form span.checked').removeClass('checked');
}

function ajaxEdit(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            console.log(callback.data);
            $('#edit-form input[name="id"]').val(callback.data.id);
            $('#edit-form input[name="group"]').select2('data', {id : callback.data.usergroup_id, text: callback.data.usergroup_name });
            if(callback.data.parent_id !== null){
                $('#edit-form input[name="parent"]').select2('data', {id : callback.data.parent_id, text: callback.data.parent_menu });
            }else{
                $('#edit-form input[name="parent"]').select2('data', {id:0,text:'No Parent Menu..'});
            }

            if(callback.data.menu_id != null){
                $('#edit-form input[name="submenu"]').select2('data', {id : callback.data.menu_id, text: callback.data.menu_name });
            }else{
                $('#edit-form input[name="submenu"]').select2('data', {id:0,text:'Choose Sub Menu..'});
            }

            if(callback.data.view === '1') $('#edit-form input[name="view"]').trigger("click");
            if(callback.data.add === '1') $('#edit-form input[name="add"]').trigger("click");
            if(callback.data.edit === '1') $('#edit-form input[name="edit"]').trigger("click");
            if(callback.data.delete === '1') $('#edit-form input[name="delete"]').trigger("click");
        }
        else {
            console.log('failed');
        }
    }, 'json');

}

function ajaxView(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            console.log(callback.data);
            $('#view-form #group').html(callback.data.usergroup_name);

            if(callback.data.parent_menu !== null) $('#view-form #parent_menu').html(callback.data.parent_menu);
            else $('#view-form #parent_menu').html('-');

            if(callback.data.menu_name !== null) $('#view-form #menu_name').html(callback.data.menu_name);
            else $('#view-form #menu_name').html('-');

            if(callback.data.view == 1)$('#view-form #view').html('Yes');
            else $('#view-form #view').html('No Access');

            if(callback.data.add == 1)$('#view-form #add').html('Yes');
            else $('#view-form #add').html('No Access');

            if(callback.data.edit == 1)$('#view-form #edit').html('Yes');
            else $('#view-form #edit').html('No Access');

            if(callback.data.delete == 1)$('#view-form #delete').html('Yes');
            else $('#view-form #delete').html('No Access');
        }
        else {
            console.log('failed');
        }
    }, 'json');

}
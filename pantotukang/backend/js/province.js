$(function(){

    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
    $('#btn-add').click(function(){
        $('#list').hide();
        $('#add-form').fadeIn();
        //resetForm();
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

    // DATATABLE
    var oTable = $('.list-province table').DataTable( {
        "iDisplayLength" : 10
        ,"sAjaxSource" : vars.url
        ,"sServerMethod" : "GET"
        ,"fnServerParams" : function ( aoData ) {
            aoData.push(
                { "name": "d", "value" : vars.id },
                { "name": "t", "value" : vars.table },
                { "name": "c", "value" : vars.column }
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
                            string += "<a data-toggle=\"modal\" id=\"aRemove\" data-id=" + aData[0] + " data-name=" + aData[1] +" role=\"button\" href=\"#delete_modal\" class=\"remove btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Delete data\"><i class=\"icon-remove5\"></i></a>";
                        }
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }
            }
        }
    });

    $(".dataTables_length select").select2({
        minimumResultsForSearch: "-1"
    });


    // A CLICK
    $('.list-province tbody').on('click', 'tr td a', function(){
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
            $('#delete_modal input[name="province_id"]').val(id);
            $('#delete_modal #label-name').html(name);

        }else if(type == 'aEdit'){
            $('#list').hide();
            $('#edit-form').fadeIn();
            ajaxEdit(id);
        }else{
            $('#list').hide();
            $('#view-form').fadeIn();
            ajaxView(id);
            //resetForm();
        }
    });


    // FORM SUBMIT
    $('#form-add-province').submit(function(){
        if($(this).valid()) {
            var validator = $(this).validate();
            validator.resetForm();
            $('#btn-save').attr('disabled', 'disabled');
            var url = $(this).attr('action');
            $.post(url, $(this).serializeArray(), function(callback){
                if(callback.status == 1) {
                    //console.log(callback.data);
                    oTable.row.add(callback.data).draw();
                    $('#btn-reset').trigger('click');
                    $('#btn-save').removeAttr("disabled");
                    $('#add-form').hide();
                    $('#list').fadeIn();
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

    $('#form-edit-province').submit(function(){
        if($(this).valid()) {
            var validator = $(this).validate();
            validator.resetForm();
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
                    $('#notification-succes').click();
                }
                else {
                    $('#btn-save').removeAttr("disabled");
                    $('#notification-error').click();
                }
            }, 'json');
        }else{
            alert('no valid');
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
                $('#list').fadeIn();
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
}

function ajaxEdit(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            //console.log(callback.data);
            $('#edit-form input[name="id"]').val(callback.data.id);
            $('#edit-form input[name="province_name"]').val(callback.data.name);
            $('#edit-form input[name="latitude"]').val(callback.data.latitude);
            $('#edit-form input[name="longitude"]').val(callback.data.longitude);
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
            //console.log(callback.data);
            $('#view-form #province_name').html(callback.data.name);
            $('#view-form #latitude').html(callback.data.latitude);
            $('#view-form #longitude').html(callback.data.longitude);
        }
        else {
            console.log('failed');
        }
    }, 'json');
}
$(function(){
    // onload
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
    resetForm();

    // button action
    $('#btn-add').click(function(){
        $('#list').hide();
        $('#add-form').fadeIn();
        resetForm();
    })
    $('#btn-cancel').click(function(){
        cancel();
        resetForm();
    })
    $('#btn-edit-cancel').click(function(){
        cancel();
        resetForm();
    })
    $('#btn-back').click(function(){
        cancel();
        resetForm();
    })

    // SELECT2
    $('.select2-usergroup').each(function(){
        $(this).select2({
            width:"100%"
            ,placeholder: "Choose Usergroup"
            ,ajax: {
                url: vars.user_group.url_usergroup
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
        })
    });

    $('.select2-city').each(function(){
        $(this).select2({
            width:"100%",
            placeholder: "Choose City..",
            ajax: {
                url: vars.city.url_city,
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        age_limit: 50,
                        page: page
                    };
                }, results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    return {results: data.cities, more: more};
                }
            }
        })
    });

    // DATATABLE
    var oTable = $('.list-member table').DataTable( {
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
                            string += "<a data-toggle=\"modal\" id=\"aRemove\" data-id=" + aData[0] + " data-name=" + aData[2] +" role=\"button\" href=\"#delete_modal\" class=\"remove btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Delete data\"><i class=\"icon-remove5\"></i></a>";
                        }
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }

                if(i == 4){
                    if(aData[i] != 0) {
                        string += date('d M Y', aData[i]).toUpperCase();
                    }else{
                        string += '-';
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }
            }
        }
    });

    $(".dataTables_length select").select2({
        minimumResultsForSearch: "-1"
    });


    // a href click on datatable
    $('.list-member tbody').on('click', 'tr td a', function(){
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
            $('#delete_modal input[name="id"]').val(id);
            $('#delete_modal #label-name').html(name);

        }else if(type == 'aEdit'){
            $('#list').hide();
            $('#edit-form').fadeIn();
            ajaxEdit(id);
        }else{
            $('#list').hide();
            $('#view-form').fadeIn();
            ajaxView(id);
            resetForm();
        }
    });


    // FORM SUBMIT
    $('#form-add-member').submit(function(){
        if($(this).valid()) {
            // var validator = $(this).validate();
            // validator.resetForm();
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
					var validator = $(this).validate();
                    validator.resetForm();
                    cancel();

                }
                else {
                    $('#btn-save').removeAttr("disabled");
                    $('#notification-error').click();
                }
            }, 'json');
        }
        return false;
    });

    $('#form-edit-member').submit(function(){
        if($(this).valid()) {
            // var validator = $(this).validate();
            // validator.resetForm();
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
}
function resetForm(){
    var formValidator = $('#form-add-member').validate();
    formValidator.resetForm();
    $('#btn-reset-add').trigger('click');
    $('#btn-reset-edit').trigger('click');
    $('#add-form span.checked').removeClass('checked');
    $('#add-form #radio-male input[name="gender"]').attr('checked', false);
    $('#add-form #radio-female input[name="gender"]').attr('checked', false);
    $('#edit-form span.checked').removeClass('checked');
    $('#edit-form #radio-male input[name="gender"]').attr('checked', false);
    $('#edit-form #radio-female input[name="gender"]').attr('checked', false);
    $('#add-form input[name="usergroup"]').select2('data', {id : '', text:"Choose Usergroup.."});
    $('#add-form .select-day').select2('data', {id : '', text:"day"});
    $('#add-form .select-month').select2('data', {id : '', text:"month"});
    $('#add-form .select-year').select2('data', {id : '', text:"year"});
    $('#add-form input[name="city"]').select2('data', {id : '', text:"Choose City.."});
};

function ajaxEdit(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        if(callback.status == 1) {
            var dob = new Date(callback.data.dob*1000);
            var day = dob.getDate();
            var month = dob.getMonth() + 1;
            var year = dob.getFullYear();
            var monthName = '';
            switch(month){case 1:monthName = "Januari";break;case 2:monthName = "Februari";break;case 3:monthName = "Maret";break;case 4:monthName = "April";break;case 5:monthName = "Mei";break;case 6:monthName = "Juni";break;case 7:monthName = "Juli";break;case 8:monthName = "Agustus";break;case 9:monthName = "September";break;case 10:monthName = "Oktober";break;case 11:monthName = "November";break;case 12:monthName = "Desember";break;}
            $('#edit-form input[name="id"]').val(callback.data.id_member);
            if(callback.data.usergroup_id != null) $('#edit-form input[name="usergroup"]').select2('data', {id : callback.data.usergroup_id, text: callback.data.usergroup_name });
            $('#edit-form input[name="name"]').val(callback.data.name);
            $('#edit-form input[name="email"]').val(callback.data.email);
            // $('#edit-form input[name="password"]').val(callback.data.password);
            $('#edit-form input[name="telephone"]').val(callback.data.telephone);
            $('#edit-form input[name="handphone"]').val(callback.data.handphone);
            $('#edit-form input[name="zipcode"]').val(callback.data.zipcode);
            $('#edit-form #textarea_address').val(callback.data.address);

           // $('#edit-form #radio-male').trigger('click');
            $('#edit-form span.checked').removeClass('checked');
            if(callback.data.sex == 'MALE'){
                $('#edit-form #radio-male span').addClass('checked');
                $('#edit-form #radio-male input[name="gender"]').attr('checked', true);
                $('#edit-form #radio-female input[name="gender"]').attr('checked', false);
            }else if(callback.data.sex == "FEMALE"){
                $('#edit-form #radio-female span').addClass('checked');
                $('#edit-form #radio-female input[name="gender"]').attr('checked', true);
                $('#edit-form #radio-male input[name="gender"]').attr('checked', false);
            }else{
                $('#edit-form span.checked').removeClass('checked');
                $('#edit-form #radio-male input[name="gender"]').attr('checked', false);
                $('#edit-form #radio-female input[name="gender"]').attr('checked', false);
            }

            $('#edit-form #select-month').select2('data', {id : month, text: monthName});
            $('#edit-form #select-day').select2('data', {id : day, text: day});
            $('#edit-form #select-year').select2('data', {id : year, text: year});
            if(callback.data.city_id != 0){
                $('#edit-form input[name="city"]').select2('data', {id : callback.data.city_id, text: callback.data.city_name});
            }
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
            var dob = new Date(callback.data.dob*1000);
            var day = dob.getDate();
            var month = dob.getMonth() + 1;
            var year = dob.getFullYear();
            var monthName = '';
            switch(month){
                case 1:monthName = "Januari";break;case 2:monthName = "Februari";break;case 3:monthName = "Maret";break;case 4:monthName = "April";break;case 5:monthName = "Mei";break;case 6:monthName = "Juni";break;case 7:monthName = "Juli";break;case 8:monthName = "Agustus";break;case 9:monthName = "September";break;case 10:monthName = "Oktober";break;case 11:monthName = "November";break;case 12:monthName = "Desember";break;
            }

            $('#view-form #usergroup_name').html(callback.data.usergroup_name);
            $('#view-form #name').html(callback.data.name);
            $('#view-form #email').html(callback.data.email);
            $('#view-form #phonenumber').html(callback.data.telephone);
            $('#view-form #handphone').html(callback.data.handphone);
            $('#view-form #birthday').html(day + ' ' + monthName + ' ' + year);
            $('#view-form #gender').html(callback.data.sex);
            $('#view-form #city').html(callback.data.city_name);
            $('#view-form #zipcode').html(callback.data.zipcode);
            $('#view-form #address').html(callback.data.address);

        }
        else {
            console.log('failed');
        }
    }, 'json');

}
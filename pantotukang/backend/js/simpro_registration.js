$body = $("body");

$(function(){
    $(document).ajaxStart(function(){
        $body.addClass("loading");
    });
    $(document).ajaxComplete(function(){
        $body.removeClass("loading");
    });

    // onload
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
    resetForm();

    // button action
    $('#btn-add').click(function(){
        $('#list').hide();
        $(".breadcrumb-line").hide();
        $(".page-header").hide();
        $('#add-form').fadeIn();
        generateNumber();
        resetForm();
    })

    $('#btn-cancel').click(function(){
        cancel();
        $(".page-header").fadeIn();
        $(".breadcrumb-line").fadeIn();
        resetForm();
    })
    $('#btn-edit-cancel').click(function(){
        cancel();
        $(".page-header").fadeIn();
        $(".breadcrumb-line").fadeIn();
        resetForm();
    })
    $('#btn-back').click(function(){
        cancel();
        $(".page-header").fadeIn();
        $(".breadcrumb-line").fadeIn();
        resetForm();
    })

    $('#add-form #btn-reset').click(function(){
        resetForm();
        generateNumber();
    })

    $('#edit-form #btn-reset').click(function(){
        resetForm();
        generateNumber();
    })


    $('#aDel').click(function(){
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        $('#delete_modal input[name="simpro_id"]').val(id);
        $('#delete_modal #label-name').html(name);
    });

    $("#add-form input[name='purchase_date']").datepicker({
        onSelect: function(dateText, inst) {
            $("#add-form input[name='has_payment']").focus();
        },
        "dateFormat": "dd-mm-yy"
    });

    $("#edit-form input[name='purchase_date']").datepicker({
        onSelect: function(dateText, inst) {
            $("#edit-form input[name='has_payment']").focus();
        },
        "dateFormat": "dd-mm-yy"
    });


    //$("#add-form input[name='product_period_start']").datepicker({
    //    onSelect: function(dateText, inst) {
    //        var url = vars.url_next_date;
    //        $.post(url,
    //            {
    //                'id':$(this).val()
    //
    //            },function(callback){
    //                if(callback.status == 1) {
    //                    $("#add-form input[name='product_period_end']").val(callback.data);
    //                }
    //                else {
    //                    console.log('failed');
    //                }
    //            }, 'json');
    //    },
    //    "dateFormat": "dd-mm-yy"
    //});

    $('.select2-product-id').each(function(){
        $(this).select2({
            width:"100%",
            placeholder: "Choose Brand..",
            ajax: {
                url: vars.product.list_product,
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        age_limit: 50,
                        page: page,
                        id: $('#product_id').val()
                    };
                },results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    return {results: data.results, more: more};
                }
            }
        })
    });

    $('#add-form .select2-device-type-id').each(function(){
        $(this).select2({
            width:"100%",
            placeholder: "Choose Device..",
            ajax: {
                url: vars.product.list_device,
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        age_limit: 50,
                        page: page,
                        id: $('#add-form #product_id').val()
                    };
                },results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    return {results: data.results, more: more};
                }
            }
        })
    });

    $('#edit-form .select2-device-type-id').each(function(){
        $(this).select2({
            width:"100%",
            placeholder: "Choose Device..",
            ajax: {
                url: vars.product.list_device,
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        age_limit: 50,
                        page: page,
                        id: $('#edit-form #product_id').val()
                    };
                },results: function (data, page) {
                    var more = (page * 50) < data.count_all;
                    return {results: data.results, more: more};
                }
            }
        })
    });

    $(document).on('change', '#add-form #kondisi', function(){
        $('#add-form #sum_insured').val("");
        $('#add-form #simpro_category').val("");
        if($(this).val() == "new"){
            $('#add-form #purchase_date').val($("#add-form #product_period_start").val());
            $('#add-form #purchase_date').removeClass("hasDatepicker");
            $('#add-form #purchase_date').addClass("readonly");
        }else{
            $('#add-form #purchase_date').val("");
            $('#add-form #purchase_date').addClass("hasDatepicker");
            $('#add-form #purchase_date').removeClass("readonly");
        }
    })

    $(document).on('change', '#edit-form #kondisi', function(){
        $('#edit-form #sum_insured').val("");
        $('#edit-form #simpro_category').val("");

        if($(this).val() == "new"){
            $('#add-form #purchase_date1').val($("#add-form #product_period_start").val());
            $('#add-form #purchase_date1').removeClass("hasDatepicker");
            $('#add-form #purchase_date1').addClass("readonly");
        }else{
            $('#add-form #purchase_date1').val("");
            $('#add-form #purchase_date1').addClass("hasDatepicker");
            $('#add-form #purchase_date1').removeClass("readonly");
        }

    })

    $(document).on('change', '#add-form input[name="has_payment"]', function(){
        var noCommas = $("#add-form #sum_insured").val().replace('.00', '');
        var noDotsPrice = noCommas.replace(/\,/g, '');
        var amount = 0;

        var kondisi = $("#add-form #kondisi").find(':selected').val();
        if($(this).is(":checked")) {
            amount = getPayment(kondisi, noDotsPrice);
            $('#add-form #payment_amount').val(amount);
            $(this).attr("checked");
        }else{
            console.log("unchecked");
            $('#add-form #payment_amount').val("");
            $(this).removeAttr("checked");
        }
    })

    $(document).on('change', '#edit-form input[name="has_payment"]', function(){
        var noCommas = $("#edit-form #sum_insured").val().replace('.00', '');
        var noDotsPrice = noCommas.replace(/\,/g, '');
        var amount = 0;
        console.log(noDotsPrice);

        var kondisi = $("#edit-form #kondisi").find(':selected').val();
        if($(this).is(":checked")) {
            console.log("checked");
            amount = getPayment(kondisi, noDotsPrice);
            $('#edit-form #payment_amount').val(amount);
            $(this).attr("checked");
        }else{
            console.log("unchecked");
            $('#edit-form #payment_amount').val("");
            $(this).removeAttr("checked");
        }
    })

    $(document).on('change', '#edit-form input[name="device_type"]', function(){
        var data = $(this).select2('data');
        $("#edit-form input[name='product_name']").val(data.text);
    })

    $(document).on('change', '#add-form input[name="device_type"]', function(){
        var data = $(this).select2('data');
        $("#add-form input[name='product_name']").val(data.text);
    })

    // DATATABLE
    var oTable = $('.list-simpro table').DataTable( {
        "iDisplayLength" : 10
        ,"sAjaxSource" : vars.url
        ,"sServerMethod" : "GET"
        ,"order": [[ 8, "desc" ]]
        ,dom: 'Bfrtip',
        buttons: [
            'excel', 'print'
        ]
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
                            string += "<a data-id=" + aData[0] + " id=\"print\" href='simpro_registration/printInvoice/"+aData[0]+"' target='_blank' class=\"btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Print\" ><i class=\"icon-print\"></i></a>";
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

                // if(i == 3)
                // {
                // var img = '';
                // if(aData[i] == '') img = '<div><img src=\"' + vars.base_no_image + 'no_images.png\" class=\"img-polaroid\" width=\"90px\" /></div>';
                // else img = '<div><img src=\"' + vars.base_image + '/' + aData[i] + '?' + (new Date()).getTime() + '\" class=\"img-polaroid\" width=\"90px\" /></div>';
                // $('td:eq(' + i.toString() + ')', nRow).html(img);
                // }

                // if(i == 7){
                // if(aData[i] != 0) {
                // string += date('d M Y', aData[i]).toUpperCase();
                // }else{
                // string += '-';
                // }
                // $('td:eq(' + i.toString() + ')', nRow).html( string );
                // }

                // if(i == 2){
                // if(aData[i] != 0) {
                // string += aData[i].substr(0, 50) + " ...More";
                // }else{
                // string += '-';
                // }
                // $('td:eq(' + i.toString() + ')', nRow).html( string );
                // }

            }
        }
        ,"aoColumnDefs": [
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 0 ] },
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 4 ] },
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 6 ] }
            //{ "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 7 ] }

        ]
    });

    $(".dataTables_length select").select2({
        minimumResultsForSearch: "-1"
    });

    $('div.dt-buttons').css('float', 'right');
    $('div.dt-buttons').css('padding', '20px');

    // a href click on datatable
    $('.list-simpro tbody').on('click', 'tr td a', function(){
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
            $('#delete_modal input[name="simpro_id"]').val(id);
            $('#delete_modal input[name="reg_no"]').val(name);
            $('#delete_modal #label-name').html(name);

        }else if(type == 'aEdit'){
            $('#list').hide();
            $('#edit-form').fadeIn();
            $("#add-form input.error").fadeIn();
            $("#add-form .select2-container").fadeIn();
            $("#add-form input.error").css('border-color', '#e5e5e5');

            ajaxEdit(id);
        }else if(type == 'print'){
            resetForm();
        }else{
            $('#list').hide();
            $('#view-form').fadeIn();
            ajaxView(id);
            resetForm();
        }
    });

    $(document).on('focus click', 'input',  function(e){
        $("#add-form label.error").hide();
        $("#edit-form label.error").hide();
    });

    $(document).on('focus click', '#add-form',  function(e){
        $("#add-form label.error").hide();
        $("#edit-form label.error").hide();
    });



    // FORM SUBMIT
    $('#btn-save').on('click' , function(){
        redForm("add-form");

        if($(this).valid()) {
            // $('#add-form #btn-save').addClass("disabled");
            $('#form-add-simpro').ajaxForm({
                dataType: 'json',
                success: function (callback) {
                    if(callback.status == 1) {
                        oTable.row('.row_selected').remove().draw(false);
                        oTable.row.add(callback.data).draw();
                        $('#add-form #btn-reset').trigger('click');
                        $('#add-form #btn-save').removeClass("disabled");
                        $('#edit-form').hide();
                        $('#list').fadeIn();
                        $(".page-header").fadeIn();
                        $(".breadcrumb-line").fadeIn();
                        $('#notification-succes').click();
                        var validator = $(this).validate();
                        validator.resetForm();
                        cancel();

                        // GENERATE
                        var url = vars.url_email;
                        $.post(url,
                            {
                                'id': callback.tempId

                            },function(callback1){
                                if(callback1.status == 1) {
                                    console.log('oke');
                                }
                                else {
                                    console.log('failed');
                                }
                            }, 'json');
                        //GENERATE
                    }
                    else {
                        $('#btn-save').removeClass("disabled");
                        $('#notification-error').click();
                    }
                }
            }).submit();

        }else{
            return false;
        }
    })

    $('#btn-save-edit').on('click' , function(){
        if($(this).valid()) {
            // $('#edit-form #btn-save-edit').addClass("disabled");
            $('#form-edit-simpro').ajaxForm({
                dataType: 'json',
                success: function (callback) {
                    if(callback.status == 1) {
                        oTable.row('.row_selected').remove().draw(false);
                        oTable.row.add(callback.data).draw();
                        $('#edit-form #btn-reset').trigger('click');
                        $('#edit-form #btn-save-edit').removeClass("disabled");
                        $('#edit-form').hide();
                        $('#list').fadeIn();
                        $('#notification-succes').click();
                        var validator = $(this).validate();
                        validator.resetForm();
                        cancel();
                    }
                    else {
                        $('#edit-form #btn-save-edit').removeClass("disabled");
                        $('#notification-error').click();
                    }
                }
            }).submit();

        }else{
            return false;
        }
    })

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

    if($("#store_id").val() == 1 || $("#store_id").val() == 2 || $("#store_id").val() == 3){
        $(".dt-buttons").fadeIn();
    }else{
        $(".dt-buttons").hide();
    }

});


// FUNCTION
function redForm(type){
    var explode = function(){
        $("#"+type+" label.error").hide();
        $("#"+type+" .error").each(function( i ) {
            if ( this.style.borderColor  !== "red" ) {
                this.style.borderColor  = "red";
            } else {
                this.style.borderColor  = "#e5e5e5";
            }
        });
    };
    setTimeout(explode, 100);
}

function generateNumber(){
    var url = vars.url_get_store;
    $.post(url,
        {
            'id': ""

        },function(callback){
            if(callback.status == 1) {

                $(".store_name").html("STORE : "+callback.store_name);
                $("#add-form input[name='store']").val(callback.store_name);
                $("#add-form input[name='date_in']").val(callback.date);
                $("#add-form input[name='product_period_start']").val(callback.date);
                $("#add-form input[name='product_period_end']").val(callback.new_date);


            }
            else {
                console.log('failed');
            }
        }, 'json');
}

function getCategory(condition, sum_insurance){
    var simpro_category = "";

    if(condition == "new" && parseInt(sum_insurance) <= 5000000){
        simpro_category = "SIM Pro 6M - New 60K";
    }else if( condition == "new" && (parseInt(sum_insurance) > 5000000 && parseInt(sum_insurance) <= 20000000) ){
        simpro_category = "SIM Pro 6M - New 80K";
    }else if(condition == "used"){
        simpro_category = "SIM Pro 6M - Used 90K";
    }else{
        simpro_category = "";
    }

    return simpro_category;
}

function getPayment(condition, sum_insurance){
    var simpro_price = "";
    if(condition == "new" && parseInt(sum_insurance) <= 5000000){
        simpro_price = "60,000";
    }else if( condition == "new" && (parseInt(sum_insurance) > 5000000 && parseInt(sum_insurance) <= 20000000) ){
        simpro_price = "80,000";
    }else{
        simpro_price = "90,000";
    }

    return simpro_price;
}
function nextfieldBarPress(event, next, form, id){  // fungsi saat tombol enter.
    console.log(event.keyCode);

    if(event.keyCode == 13 || event.which == 13){
        $("#"+form+" #"+ next ).focus();
    }
}

function nextfieldBar(event, next, form, id){  // fungsi saat tombol enter.
    if (event.keyCode != ""){
        if($("#"+form+" #"+id).val() == ""){
            $("#"+form+" #"+id).css('border-color', 'red');
            var explode = function(){
                $("#"+form+" label.error").hide();
            };
            setTimeout(explode, 50);
        }else{
            $("#"+form+" #"+id).css('border-color', '#ddd');
            $("#"+form+" label.error").hide();
        }
    }

    if(id == "sum_insured"){
        var condition = $("#"+form+" #kondisi").find(':selected').val();
        var noCommas = $("#"+form+" #sum_insured").val().replace('.00', '');

        var noDotsPrice = noCommas.replace(/\,/g, '');
        var category = "";
        if(parseInt(noDotsPrice) > 20000000){
            alert("Sum Insured is too big");
            $("#"+form+" #sum_insured").val(20000000);
        }else{
            category = getCategory(condition, noDotsPrice);
        }

        $("#"+form+" #simpro_category").val(category);
    }

}


function cancel(){
    $('#list').fadeIn();
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
}
function resetForm(){
    // var formValidator = $('#form-add-simpro').validate();
    // var formValidator2 = $('#form-edit-simpro').validate();
    // formValidator.resetForm();
    // formValidator2.resetForm();

    // $( "#add-form input").each(function( i ) {
    // this.style.borderColor  = "black";
    // });

    $('#add-form .error').hide();
    $('#edit-form .error').hide();
    $('#btn-reset-add').trigger('click');
    $('#btn-reset-edit').trigger('click');
    $('#add-form span.checked').removeClass('checked');
    $('#edit-form span.checked').removeClass('checked');


    $('#add-form select[name="product_id"]').val("");
    $('#edit-form select[name="product_id"]').val("");
    //$('#add-form select[name="kondisi"]').select2('data', {id:"",text:'Pilih  Kondisi'});
    //$('#edit-form select[name="kondisi"]').select2('data', {id:"",text:'Pilih Kondisi'});

    $('#edit-form select[name="kondisi"]').val("");
    $('#edit-form select[name="kondisi"]').val("");

    $('#add-form input[name="product_id"]').select2('data', {id:"",text:'Pilih Merek'});
    $('#edit-form input[name="product_id"]').select2('data', {id:"",text:'Pilih Merek'});

    $('#add-form input[name="device_type"]').select2('data', {id:"",text:'Pilih Tipe'});
    $('#edit-form input[name="device_type"]').select2('data', {id:"",text:'Pilih Tipe'});


    $('#add-form input[name="full_name"]').val('');
    $('#add-form input[name="card_number"]').val('');
    $('#add-form input[name="address"]').val('');
    $('#add-form input[name="phone_number"]').val('');
    $('#add-form input[name="contact_number"]').val('');
    $('#add-form input[name="email_address"]').val('');
    $('#add-form input[name="claim_price"]').val('');
    $('#add-form input[name="device_type"]').val('');
    $('#add-form input[name="imei"]').val('');
    $('#add-form input[name="product_period_start"]').val('');
    $('#add-form input[name="product_period_end"]').val('');
    $('#add-form input[name="purchase_date"]').val('');
    $('#add-form input[name="payment_amount"]').val('');
    $('#add-form input[name="other"]').val('');

    $('#edit-form input[name="full_name"]').val('');
    $('#edit-form input[name="card_number"]').val('');
    $('#edit-form input[name="address"]').val('');
    $('#edit-form input[name="phone_number"]').val('');
    $('#edit-form input[name="contact_number"]').val('');
    $('#edit-form input[name="email_address"]').val('');
    $('#edit-form input[name="claim_price"]').val('');
    $('#edit-form input[name="device_type"]').val('');
    $('#edit-form input[name="imei"]').val('');
    $('#edit-form input[name="product_period_start"]').val('');
    $('#edit-form input[name="product_period_end"]').val('');
    $('#edit-form input[name="purchase_date"]').val('');
    $('#edit-form input[name="payment_amount"]').val('');
    $('#edit-form input[name="other"]').val('');
    $('#add-form #s2id_simpro_category').show();
    $('#edit-form #s2id_simpro_category').show();

    $('#view-form #status').removeClass('label-success');
    $('#view-form #status').removeClass('label-danger');

    $('#add-form #btn-save').removeClass("disabled");
    $('#edit-form #btn-save-edit').removeClass("disabled");

    $("#add-form select.error").fadeIn();
    $("#add-form input.error").fadeIn();
    $("#add-form .select2-container").fadeIn();
    $("#add-form input").css('border-color', '#e5e5e5');
    $("#add-form select").css('border-color', '#e5e5e5');

    $("#edit-form select.error").fadeIn();
    $("#edit-form input.error").fadeIn();
    $("#edit-form .select2-container").fadeIn();
    $("#edit-form input").css('border-color', '#e5e5e5');
    $("#edit-form select").css('border-color', '#e5e5e5');

};

function ajaxEdit(id){
    var url = vars.url_by_id;
    $.post(url,
        {
            'id':id

        },function(callback){
            if(callback.status == 1) {
                var date = new Date(callback.data.purchase_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                var date1 = new Date(callback.data.product_period_start);
                var day1 = date1.getDate();
                var month1 = date1.getMonth() + 1;
                var year1 = date1.getFullYear();

                var date2 = new Date(callback.data.product_period_end);
                var day2 = date2.getDate();
                var month2 = date2.getMonth() + 1;
                var year2 = date2.getFullYear();

                var date3 = new Date(callback.data.date_in);
                var day3 = date3.getDate();
                var month3 = date3.getMonth() + 1;
                var year3 = date3.getFullYear();

                var purchase_date = day + "-" + month + "-" + year;
                var product_period_start = day1 + "-" + month1 + "-" + year1;
                var product_period_end = day2 + "-" + month2 + "-" + year2;
                var date_in = day3 + "-" + month3 + "-" + year3;
                console.log(purchase_date);
                console.log(product_period_start);
                console.log(product_period_end);

                var category = callback.data.simpro_category;

                $('#edit-form input[name="id"]').val(callback.data.id);

                $('#edit-form input[name="full_name"]').val(callback.data.full_name);
                $('#edit-form input[name="card_number"]').val(callback.data.card_number);
                $('#edit-form input[name="address"]').val(callback.data.address);
                $('#edit-form input[name="phone_number"]').val(callback.data.phone_number);
                $('#edit-form input[name="contact_number"]').val(callback.data.contact_number);
                $('#edit-form input[name="email_address"]').val(callback.data.email_address);
                $('#edit-form input[name="claim_price"]').val(callback.data.claim_price);
                $('#edit-form input[name="device_type"]').val(callback.data.device_type);
                $('#edit-form input[name="imei"]').val(callback.data.imei);
                $('#edit-form input[name="product_period_start"]').val(product_period_start);
                $('#edit-form input[name="product_period_end"]').val(product_period_end);
                $('#edit-form input[name="purchase_date"]').val(purchase_date);
                $('#edit-form input[name="payment_amount"]').val(callback.data.payment_amount);
                $('#edit-form input[name="reg_no"]').val(callback.data.reg_no);
                $('#edit-form input[name="date_in"]').val(callback.data.date_in);
                $('#edit-form input[name="store"]').val(callback.data.store_name);
                $('#edit-form input[name="simpro_category"]').val(callback.data.simpro_category);
                $('#edit-form input[name="product_name"]').val(callback.data.product_name);

                $('#edit-form select[name="kondisi"]').val(callback.data.kondisi);
                //$('#edit-form select[name="kondisi"]').select2();

                $('#edit-form input[name="product_id"]').select2('data', {id:callback.data.brand_slug, text:callback.data.brand});
                $('#edit-form input[name="device_type"]').select2('data', {id:callback.data.product_id, text:callback.data.device_type});
                $('#edit-form input[name="sum_insured"]').val(callback.data.sum_insured);
                // $('#edit-form input[name="device_type"]').val(callback.data.device_type);

                if(callback.data.has_payment == 1){
                    $('#edit-form .checker span').addClass('checked');
                    $('#edit-form input[name="has_payment"]').attr('checked', 'checked');
                }else{
                    $('#edit-form .checker span').removeClass('checked');
                    $('#edit-form input[name="has_payment"]').removeAttr('checked');
                }

                var doc = JSON.parse(callback.data.document_json);
                var check = JSON.parse(callback.data.check_point_json);
                // Document JSON
                if(doc.bukti_pembelian == "Y"){
                    $('#edit-form #uniform-bukti_pembelian_y span').addClass('checked');
                    $('#edit-form #bukti_pembelian_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-bukti_pembelian_n span').addClass('checked');
                    $('#edit-form #bukti_pembelian_n').prop('checked',true);
                }

                if(doc.kartu_garansi == "Y"){
                    $('#edit-form #uniform-kartu_garansi_y span').addClass('checked');
                    $('#edit-form #kartu_garansi_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-kartu_garansi_n span').addClass('checked');
                    $('#edit-form #kartu_garansi_n').prop('checked',true);
                }

                if(doc.kartu_identitas == "Y"){
                    $('#edit-form #uniform-kartu_identitas_y span').addClass('checked');
                    $('#edit-form #kartu_identitas_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-kartu_identitas_n span').addClass('checked');
                    $('#edit-form #kartu_identitas_n').prop('checked',true);
                }

                if(doc.voucher == "Y"){
                    $('#edit-form #uniform-voucher_y span').addClass('checked');
                    $('#edit-form #voucher_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-voucher_n span').addClass('checked');
                    $('#edit-form #voucher_n').prop('checked',true);
                }

                // Check Point JSON
                if(check.unit == "Y"){
                    $('#edit-form #uniform-unit_y span').addClass('checked');
                    $('#edit-form #unit_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-unit_n span').addClass('checked');
                    $('#edit-form #unit_n').prop('checked',true);
                }

                if(check.cover == "Y"){
                    $('#edit-form #uniform-cover_y span').addClass('checked');
                    $('#edit-form #cover_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-cover_n span').addClass('checked');
                    $('#edit-form #cover_n').prop('checked',true);
                }

                if(check.battery == "Y"){
                    $('#edit-form #uniform-battery_y span').addClass('checked');
                    $('#edit-form #battery_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-battery_n span').addClass('checked');
                    $('#edit-form #battery_n').prop('checked',true);
                }
                $('#edit-form input[name="other"]').val(check.other);


                if(callback.data.is_warranty == 1){
                    $('#edit-form #uniform-is_warranty_y span').addClass('checked');
                    $('#edit-form #is_warranty_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-is_warranty_n span').addClass('checked');
                    $('#edit-form #is_warranty_n').prop('checked',true);
                }

                if(callback.data.is_seal == 1){
                    $('#edit-form #uniform-is_seal_y span').addClass('checked');
                    $('#edit-form #is_seal_y').prop('checked',true);
                }else{
                    $('#edit-form #uniform-is_seal_n span').addClass('checked');
                    $('#edit-form #is_seal_n').prop('checked',true);
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
            var date = new Date(callback.data.purchase_date);
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            var date1 = new Date(callback.data.product_period_start);
            var day1 = date1.getDate();
            var month1 = date1.getMonth() + 1;
            var year1 = date1.getFullYear();

            var date2 = new Date(callback.data.product_period_end);
            var day2 = date2.getDate();
            var month2 = date2.getMonth() + 1;
            var year2 = date2.getFullYear();

            var date3 = new Date(callback.data.date_in);
            var day3 = date3.getDate();
            var month3 = date3.getMonth() + 1;
            var year3 = date3.getFullYear();


            var date_in = day3 + "-" + month3 + "-" + year3;
            var purchase_date = day + "-" + month + "-" + year;
            var product_period_start = day1 + "-" + month1 + "-" + year1;
            var product_period_end = day2 + "-" + month2 + "-" + year2;

            // var category = "New Phone (1mio - 5mio)";
            // if(callback.data.simpro_category == "new_phone_up"){
            // category = "New Phone (5mio - 20mio)";
            // }else if(callback.data.simpro_category == "used_phone"){
            // category = "Used Phone (1mio - 20mio)";
            // }

            $('#view-form #reg_no').html(callback.data.reg_no);
            $('#view-form #store_name').html(callback.data.store_name);
            $('#view-form #date_in').html(date_in);
            $('#view-form #full_name').html(": " + callback.data.full_name);
            $('#view-form #card_number').html(": " + callback.data.card_number);
            $('#view-form #address').html(": " + callback.data.address);
            $('#view-form #email_address').html(": " + callback.data.email_address);
            $('#view-form #phone_number').html(": " + callback.data.phone_number);
            $('#view-form #contact_number').html(": " + callback.data.contact_number);
            $('#view-form #simpro_category').html(": " + callback.data.simpro_category);
            $('#view-form #brand').html(": " + callback.data.brand);
            $('#view-form #sum_insured').html(": Rp. " + accounting.formatNumber(callback.data.sum_insured));
            $('#view-form #device_type').html(": " + callback.data.device_type);
            $('#view-form #imei').html(": " + callback.data.imei);
            $('#view-form #product_period_start').html(": " + product_period_start);
            $('#view-form #product_period_end').html(": " + product_period_end);
            $('#view-form #purchase_date').html(": " + purchase_date);
            $('#view-form #payment_amount').html(": Rp. " + accounting.formatNumber(callback.data.payment_amount));
            $('#view-form #total_amount').html(": Rp. " + accounting.formatNumber(callback.data.payment_amount));



            // $('#edit-form select[name="simpro_category"]').val(callback.data.simpro_category);
            // $('#edit-form select[name="simpro_category"]').select2();

            // $('#edit-form input[name="product_id"]').select2('data', {id:callback.data.product_id, text:callback.data.product_name});
            // $('#edit-form input[name="claim_price"]').val(callback.data.claim_price);
            // $('#edit-form input[name="device_type"]').val(callback.data.device_type);

            if(callback.data.has_payment == 1){
                $('#view-form #status').addClass('label-success');
                $('#view-form #status').html("Paid");
            }else{
                $('#view-form #status').addClass('label-danger');
                $('#view-form #status').html("Unpaid");
            }

            var doc = JSON.parse(callback.data.document_json);
            var check = JSON.parse(callback.data.check_point_json);
            // Document JSON
            if(doc.bukti_pembelian == "Y"){
                $('#view-form #bukti_pembelian').html(": Yes");
            }else{
                $('#view-form #bukti_pembelian').html(": No");
            }

            if(doc.kartu_garansi == "Y"){
                $('#view-form #kartu_garansi').html(": Yes");
            }else{
                $('#view-form #kartu_garansi').html(": No");
            }

            if(doc.kartu_identitas == "Y"){
                $('#view-form #kartu_identitas').html(": Yes");
            }else{
                $('#view-form #kartu_identitas').html(": No");
            }

            if(doc.voucher == "Y"){
                $('#view-form #voucher').html(": Yes");
            }else{
                $('#view-form #voucher').html(": No");
            }

            // Check Point JSON
            if(check.unit == "Y"){
                $('#view-form #unit').html(": Yes");
            }else{
                $('#view-form #unit').html(": No");
            }

            if(check.cover == "Y"){
                $('#view-form #cover').html(": Yes");
            }else{
                $('#view-form #cover').html(": No");
            }

            if(check.battery == "Y"){
                $('#view-form #battery').html(": Yes");
            }else{
                $('#view-form #battery').html(": No");
            }
            $('#view-form #other').val(":" + check.other);


            if(callback.data.is_warranty == 1){
                $('#view-form #is_warranty').html(": Yes");
            }else{
                $('#view-form #is_warranty').html(": No");
            }

            if(callback.data.is_seal == 1){
                $('#view-form #is_seal').html(": Yes");
            }else{
                $('#view-form #is_seal').html(": No");
            }

            $("#view-form #print_url").attr("href", "http://www.sim.id/simpro/simpro_registration/printInvoice/"+id)

        }
        else {
            console.log('failed');
        }
    }, 'json');

}
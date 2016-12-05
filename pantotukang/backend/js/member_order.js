$(function(){
    // onload
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();

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
    })


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
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html( string );
                }

                if(i == 2){
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
        }
    });

});


// FUNCTION
function cancel(){
    $('#list').fadeIn();
    $('#add-form').hide();
    $('#edit-form').hide();
    $('#view-form').hide();
}


function ajaxView(id){
    var url = vars.url_by_id;
    $.post(url, {'id':id}, function(callback){
        // if(callback.status == 1) {
            console.log(callback.data);
            var dob = new Date(callback.data.dob*1000);
            var day = dob.getDate();
            var month = dob.getMonth() + 1;
            var year = dob.getFullYear();
            var monthName = '';
            switch(month){
                case 1:monthName = "Januari";break;case 2:monthName = "Februari";break;case 3:monthName = "Maret";break;case 4:monthName = "April";break;case 5:monthName = "Mei";break;case 6:monthName = "Juni";break;case 7:monthName = "Juli";break;case 8:monthName = "Agustus";break;case 9:monthName = "September";break;case 10:monthName = "Oktober";break;case 11:monthName = "November";break;case 12:monthName = "Desember";break;
            }

            $('#view-form #name').html(callback.data.name);
			$('#view-form #birthday').html(day + ' ' + monthName + ' ' + year);
			$('#view-form #address').html(callback.data.address);	
            $('#view-form #email').html(callback.data.email);			
            $('#view-form #phone').html(callback.data.phone);
            $('#view-form #numberorder').html(callback.data.project_number);

        // }
        // else {
            // console.log('failed');
        // }
    }, 'json');

}
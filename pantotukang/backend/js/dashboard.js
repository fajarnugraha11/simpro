$(function () {
    
    // DATATABLE
    var oTable = $('.list-quotation table').DataTable({
        "iDisplayLength": 10
        , "sAjaxSource": vars.url
        , "sServerMethod": "GET"
        , "fnServerParams": function (aoData) {
            aoData.push(
                { "name": "a", "value": vars.access }
            );
        },
		"order": [[ 7, "desc" ]]
        , "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            for (var i = 0; i < aData.length ; i++) {
                var string = '';
                if (aData[i] == null) {
                    aData[i] = '';
                }
                var thisData = aData[i].toString(); // convert data to string
                if (thisData == "expand") {
                    string = "<a class=\"expand icon-plus tipl\" href=\"javascript:void(0)\" data-original-title=\"Expand\" id=" + aData[0] + "></a>";
                    $('td:eq(' + i.toString() + ')', nRow).html(string);
                }
                else if (thisData.indexOf('view') != -1 || thisData.indexOf('edit') != -1 || thisData.indexOf('delete') != -1) {
                    var x = thisData.split(',');

                    for (var z = 0; z < x.length; z++) {
                        if (string.length > 0) string += '&nbsp;&nbsp;';
                        if (x[z] == "view") {
                            string += "<a data-id=" + aData[0] + " id=\"aView\" class=\"view btn btn btn-link btn-icon btn-xs tip\" title data-original-title=\"View data\"><i class=\"icon-zoom-in\"></i></a>";
                        }
                        else if (x[z] == "edit") {
                            string += "<a data-id=" + aData[0] + " id=\"aEdit\" class=\"edit btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Edit data\" ><i class=\"icon-pencil\"></i></a>";
                        }
                        else if (x[z] == "delete") {
                            string += "<a data-toggle=\"modal\" id=\"aRemove\" data-id=" + aData[0] + " data-name=" + aData[2] + " role=\"button\" href=\"#delete_modal\" class=\"remove btn btn-link btn-icon btn-xs tip\" title data-original-title=\"Delete data\"><i class=\"icon-remove5\"></i></a>";
                        }
                    }
                    $('td:eq(' + i.toString() + ')', nRow).html(string);
                }

				if(i == 3)              
				{                  
					var img = aData[i] + ' m2';        
					$('td:eq(' + i.toString() + ')', nRow).html(img);      
				}						
				if(i == 4)               
				{                  
					var rp = 'Rp. ' + aData[i];          
					$('td:eq(' + i.toString() + ')', nRow).html(rp);   
				}
				
            }
        }
        , "aoColumnDefs": [
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [0] },
            { "bSortable": false, "bSearchable": false, "sClass": "hidden", "aTargets": [ 8 ] }
        ]
    });

    $(".dataTables_length select").select2({
        minimumResultsForSearch: "-1"
    });


});


var EventTypesTableData = function () {
    "use strict";

    var EventTypesTable = function () {
        var newRow = false;
        var actualEditingRow = null;

        $(document).ready(function(){
            $.ajax({
                url: serverUrl + '/admin/get/event/types',
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    $.unblockUI();
                    if(data.status == "success"){
                        var i;
                        for(i=0; i<data.result.event_types.length; i++){
                            deleteAndCreateTable(oTable, data.result.event_types[i]);
                        }
                    }else if(data.status == "failed"){
                        toastr.warning("Sorry!!. Failed to Get data from the server. Contact Support!!");
                    }
                }
            });

        });
        function deleteAndCreateTable(oTable, result) {

            var aiNew = oTable.fnAddData(['', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            nRow.setAttribute('data-event-type-id', result.id);

            oTable.fnUpdate(result.event_type_name, nRow, 0, false);
            oTable.fnUpdate('<a class="edit-row-event-types" href="#">Edit</a>', nRow, 1, false);
            oTable.fnUpdate('<a class="delete-row-event-types" href="#">Delete</a>', nRow, 2, false);

            oTable.fnDraw();

            nRow = false;
        }


        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="input-field-event-type-name" value="' + aData[0] + '">';

            jqTds[1].innerHTML = '<a class="save-row-event-types" href="">Save</a>';
            jqTds[2].innerHTML = '<a class="cancel-row-event-types" href="">Cancel</a>';

        }

        function saveRow(oTable, nRow, result) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            nRow.setAttribute('data-event-type-id', result.id);         //event type id added to the attribute of the row
            oTable.fnUpdate('<a class="edit-row-event-types" href="">Edit</a>', nRow, 1, false);
            oTable.fnUpdate('<a class="delete-row-event-types" href="">Delete</a>', nRow, 2, false);
            oTable.fnDraw();
            newRow = false;
            actualEditingRow = null;
        }

        $('body').on('click', '.add-row-event-types', function (e) {
            e.preventDefault();
            if (newRow == false) {
                if (actualEditingRow) {
                    restoreRow(oTable, actualEditingRow);
                }
                newRow = true;
                var aiNew = oTable.fnAddData(['', '', '']);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                actualEditingRow = nRow;
            }
        });
        $('#table-event-types').on('click', '.cancel-row-event-types', function (e) {

            e.preventDefault();
            $(this).parents('.panel-body').find('.errorHandler').addClass('no-display');
            if (newRow) {
                newRow = false;
                actualEditingRow = null;
                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);

            } else {
                restoreRow(oTable, actualEditingRow);
                actualEditingRow = null;
            }
        });
        $('#table-event-types').on('click', '.delete-row-event-types', function (e) {
            e.preventDefault();
            if (newRow && actualEditingRow) {
                oTable.fnDeleteRow(actualEditingRow);
                newRow = false;

            }
            var nRow = $(this).parents('tr')[0];

            var data = {
                event_type_id : $(this).parents('tr').attr('data-event-type-id')
            };

            console.log(data);
            bootbox.confirm("Are you sure to delete this row?", function (result) {

                if (result) {
                    $.blockUI({
                        message: '<i class="fa fa-spinner fa-spin"></i> Do some ajax to sync with backend...'
                    });
                    $.ajax({
                        url: serverUrl + '/admin/delete/event/types',
                        dataType: 'json',
                        data: data,
                        method: 'POST',
                        success: function (data) {
                            $.unblockUI();
                            console.log(data);
                            if (data.status == "success") {
                                oTable.fnDeleteRow(nRow);
                                toastr.success("Deleted Successfully !!");
                            }else if(data.status == "failed"){
                                toastr.warning('Could Not delete it. Call Support !!');
                            }
                        }
                    });

                }
            });


        });

        function validation(data) {

            if (data.event_type_name === "undefined" || data.event_type_name === "") {
                return false;
            }
            return true;

        }

        function errorPlacement(id, data) {

            var fieldName;
            $(id).parents('.panel-body').find('.errorHandler').find('p').remove('p');

            if (data.event_type_name === "undefined" || data.event_type_name === "") {
                fieldName = "Event Type Name";
            }

            $(id).parents('.panel-body').find('.errorHandler').removeClass('no-display').append('<p>Please Input ' + fieldName + ' .</p>');

        }
        $('#table-event-types').on('click', '.save-row-event-types', function (e) {
            e.preventDefault();

            var nRow = $(this).parents('tr')[0];
            var data = {
              event_type_name : $(this).parents('tr').find('.input-field-event-type-name').val(),
              event_type_id : $(this).parents('tr').attr('data-event-type-id')
            };

            if (validation(data)) {

                $(this).parents('.panel-body').find('.errorHandler').addClass('no-display');

                $.blockUI({
                    message: '<i class="fa fa-spinner fa-spin"></i> Do some ajax to sync with backend...'
                });

                $.ajax({
                    url: serverUrl + '/admin/school/save/event/types',
                    data: data,
                    method: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $.unblockUI();
                        if (data.status == "success") {
                            saveRow(oTable, nRow, data.result);
                            toastr.success('Event Type saved successfully. !!');
                        }else if(data.status == "failed"){
                            toastr.warning('Could Not save the Event Type. <br> Contact Support!!');
                        }
                    }
                });

            }else {
                errorPlacement(this, data);
            }
        });
        $('#table-event-types').on('click', '.edit-row-event-types', function (e) {
            e.preventDefault();
            if (actualEditingRow) {
                if (newRow) {
                    oTable.fnDeleteRow(actualEditingRow);
                    newRow = false;
                } else {
                    restoreRow(oTable, actualEditingRow);

                }
            }
            var nRow = $(this).parents('tr')[0];
            editRow(oTable, nRow);
            actualEditingRow = nRow;

        });
        var oTable = $('#table-event-types').dataTable({
            "aoColumnDefs": [{
                "aTargets": [0]
            }],
            "oLanguage": {
                "sLengthMenu": "Show _MENU_ Rows",
                "sSearch": "",
                "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
            },
            "aaSorting": [[0, 'asc']],
            "aLengthMenu": [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 10
        });
        $('#table-event-types_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        // modify table search input
        $('#table-event-types_wrapper .dataTables_length select').addClass("m-wrap small");
        // modify table per page dropdown
        $('#table-event-types_wrapper .dataTables_length select').select2();
        // initialzie select2 dropdown
        $('#table-event-types_column_toggler input[type="checkbox"]').change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, ( bVis ? false : true));
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            EventTypesTable();
        }
    };
}();

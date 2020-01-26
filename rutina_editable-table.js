var EditableTable = function () {
console.log("entra js editable table");

    return {

        //main function to initiate the module
        init: function () {
        	console.log("entra init");
            function restoreRow(oTable, nRow) {
                console.log("llama oTable.fnGetData");
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }
                console.log("llama oTable.fnDraw");
                oTable.fnDraw();
                console.log("sale init");
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[3] + '">';
                jqTds[4].className ="club";
                $('.club').load("nadadora_select_option.php", "desde=rutina&id_rutina="+aData[0]+"&id_nadadora="+aData[3]+"&club_nombre_corto="+aData[2]);
                jqTds[5].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[5] + '">';
                jqTds[6].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[6] + '">';
                jqTds[7].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[7] + '">';
                jqTds[8].innerHTML = '<input disabled="disabled" type="text" class="form-control small" value="' + aData[8] + '">';
                jqTds[9].innerHTML = '<a class="edit" href="">Guardar</a>';
                jqTds[10].innerHTML = '<a class="cancel" href="">Cancelar</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);

                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                //oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                //jqTds[3].className ="";
                oTable.fnUpdate($('#club').val(), nRow, 4, false);
                var jqTds = $('>td', nRow);
                $('.club').load("nadadora_lee_nombre.php", "desde=nadadora&id="+jqTds[3].value);
                jqTds[4].className ="";
                oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
                oTable.fnUpdate(jqInputs[5].value, nRow, 6, false);
                oTable.fnUpdate(jqInputs[6].value, nRow, 7, false);
                oTable.fnUpdate(jqInputs[7].value, nRow, 8, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 9, false);
                oTable.fnUpdate('<a class="delete" href="">Borrar</a>', nRow, 10, false);
                oTable.fnDraw();
                //location.reload();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
                oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
                oTable.fnUpdate(jqInputs[6].value, nRow, 6, false);
                oTable.fnUpdate(jqInputs[7].value, nRow, 7, false);
                oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 9, false);
                oTable.fnDraw();
            }
            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": -1,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '', '','','','','',
                        '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
                borra($(this).attr('id'));
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Guardar") {
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    //alert("Updated! Do not forget to do some ajax to sync with backend :)");
                    actualiza(nRow);
					setInterval("location.reload()",500);		                    
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }

    };

}();

function borra(id_participacion){
 //borra un nadadora de la DBi
   $.ajax({
      type:'POST',
      url:'./rutina_borra.php',
      data:'id_participacion='+id_participacion,
      success:function(data) {
        if(data) {               
	        console.log('carga ajax borra ok');
        } else {  
        	console.log('carga ajax borra error');
      }}
   });
}
 
 

function actualiza(nRow){
	console.log("save");	   
    var jqTds = $('>td', nRow);
    id_rutina = jqTds[0].innerHTML;
    id_rutina_participante = jqTds[1].innerHTML;
    id_nadadora = jqTds[4].innerHTML;
    reserva = jqTds[8].innerHTML;
	$.ajax({
	     type:'POST',
	      url:'./rutina_guarda.php',
	      data:'id_rutina='+id_rutina+'&id_rutina_participante='+id_rutina_participante+'&id_nadadora='+id_nadadora+'&reserva='+reserva+'&tipo='+tipo+'&id_competicion_activa='+tipo,
	      success:function(data) {
	        if(data) {               
		        console.log('carga ajax edita ok');
	        } else {  
	        	console.log('carga ajax edita error');
	      }}
	   });
	}
	
function tipo(tipo_rutina){
	tipo = tipo_rutina;
    EditableTable.init();
};
	
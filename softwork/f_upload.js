function resultadoUpload(estado, file, num_file, directorio) 
{
	var link = 'datos:' + estado +' - '+ file +' - '+ num_file +' - '+ directorio;
	if (estado == 0)
	{
		var archivo = '<a href="' + directorio + file + '" target="_blank" class="textArchivo">' + file + '</a>';
		var opcion = '<input type="hidden" name="hddFile" value="'+ file +'" ><input type="hidden" name="hddAccion" value="delete">&nbsp;&nbsp;<button type="submit" class="btn btn-danger btn-sm textContenido01min"> X </button>';
		
		document.getElementById('fil_'+num_file).innerHTML = archivo;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (estado == 1)
	{
		var opcion = 'Error! - El Archivo no llego al servidor ' + file + ' ' + num_file + ' ' + directorio + '<input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';// + link;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (estado == 2)
	{
		var opcion = 'Error! - Error en formato de archivo <input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';// + link;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (estado == 3)
	{
		var opcion = 'Error! - Problema en acceso a servidor <input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';// + link;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (estado == 4)
	{
		var opcion = 'Error! - No se creo directorio principal <input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';// + link;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (estado == 5)
	{
		var opcion = 'Error! - No se creo directorio secundario <input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';// + link;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
} 
function elimino(rpta, num_file, file)
{
	if (rpta == 'N')
	{
		var opcion = '<input type="hidden" name="hddFile" value="'+ file +'" ><input type="hidden" name="hddAccion" value="delete"><input type="submit"  class="textBoton" value="X">';
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
	if (rpta == 'S')
	{
		var archivo = '<input name="fileUpload" type="file" class="textBotonMin" onchange="submit()">';
		var opcion = '<input type="hidden" name="hddAccion" value="upload"><input type="hidden" name="hddFile" value="" >';
		
		document.getElementById('fil_'+num_file).innerHTML = archivo;
		document.getElementById('opc_'+num_file).innerHTML = opcion;
	}
}

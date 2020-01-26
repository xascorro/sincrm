

<?php

include "lib/conexion_abre.php"; //Connect to Database

$deleterecords = "TRUNCATE TABLE nadadoras_temp"; //empty the table of its current records
mysql_query($deleterecords);

//Upload File
if (isset($_POST['submit'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']);
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
	$numero_inserts = 0;
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		$numero_inserts++;
		if($numero_inserts > 1){
			$import="INSERT into nadadoras_temp (club, licencia, apellidos, nombre, fecha_nacimiento) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')";
			mysql_query($import) or die(mysql_error());
		}
	}

	fclose($handle);

	print "Importación realizada, se han añadido $numero_inserts nadadoras.";
	
	//paso todo a mayusculas
	$query = 'update nadadoras_temp set nombre=UPPER(nombre), apellidos =UPPER(apellidos) where 1';
	mysql_query($query);
	print 'Nombre y Apellidos convertidos a mayúsculas.';
	//borro basurilla
	$query = 'delete from nadadoras_temp where nombre="" and apellidos="" and licencia=""';
	mysql_query($query);
	print 'Borro basurilla';
	$query = 'update nadadoras_temp set licencia=id where licencia=""';
	mysql_query($query);
	$query = 'update nadadoras_temp set nombre= TRIM(nombre), apellidos=TRIM(apellidos)';
	mysql_query($query);
	$query = 'update nadadoras_temp set nombre=replace(nombre,",",""), apellidos=replace(apellidos,",","")';
	mysql_query($query);
	$query = 'CREATE TABLE nadadoras_retemp AS SELECT * FROM nadadoras_temp GROUP BY licencia';
	mysql_query($query);
	$query = 'TRUNCATE TABLE nadadoras_temp';
	mysql_query($query);
	$query = 'INSERT INTO nadadoras_temp SELECT * FROM nadadoras_retemp;';
	mysql_query($query);
	$query = 'DROP TABLE nadadoras_retemp';
	mysql_query($query);
	$query = 'update nadadoras_temp set licencia="" where licencia=id';
	mysql_query($query);
	$query = 'TRUNCATE TABLE nadadoras';
	mysql_query($query);
	$query = 'INSERT INTO nadadoras SELECT * FROM nadadoras_temp;';
	mysql_query($query);
	
		/*
	CREATE TABLE tabla_temporal AS SELECT * FROM tabla_original GROUP BY campoA, CampoB; 2. Eliminamos la información de la tabla original. DELETE FROM tabla_original; 3. Regresamos la información ya sin duplicados de la tabla temporal a la original. INSERT INTO tabla_original SELECt * FROM tabla_temporal; 4. Por último eliminamos la tabla temporal. DROP TABLE tabla_temporal; */

	//view upload form
}else {

	print "Upload new csv by browsing to file and clicking on Upload<br />\n";

	print "<form enctype='multipart/form-data' action='nadadoras_importar.php' method='post'>";

	print "Nombre de archivo a importar:<br />\n";

	print "<input size='50' type='file' name='filename'><br />\n";

	print "<input type='submit' name='submit' value='Upload'></form>";

}

?>

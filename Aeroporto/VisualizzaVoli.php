<?php
if(file_exists("ListaVoli.csv"))
{
	$file=fopen("ListaVoli.csv","r");
	echo "<table width='100%' style='background-color:white;' border='2px';>";
		echo "<th>TipoAereo</th><th>Destinazione</th><th>Orario di partenza</th><th>Tempo di arrivo</th><th>Numero posti</th><th>Data</th>";
		$vett=fgetcsv($file);
		while(!feof($file))
		{
			echo "<tr style='text-align:center;'>";
			echo "<td>".$vett[1]."</td>";
			echo "<td>".$vett[2]."</td>";
			echo "<td>".$vett[3]."</td>";
			echo "<td>".$vett[4]."min</td>";
			echo "<td>".$vett[5]."</td>";
			echo "<td>".$vett[6]."</td>";
			echo "</tr>";
			$vett=fgetcsv($file);
		}
	echo "</table>";
	fclose($file);
}
else
{
	echo "<h1>Nessun volo programmato!</h1>";
}
?>